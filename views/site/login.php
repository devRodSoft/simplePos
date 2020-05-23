<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'smartPOS';
?>
<div class="site-login">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]);
        
        //rod changues
    ?>
        <div class="forms">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Usuario') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Contraseña')?>
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>