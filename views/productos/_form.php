<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Sucursales;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="productos-form">

    <?php $form = ActiveForm::begin();

        $ldSucursales = Sucursales::find()->all();
        $sucursales   = ArrayHelper::map($ldSucursales,'id','nombre');   

    ?>

    <?= $form->field($model, 'codidoBarras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'costo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio')->textInput() ?>

    <?= $form->field($model, 'precio1')->textInput() ?>

    <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true])->label("Almacen") ?>

    <?php
        foreach($ldSucursales  as $sucursal) {
            echo Html::label("cantidad - " . $sucursal->nombre, 'sucu');
            
            echo Html::hiddenInput('sucursal'.$sucursal->id, $sucursal->id);

            echo  Html::input('text', "cantidad" . $sucursal->id, '', $options=['class'=>'form-control']);
        }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
