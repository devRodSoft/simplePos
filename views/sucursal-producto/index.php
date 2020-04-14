<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sucursales;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SucursalProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sucursal Productos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sucursal-producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Sucursal Producto'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
        $listaSucursales = ArrayHelper::map(Sucursales::find()->all(), 'id', 'nombre');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => 'Sucursal',
                'attribute' => 'sucursalId',
                'filter' => $listaSucursales,
                'value' => function ($model) {
                    return $model->sucursal->nombre;
                }
            ],
            [
                'label' => 'Producto',
                'attribute' => 'producto.descripcion',
                'filter' => true,
                
            ],
            'producto.codidoBarras',
            'cantidad',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
