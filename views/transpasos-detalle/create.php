<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TranspasosDetalle */

$this->title = 'Create Transpasos Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Transpasos Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transpasos-detalle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
