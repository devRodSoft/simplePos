<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TranspasosDetalle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transpasos-detalle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transpasoId')->textInput() ?>

    <?= $form->field($model, 'productoId')->textInput() ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <?= $form->field($model, 'qtyFrom')->textInput() ?>

    <?= $form->field($model, 'qtyFinal')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
