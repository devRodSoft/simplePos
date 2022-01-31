<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SucursalProducto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sucursal-producto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sucursalId')->textInput() ?>

    <?= $form->field($model, 'productoId')->textInput() ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
