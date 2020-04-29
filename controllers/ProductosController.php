<?php

namespace app\controllers;

use Yii;
use app\models\Productos;
use app\models\SucursalProducto;
use app\models\ProductosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use arogachev\excel\import\basic\Importer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\filters\AccessControl;

/**
 * ProductosController implements the CRUD actions for Productos model.
 */
class ProductosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Lists all Productos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Productos model.
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
     * Creates a new Productos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Productos();
        $sucProModel = new SucursalProducto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           
            $cantidades = Yii::$app->request->post();
          

            unset($cantidades["Productos"]);

            $sucursalProducto = new SucursalProducto();

            $sucursalProducto->sucursalId = $cantidades['sucursal1'];
            $sucursalProducto->productoId = $model->id;
            $sucursalProducto->cantidad   = $cantidades['cantidad1'];

            $sucursalProducto->save();

            $sucursalProducto = new SucursalProducto();

            $sucursalProducto->sucursalId = $cantidades['sucursal2'];
            $sucursalProducto->productoId = $model->id;
            $sucursalProducto->cantidad   = $cantidades['cantidad2'];

            $sucursalProducto->save();


             return $this->render('view', [
                'model' => $this->findModel($model->id),
            ]);


        }

        return $this->render('create', [
            'model' => $model,
            'sucProModel' => $sucProModel,
        ]);
    }
    public function actionProducto($barcode, $sucursal) {
        
        $request = Yii::$app->request;
        //$params = $request->get();

        if (Yii::$app->request->isAjax) {            

            $data = SucursalProducto::find()

            ->joinWith('producto p')
            ->where(['in', 'p.codidoBarras', $barcode])
            ->andWhere(['sucursalproducto.sucursalId' => $sucursal])
            ->andWhere(['>','sucursalproducto.cantidad', 0])
            ->asArray()
            ->all();
          
            return $this->asJson($data);
        }    
    }

    public function actionNombre($idProducto) {
        $request = Yii::$app->request;
        //$params = $request->get();

        if (Yii::$app->request->isAjax) {            

            $data = SucursalProducto::find()

            ->joinWith('producto p')
            ->where(['in', 'p.id', $idProducto])
            //->andWhere(['sucursalproducto.sucursalId' => $sucursal])
            ->andWhere(['>','sucursalproducto.cantidad', 0])
            ->asArray()
            ->all();
          
            return $this->asJson($data);
        }   
    }
    /* import inventary */ 
    public function actionImport() {
        
        $inputFileName = 'uploads/inven.xlsx';
        //  $helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheetData as $data => $valor) {
            if ($valor["B"] != NULL) {

                $producto = new Productos();

                $producto->codidoBarras = $valor["A"];
                $producto->descripcion  = $valor["B"];
                $producto->costo        = $valor["C"];
                $producto->precio       = $valor["D"];
                $producto->precio1      = $valor["E"];
                $producto->cantidad     = $valor["F"];

                //Save the product
                echo $producto->save();
                //save the fisrt sucursal
                $sucursalProducto = new SucursalProducto();

                $sucursalProducto->sucursalId = $valor['G'];
                $sucursalProducto->productoId = $producto->id;
                $sucursalProducto->cantidad   = $valor['H'];

                echo $sucursalProducto->save();

                //save the secon sucursal
                $sucursalProducto = new SucursalProducto();

                $sucursalProducto->sucursalId = $valor['I'];
                $sucursalProducto->productoId = $producto->id;
                $sucursalProducto->cantidad   = $valor['J'];

                echo $sucursalProducto->save();
            }       
        }
    }

    /**
     * Updates an existing Productos model.
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
     * Deletes an existing Productos model.
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
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Productos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
