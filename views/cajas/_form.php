<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Sucursales;

/* @var $this yii\web\View */
/* @var $model app\models\Cajas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cajas-form">

    <?php 
        $form = ActiveForm::begin();

        /* Get data for dopdowns */
        $ldSucursales = Sucursales::find()->all();
        $sucursales   = ArrayHelper::map($ldSucursales,'id','nombre');    
    ?>

    <?php echo $form->field($model, 'sucursalId')->dropDownList($sucursales, ['prompt'=>'Selecciona una Sucursal'])->label('Sucursal');?>

    <?php echo $form->field($model, 'userId')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false); ?>    

    <?= $form->field($model, 'saldoInicial')->textInput() ?>

    <?php echo $form->field($model, 'apertura')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
