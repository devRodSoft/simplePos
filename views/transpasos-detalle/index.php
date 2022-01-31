<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TranspasosDetalleSeach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transpasos Detalles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transpasos-detalle-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'transpasoId',
            'producto.descripcion',
            'cantidad',
            'qtyFrom',
            'qtyFinal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 

    ?>
    


</div>
