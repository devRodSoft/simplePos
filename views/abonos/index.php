<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AbonosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Abonos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="abonos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Abonos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'cliente.nombre',
            'ventaId',
            'user.username',
            'cajaId',
            'venta.total',
            'abono',
            'restante',
            
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
