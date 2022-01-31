<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\TranspasosDetalle */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transpasos Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="transpasos-detalle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= 
    
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'transpasoId',
            'productoId',
            'cantidad',
            'qtyFrom',
            'qtyFinal',
        ],
    ]);
    

        //create grid for abonos
        // Create a panel layout for your GridView widget
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
                'qtyFrom',
                'qtyFinal'
            ],
            'toolbar' => [
                '{export}',
                '{toggleData}'
            ]
        ]);

    
    ?>

</div>
