<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use app\models\Sucursales;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';

$ldSucursales = Sucursales::find()->all();
$sucursales   = ArrayHelper::map($ldSucursales,'id','nombre');    
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Agregar usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            [
                'label' => 'Sucursal',
                'attribute' => 'sucursalId',
                'filter' => $sucursales,
                'value' =>  function ($model, $key, $index, $column) {
                    return $model->sucursal->nombre;
                }

                 
            ],
            //'auth_key',
            //'password_hash',
            //'password_reset_token',            
            //'status',
            //'created_at',
            //'updated_at',
            [
                'label' => 'Tipo de usuario',
                'attribute' => 'userType',
                'filter' => ['0' => 'Administrador', '1' => 'Vendedor'],
                'value' =>  function ($model, $key, $index, $column) {
                    return $model->userType == '0' ? 'Administador' : 'Vendedor';
                }
            ],

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
