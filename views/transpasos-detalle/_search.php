<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TranspasosDetalleSeach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transpasos-detalle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'transpasoId') ?>

    <?= $form->field($model, 'productoId') ?>

    <?= $form->field($model, 'cantidad') ?>

    <?= $form->field($model, 'qtyFrom') ?>

    <?php // echo $form->field($model, 'qtyFinal') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
