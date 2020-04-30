<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Salidas;
use app\models\DetalleVenta;

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
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        
        <?= Html::a("Ventas", ['corte', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a("Salidas", ['salidas', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
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
                'label' => 'Ventas Efectivo',
                'value' => DetalleVenta::find()->joinWith('venta v')
                ->where(['in', 'v.cajaId', $model->id])->andWhere(['=', 'tipoVenta', '0'])->sum('total')
            ],
            [
                'label' => 'Ventas Targeta',
                'value' => DetalleVenta::find()->joinWith('venta v')
                ->where(['in', 'v.cajaId', $model->id])->andWhere(['=', 'tipoVenta', '1'])->sum('total')
            ],
            [
                'label' => 'Salidas',
                'value' => Salidas::find()->where(['=', 'cajaId', $model->id])->sum('retiroCantidad')
            ],
            [
                'label' => 'Saldo Final',
                'value' =>  function ($model) {
                    $Efectivo = DetalleVenta::find()->joinWith('venta v')
                    ->where(['in', 'v.cajaId', $model->id])->andWhere(['=', 'tipoVenta', '0'])->sum('total');

                    $targeta = DetalleVenta::find()->joinWith('venta v')
                    ->where(['in', 'v.cajaId', $model->id])->andWhere(['=', 'tipoVenta', '1'])->sum('total');

                    $salidas = Salidas::find()->where(['=', 'cajaId', $model->id])->sum('retiroCantidad');

                    return ($model->saldoInicial + $Efectivo) - $salidas;
                }
            ],
        
            //'isOpen',
            //'created_at:dateTime',
            'apertura',
            'cierre',
            //'updated_at',
        ],
    ]) ?>

</div>
