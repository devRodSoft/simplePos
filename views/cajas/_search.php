<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CajasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cajas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sucursalId') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'saldoInicial') ?>

    <?= $form->field($model, 'saldoFinal') ?>

    <?php // echo $form->field($model, 'isOpen') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'apertura') ?>

    <?php // echo $form->field($model, 'cierre') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
