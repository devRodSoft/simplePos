<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sucursales;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SucursalProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sucursal Productos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sucursal-producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
        $listaSucursales = ArrayHelper::map(Sucursales::find()->all(), 'id', 'nombre');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => 'Sucursal',
                'attribute' => 'sucursalId',
                'filter' => $listaSucursales,
                'value' => function ($model) {
                    return $model->sucursal->nombre;
                }
            ],
            [
                'attribute' => 'producto',
                'value' => 'producto.descripcion',
                'filter' => true
            ],
            [
                'attribute' => 'barcode',
                'value' => 'producto.codidoBarras',
                'filter' => true 
            ],
            'cantidad:integer',    
        ],
    ]); ?>


</div>
