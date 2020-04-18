<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleVenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-venta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ventaId')->textInput() ?>

    <?= $form->field($model, 'productoId')->textInput() ?>

    <?= $form->field($model, 'precio')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
