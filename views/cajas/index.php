<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cajas'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
        $listaSucursales = ArrayHelper::map(Sucursales::find()->all(), 'id', 'nombre');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            'id',
            [
                'label' => 'Sucursal',
                'attribute' => 'sucursalId',
                'filter' => false,
                'value' => function ($model) {
                    return $model->sucursal->nombre;
                }
            ],
            'user.username',
            [
                'label'     =>  'Saldo Inicial',
                'attribute' =>  'saldoInicial',
                'filter'    =>  false
            ],
            'saldoFinal',
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
