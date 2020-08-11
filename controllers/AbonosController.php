<?php

namespace app\controllers;

use Yii;
use app\models\Abonos;
use app\models\Ventas;
use app\models\AbonosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AbonosController implements the CRUD actions for Abonos model.
 */
class AbonosController extends Controller
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
     * Lists all Abonos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AbonosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Abonos model.
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
     * Creates a new Abonos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $total, $ventaId, $restante)
    {
        
        $model = new Abonos();

        $model->clienteId = $id;
        $model->ventaId   = $ventaId;
        $model->restante  = $restante;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //liquidamos la cuenta.
            if($model->restante == 0) {

                $venta = Venta::find($ventaId);
                $venta->liquidado = 1;
                $venta->save();

            }

            return $this->redirect(['clientes/view', 'id' => $model->clienteId]);
        }

        return $this->render('create', [
            'model' => $model,
            'ventaTotal' => $total,
            'restante' => $restante
        ]);
    }

    /**
     * Updates an existing Abonos model.
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
     * Deletes an existing Abonos model.
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
     * Finds the Abonos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Abonos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Abonos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
