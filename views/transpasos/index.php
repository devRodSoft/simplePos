<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TranspasosSeach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transpasos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transpasos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Mando',
                'attribute' => 'userId',
                'value' => 'mando.username',
                'filter' => true 
            ],
            [
                'label' => 'Recibe',
                'attribute' => 'userOkId',
                'value' => 'recibe.username',
                'filter' => true 
            ],
            
            [
                'label' => 'Estado',
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->status === 1 ? "<span style=\"color: green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>" : "<span style=\"color: red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>" ;
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
