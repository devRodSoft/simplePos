<?php

namespace app\controllers;

use Yii;
use app\models\Ventas;
use app\models\VentasSearch;
use app\models\DetalleVenta;
use app\models\DetalleVentaSearch;
use app\models\Abonos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Cajas;
use app\models\SucursalProducto;
//to print
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printerd;
use Mike42\Escpos\EscposImage;

/**
 * VentasController implements the CRUD actions for Ventas model.
 */
class VentasController extends Controller
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
     * Lists all Ventas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VentasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // set default sorting
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ventas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new Ventas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ventas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionPagar() {

        $model = new Ventas();
        $caja  = new Cajas();

        $total       = Yii::$app->request->post('total');
        $descuento   = Yii::$app->request->post('descuento');
        $productos   = Yii::$app->request->post('productos');
        $wPrice      = Yii::$app->request->post('precioSelected');
        $tipoVenta   = Yii::$app->request->post('tipoVenta');
        $descripcion = Yii::$app->request->post('desc');
        $isApartado  = Yii::$app->request->post('apartado');


      
        $model->total         =  $total;
        $model->descuento     =  $descuento;
        $model->cajaId        =  $caja->getIdOpenCaja()->id;
        $model->tipoVenta     =  $tipoVenta != "false" ? Ventas::TARGETA : Ventas::EFECTIVO;
        $model->userId        =  Yii::$app->user->identity->id;
        $model->descripcion   =  $descripcion;
        $model->ventaApartado =  $isApartado ? 0 : 1;
        $model->liquidado     =  $isApartado ? 0 : 1; 

        die(var_dump($isApartado));
        
        //Guardamos la venta
        if ($model->save()) {
            
            foreach($productos as $producto) {
                //Intentamos guardar el detalle de la venta
                $modelDetalle = new DetalleVenta();
    
                $modelDetalle->ventaId    = $model->id;
                $modelDetalle->productoId = $producto['producto']['id'];              
                $modelDetalle->precio     = $wPrice == 1 ? $producto['producto']['precio'] : $producto['producto']['precio1'];
                $modelDetalle->cantidad   = $producto['selectedCantidad'];

                //Guardamos el detalle de la venta
                $modelDetalle->save();  

                //Descontamos inventario por producto vendido
                $productoInventario = SucursalProducto::find()->where(['=', 'productoId', $producto['producto']['id']])->andWhere(['=', 'sucursalId', $producto['sucursalId']])->one();

                //var_dump($productoInventario->cantidad);
                $productoInventario->cantidad -= $producto['selectedCantidad'];

                // si es apartado agregamos que es un apartado! sea la venta como sea del inventario siempre se descuenta.
                if ($isApartado) {
                    $productoInventario->productoApartado = $producto['selectedCantidad'];

                    $Abono = new Abonos();

                    $Abono->clienteId = Yii::$app->request->post('clientId');
                    $Abono->ventaId   = $model->id;
                    $Abono->userId    = Yii::$app->user->identity->id;
                    $Abono->cajaId    = $caja->getIdOpenCaja()->id;
                    $Abono->abono     = Yii::$app->request->post('abono');
                    $Abono->restante  = $total - Yii::$app->request->post('abono');
                    
                    $Abono->save();

                    //creamos el abono! 
                }
                $productoInventario->save();
            }
                     
            return true;
        } else {
            die("hubo problema");
        }
    }

    /**
     * Updates an existing Ventas model.
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
     * Deletes an existing Ventas model.
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
     * Finds the Ventas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ventas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ventas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionView($id) {

        //get data to ptrint
        $printData = Ventas::find()->where(['=', 'id', $id])->one();
        $productos = DetalleVenta::find()->where(['=', 'ventaId', $id])->all();
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
        
        $datatoPrint = [
            "total" => $printData->total,
            "descuento" => $printData->descuento,
            "productos" => $productosPrint,
            "backendPrint" => true
        ];

        $dataProvider  =  new DetalleVentaSearch();
        $dataProvider->ventaId =  $id;
        $data = $dataProvider->search(Yii::$app->request->queryParams);

        return $this->render('detalle', [
            'data' => $data,
            'searchModel' => $dataProvider,
            'print' => json_encode($datatoPrint)
        ]);
    }
}
