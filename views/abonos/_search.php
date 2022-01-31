<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AbonosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="abonos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'clienteId') ?>

    <?= $form->field($model, 'ventaId') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'cajaId') ?>

    <?php // echo $form->field($model, 'abono') ?>

    <?php // echo $form->field($model, 'restante') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
