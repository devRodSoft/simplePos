<?php
use yii\helpers\Html;    
use richardfan\widget\JSRegister;
use app\models\Sucursales;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */

$this->title = 'Punto de Venta';

?>
<div class="site-index">
    <div class="container">
        <h2>Sucursal</h2>
        <select name="hall" id="sucursales" value="1">
            <option value="1">Seduction 1</option>
            <option value="2">Seduction 2</option>
        </select>
        <h2>Producto</h2>
        <input type="text" class="form-control" id="barCode" aria-describedby="basic-addon3">
    </div>
    <div class="container">
        <h2>Datos de venta</h2>
        <div>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Cantidad</th>
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
    var cart = [];  


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
        cart = [];
    }


    //Buttons actions 
    $('#cancelar').on('click', function clear() {
        resetDatos();
    });


    //Add to car productos
    $('#barCode').on('keypress', function getProducto(e) {
        if (e.which != 13)
            return

        var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/productos/producto/" + this.value;
        $.get(url)
            .done(function(producto) { 
               var desc = '<td>' + producto.descripcion + '</td>';
               var precio = '<td>' + producto.precio + '</td>';
              
               //producto is the data to print the ticket              
               productos.push(producto);
               selectedItems(producto);
               //$('#productos').append('<tr class=\"detalle\">'+desc+precio+'</tr>');
               total += producto.precio;
               $('#total').text(total);
               $('#barCode').val("");
            })
            .fail(function(jqXHR, textStatus, errorThrown) { 
                $('#barCode').val("");
                console.log("fail");
            });
    });

    // Add selected items and do the validations to quantity! 
    
    function selectedItems (item) {
       // console.log(item);
        if (cart.length == 0) {
            
            //selectedItemsArr.push(Object.assing(item, {selectedCantidad: 1}));
            item.selectedCantidad = 1;
            cart.push(item);
            showCart();
            //console.log(item);
            //console.log(selectedItemsArr);
        } else {
            findItems(item);
        }
    }

    function findItems(item) {
        //flag to check if items exist in the curent cart
        found = false;
        
        for (index in cart) {
            if (cart[index].codidoBarras == item.codidoBarras) {
                console.log(cart[index].codidoBarras,  item.codidoBarras);
                cart[index].selectedCantidad +=1;
                found = true;
               // break;
            }
            
        }

        // If is a new item add in the cart
        if (!found) {
            item.selectedCantidad = 1;
            cart.push(item);
        }

        console.log("new");
        console.log(cart);
        showCart();
    }


    function showCart() {
        //Remove the items
        $('.detalle').remove();
        
        for (product in cart) {
            var productTotal = '<td>' + cart[product].selectedCantidad + '</td>'
            var desc = '<td>' + cart[product].descripcion + '</td>';
            var precio = '<td>' + (cart[product].selectedCantidad * cart[product].precio) + '</td>';
               
            
            $('#productos').append('<tr class=\"detalle\">'+productTotal+desc+precio+'</tr>');
        }
    }



</script>
<?php JSRegister::end(); ?>
