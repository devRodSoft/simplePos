<?php
    use yii\helpers\Html;    
    use richardfan\widget\JSRegister;
    use app\models\Sucursales;
    use yii\helpers\ArrayHelper;
    use yii\jui\AutoComplete;
    use yii\web\JsExpression;
    use app\models\Productos;
    use app\models\Clientes;
    use yii\helpers\Json;

    
    $ldSucursales = Sucursales::find()->all();
    $sucursales   = ArrayHelper::map($ldSucursales,'id','nombre');   

    $ldClientes = Clientes::find()->all();
    $clientes   = ArrayHelper::map($ldClientes, 'id', 'nombre');

    $pros = Productos::find()->all();
    $productos = ArrayHelper::map($pros, 'id', 'descripcion');
?>
<v-app id="app">
    <v-container>
        <v-row>
            <v-col>
                <v-text-field label="Codigo" v-model="barcode" v-on:change="findByBarcode"></v-text-field>
            </v-col>
               
            <v-col>
                <v-autocomplete
                    v-model="productBarcode"
                    :items="productosItems"
                    item-text="descripcion"
                    item-value="codidoBarras"
                    label="Descripcion"
                    v-on:change="findByBarcode"
                ></v-autocomplete>
            </v-col>

            <v-col>
                <v-select :items="sucursalesItems" label="Sucursal" v-model="sucursal" item-text="nombre" item-value="id"></v-select>
            </v-col>
            
            <v-col>
                <v-select :items="preciosItem" label="Precio" v-model="selectedPrice" item-text="nombre" item-value="id" v-on:change="updatePrices()"></v-select>
            </v-col>
        </v-row>
        
        <v-divider></v-divider>

        <v-simple-table class="table-wrapper-scroll-y my-custom-scrollbar">
        <template v-slot:default>
            <thead>
            <tr>
                <th></th>
                <th class="text-left">Cantidad</th>
                <th class="text-left">Producto</th>
                <th class="text-left">Sucursal</th>
                <th class="text-left">Precio Pz</th>
                <th class="text-left">Total</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in cart" :key="item.id">
                <td>
                
                <v-btn
                    class="ma-2"
                    color="red"
                    dark
                    @click="removeItem(index)"
                    >
                    Quitar
                    <v-icon
                        dark
                        right
                    >
                        mdi-cancel
                    </v-icon>
                </v-btn>
                </td>
                <td>
                    <input type="number" id="quantity" name="quantity" v-model="item.qty" v-on:change="canAdd(item, item.cantidad)">
                </td>
                <td>{{item.producto.descripcion}}</td>
                <td>{{item.sucursalId}}</td>
                <td>
                    <v-text-field label="$" v-if="selectedPrice == 1" type="text" v-model="item.producto.precio" v-on:change="changePrice(item)"></v-text-field>
                    <v-text-field label="$" v-if="selectedPrice == 2" type="text" v-model="item.producto.precio1" v-on:change="changePrice(item)"></v-text-field>
                    <v-text-field label="$" v-if="selectedPrice == 3" type="text" v-model="item.producto.costo" v-on:change="changePrice(item)"></v-text-field>
                </td>
                <td>{{item.total}}</td>
            </tr>
            </tbody>
        </template>
        </v-simple-table>        

        <v-divider></v-divider>

        <h1 style="text-align: right">Total: {{total}}</h1>
                <!-- start pay modal  -->
                <v-row style="margin-top: 15px;">
                    <v-col>
                        <v-btn elevation="2" v-on:click="remove_data()" color="danger">Borrar Almacenamiento</v-btn>
                    </v-col>
                    <v-col class="text-right">
                    <v-row justify="space-around">
                    <v-col cols="auto">
                    <v-dialog
                        v-model="dialog"
                        transition="dialog-bottom-transition"
                        max-width="600"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-btn
                                color="warning"                                
                                @click="apartado = true"
                                :disabled="total == 0"
                            >Apartar</v-btn>
                        <v-btn
                            color="success"
                            v-bind="attrs"
                            v-on="on"
                            :disabled="total == 0"
                            style="position: absolute; rigth: 0;"
                        >Pagar</v-btn>
                        </template>
                        <template v-slot:default="dialog">
                        <v-card>
                            <v-toolbar
                            color="#E10C78"
                            dark
                            >Finalizar compra</v-toolbar>
                            <v-card-text>
                                <form>
                                    <div class="form-group">
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <v-text-field label="Detalle Venta" v-model="payModal.motivo"></v-text-field>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="message-cambio" class="col-form-label" style="text-align: right">Total</label>
                                                    <h3 id="total" style="text-align: right">{{total}}</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <v-text-field label="Su pago" v-model="payModal.pago"></v-text-field>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="message-cambio" class="col-form-label" style="text-align: right">Su cambio</label>
                                                    <h3 id="cambio"  v-if="payModal.pago != 0" style="text-align: right">{{payModal.pago - total }}</h3>
                                                </div>
                                            </div>
                                            
                                            <div style="text-align: right">
                                                <label for="message-cambio" class="col-form-label" style="text-align: right">Pago con tarjeta?</label>
                                                <input type="checkbox" name="targeta" id="pagoTargeta" v-model="payModal.targeta">
                                            </div>
                                    </div>
                                </form>


                            </v-card-text>
                            <v-card-actions class="justify-end">
                            <v-btn
                                text
                                @click="dialog.value = false"
                            >Close</v-btn>
                            <v-btn
                                color="success"
                                text
                                @click="pagar(), dialog.value = false, thanks = true"
                            >Aceptar</v-btn>
                            </v-card-actions>
                        </v-card>
                        </template>
                    </v-dialog>
                    </v-col>
                </v-row> 
                <!-- End pay modal  -->
               <!-- start apartado modal  -->
               <v-row style="margin-top: 15px;">
                    <v-col>
                        
                    </v-col>
                    <v-col class="text-right">
                    <v-row justify="space-around">
                    <v-col cols="auto">
                    <v-dialog
                        v-model="apartado"
                        transition="dialog-bottom-transition"
                        max-width="600"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        </template>
                        <template v-slot:default="dialog">
                        <v-card>
                            <v-toolbar
                            color="#E10C78"
                            dark
                            >Finalizar apartado</v-toolbar>
                            <v-card-text>
                                <form>
                                    <div class="form-group">    
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="recipient-name" class="col-form-label">Detalle Apartado</label>
                                                <input type="text" class="form-control" id="desc">
                                            </div>

                                        </div>
                                        <div class="row">
                                
                                            <div class="col-md-6">
                                                <v-autocomplete
                                                    v-model="apartarModal.cliente"
                                                    :items="clientesItems"
                                                    item-text="nombre"
                                                    item-value="id"
                                                    return-object
                                                    label="Selecciona un clinete"                                                    
                                                ></v-autocomplete>
                                            </div>
                                            <div class="col-md-6">
                                                <v-text-field label="Anticipo" v-model="apartarModal.anticipo"></v-text-field>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <br>
                                                <label for="message-total" class="col-form-label" style="text-align: right">Total</label>
                                                <h3 id="total" style="text-align: right">{{total}}</h3>
                                            </div>
                                            <div class="col-md-6">
                                                <br>
                                                <label for="message-cambio" class="col-form-label" style="text-align: right">Restante</label>
                                                <h3 id="restante" style="text-align: right">{{total - apartarModal.anticipo}}</h3>
                                            </div>
                                        </div>
                                        
                                        <div style="text-align: right">
                                            <label for="message-cambio" class="col-form-label" style="text-align: right">Pago con tarjeta?</label>
                                            <input type="checkbox" name="targeta" id="pagoTargeta" v-model="apartarModal.targeta">
                                        </div>
                                    </div>
                                </form>
                            </v-card-text>
                            <v-card-actions class="justify-end">
                            <v-btn
                                text
                                @click="apartado.value = false"
                            >Close</v-btn>
                            <v-btn
                                color="success"
                                text
                                @click="apartar(), apartado = false, thanks = true"
                            >Aceptar</v-btn>
                            </v-card-actions>
                        </v-card>
                        </template>
                    </v-dialog>
                    </v-col>
                </v-row> 
                <!-- End apartado modal  -->

                <!-- start thanks modal -->
                <v-row style="margin-top: 15px;">
                    <v-col class="text-right">
                    <v-row justify="space-around">
                    <v-col cols="auto">
                    <v-dialog 
                        v-model="thanks"
                        transition="dialog-bottom-transition"
                        max-width="600"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        </template>
                        <template v-slot:default="dialog">
                        <v-card>
                            <v-toolbar
                            color="#E10C78"
                            dark
                            >Finalizar compra</v-toolbar>
                            <v-card-text>        
                                <h1>Gracias por tu compra. :D</h1>                        
                            </v-card-text>
                            <v-card-actions class="justify-end">
                            <v-btn
                                text
                                @click="thanks = !thanks"
                            >Cerrar</v-btn>
                            </v-card-actions>
                        </v-card>
                        </template>
                    </v-dialog>
                    </v-col>
                </v-row>                 
                <!-- ends thanks modal -->


                
            </v-col>
        </v-row>
    </v-container>
