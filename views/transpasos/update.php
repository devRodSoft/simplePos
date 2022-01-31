<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transpasos */

$this->title = 'Update Transpasos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transpasos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transpasos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
