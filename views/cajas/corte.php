<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\Ventas;

/* @var $this yii\web\View */
/* @var $model app\models\Cajas */

$this->title = "Corte detalle por producto";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cajas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cajas-view">
    
    <?php  /*
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
        ]);*/
        // Create a panel layout for your GridView widget
        echo GridView::widget([
            'dataProvider'=> $data,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => "Corte",
            ],
            'hover' => true,
            'columns' => [

                [
                    'attribute'           => 'ventaId',
                    'width'               => '50px',
                    //'filterInputOptions' => ['placeholder' => 'Any supplier'],
                    'group'               => true, // enable grouping
                    'groupFooter'         => function ($model, $key, $index, $widget) {
                        //if ($model->ventaId == [Totales]) {
                          //  return false;
                       // }
                        // Closure method
                        return [
                            'mergeColumns'   => [[0, 6]], // columns to merge in summary
                            'content'        => [ // content to show in each summary cell
                                //0 => $model->nombre_pelicula,
                                //6 => GridView::F_SUM,
                                
                            ],
                            'contentFormats' => [ // content reformatting for each summary cell
                                //6 => ['format' => 'number', 'decimals' => 0],
                                
                            ],
                            'contentOptions' => [ // content html attributes for each summary cell
                                //1 => ['style' => 'text-align:center'],
                                //6 => ['style' => 'text-align:right'],
                                
                            ],
                            // html attributes for group summary row
                            'options'        => ['class' => 'info table-info', 'style' => 'font-weight:bold;'],
                        ];
                    },
                ],
                [
                    'label' => 'Vendedor',
                    "attribute" => 'ventaId',
                    'width' => '100px',
                    'group' => true,
                    'subGroupOf' => 0,
                    'value' => function ($model) {
                        return $model->ventaId ? $model->venta->user->username : "";
                    }
                ],
                [
                    'label' => 'Tipo de Venta',
                    'attribute' => 'tipoVenta',
                    'width' => '100px',
                    'group' => true,
                    'subGroupOf' => 0,
                    'value' => function ($model) {
                        return $model->venta->tipoVenta === 0 ? "Efectivo" : "Tarjeta";
                    }
                ],
                [
                    'label' => 'Descripcion',
                    'attribute' => 'producto.descripcion',
                    'width' => '300px',
                ],
                [
                    'label' => 'Cantidad',
                    'attribute' => 'cantidad',
                    'width' => '80px',
                ],
                [
                    'label' => "Precio Pieza",
                    'attribute' => 'precio',
                    'filter' => false,
                    'width' => '80px',
                ], 
                [
                    'label' => "Total Pieza",
                    'value' => function ($data) {
                        return $data->cantidad * $data->precio;
                    },
                    'width' => '100px',
                    'filter' => false,
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                ],    
                [
                    'label' => "Descuento",
                    'value' => function ($data) {
                        return $data->venta->descuento;
                    },
                    'width' => '100px',
                    'filter' => false,
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                ], 
                [
                    'label' => "Total",
                    'width' => '80px',
                    'value' => function ($data) {
                        return $data->precio - $data->venta->descuento;
                    },
                    'filter' => false,
                    'group' => true,
                    'subGroupOf' => 0,
                    'pageSummary' => true,
                    
                ],        
            ],
            'toolbar' => [
                '{export}',
                '{toggleData}'
            ]
        ]);
    ?>
</div>
