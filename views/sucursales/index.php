<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SucursalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sucursales');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sucursales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Nueva sucursal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',

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

    <?php Pjax::end(); ?>

</div>
