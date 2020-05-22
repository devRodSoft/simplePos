<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $model app\models\Cajas */

$this->title = "Corte detalle por producto";
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
                [
                    'attribute' => 'ventaId',
                    'group'     => true,
                    'filter'      => false
                ],
                'producto.descripcion',
                'cantidad',
                [
                    'label' => "Precio Pieza",
                    'attribute' => 'precio',
                    'filter' => false
                ], 
                [
                    'label' => "Precio total",
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'value' =>  function ($data) {
                        return $data->cantidad * $data->precio;
                    }
                ],
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
                [
                    'attribute' => 'ventaId',
                    'group'     => true,
                    'filter'      => false
                ],
                [
                    'label' => 'Vendedor',
                    "attribute" => 'ventaId',
                    'value' => function ($model) {
                        return $model->ventaId ? $model->venta->user->username : "";
                    }
                ],
                [
                    'label' => 'Tipo de Venta',
                    'attribute' => 'tipoVenta',
                    'value' => function ($model) {
                        return $model->venta->tipoVenta === 0 ? "Efectivo" : "Tarjeta";
                    }
                ],
                'producto.descripcion',
                'cantidad',
                [
                    'label' => "Precio Pieza",
                    'attribute' => 'precio',
                    'filter' => false
                ], 
                [
                    'label' => 'Descuento',
                    'group' => true,
                    'subGroupOf' => 0,
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'value' =>  function ($data) {
                        return $data->venta->descuento;
                    }
                ],
                [
                    'label' => 'Total venta',
                    'group' => true,
                    'subGroupOf' => 0,
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'value' =>  function ($data) {
                        return $data->venta->total;
                    }
                ]                
            ],
            'toolbar' => [
                '{export}',
                '{toggleData}'
            ]
        ]);
    ?>
</div>
