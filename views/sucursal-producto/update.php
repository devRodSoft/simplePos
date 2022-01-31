<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SucursalProducto */

$this->title = Yii::t('app', '{name} / {sucursal}', [
    'name'     => $model->producto->descripcion,
    'sucursal' => $model->sucursal->nombre
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sucursal Productos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>$model->producto->descripcion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sucursal-producto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
