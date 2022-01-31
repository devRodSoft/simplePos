<?php

namespace app\controllers;

use Yii;
use app\models\Transpasos;
use app\models\TranspasosSeach;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TranspasosDetalle;
use app\models\TranspasosDetalleSeach;
use app\models\Productos;
use app\models\SucursalProducto;

/**
 * TranspasosController implements the CRUD actions for Transpasos model.
 */
class TranspasosController extends Controller
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
                    'transpaso' => ['GET']
                ],
            ],
        ];
    }

    /**
     * Lists all Transpasos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TranspasosSeach();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTranspaso($id) {
        
        $productos = TranspasosDetalle::find()->where(['transpasoId' => $id])->all();

        foreach($productos as $producto) {
            $pro = SucursalProducto::find()->where(['=', 'productoId', $producto->productoId])->andWhere(['=', 'sucursalId', $producto->qtyFinal])->one();
            $pro->cantidad += $producto['cantidad'];
            $pro->save(false);
        }

        //update transpaso status
        $t = $this->findModel($id);
        $t->status = 1;
        $t->userOkId = Yii::$app->user->identity->id;
        $t->save();

        return $this->redirect(['view', 'id' => $id]);
    }
    /**
     * Displays a single Transpasos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {    

        $dataProvider = new TranspasosDetalleSeach();
        $dataProvider->transpasoId = $id;
        $detalle =  $dataProvider->search([]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'products' => $detalle,
        ]);
    }

    /**
     * Creates a new Transpasos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transpasos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transpasos model.
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
     * Deletes an existing Transpasos model.
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
     * Finds the Transpasos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transpasos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transpasos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
