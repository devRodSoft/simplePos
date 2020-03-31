<?php
use yii\helpers\Html;    
use richardfan\widget\JSRegister;
/* @var $this yii\web\View */

$this->title = 'Punto de Venta';
?>
<div class="site-index">
    <div class="container">
        <h2>Producto</h2>
        <input type="text" class="form-control" id="barCode" aria-describedby="basic-addon3">
    </div>
    <div class="container">
        <h2>Datos de venta</h2>
        <div>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Precio</th>
                    </tr>
                </thead>
                <tbody id="productos">
                </tbody>
            </table>
            <div>
                <input placeholder="Descuento" type="text" class="form-control" id="descuento" aria-describedby="basic-addon3">
                <h1 id="total"></h1>
            </div>
            
            <div>
                <button id="pagar" class="btn btn-success">Pagar</button>
                <button id="cancelar" class="btn btn-warning">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<?php JSRegister::begin(); ?>
<script>

    var total = 0;       
    var descuento = 0; 
    var productos = [];    


    $('#descuento').on('keypress', function getProducto(e){
        if (e.which != 13)
            return

        descuento = this.value;
        total -= descuento;
        $('#total').text(total);
    });

    $('#pagar').on('click', function () {        
        url =   "<?php echo Yii::$app->request->baseUrl; ?>" + "/ventas/pagar/";
        $.post(url, {'total': total, 'descuento': descuento, 'productos': productos})
            .done(function( data ) {
                url = "http://localhost/simpleprint/index.php";

                $.post(url, {'total': total, 'descuento': descuento, 'productos': productos})
                    .done(function( data ) {
                    console.log("print ticket!")
                    productos = [];
                });
                resetDatos();
            });
    });



    
        

 


    //New login Refactor start here! 


    //helpers

    /* Reset the sale data */
    function resetDatos() {
        $('#descuento').val("");
        $('#barCode').val("");        
        $('#total').text("")
        $('.detalle').remove();
        total = 0;
        descuento = 0;
    }


    //Buttons actions 
    $('#cancelar').on('click', function clear() {
        resetDatos();
    });
    // Add selected items and do the validations to quantity! 
    var selectedItems = [];
    function selectedItems (item) {
        
        if (selectedItems.length == 0) {
            selectedItems.push(Object.assing(item, {selectedCantidad: 1}));
            console.log(selectedItems);
        } else {
            debugger
        }
    }

    //Add to car productos
    $('#barCode').on('keypress', function getProducto(e) {
        if (e.which != 13)
            return

        var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/productos/producto/" + this.value;
        $.get(url)
            .done(function(producto) { 
               var desc = '<td>' + producto.descripcion + '</td>';
               var precio = '<td>' + producto.precio + '</td>';
               productos.push(producto);
               selectedItems(producto);
               $('#productos').append('<tr class=\"detalle\">'+desc+precio+'</tr>');
               total += producto.precio;
               $('#total').text(total);
               $('#barCode').val("");
            })
            .fail(function(jqXHR, textStatus, errorThrown) { 
                $('#barCode').val("");
                console.log("fail");
            });
    });




</script>
<?php JSRegister::end(); ?>