<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $model app\models\Cajas */

$this->title = "Corte";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cajas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cajas-view">

    <h1>Corte</h1>

    <?php 
        echo ExportMenu::widget([
            'dataProvider' => $data,
            'columns' => [
                //'id',
                [
                    'attribute' => 'ventaId',
                    'group'     => true,
                    'filter'      => false
                ],
                
                'cantidad',
                'producto.descripcion',
                [
                    'attribute' => 'venta.descuento',
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM
                ],                
                [
                    'attribute' => 'venta.total',
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM
                ]
            ],
            'dropdownOptions' => [
                'label' => 'Exportar',
                'class' => 'btn btn-secondary'
            ],
            'filename' => 'Corte - ' . date("d-m-Y")
        ]);
        // Create a panel layout for your GridView widget
        echo GridView::widget([
            'dataProvider'=> $data,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
            'hover' => true,
            'columns' => [
                //'id',
                [
                    'attribute' => 'ventaId',
                    'group'     => true,
                    'filter'      => false
                ],
                
                'cantidad',
                'producto.descripcion',
                [
                    'attribute' => 'venta.descuento',
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM
                ],                
                [
                    'attribute' => 'venta.total',
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM
                ]
            ],
            'toolbar' => [
                '{export}',
                '{toggleData}'
            ]
        ]);
    ?>
</div>
