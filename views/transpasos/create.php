<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transpasos */

$this->title = 'Create Transpasos';
$this->params['breadcrumbs'][] = ['label' => 'Transpasos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transpasos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
