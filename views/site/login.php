<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'smartPOS';
?>
<div class="container">
    <div class="row">
        <div class="col">
        <?php echo Html::img( Url::base(true) . "/img/logo.png", ['class' => 'login-logo']) ?>
        <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"login-error\">{error}</div>",
                    //'labelOptions' => ['class' => 'control-label'],
                ],
            ]);        
            ?>
                
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Usuario')->label(false) ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Contraseña')->label(false)?>
            
            <div class="form-group">
                <div>
                    <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary login-btn', 'name' => 'login-button']) ?>
                </div>
            </div>
                
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>