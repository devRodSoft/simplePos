<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\SucursalProducto;
use app\models\Sucursales;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="productos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actulizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*
         Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codidoBarras',
            'descripcion',
            'precio',
            'cantidad',
            [
                'label' => Sucursales::find()->where(['=', 'id', 1])->one()->nombre,
                "value" =>  SucursalProducto::find()->select("cantidad")->where(['=', 'productoId', $model->id])->andWhere(['=', 'sucursalId','1'])->one()->cantidad                
            ],
            [
                'label' => Sucursales::find()->where(['=', 'id', 2])->one()->nombre,
                "value" => SucursalProducto::find()->select("cantidad")->where(['=', 'productoId', $model->id])->andWhere(['=', 'sucursalId','2'])->one()->cantidad
            ]
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

</div>
