<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VentasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ventas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php /*Html::a('Create Ventas', ['create'], ['class' => 'btn btn-success'])*/ ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'hover' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Vendedor',
                "attribute" => 'userId',
                'value' => function ($model) {
                    return $model->userId ? $model->user->username : "";
                }
            ],
            'total:currency',
            'descuento:currency',
            'descripcion',
            'created_at:datetime',
            [
                'label' => 'Forma de pago',
                'attribute' => 'tipoVenta',
                'value' => function ($model) {
                    return $model->tipoVenta === 0 ? "Efectivo" : "Tarjeta";
                }
            ],
            [
                'label' => 'Venta de',
                'attribute' => 'tipoVenta',
                'value' => function ($model) {
                    return $model->ventaApartado === 0 ? "Contado" : "Credito";
                }
            ],
            [
                'label' => 'Liquidado',
                'attribute' => 'tipoVenta',
                'value' => function ($model) {
                    return $model->liquidado === 1 ? "si" : "no";
                }
            ],
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'visible' => Yii::$app->user->identity->userType == User::SUPER_ADMIN
            ]     
        ],
    ]); ?>


</div>
