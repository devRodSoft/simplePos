<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SucursalProducto */

$this->title = Yii::t('app', 'Create Sucursal Producto');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sucursal Productos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sucursal-producto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
