<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php
        $userTypes = [0 => 'Administrador', 1 => 'Vendedor'];
        $form = ActiveForm::begin(); 
    ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Nombre ususario') ?>


    <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>

    <?php echo $form->field($model, 'userType')->dropDownList($userTypes, ['prompt'=>'Selecciona el tipo de usuario.'] )->label('Tipo de Usuario');?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
