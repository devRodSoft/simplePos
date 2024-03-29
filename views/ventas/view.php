<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ventas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'total',
            'descuento',
            'descripcion',
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
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

</div>
