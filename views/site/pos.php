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

$ldSucursales = Sucursales::find()->all();
$sucursales   = ArrayHelper::map($ldSucursales,'id','nombre');   


?>

<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                    <h2>Codigo</h2>
                    <input type="text" class="form-control" id="barCode" aria-describedby="basic-addon3">
                </div>
                <div class="col-md-3">
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
                        'options' => ['class' => 'form-control findByDescReset'],    
                        'select' => new JsExpression("function( event, ui ) {
                            $('#descripcion').val(ui.item.id);
                            findByDescription(event, ui.item.id);
                            //#memberssearch-family_name_id is the id of hiddenInput.
                            }")],
                        ]);

                    ?>
                </div>
                <div class="col-md-3">
                    <h2>Sucursal</h2>
                    <?php
                        echo Html::dropDownList('sucursales', $selection = Yii::$app->user->identity->sucursalId, $sucursales, $options = ["class"=>"form-control", "id"=>"sucursales", "name"=>"sucursales"]);
                    ?>
                </div>

                <div class="col-md-3">
                    <h2>Precio</h2>
                    <select name="sucursales" id="precios" class="form-control">
                        <option value="1" selected>Menudeo</option>
                        <option value="2">Mayoreo</option>
                    </select>
                </div>            
            </div>
        </div>
        <div class="row ">
            <h2>Venta</h2>
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table table table-bordered table-striped mb-0">
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
            </div>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <h1 id="total" style="text-align: right"></h1>
            </div>
            
        </div>


        <div class="row">
            <div class="col-md-4">
                <button id="cancelar" class="btn btn-danger">Cancelar</button>
            </div>
            <div class="col-md-4">
                <!--<label for="">Anticipo</label>
                <input type="text" id="anticipo" class="form-control text-apartar" style="display: inline; width:129px;">
                <button id="apartar" class="btn btn-success">Apartar</button>-->
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">PAgar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Venta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
        <div class="form-group">
            
            <div class="row">
                <div class="col-md-12">
                    <label for="recipient-name" class="col-form-label">Detalle venta</label>
                    <input type="text" class="form-control" id="desc">
                </div>
                
            </div>
            
          
            <div class="row">
                <div class="col-md-6">
                    <label for="recipient-descuento" class="col-form-label">Descuento</label>
                    <input type="text" class="form-control" id="descuento">
                </div>

                <div class="col-md-6">
                    <label for="message-cambio" class="col-form-label" style="text-align: right">Total</label>
                    <h3 id="total" style="text-align: right"></h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="message-pago" class="col-form-label">Su pago</label>  
                    <input type="text" class="form-control" id="cantidad-pago">
                </div>
                <div class="col-md-6">
                    <label for="message-cambio" class="col-form-label" style="text-align: right">Su cambio</label>
                    <h3 id="cambio" style="text-align: right"></h3>
                </div>
            </div>
            
            <div style="text-align: right">
                <label for="">Pago con tarjeta?</label>
                <input type="checkbox" name="targeta" id="pagoTargeta">
            </div>
            
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="pagar">Pagar</button>
      </div>
    </div>
  </div>
</div>


<!-- Small modal -->
<div class="modal fade" id="gracias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Venta Exitosa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>Gracias por su compra!</h2>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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


    //modal handle

    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = total // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        //modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body #total').text(recipient)


        $('#cantidad-pago').on('keypress', function (ele){
            if (ele.which != 13)
            return

            var cambio =  $('#cantidad-pago').val() - total;
            $("#cambio").text(cambio)
            })

            $('#descuento').on('keypress', function(e){
                console.log("here");
            if (e.which != 13)
                return
            

            descuento = this.value;
            var totalFinal = descuento == "" ? recipient : total -= descuento;
            modal.find('.modal-body #total').text(totalFinal)
            //$('#total').text(total);

        });

    })

    //Buttons actions
    $('#precios').change(function (element) {
        precioSelected = $("#sucursales :selected").val();
        showCart();
    })

    $('#sucursales').on('change', function (element) {
        sucursalSelected = $("#sucursales :selected").val();
    })

    $('#pagar').on('click', function () {        
        url =   "<?php echo Yii::$app->request->baseUrl; ?>" + "/ventas/pagar/";
        $.post(url, {'total': total, 'descuento': descuento, 'precioSelected': $("#precios :selected").val(), 'desc': $('#desc').val(), 'tipoVenta': $('#pagoTargeta').prop('checked'), 'apartado':  false, 'productos': cart})
            .done(function( data ) {
                url = "http://localhost/simpleprint/index.php";

                $.post(url, {'total': total, 'descuento': descuento, 'productos': productos})
                    .done(function( data ) {
                    console.log("print ticket!")
                    productos = [];                    
                    $('#exampleModal').modal('hide');
                    $("#gracias").modal('show');
                });
                resetDatos();
            });
    });

    $('#apartar').on('click', function () {        
        url =   "<?php echo Yii::$app->request->baseUrl; ?>" + "/ventas/pagar/";
        $.post(url, {'total': total, 'descuento': descuento, 'precioSelected': precioSelected, 'desc': $('#desc').val(), 'tipoVenta': $('#pagoTargeta').prop('checked'), 'apartado':  true, 'anticipo': $('#apartado').val(),  'productos': cart})
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
        $('#desc').val("");
        $('#total').text("");        
        $('.findByDescReset').val('');
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

    function findByDescription (event, id) {        
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
        var showAlert = false;

        for (index in cart) {

            if (cart[index].producto.id == item.producto.id && cart[index].sucursalId == item.sucursalId) {
                //console.log(cart[index],  item);
                
                //check if can  add one more product check from sucursal producto cantidad
                if (cart[index].selectedCantidad + 1 > cart[index].cantidad){
                       showAlert = true;
                        if (cart[index].sucursalId != suc){
                            tryOtherSucursal = true;
                            showAlert = false;
                        }
                } else {
                    cart[index].selectedCantidad +=1;                    
                }
            } 
        }

        if (showAlert) {
            toastr.warning('Ya no tienes existencias disponibles en ninguna Sucursal');
        }

        if (tryOtherSucursal) {
            tryOtherSucursal = false;
            var barcode = $('#barCode').val() == "" ? item.producto.codidoBarras : $('#barCode').val();
            findByBarcode(barcode, suc);
        }
        
        showCart();
    }
    //Add one each one cantidad from product
    $(document).on('click', '.buttonAdd', function(el) { 
        var current = el.currentTarget.name.split("-");
            for (index in cart) {
                if (cart[index].producto.id == current[1] && cart[index].sucursalId == current[0]) {
                    //cart[index].selectedCantidad -= 1;
                    //if (cart[index].selectedCantidad +1 <= cart[index].cantidad)
                    if (cart[index].selectedCantidad + 1 <= cart[index].cantidad){
                        cart[index].selectedCantidad += 1;
                    } else {
                        console.log("can't buy more");
                    }
                    showCart();
                }
            }        
    });

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
            var sucursal     = '<td>' + (cart[product].sucursalId == 1   ? "Matriz" : "Sucursal") + '</td>';
            var actions      = '<td><button name="'+ cart[product].sucursalId + '-' + cart[product].producto.id + '" class="buttonDelete">-</button><button name="'+ cart[product].sucursalId + '-' + cart[product].producto.id + '" class="buttonAdd">+</button></td>';

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
