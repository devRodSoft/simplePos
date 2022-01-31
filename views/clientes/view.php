<?php

use yii\helpers\Html;
use yii\helpers\Url;;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Clientes */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clientes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Abonar', ['abonos/create', 'id' => $model->id, 'total' => $ventatotal, 'ventaId' => $ventaId, 'restante' => $restante], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= 
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
            [
                'label' => 'Estado',
                //'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->venta->status === 0 ? "<span style=\"color: green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>" : "<span style=\"color: red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>" ;
                }
            ],
            'ventaId',
            [
                'label' => 'Vendedor',
                "attribute" => 'userId',
                'value' => function ($model) {
                    return $model->userId ? $model->user->username : "";
                }
            ],
            //'cajaId',
            'abono',
            'restante',
            'created_at:datetime'
        ],
    ]); 
    ?>

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
            [
                'label' => 'Estado',
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->status === 0 ? "<span style=\"color: green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>" : "<span style=\"color: red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>" ;
                }
            ],
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['ventas/delete', 'id' => $model->id, 'keep' => true, 'clienteId' => Yii::$app->request->get('id')]);
                },
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
