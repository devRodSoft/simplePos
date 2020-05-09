<?php

namespace app\controllers;

use Yii;
use app\models\Cajas;
use app\models\CajasSearch;
use app\models\DetalleVenta;
use app\models\DetalleVentaSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Salidas;
use app\models\SalidasSearch;
use app\models\Ventas;
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
        $session = Yii::$app->session;
        $searchModel = new CajasSearch();

        //Check if the user is admin or is restaurant type in then sisten vendedor
        if (!Yii::$app->user->identity->userType == User::SUPER_ADMIN) {
            $searchModel->sucursalId = Yii::$app->user->identity->sucursalId;
        }
                
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
