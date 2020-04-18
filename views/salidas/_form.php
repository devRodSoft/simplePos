<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Sucursales;
use app\models\Cajas;


/* @var $this yii\web\View */
/* @var $model app\models\Salidas */
/* @var $form yii\widgets\ActiveForm */


        /* Get data for dopdowns */
        $ldSucursales = Sucursales::find()->all();
        $sucursales   = ArrayHelper::map($ldSucursales,'id','nombre');   

        /* Get data for dopdowns */
        $ldCajas = Cajas::find()->all();
        $cajas   = ArrayHelper::map($ldCajas,'id','sucursal.nombre');   
?>

<div class="salidas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'cajaId')->dropDownList($cajas, ['prompt'=>'Selecciona una caja.'] )->label('Caja');?>
    
    <?php echo $form->field($model, 'sucursalId')->dropDownList($sucursales, ['prompt'=>'Selecciona una sucursal.'] )->label('Sucursal');?>

    <?php echo $form->field($model, 'userId')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false); ?>

    <?= $form->field($model, 'retiroCantidad')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
