<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Abonos */

$this->title = 'Create Abonos';
$this->params['breadcrumbs'][] = ['label' => 'Abonos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="abonos-create">

    <h1><?= Html::encode("Total: " . $ventaTotal) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
