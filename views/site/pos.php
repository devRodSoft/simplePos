<?php
use yii\helpers\Html;    
use richardfan\widget\JSRegister;
use app\models\Sucursales;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use app\models\Productos;

/* @var $this yii\web\View */

$this->title = 'Punto de Venta';

?>
<div class="site-index">
    <div class="container">
        <div class="container">
            <div class="col-md-3">
                <h2>Sucursal</h2>
                <select name="sucursales" id="sucursales" class="form-control">
                    <option value="1" selected>Seduction centro</option>
                    <option value="2">Seduction 2 central</option>
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
        <div class="row">
            <div class="col-md-6">
            <h2>Codigo</h2>
                <input type="text" class="form-control" id="barCode" aria-describedby="basic-addon3">
            </div>
            <div class="col-md-6">
                <h2>Descripcion</h2>

                    <?php 
                    $data = Productos::find()
                    ->select(['descripcion as value', 'descripcion as label','id as id'])
                    ->asArray()
                    ->all();
        
                    echo AutoComplete::widget([    
                    'clientOptions' => [
                    'source' => $data,
                    'minLength'=>'3', 
                    'options' => ['class' => 'form-control'],    
                    'select' => new JsExpression("function( event, ui ) {
                        $('#descripcion').val(ui.item.id);
                        findByDescription(ui.item.id);
                        //#memberssearch-family_name_id is the id of hiddenInput.
                        }")],
                    ]);

                ?>
            </div>
        </div>
        
    </div>
    <div class="container">
        <h2>Datos de venta</h2>
        <div>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Sucursal</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="productos">
                </tbody>
            </table>
            <div>
                <input placeholder="Descuento" type="text" class="form-control" id="descuento" aria-describedby="basic-addon3">
                <h1 id="total"></h1>
            </div>
            
            <div class="row">

                <div class="col-md-4">
                    <button id="cancelar" class="btn btn-warning">Cancelar</button>
                </div>
                <div class="col-md-4">
                    <label for="">Anticipo</label>
                    <input type="text" id="anticipo" class="form-control text-apartar" style="display: inline; width:129px;">
                    <button id="apartar" class="btn btn-success">Apartar</button>
                </div>

                <div class="col-md-4">
                    <label for="">Pago con targeta?</label>
                    <input type="checkbox" name="targeta" id="pagoTargeta">
                    <button id="pagar" class="btn btn-success">Pagar</button>
                </div>
                
                
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
    var productosFound = [];
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
        $.post(url, {'total': total, 'descuento': descuento, 'precioSelected': precioSelected, 'tipoVenta': $('#pagoTargeta').prop('checked'), 'productos': cart})
            .done(function( data ) {
                url = "http://localhost/simpleprint/index.php";

                $.post(url, {'total': total, 'descuento': descuento, 'productos': productos})
                    .done(function( data ) {
                    console.log("print ticket!")
                    toastr.success('Venta realizada');
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
            .done(function(productos) {           
                //check products exist
               //check if product exist 
               if (!productos.length) {
                 toastr.warning('No se encontro el producto!');     
                 return;
               } 
               
               if (productos.length>1) {
                   for (index in productos) {
                       if (productos[index].sucursalId == sucursalSelected) {
                            productos.push(productos[index]);
                            selectedItems(productos[index]);
                       }
                   }
               } else {
                    productos.push(productos[0]);
                    selectedItems(productos[0]);
               }

               $('#barCode').val("");
            })
            .fail(function(jqXHR, textStatus, errorThrown) { 
                $('#barCode').val("");
                console.log("fail");
            });
    });

    //find by barcode 
    function findByBarcode (barcode, sucursal) {
        var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/productos/producto/" + barcode + "/" + sucursal;
        console.log(url);
        $.get(url)
            .done(function(productos) {                          
                //check products exist
               //check if product exist 
               if (!productos.length) {
                 toastr.warning('No se encontro el producto!');     
                 return;
               } 
               
               if (productos.length>=1) {
                   for (index in productos) {
                       if (productos[index].sucursalId == sucursal) {
                            productos.push(productos[index]);
                            selectedItems(productos[index]);
                       }
                   }
               } else {
                    productos.push(productos[0]);
                    selectedItems(productos[0]);
               }

               $('#barCode').val("");
            })
            .fail(function(jqXHR, textStatus, errorThrown) { 
                $('#barCode').val("");
                console.log("fail");
            });
    }
    // findl product by id

    function findByDescription (id) {
        console.log(id);
        var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/productos/nombre/" + id;
        $.get(url)
            .done(function(productos) {           

                //check products exist
               //check if product exist 
               if (!productos.length) {
                 toastr.warning('No se encontro el producto!');     
                 return;
               } 
               
               if (productos.length>1) {
                   for (index in productos) {
                       if (productos[index].sucursalId == sucursalSelected) {
                            productos.push(productos[index]);
                            selectedItems(productos[index]);
                       }
                   }
               } else {
                    productos.push(productos[0]);
                    selectedItems(productos[0]);
               }

               $('#barCode').val("");
            })
            .fail(function(jqXHR, textStatus, errorThrown) { 
                $('#barCode').val("");
                console.log("fail");
            });
    }
    // Add selected items and do the validations to quantity!
    
    function selectedItems (item) {
        var found = false;
        var suc = sucursalSelected == 1 ? 2 : 1;
       // console.log(item);
        if (cart.length == 0) {
            
            //selectedItemsArr.push(Object.assing(item, {selectedCantidad: 1}));
            item.selectedCantidad = 1;
            cart.push(item);
            showCart();        
        } else {
            for (index in cart) {
                //check the current selected sucursal and check if can add other item
                if (cart[index].producto.id == item.producto.id && item.sucursalId == sucursalSelected) {
                    found = true;
                }

                //check if item exist with the second sucursal
                if (cart[index].producto.id == item.producto.id && item.sucursalId == cart[index].sucursalId) {
                    found = true;
                }

                //check in other sucursal
                if (cart[index].producto.id == item.producto.id && item.sucursalId != cart[index].sucursalId && item.hasOwnProperty('selectedCantidad')) {                    
                    found = false;
                }
            }

            if (found) {
                findItems(item);
            } else {                
                item.selectedCantidad = 1;
                cart.push(item);
                showCart(); 
            }
        }
    }

    function findItems(item) {
        
        //flag to check if items exist in the curent cart
        //found = false;

        var tryOtherSucursal = false;
        var suc = $("#sucursales :selected").val() == 1 ? 2 : 1;

        for (index in cart) {

            if (cart[index].producto.id == item.producto.id && cart[index].sucursalId == item.sucursalId) {
                //console.log(cart[index],  item);

                //check if can  add one more product check from sucursal producto cantidad
                if (cart[index].selectedCantidad + 1 > cart[index].cantidad && !tryOtherSucursal){
                        tryOtherSucursal = true;
                        toastr.warning('Ya no tienes existencias disponibles');
                } else {
                    cart[index].selectedCantidad +=1;                    
                }
            } 
            
        }

        if (tryOtherSucursal) {
            var barcode = $('#barCode').val() == "" ? item.producto.codidoBarras : $('#barCode').val();
            findByBarcode(barcode, suc);
        }
        // If is a new item add in the cart
        /*if (!found) {
            item.selectedCantidad = 1;
            cart.push(item);
        }*/

        showCart();
    }

    //Remove one each one cantidad from product
    $(document).on('click', '.buttonDelete', function(el) { 
        var current = el.currentTarget.name.split("-");
            for (index in cart) {
                if (cart[index].producto.id == current[1] && cart[index].sucursalId == current[0]) {
                    cart[index].selectedCantidad -= 1;
                    
                    if (cart[index].selectedCantidad == 0) {
                        cart.splice(index, 1);
                    }
                    showCart();
                }
            }        
    });


    function showCart() {
        var totalPrice = 0;
        //Remove the items
        $('.detalle').remove();
        
        for (product in cart) {
            var productTotal = '<td>' + cart[product].selectedCantidad + '</td>'
            var desc         = '<td>' + cart[product].producto.descripcion + '</td>';
            var sucursal     = '<td>' + (cart[product].sucursalId == 1   ? "Seduction centro" : "Seduction 2 central") + '</td>';
            var actions      = '<td><button name="'+ cart[product].sucursalId + '-' + cart[product].producto.id + '" class="buttonDelete">-</button></td>';

            if ($("#precios :selected").val() == 1) {
                var precio = '<td>' + (cart[product].selectedCantidad * cart[product].producto.precio) + '</td>';
                totalPrice += (cart[product].selectedCantidad * cart[product].producto.precio);
            } else {
                var precio = '<td>' + (cart[product].selectedCantidad * cart[product].producto.precio1) + '</td>';
                totalPrice += (cart[product].selectedCantidad * cart[product].producto.precio1);
            }
            
            $('#productos').append('<tr class=\"detalle\">'+productTotal+desc+sucursal+precio+actions+'</tr>');
        }
        $('#total').text(totalPrice);
        total = totalPrice;
    }

</script>
<?php JSRegister::end(); ?>
