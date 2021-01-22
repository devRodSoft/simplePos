<?php

namespace app\controllers;

use app\models\Abonos;
use Yii;
use app\models\Cajas;
use app\models\CajasSearch;
use app\models\DetalleVenta;
use app\models\DetalleVentaSearch;
use app\models\AbonosSearch;
use app\models\Productos;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Salidas;
use app\models\SalidasSearch;
use app\models\Ventas;
use yii\helpers\ArrayHelper;
/**
 * CajasController implements the CRUD actions for Cajas model.
 */
class CajasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cajas models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new CajasSearch();        

        //Check if the user is admin or is restaurant type in then sisten vendedor
        if (!Yii::$app->user->identity->userType == User::SUPER_ADMIN) {
            $searchModel->sucursalId = Yii::$app->user->identity->sucursalId;
        }
                
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // set default sorting
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cajas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider  =  new DetalleVentaSearch();
        $data = $dataProvider->Corte([], $id);

        $dataProviderCancel  =  new DetalleVentaSearch();
        $dataCancel = $dataProvider->CorteCancel([], $id);

        $dataProviderSalidas  =  new SalidasSearch();
        $dataProviderSalidas->cajaId =  $id;
        $dataSalidas = $dataProviderSalidas->search(Yii::$app->request->queryParams);

        $dataProviderAbonos = new AbonosSearch();
        $dataProviderAbonos->cajaId = $id;
        $abonos =  $dataProviderAbonos->search([]);

        $model = $this->findModel($id);

        //queries to get the total.
        $Efectivo = Ventas::find()->where(['=', 'cajaId', $model->id])->andWhere(['=', 'tipoVenta', '0'])->andWhere(['ventaApartado' => 0])->andWhere(['=', 'status', 0])->sum('total');
        $abonosEfectivo = Abonos::find()->where(['=', 'abonos.cajaId', $model->id])->andWhere(['=', 'ventas.tipoVenta', 0])->innerJoin('ventas','ventas.id = abonos.ventaId')->sum('abono');  
        $salidas  =  Salidas::find()->where(['=', 'cajaId', $model->id])->sum('retiroCantidad');
        $total = $model->saldoInicial + $Efectivo + $abonosEfectivo;
        $total -= $salidas;


        //get the caja products
        $productsIDS = Ventas::find()->where(['=', 'cajaId', $id])->andWhere(['=', 'status', 0])->select('id')->all();
        $ids = ArrayHelper::map($productsIDS, 'id', 'id');

        $productos = [];

        if (count($ids) > 1) {
            $productos = DetalleVenta::find()->where(['in', 'ventaId', array_values($ids)])->all();
        } elseif (count($ids) == 1) {
            $productos = DetalleVenta::find()->where(['=', 'ventaId', $ids[array_key_first($ids)]])->all();
        }

       
        $productosPrint = [];
        

        foreach($productos as $p) {
            $pro = [
                
                "descripcion" => $p->producto->descripcion,
                "precio" => $p->producto->precio,
                "precio1" => $p->producto->precio1,
                "selectedCantidad" => $p->cantidad
                
            ];
            array_push($productosPrint, $pro);
        }

        //get the cancel ids to print in the corte ticket
        $productsCancelIDS = Ventas::find()->where(['=', 'cajaId', $id])->andWhere(['=', 'status', 1])->select('id')->all();
        $cancelIds = ArrayHelper::map($productsCancelIDS, 'id', 'id');
        
        $productosCancel = [];

        if (count($cancelIds) > 1) {
            $productosCancel = DetalleVenta::find()->where(['in', 'ventaId', array_values($cancelIds)])->all();
        } elseif (count($cancelIds) == 1) {
            $productosCancel = DetalleVenta::find()->where(['=', 'ventaId', $cancelIds[array_key_first($cancelIds)]])->all();
        }

        $productosCancelPrint = [];
        
        foreach($productosCancel as $p) {
            $pro = [
                
                "descripcion" => $p->producto->descripcion,
                "precio" => $p->producto->precio,
                "precio1" => $p->producto->precio1,
                "selectedCantidad" => $p->cantidad
                
            ];
            array_push($productosCancelPrint, $pro);
        }


        $printData = [
            'id' => $model->id,
            'sucursal' => $model->sucursal->nombre,
            'empleado' => $model->user->username,
            'saldoInitial' => $model->saldoInicial,
            'saldoFinal' => $total,
            'ventasEfectivo' => Ventas::find()->where(['=', 'cajaId', $id])->andWhere(['=', 'tipoVenta', '0'])->andWhere(['ventaApartado' => 0])->sum('total'),
            'ventasAbonosEfectivo' => Abonos::find()->where(['=', 'abonos.cajaId', $id])->andWhere(['=', 'ventas.tipoVenta', 0])->innerJoin('ventas','ventas.id = abonos.ventaId')->sum('abono'),
            'ventasTargeta' => Ventas::find()->where(['=', 'cajaId', $id])->andWhere(['=', 'tipoVenta', '1'])->andWhere(['ventaApartado' => 0])->sum('total'),
            'abonosTargeta' => Abonos::find()->where(['=', 'abonos.cajaId', $id])->andWhere(['=', 'ventas.tipoVenta', 1])->innerJoin('ventas','ventas.id = abonos.ventaId')->sum('abono'),
            'salidas' => Salidas::find()->where(['=', 'cajaId', $id])->sum('retiroCantidad'),
            'isOpen' => $model->isOpen,
            'apertura' => $model->apertura,
            'cierre' => $model->cierre,
            "productos" => $productosPrint,
            "productosCancel" => $productosCancelPrint
        ];
        
        return $this->render('view', [
            'model' => $model,
            'data'  => $data,
            'searchModel' => $dataProvider,
            'dataCancel'  => $dataCancel,
            'searchModelCancel' => $dataProviderCancel,
            'dataSalidas'  => $dataSalidas,
            'searchModelSalidas' => $dataProviderSalidas,
            'abonos' => $abonos,
            'printData' => json_encode($printData)
        ]);
    }

    /**
     * Creates a new Cajas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cajas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }




    /**
     * Updates an existing Cajas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cajas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cajas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cajas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cajas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionCorte($id) {
        $dataProvider  =  new DetalleVentaSearch();
        $data = $dataProvider->Corte([], $id);


        return $this->render('corte', [
            'data' => $data,
            'searchModel' => $dataProvider
        ]);
    }

    public function actionSalidas($id) {
        $dataProvider  =  new SalidasSearch();
        $dataProvider->cajaId =  $id;
        $data = $dataProvider->search(Yii::$app->request->queryParams);

        return $this->render('salidas', [
            'data' => $data,
            'searchModel' => $dataProvider
        ]);
    }

    public function actionCerrar($id) {
        $totalVentas = DetalleVenta::find()->joinWith('venta v')
        ->where(['in', 'v.cajaId', $id])->sum('total');

        $caja = Cajas::find()->where(['=', 'id', $id])->one();


    

        $Efectivo = Ventas::find()->where(['=', 'cajaId', $id])->andWhere(['=', 'tipoVenta', '0'])->sum('total');                    
        $salidas  = Salidas::find()->where(['=', 'cajaId', $caja->id])->sum('retiroCantidad');

        //aqui faltaria agregar abonos
        $caja->saldoFinal = ($caja->saldoInicial + $Efectivo) - $salidas;
        $caja->isOpen = 2;
        $caja->cierre = date('Y-m-d H:i:s');
        
        $caja->save();

        return $this->redirect(['view', 'id' => $id]);
    }
}
