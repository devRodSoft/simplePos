<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Clientes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clientes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Abonar', ['abonos/create', 'id' => $model->id, 'total' => $ventatotal, 'ventaId' => $ventaId, 'restante' => $restante], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= 
     var_dump($restante);
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'direccion',
            'entreCalles',
            'codigoPostal',
            'telefono',
            'notas',
            //'created_at',
            //'updated_at',
        ],
    ]) ?>



    <?= GridView::widget([
        'dataProvider' => $abonos,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "Abonos",
        ],
        'hover' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'clienteId',
            'ventaId',
            'userId',
            'cajaId',
            'abono',
            'restante'
        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $ventaAparados,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "Venta",
        ],
        'hover' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Vendedor',
                "attribute" => 'userId',
                'value' => function ($model) {
                    return $model->userId ? $model->user->username : "";
                }
            ],
            'total:currency',
            'descuento:currency',
            'descripcion',
            'created_at:datetime',
            [
                'label' => 'Forma de pago',
                'attribute' => 'tipoVenta',
                'value' => function ($model) {
                    return $model->tipoVenta === 0 ? "Efectivo" : "Tarjeta";
                }
            ],
            [
                'label' => 'Venta de',
                'attribute' => 'tipoVenta',
                'value' => function ($model) {
                    return $model->ventaApartado === 0 ? "Contado" : "Credito";
                }
            ],
            [
                'label' => 'Liquidado',
                'attribute' => 'tipoVenta',
                'value' => function ($model) {
                    return $model->liquidado === 1 ? "si" : "no";
                }
            ],
            //'updated_at',

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

        
    <?php echo GridView::widget([
        'dataProvider'=> $detalleVenta,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "Productos",
        ],
        'hover' => true,
        'columns' => [
            //'id',
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
        'toolbar' => [
            '{export}',
            '{toggleData}'
        ]
    ]);
    ?>


</div>
