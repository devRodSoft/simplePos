<?php

namespace app\controllers;

use Yii;
use app\models\Clientes;
use app\models\Ventas;
use app\models\VentasSearch;
use app\models\Abonos;
use app\models\AbonosSearch;
use app\models\ClientesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DetalleVenta;
use app\models\DetalleVentaSearch;

/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller
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
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clientes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        

        // get if the user has apartados open
        $query = Abonos::find()
        ->leftJoin('ventas', ['ventas.ventaApartado' => '1'])
        ->where(['clienteId' =>  $id])
        ->andFilterWhere(['ventas.liquidado' => '0'])
        ->orderBy(['(id)' => SORT_DESC])
        ->one();

        if (isset($query->restante) && $query->restante != 0 && $query->venta->status !=  '0') {
            //get the abonos
            $abonosData = new AbonosSearch();
            $abonosData->clienteId = $id;
            $abonos = $abonosData->search([]);

            //get thte total venta
            $ventaTotal = Ventas::find()->andFilterWhere(['id' => $query->ventaId])->one();

            //get venta sin liquidar
            $searchModel = new VentasSearch();  
            $searchModel->liquidado = 0;
            $searchModel->ventaApartado = 1;
            $searchModel->id = $query->ventaId;
            $ventas = $searchModel->search([]);

            //get venta detalle
            $dataProvider  =  new DetalleVentaSearch();
            $dataProvider->ventaId = $query->ventaId;
            $data = $dataProvider->search([]);
        } else {
            //get the abonos
            $abonosData = new AbonosSearch();
            $abonosData->clienteId = 0;
            $abonos = $abonosData->search([]);

            //get thte total venta
            //$ventaTotal = Ventas::find()->andFilterWhere(['id' => $query->ventaId])->one();

            //get venta sin liquidar
            $searchModel = new VentasSearch();  
            $searchModel->id = 0;
            $ventas = $searchModel->search([]);

            //get venta detalle
            $dataProvider  =  new DetalleVentaSearch();
            $dataProvider->ventaId = 0;
            $data = $dataProvider->search([]);
        }

            
        //return al data needed for the abono and check the apartado
        return $this->render('view', [
            'model' => $this->findModel($id),
            'ventaAparados'=> $ventas,
            'abonos'=> $abonos,
            'detalleVenta' => $data,
            'clienteId' => $id,
            'ventaId' => isset($query->ventaId) ? $query->ventaId : null,
            'restante' => isset($query->restante) ? $query->restante : null,
            'ventatotal'=> isset($ventaTotal->total) ? $ventaTotal->total : null
        ]);
    }

    /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clientes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionClientes() {
        $data = Clientes::find()->all();
        return $this->asJson($data); 
    }

    /**
     * Updates an existing Clientes model.
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
     * Deletes an existing Clientes model.
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
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
