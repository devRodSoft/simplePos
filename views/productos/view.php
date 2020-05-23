<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;;
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
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*
         Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>


    <?php
            $attributes = [
                'id',
                'codidoBarras',
                'descripcion',
                'precio',
                'cantidad',
            ];

            $ldSucursales = Sucursales::find()->all();
            $sucursales   = ArrayHelper::map($ldSucursales,'id','nombre');   
            
            foreach($ldSucursales  as $sucursal) {                
                $cantidad = SucursalProducto::find()->select("cantidad")->where(['=', 'productoId', $model->id])->andWhere(['=', 'sucursalId', $sucursal->id])->one()->cantidad;
                array_push($attributes, ['label' => $sucursal->nombre, 'value' => $cantidad]);
            }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes
    ]) ?>

</div>
