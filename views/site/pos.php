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
        <div class="container">
            <div class="col-md-3">
                
                <h2>Sucursal</h2>
                <select name="sucursales" id="sucursales" class="form-control">
                    <option value="1" selected>Seduction 1</option>
                    <option value="2">Seduction 2</option>
                </select>
            </div>
            <div class="col-md-3">
                
                <h2>Precio</h2>
                <select name="sucursales" id="precios" class="form-control">
                    <option value="1" selected>Menudeo</option>
                    <option value="2">Mayoreo</option>
                </select>
            </div>
        </div>
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
    toastr.options.newestOnTop = false; 

    var total = 0;       
    var descuento = 0; 
    var productos = [];  
    var cart = [];  
    var sucursalSelected = $("#sucursales :selected").val();
    var precioSelected   = $("#precios :selected").val();


    //Buttons actions
    $('#precios').change(function (element) {
        precioSelected = $("#sucursales :selected").val();
        showCart();
    })

    $('#sucursales').on('change', function (element) {
        sucursalSelected = $("#sucursales :selected").val();
    })

    $('#descuento').on('keypress', function getProducto(e){
        if (e.which != 13)
            return

        descuento = this.value;
        total -= descuento;
        $('#total').text(total);
    });

    $('#pagar').on('click', function () {        
        url =   "<?php echo Yii::$app->request->baseUrl; ?>" + "/ventas/pagar/";
        $.post(url, {'total': total, 'descuento': descuento, 'precioSelected': precioSelected, 'productos': cart})
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

    $('#cancelar').on('click', function clear() {
        resetDatos();
    });

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

    //Find a product
    $('#barCode').on('keypress', function getProducto(e) {
        if (e.which != 13)
            return

        var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/productos/producto/" + this.value + "/" + sucursalSelected;
        $.get(url)
            .done(function(producto) {           

               //check if product exist 
               if (!producto.length) {
                 toastr.warning('No se encontro el producto o no tienes existencias!');     
                 return;
               }
                    
               //producto is the data to print the ticket              
               productos.push(producto[0]);
               selectedItems(producto[0]);
            
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
        } else {
            findItems(item);
        }
    }

    function findItems(item) {
        //flag to check if items exist in the curent cart
        found = false;
        
        for (index in cart) {
            if (cart[index].producto.id == item.producto.id) {
                //console.log(cart[index],  item);

                //check if can  add one more product check from sucursal producto cantidad
                if (cart[index].selectedCantidad + 1 > cart[index].cantidad ){
                    toastr.warning('Ya no tienes existencias disponibles');
                    return
                }
                    
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
        var totalPrice = 0;
        //Remove the items
        $('.detalle').remove();
        
        for (product in cart) {
            var productTotal = '<td>' + cart[product].selectedCantidad + '</td>'
            var desc = '<td>' + cart[product].producto.descripcion + '</td>';

            if ($("#precios :selected").val() == 1) {
                var precio = '<td>' + (cart[product].selectedCantidad * cart[product].producto.precio) + '</td>';
                totalPrice += (cart[product].selectedCantidad * cart[product].producto.precio);
            } else {
                var precio = '<td>' + (cart[product].selectedCantidad * cart[product].producto.precio1) + '</td>';
                totalPrice += (cart[product].selectedCantidad * cart[product].producto.precio1);
            }
            
            $('#productos').append('<tr class=\"detalle\">'+productTotal+desc+precio+'</tr>');
        }
        $('#total').text(totalPrice);
    }

</script>
<?php JSRegister::end(); ?>
