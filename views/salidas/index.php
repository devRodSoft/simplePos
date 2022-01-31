<?php

use yii\helpers\Html;
use app\models\User;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalidasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salidas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salidas-index">

    <p>
        <?= Html::a('Nueva retiro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showPageSummary' => true,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "Retiros de Caja",
        ],
        'hover' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'cajaId',
            [
                'label' => 'Caja',
                'attribute' => 'cajaId',
                'filter' => false
            ],
            'sucursal.nombre',
            'user.username',
            'retiroCantidad',
            [
                'label' => 'Concepto',
                'attribute' => 'concepto',
                'filter' => false,
            ],
            //'created_at',
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
