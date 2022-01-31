<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Transpasos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transpasos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="transpasos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php 
            if($model->status === 0)
                echo Html::a("Confirmar", ['transpaso', 'id' => $model->id], ['class' => 'btn btn-primary'])
        /*
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) */
        ?>    
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Mando',
                'attribute' => 'userId',
                //'value' => 'user.username',
                'filter' => true 
            ],
            [
                'label' => 'Recibe',
                'attribute' => 'userOkId',
                //'value' => 'user.username',
                'filter' => true 
            ],
            [
                'label' => 'Estado',
                'attribute' => 'status',
                'format' => 'html',
               // 'value' => function ($model) {
                 //   return $model->status === 1 ? "<span style=\"color: green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>" : "<span style=\"color: red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>" ;
                //}
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]);  
    //create grid for transpasos

    //Create a panel layout for your GridView widget
    echo GridView::widget([
        'dataProvider'=> $products,
        //'filterModel' => $searchModelSalidas,
        'showPageSummary' => true,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "Productos",
        ],
        'hover' => true,
        'columns' => [
            'transpasoId',
            'productoId',
            'producto.descripcion',
            'cantidad',
            [
                'label' => 'Origen',
                'attribute' => 'qtyFrom',
                'value' => 'origen.nombre',
                
            ],    
            [
                'label' => 'Destino',
                'attribute' => 'qtyFinal',
                'value' => 'destino.nombre',
                
            ],
        ],
        'toolbar' => [
            '{export}',
            '{toggleData}'
        ]
    ]);?>

</div>
