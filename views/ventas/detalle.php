<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model app\models\Cajas */

$this->title = "Venta detalle por producto";
$this->params['breadcrumbs'][] = ['label' => "Ventas", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cajas-view">

    <h1>Detalles de venta</h1>
    <button class="btn btn-primary" id="print">Imprimir Venta</button>
    <?php 
       echo ExportMenu::widget([
            'dataProvider' => $data,
            'columns' => [
                [
                    'attribute' => 'ventaId',
                    'group'     => true,
                    'filter'      => false
                ],
                'producto.descripcion',
                'cantidad',
                [
                    'label' => "Precio unitario",
                    'attribute' => 'precio',
                    'filter' => false
                ], 
                [
                    'label' => "Precio total",
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'value' =>  function ($data) {
                        return $data->cantidad * $data->precio;
                    }
                ],
            ],
            'dropdownOptions' => [
                'label' => 'Exportar',
                'class' => 'btn btn-secondary'
            ],
            'filename' => 'Corte - ' . date("d-m-Y")
        ]);
        // Create a panel layout for your GridView widget
        echo GridView::widget([
            'dataProvider'=> $data,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
            'hover' => true,
            'columns' => [
                //'id',
                [
                    'attribute' => 'ventaId',
                    'group'     => true,
                    'filter'      => false
                ],
                'producto.descripcion',
                'cantidad',
                [
                    'label' => "Precio Pieza",
                    'attribute' => 'precio',
                    'filter' => false
                ], 
                [
                    'label' => "Precio total",
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'value' =>  function ($data) {
                        return $data->cantidad * $data->precio;
                    }
                ], 
            ],
            'toolbar' => [
                '{export}',
                '{toggleData}'
            ]
        ]);
    ?>
    
</div>
<?php JSRegister::begin(); ?>
<script>
        var data = '<?php echo $print; ?>';
        dataParse = JSON.parse(data);

        $('#print').on('click', function () {
            print();
        })

        function print() {
            url = "http://localhost/simpleprint/index.php";
            $.post(url, dataParse)
            .done(function( data ) {
                console.log("print ticket!")          
            });
        }
        

</script>
<?php JSRegister::end(); ?>