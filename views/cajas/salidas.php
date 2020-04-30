<?php

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Cajas */

$this->title = "Salidas";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cajas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cajas-view">

    <h1>Salidas Detalle</h1>
    
    <?php 
        // Create a panel layout for your GridView widget
        echo GridView::widget([
            'dataProvider'=> $data,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
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