<v-app>


<!-- Small modal -->
<div class="modal fade" id="gracias" tabindex="-1" role="dialog" aria-labelledby="setPrecioLabel" aria-hidden="true">
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
    var app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            dialog: false,
            thanks: false,
            apartado: false,
            message: 'Hello Vue!',
            productBarcode: '',
            barcode: '',
            pName: '',
            sucursal: 1,
            selectedPrice: 1,
            cart: [],
            total: 0,
            canPay: this.total>0,
            modalpayVisible: false,
            payModal: {
                descuento: 0,
                //total: this.total,
                motivo: "",
                pago: 0,
                cambio: 0,
                tarjeta: false
            },
            apartarModal: {
                anticipo: 0,
                restante: this.total - this.anticipo,
                //total: this.total,
                motivo: "",
                clienteId: "",
                tarjeta: false
            },
            productosItems: [],
            sucursalesItems: [],
            clientesItems: [],
            preciosItem: [
                {id: 1, nombre: 'Menudeo'},
                {id: 2, nombre: 'Mayoreo'},
            ]
        },
        created() {
           if (localStorage.getItem("cacheCart")) {
               this.cart = this.get_data();
               this.getCartTotal();
           }
           this.getAllProducts();
           this.getAllSucursales();
           this.getAllClientes();


        },
        methods: {
            showPayModal: function showPayModal() {

                if (this.total != 0 ) {
                    this.modalpayVisible = true;
                    this.$nextTick(() => {
                        $('#modal-pay').modal('show');
                    });
                }
            },
            hidePayModal: function hidePayModal() {
                this.modalpayVisible = false;
                this.$nextTick(() => {
                    $('#modal-pay').modal('hide');
                });
            },
            getAllProducts() {
                
                self = this;
                var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/productos/productos";

                $.get(url)
                .done(function(data) {                          
                    self.productosItems = data;
                })
                .fail(function(jqXHR, textStatus, errorThrown) { 
                    console.log("fail getting products");
                });
            },
            getAllClientes() {
                
                self = this;
                var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/clientes/clientes";

                $.get(url)
                .done(function(data) {                          
                    self.clientesItems = data;
                })
                .fail(function(jqXHR, textStatus, errorThrown) { 
                    console.log("fail getting clientes");
                });
            },
            getAllSucursales() {
                self = this;
                var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/sucursales/sucursales";

                $.get(url)
                .done(function(data) {                          
                    self.sucursalesItems = data;
                })
                .fail(function(jqXHR, textStatus, errorThrown) { 
                    console.log("fail getting products");
                });
            },
            findByBarcode: function findBybarCode() {
                this.barcode = this.barcode == "" ? this.productBarcode : this.barcode;
                self = this;
                var url = "<?php echo Yii::$app->request->baseUrl; ?>" + "/productos/producto/" + this.barcode + "/" + this.sucursal + "/" + true;

                $.get(url)
                .done(function(data) {                          
                    
                    if (data.length) {
                        console.log(data)
                        self.addToCart(data[0]);
                    } else {
                        console.log("Not Found");
                    }

                    self.barcode = '';
                    self.productBarcode = '';
                })
                .fail(function(jqXHR, textStatus, errorThrown) { 
                    $('#barCode').val("");
                    console.log("fail");
                });
            },
            addToCart: function addToCart(item) {
                
                if (this.cart.length == 0) {
                    item.qty = 1;
                    this.getPrice(item);
                    this.cart.push(item);
                } else {
                    this.findItem(item);
                }
                this.set_data();
                this.getCartTotal();
            },
            findItem: function findItem(item) {
                var addNew = true;
                for(index in this.cart) {
                    if (this.cart[index].id == item.id) {
                        this.canAddMore(this.cart[index], item);
                        addNew = false;
                    } 
                }

                //add new item only where the for to found does not found nothing.
                if (addNew) {
                    item.qty = 1;
                    this.getPrice(item);
                    this.cart.push(item);
                }
            },
            canAddMore: function canAddMore(producto, item) {
                if (parseInt(producto.cantidad) > producto.qty) {
                    producto.qty++;
                } else {
                    console.log("ya no quedan existencias");
                }
                this.getPrice(producto);
            },
            canAdd: function canAdd(data, stock) {
                if (parseInt(stock) < data.qty) {
                    data.qty = stock;
                    console.log("Cantidad Max");
                }

                if (parseInt(data.qty) == 0) {
                    data.qty = 1;
                    console.log("Cantidad Min");
                }

                this.getPrice(data);
            },
            removeItem: function removeItem(index) { 
                this.cart.splice(index, 1);
                this.set_data();
                this.getCartTotal();
            },
            changePrice: function changePrice(data) {
                this.getPrice(data);
            },
            updatePrices: function updatePrices () {
                this.cart.forEach(data => this.getPrice(data)); 
            },
            getPrice: function getPrice(data) { 
                switch(this.selectedPrice) {
                    case "2":
                        data.total = data.qty * data.producto.precio1;
                        this.getCartTotal();
                    break;
                    case "3":
                        data.total = data.qty * data.producto.costo;
                        this.getCartTotal();
                    break;
                    default:
                        data.total = data.qty * data.producto.precio;
                        this.getCartTotal();
                    break;
                }
            },
            getCartTotal: function getCartTotal() {
                this.total = 0;
                for(index in this.cart) {
                   this.total += this.cart[index].total;
                }
            },
            set_data : function(){
                console.log('set');
                localStorage.setItem( 'cacheCart', JSON.stringify(this.cart) );
                this.cart = this.get_data();
            },
            get_data : function(){
                console.log('get');
                return JSON.parse(localStorage.getItem( 'cacheCart' ));
            },
            remove_data: function () {
                console.log("remove");
                this.cart = [];
                this.getCartTotal();
                localStorage.removeItem("cacheCart");
            },
            pagar: function pagar() {
                self = this;
                url =   "<?php echo Yii::$app->request->baseUrl; ?>" + "/ventas/pagar/";
                $.post(url, {
                        'total': this.total, 
                        'descuento': this.payModal.descuento, 
                        'subTotal': this.total,
                        'precioSelected': this.selectedPrice,
                        'desc': this.payModal.motivo,
                        'tipoVenta': this.payModal.tarjeta, 
                        'apartado':  false, 
                        'productos': this.cart
                    })
                    .done(function( data ) {
                        url = "http://localhost/simpleprint/index.php";
                                                
                        $.post(url, {
                            'total': self.total,
                             'descuento': self.payModal.descuento, 
                             'subTotal': self.total, 
                             'productos': self.cart, 
                             'precioSelected': self.selectedPrice
                             })
                            .done(function( data ) {
                              console.log("print ticket!");
                              self.remove_data();  
                              self.cleanPagoModal();
                        });
                        
                    });
                
            },
            cleanPagoModal() {
                this.payModal.descuento = 0;                
                this.payModal.motivo = "";
                this.payModal.pago = 0;
                this.payModal.cambio = 0;
                this.payModal.tarjeta = false;
            },
            apartar: function apartar() {

                selft = this;
                
                url =  "<?php echo Yii::$app->request->baseUrl; ?>" + "/ventas/pagar/";
                
                $.post(url, {
                    'total': self.total, 
                    'precioSelected': this.selectedPrice,
                    'desc': 0, 
                    'tipoVenta': this.apartarModal.tarjeta,
                    'apartado': 1,
                    'abono': this.apartarModal.anticipo, 
                    'clientId':self.apartarModal.cliente,  
                    'productos': this.cart
                })
                .done(function( data ) {
                    url = "http://localhost/simpleprint/apartado.php";
                    $.post(url, {
                        'total': self.total, 
                        'abono': self.apartarModal.anticipo, 
                        'cliente': self.apartarModal.cliente.nombre,
                        'clienteId': self.apartarModal.cliente.id,
                        'productos': self.cart})
                        .done(function( data ) {    
                            console.log("Print Ticket! apartado");
                            self.remove_data();
                            this.cleanApartarModal();
                    });                    
                });
            },
            cleanApartarModal() {
                this.apartarModal.anticipo = 0;
                this.apartarModal.restante = this.total - this.anticipo;
                this.apartarModal.motivo = "";
                this.apartarModal.clienteId = "";
                this.apartarModal.tarjeta = false;
            }
        }
    })
</script>

<?php JSRegister::end(); ?>