<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Sucursales;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CajasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cajas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cajas-index">

    <p>
        <?= Html::a(Yii::t('app', 'Abrir nueva caja'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
        $listaSucursales = ArrayHelper::map(Sucursales::find()->all(), 'id', 'nombre');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "Cortes de Caja",
        ],
        'hover' => true,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            'id',
            [
                'attribute' => 'sucursalId',
                'label' => 'Sucursal',
                'value' => 'sucursal.nombre',
                'filter' => ArrayHelper::map(Sucursales::find()->all(), 'id', 'nombre')
            ],
            [
                'attribute' => 'userId',
                'label' => 'Empleado',
                'value' => 'user.username',
                'filter' => ArrayHelper::map(User::find()->all(), 'id', 'username'),
            ],
            [
                'attribute' => 'Saldo Final',
                'value' => 'saldoFinal',
                'filter' => false
            ],
            //'isOpen',
            'created_at:datetime',
            //'apertura',
            //'cierre',
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
