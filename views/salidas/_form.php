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
        
        $oCajas = new Cajas();
?>

<div class="salidas-form">

    <?php $form = ActiveForm::begin();?>
 
    <?php echo $form->field($model, 'cajaId')->hiddenInput(['value' =>  $oCajas->getIdOpenCaja()->id])->label(false); ?> 

    <?php echo $form->field($model, 'sucursalId')->hiddenInput(['value' =>  Yii::$app->user->identity->sucursalId])->label(false); ?> 

    <?php echo $form->field($model, 'userId')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false); ?>

    <?= $form->field($model, 'retiroCantidad')->textInput() ?>
    
    <?= $form->field($model, 'concepto')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
