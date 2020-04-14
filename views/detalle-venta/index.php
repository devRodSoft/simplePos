<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleVentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalle Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-venta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Detalle Venta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

           // 'id',
            //'ventaId',
            'producto.descripcion',
            [
                'label' => "precio Unitario",
                'attribute' => "precio",
                'filter' => false
            ],
            'cantidad',
            'created_at:dateTime',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
