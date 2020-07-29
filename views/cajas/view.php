<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Salidas;
use app\models\Ventas;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $model app\models\Cajas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cajas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cajas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        
        <?php 
            if($model->canClose($model->id))
             echo Html::a("Cerrar", ['cerrar', 'id' => $model->id], ['class' => 'btn btn-primary'])
            
        
        
        
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
                'label' => 'Sucursal',
                'attribute' => 'sucursal.nombre',
            ],
            [
                'label' => 'Usuario',
                'attribute' => 'user.username',
            ],
            
            'saldoInicial',
            [
                'label' => 'Ventas en efectivo',
                'value' => Ventas::find()->where(['=', 'cajaId', $model->id])->andWhere(['=', 'tipoVenta', '0'])->sum('total')
            ],
            [
                'label' => 'Ventas con tarjeta',
                'value' => Ventas::find()->where(['=', 'cajaId', $model->id])->andWhere(['=', 'tipoVenta', '1'])->sum('total')
            ],
            [
                'label' => 'Salidas',
                'value' => Salidas::find()->where(['=', 'cajaId', $model->id])->sum('retiroCantidad')
            ],
            [
                'label' => 'Descuentos',
                'value' => Ventas::find()->where(['=', 'cajaId', $model->id])->sum('descuento')
            ],
            [
                'label' => 'Saldo final',
                'value' =>  function ($model) {
                    
                    $Efectivo  = Ventas::find()->where(['=', 'cajaId', $model->id])->andWhere(['=', 'tipoVenta', '0'])->sum('total');                    
                    
                    $salidas   = Salidas::find()->where(['=', 'cajaId', $model->id])->sum('retiroCantidad');

                   // $descuento =  Ventas::find()->where(['=', 'cajaId', $model->id])->sum('descuento');


                    $total = $model->saldoInicial + $Efectivo;
                    $total -= $salidas;
                    //$total -= $descuento;


                    return $total;
                }
            ],
           
        
            //'isOpen',
            //'created_at:dateTime',
            'apertura',
            'cierre',
            //'updated_at',
        ],
    ]) ?>
    <?php          
    /*
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
            //'showPageSummary' => true,
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
                    //'groupedRow'          => true,  
                    'groupFooter'         => function ($model, $key, $index, $widget) {
                        //if ($model->ventaId == [Totales]) {
                          //  return false;
                       // }
                        // Closure method
                        return [
                            'mergeColumns'   => [[0, 6]], // columns to merge in summary
                            'content'        => [ // content to show in each summary cell
                                //0 => $model->nombre_pelicula,
                                7 => GridView::F_SUM,
                                8 => GridView::F_SUM,
                                
                            ],
                            'contentFormats' => [ // content reformatting for each summary cell
                                7 => ['format' => 'number', 'decimals' => 2],
                                8 => ['format' => 'number', 'decimals' => 2],
                                
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
                    'group' => true,
                    'subGroupOf' => 0,
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                ], 
                [
                    'label' => "Total",
                    'width' => '80px',
                    'value' => function ($data) {
                        return $data->venta->total;
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
    <?php 
        // Create a panel layout for your GridView widget
        echo GridView::widget([
            'dataProvider'=> $dataSalidas,
            'filterModel' => $searchModelSalidas,
            'showPageSummary' => true,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => "Salidas",
            ],
            'hover' => true,
            'columns' => [

                //'id',
                //'cajaId',
                [
                    'label' => 'Sucursal',
                    'attribute' => 'sucursalId',
                    'filter' => false,
                    'value' => function ($model) {
                        return $model->sucursal->nombre;
                    }
                ],
                [
                    "label" => "Vendedor",
                    'attribute' => "user.username",
                    'pageSummary' => true,
                ],
                'concepto',
                [
                    'attribute' => "retiroCantidad",
                    'pageSummary' => true,
                    "filter" => false,
                    'pageSummaryFunc' => GridView::F_SUM,
                ],
                
            ],
            'toolbar' => [
                '{export}',
                '{toggleData}'
            ]
        ]);
    ?>
</div>
