<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;;
use kartik\grid\GridView;
use app\models\User;
use app\models\Sucursales;
use kartik\export\ExportMenu;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productos-index">

    <p>
        <?= Html::a('Añadir producto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
        $listaSucursales = ArrayHelper::map(Sucursales::find()->all(), 'id', 'nombre');
    ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "Productos",
        ],
        'hover' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'producto.id',
            [
                'label' => 'Sucursal',
                'attribute' => 'sucursalId',
                'filter' => $listaSucursales,
                'value' => function ($model) {
                    return $model->sucursal->nombre;
                } 
            ],
            [
                'attribute' => 'producto',
                'value' => 'producto.descripcion',
                'filter' => true
            ],
            [
                'attribute' => 'barcode',
                'value' => 'producto.codidoBarras',
                'filter' => true 
            ],
            [
                'label' => "Costo",
                'attribute' => 'producto.costo',
                'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
                
            ],  
            [
                'label' => 'Precio',
                'attribute' => 'producto.precio',
                'filter' => false,
                'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
            ],
            [
                'label' => 'Precio Mayoreo',
                'attribute' => 'producto.precio1',
                'filter' => false,
                'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
            ],
            [
                'label' => 'Cantidad Sucursal',
                'attribute' => 'cantidad',
                'filter' => false
            ],
            [
                'label' => 'Almacen',
                'attribute' => 'producto.cantidad',
                'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
            ],
            

            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{leadView}',
                'buttons' => [
                    'leadView' => function ($url, $model) {
                        $url = Url::to(['productos/view', 'id' => $model->producto->id]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => 'view']);
                        },
                    ],
                    'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        $url = Url::to(['productos/update', 'id' => $model->producto->id]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'view']);
                        },
                    ],
                    'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $url = Url::to(['productos/delete', 'id' => $model->producto->id]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'view']);
                        },
                    ],
                'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
            ],  
        ]  
    ]); ?>

</div>
