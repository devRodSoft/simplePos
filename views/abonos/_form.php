<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Cajas;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model app\models\Abonos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="abonos-form">

    <?php $form = ActiveForm::begin(); 
        $caja = new Cajas();
    ?>

    <?php echo $form->field($model, 'clienteId')->hiddenInput([$model->clienteId])->label(false); ?>

    <?php echo $form->field($model, 'ventaId')->hiddenInput([$model->ventaId])->label(false); ?>

    <?php echo $form->field($model, 'userId')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false); ?>    

    <?php echo $form->field($model, 'cajaId')->hiddenInput(['value' => $caja->getIdOpenCaja()->id])->label(false); ?>

    <?= $form->field($model, 'abono')->textInput() ?>

    <?= $form->field($model, 'restante')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php JSRegister::begin(); ?>
<script>
    var restanteInitial = $('#abonos-restante').val();
    
    $('#abonos-abono').on('blur', function () {
        if (this.value) {
            newRestante = restanteInitial - this.value;
        } else {
            newRestante = restanteInitial;
        }

        $('#abonos-restante').val(newRestante);
    });

    $('#abonos-abono').on('keypress', function (ele){
            if (ele.which != 13)
             return

            if (this.value) {
                newRestante = restanteInitial - this.value;
            } else {
                newRestante = restanteInitial;
            }
            
            $('#abonos-restante').val(newRestante);
        });

</script>
<?php JSRegister::end(); ?>