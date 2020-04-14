<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cajas */

$this->title = Yii::t('app', 'Create Cajas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cajas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cajas-create">

    <h1>Para poder vender tienes que abrir una caja!</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
