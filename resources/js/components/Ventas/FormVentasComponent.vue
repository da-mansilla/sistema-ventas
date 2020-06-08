<template>

      <div class="card-body">
        <form v-on:submit.prevent="newProductVenta()">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Cliente</label>

              <span v-if="editMode && disabled">
                
                <input type="text" class="form-control" v-bind:placeholder="editMode.cliente" disabled v-model="cliente">
              </span>

              <span v-else>
                <!-- Modal Button -->
                <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter2">{{cliente}}</button>
              </span>

            </div>
            <div class="form-group col-md-3">
              <label for="inputPassword4">Telefono</label>

              <span v-if="editMode && disabled">
                <input type="text" class="form-control" v-bind:placeholder="editMode.telefono" v-model="telefono" disabled>
              </span>

              <span v-else>
                <input type="number" class="form-control" v-model="telefono">
              </span>

            </div>
            <div class="form-group col-md-3">
              <label for="inputPassword4">Email</label>

              <span v-if="editMode && disabled">
                <input type="email" class="form-control" v-bind:placeholder="editMode.email" v-model="email" disabled>
              </span>

              <span v-else>
                <input type="email" class="form-control" v-model="email">
              </span>

            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">Forma de Pago</label>

              <span v-if="editMode && disabled">
                <input type="text" class="form-control" v-bind:placeholder="editMode.forma_pago" v-model="forma_pago" disabled>
              </span>

              <span v-else>
                <select class="form-control" v-model="forma_pago" value="Efectivo" required v-on:click="selectFormaPago">
                  <option selected>Efectivo</option>
                  <option>Tarjeta</option>
                  <option value="efectivoTarjeta">Efectivo y Tarjeta</option>
                  <option v-if="habilitarCuenta"value="Cuenta">Cuenta Corriente</option>
                  <option v-if="habilitarSeña" value="Seña">Seña</option>
                </select>
              </span>
            </div>

            
            
              <div class="form-group col-md-3">
                <span v-if="editMode && disabled">
                  
                </span>

                <span v-else>
                  <span v-if="forma_pago=='Cuenta'">

                    <label for="exampleFormControlSelect1">Efectivo o Tarjeta</label>
                    <select class="form-control"  value="Efectivo" v-model="Cuenta_formaPago"required>
                      <option selected>Efectivo</option>
                      <option>Tarjeta</option>
                      <option value="efectivoTarjeta">Efectivo y Tarjeta</option>
                    </select>

                  </span>
                  <span v-else>

                    <label>Recargo</label>
                    <div class="input-group">
                      <input type="number" class="form-control" v-model="recargo">
                      <div class="input-group-append">
                        <button :disabled="activarBoton(recargo)" class="btn btn-outline-secondary" type="button" v-on:click="cargarRecargo"><i class="fas fa-plus"></i></button>
                      </div>
                    </div>

                  </span>
                </span>

              </div>
            

            <div class="form-group col-md-3">
              <div v-if="editMode && disabled">
                <label for="exampleFormControlSelect1">Tarjeta</label>
                <input type="text" class="form-control" v-bind:placeholder="editMode.tarjeta" v-model="tarjeta" disabled>
              </div>

              <div v-else-if="forma_pago=='Tarjeta' || forma_pago=='efectivoTarjeta' || (forma_pago=='Cuenta' && (Cuenta_formaPago =='Tarjeta' || Cuenta_formaPago =='efectivoTarjeta'))">
                
                <label for="exampleFormControlSelect1">Tarjeta</label>
                <div class="input-group">
                    <select class="d-block form-control" id="exampleFormControlSelect1" v-model="tarjeta">
                      <option>Debito</option>
                      <option>Visa</option>
                      <option>MasterCard</option>
                      <option value="TarjetaNaranja">Tarjeta Naranja</option>
                    </select>
                    <div class="input-group-append">
                      <button :disabled="activarBoton(tarjeta)" class="btn btn-outline-secondary" type="button" id="button-addon2" v-on:click="cargarTarjeta"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
              </div>

              
            </div>

            
            
          </div>

          <hr>
          <span>
            <span v-if='editMode && disabled'>
              <div v-if="editMode.promocion !== '' "class="form-group col-md-6">
                <label>Promocion</label>
                <input disabled class="form-control" :value="editMode.promocion">
              </div>
            </span>
            <span v-else>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="inputCity">Producto</label>
                   <!-- Button trigger modal
                  <input type="text" class="form-control" v-model="producto">
                   -->
                   <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">{{producto}}</button>
                  
                </div>
                <div class="form-group col-md-2">
                  <label for="inputState">Precio</label>
                  <input type="number" class="form-control" v-model="precio" disabled="">
                </div>
                <div v-if="forma_pago=='Efectivo'||forma_pago=='Tarjeta'||forma_pago=='efectivoTarjeta'"class="form-group col-md-3">
                  <label for="inputState">Promocion</label>
                  <select class="form-control" v-on:click="elegirPromocion" v-model="promocion">
                    <option></option>
                    <option value="2x1">2 x 1</option>
                    <option value="descuento">Descuento</option>
                  </select>
                </div>
                <div v-if="promocion =='descuento'"class="form-group col-md-3">
                  <label>Descuento</label>
                  <div class="input-group">
                      <input class="d-block form-control" v-model="valorDescuento">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" v-on:click="agregarDescuento" type="button" id="button-addon2" ><i class="fas fa-plus"></i></button>
                      </div>
                  </div>
                  
                </div>
                
                
                
              </div>
              
              <div class="form-row row justify-content-end">
                <div class="form-group">
                  <button class="btn btn-success btn-lg">Agregar</button>         
                </div>
              </div>
            </span>
          </span>
        </form>

        <hr>
          <div v-if="forma_pago == 'Cuenta'">
            <cuenta-component
              :productsVenta='productsVenta'
              :totalNeto='totalNeto'
              :cuentaActivada="cuentaActivada"
              :cuentaCliente="cuentaCliente"
              :Cuenta_formaPago="Cuenta_formaPago"
              :listTarjetas="listTarjetas"
              @dejaPagando = 'dejaPagando'
              @Cuenta_deleteProductVenta="deleteProductVenta"
              @Cuenta_eliminarTarjeta='eliminarTarjeta'
              @Cuenta_FormaTarjeta="Cuenta_agregarTarjetas">
              
            </cuenta-component>
          </div>
          <div v-else-if="forma_pago == 'Seña'">
              <table class="table table-bordered ">
                <thead>
                  <tr class=" table-primary ">
                    <th scope="col"></th>
                    <th scope="col">N° Serie</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Color</th>
                    <th scope="col">Talle</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Precio</th>

                  </tr>

                </thead>
                <tbody>


                  <tr v-for="product in productsVenta" :key="product.id">
                    <th>
                      <button type="button" class="btn btn-danger btn-sm" v-on:click="deleteProductVenta(index)">X</button>
                    </th>
                    <th>{{product.n_serie}}</th>
                    <th>{{product.categoria}}</th>
                    <th>{{product.color}}</th>
                    <th>{{product.talle}}</th>
                    <th>Nuevo</th>
                    <th>{{product.precio}}</th>

                  </tr>
                  <tr>
                      <td colspan="6" class="text-right table-light td-venta" ><strong>Total Neto</strong></td>
                      <td class="td-venta">{{totalNeto}}</td> 
                  </tr> 
                  <tr>
                      <td colspan="6" class="text-right table-light td-venta"><strong>Deja Pagando</strong></td>
                      <td class="td-venta"><input type="number" class="input-venta" v-model="señaPagado" v-on:keyup="insertSeñaPagado"></td> 
                  </tr> 

                  <tr>
                      <td colspan="6" class="text-right table-light td-venta"><strong>Total a Pagar</strong></td>
                      <td class="td-venta">{{totalNeto - señaPagado}}</td>  
                  </tr> 


                  
                </tbody>
              </table>
          </div>
          <div v-else>
            <table class="table table-bordered table-ventas">
              <thead>
                <tr class=" table-primary ">
                  <th scope="col"></th>
                  <th scope="col">N° Serie</th>
                  <th scope="col">Categoria</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Talle</th>
                  <th scope="col">Color</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody v-if="editMode && disabled">
                <tr v-for="(productVenta,index) in productsVendidos" :key="productVenta.id">
                  <td>
                    
                  </td>
                  <td>
                    <span>{{productVenta.n_serie}}</span>
                  </td>
                  <td>
                    <span>{{productVenta.categoria}}</span>
                  </td>
                  <td>
                    <span>{{productVenta.precio}}$</span>
                  </td>
                  <td>
                    <span>{{productVenta.cantidad}}</span>
                  </td>
                  <td>
                    <span>{{productVenta.talle}}</span>
                  </td>
                  <td>
                    <span>{{productVenta.color}}</span>
                  </td>
                  <td>
                    <span>{{(productVenta.precio * productVenta.cantidad) - productVenta.descuento}}$</span>
                  </td>
                </tr>
                <tr v-if="editMode.recargo > 0">
                    <td colspan="7" class="text-right table-light td-venta"><strong>Recargo</strong></td>
                    <td class="td-venta" v-bind:value="editMode.pagoEfectivo">${{editMode.recargo}}</td> 
                </tr>
                <tr v-if="editMode.forma_pago=='Efectivo'">
                    <td colspan="7" class="text-right table-light td-venta"><strong>Efectivo</strong></td>
                    <td class="td-venta" v-bind:value="editMode.pagoEfectivo">${{editMode.pagoEfectivo}}</td> 
                </tr> 

                <tr v-if="editMode.forma_pago=='Tarjeta'" v-for="tarjeta in editMode.tarjetas">
                    <!--
                    <td colspan="7" class="text-right table-light td-venta"><strong>Tarjeta</strong></td>
                    <td class="td-venta" v-bind:value="editMode.pagoTarjeta" disabled>{{editMode.pagoTarjeta}}</td> 
                    -->
                    <td colspan="7" class="text-right table-light td-venta"><strong>{{tarjeta.nombre}}</strong></td>
                    <td class="td-venta" disabled>${{tarjeta.total}}</td>
                </tr>

                <tr v-if="editMode.forma_pago=='efectivoTarjeta'">
                    <td colspan="7" class="text-right table-light td-venta"><strong>Efectivo</strong></td>
                    <td class="td-venta"><input type="number" class="input-venta" v-bind:value="editMode.pagoEfectivo" disabled></td> 
                </tr> 
                <tr v-if="editMode.forma_pago=='efectivoTarjeta'">
                    <td colspan="7" class="text-right table-light td-venta"><strong>Tarjeta</strong></td>
                    <td class="td-venta"><input type="number" class="input-venta" v-bind:value="editMode.pagoTarjeta" disabled></td> 
                </tr>
                <tr>
                    <td colspan="7" class="text-right table-light"><strong>Total Neto</strong></td>
                    <td>${{editMode.total}}$</td> 
                </tr>  
              </tbody>

              <tbody v-else>
                <tr v-for="(productVenta,index) in productsVenta" :key="productVenta.id">
                  <td>
                    <button type="button" class="btn btn-danger btn-sm" v-on:click="deleteProductVenta(index)">X</button>
                  </td>
                  <td>
                    <span>{{productVenta.n_serie}}</span>
                  </td>
                  <td>
                    <span>{{productVenta.categoria}}</span>
                  </td>
                  <td>
                    <span>{{productVenta.precio}}$</span>
                  </td>
                  <td>
                    <span>{{productVenta.cantidad}}</span>
                  </td>
                  <td>
                    <span>{{productVenta.talle}}</span>
                  </td>
                  <td>
                    <span>{{productVenta.color}}</span>
                  </td>
                  <td>
                    <span>${{(productVenta.precio * productVenta.cantidad) - productVenta.descuento}}</span>
                  </td>
                </tr>
                <tr v-if="recargoActivate">
                    <td colspan="7" class="text-right table-light td-venta">
                      <button type="button" class="btn btn-danger btn-sm" v-on:click="eliminarRecargo()">X</button>
                      <strong>{{TitulovalorRecargo}}</strong>
                    </td>
                    <td class="td-venta" style="color:green;">+${{totalRecargo}}</td>
                </tr>
                <tr v-if="descuentoActivate">
                    <td colspan="7" class="text-right table-light td-venta">
                      <button type="button" class="btn btn-danger btn-sm" v-on:click="eliminarDescuento()">X</button>
                      <strong>{{TitulovalorDescuento}}</strong>
                    </td>
                    <td class="td-venta" style="color:red;">-${{totalDescuento}}</td>
                </tr>
                <tr v-if="forma_pago=='Efectivo'">
                    <td colspan="7" class="text-right table-light td-venta"><strong>Efectivo</strong></td>
                    <td class="td-venta">${{totalNeto}}</td> 
                </tr> 

                <tr v-if="forma_pago=='Tarjeta'" v-for='(tarjeta,index) in listTarjetas'>

                    <td colspan="7" class="text-right table-light td-venta">
                      <button type="button" class="btn btn-danger btn-sm" v-on:click="eliminarTarjeta(index)">X</button>
                      <strong>{{tarjeta.nombre}}</strong>
                    </td>

                    <td class="td-venta"><input type="number" value="0"placeholder="0" :id="tarjeta.nombre" class="input-venta" v-on:keyup="FormaTarjeta"></td> 

                </tr>

                <tr v-if="forma_pago=='efectivoTarjeta'">
                    <td colspan="7" class="text-right table-light td-venta"><strong>Efectivo</strong></td>
                    <td class="td-venta"><input type="number" class="input-venta" v-model="pagoEfectivo" v-on:keyup="FormaEyT"></td> 
                </tr> 
                <tr v-if="forma_pago=='efectivoTarjeta'" v-for='tarjeta in listTarjetas'>
                    <td colspan="7" class="text-right table-light td-venta"><strong>{{tarjeta.nombre}}</strong></td>
                    <td class="td-venta"><input type="number" :id="tarjeta.nombre" class="input-venta" v-on:keyup="FormaEyT"></td> 
                </tr>
                

                


                <tr>
                    <td colspan="7" class="text-right table-light"><strong style="font-size: 19px;">Total Neto</strong></td>
                    <td><strong style="color:green;font-size: 19px;">${{totalNeto}}</strong></td> 
                </tr>  
              </tbody>
            </table>
          </div>

          <hr>

          <span v-if='editMode'>
            <div class="form-row justify-content-end">        
              <span v-if='disabled'>
                <!-- 
                <button type="submit" class="btn btn-secondary btn-lg" >Editar</button>
              -->
              <!--
              <button v-if="editMode.estado != 'Cancelado'"type="submit" class="btn btn-secondary btn-lg ml-2" v-on:click="devolucion(editMode)">Devolucion</button>
            -->
                <button v-if="editMode.estado != 'Cancelado'"type="submit" data-toggle="modal" data-target="#ModalConfirmacion" class="btn btn-secondary btn-lg ml-2" >Borrar</button>

              </span>
              <span v-else>
                <button  type="submit" class="btn btn-secondary btn-lg ml-2" v-on:click="onClickCancelar">Cancelar</button>
                <button type="submit" class="btn btn-secondary btn-lg ml-2" v-on:click="editVenta(indexEdit)">Guardar</button>
              </span>
              <button type="submit" class="btn btn-primary btn-lg ml-5" v-on:click="exitEditMode">Salir</button> 
          </div>
          </span>

          <span v-else>
            <div class="form-row justify-content-end">
              <button type="submit" class="btn btn-primary btn-lg mr-5" v-on:click="exitEditMode">Salir</button>

              <button v-if="cuentaActivada && forma_pago == 'Cuenta'"type="submit" class="btn btn-primary btn-lg" v-on:click="modiicarCuenta()">Hecho</button> 
              <button v-else type="submit" class="btn btn-primary btn-lg" :disabled="hechoDesactivado"v-on:click="saveVenta()">Hecho</button> 
          </div>
          </span>
        

        <!-- Modal Clientes-->
        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <modalclientes-component
          @selectClient="selectClient"
          @newClient= "newClient">
            
          </modalclientes-component>
        </div>

        <!-- Modal Productos-->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <modalproducts-component
          @selectProduct="selectProduct">
            
          </modalproducts-component>
        </div>


          <div class="modal fade" id="ModalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="ModalConfirmacion" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header md-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pt-0">
                  <div class="card">
                      <div class="card-header"> <h2>Confirmación</h2> </div>
                      <div class="card-body">
                        <h4 class="mb-5">¿Estas Seguro de Borrar esta Compra?</h4>
                        <div class="float-right">
                          <button class="btn btn-secondary btn-lg" data-dismiss="modal">Cancelar</button>  
                          <button class="btn btn-secondary btn-lg " data-dismiss="modal" v-on:click="deleteVenta(editMode.id,indexEdit)">Borrar</button>  
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
 
      </div>


</template>

<script>
    export default {
      props: {
        editMode:{

        },
        indexEdit:{

        },
        productsVendidos:{

        }
      },
      data(){
        return {
            TitulovalorDescuento: '',
            TitulovalorRecargo: '',

            productsVenta: [],
            id: '',
            cliente: '',
            telefono: '',
            email: '',
            forma_pago: '',
            tarjeta: '',
            producto: '',
            precio: '',
            cantidad: 1,
            descuento: 0,
            totalNeto: 0,
            disabled: true,
            selectedProduct: '',
            selectedClient: '',
            nombreNewClient: '',
            editar: false,
            pagoEfectivo: '',
            pagoTarjeta: '',
            createClient: false,
            listTarjetas: [],
            habilitarCuenta: false,
            habilitarSeña: false,
            cuentaActivada: false,
            pagandoEfectivo: '',
            pagandoTarjeta: '',
            cuentaCliente: '',
            hechoDesactivado: true,
            descripcion: '',
            señaPagado: 0,
            promocion: '',
            promocion2x1Activate: false,
            activateAgregar: true,
            recargoActivate: false,
            totalRecargo: '',
            recargo: '',
            descuentoActivate: false,
            valorDescuento: 0,
            totalDescuento: 0,
            totalNetoAnterior: 0,
            Cuenta_formaPago:''


        };
      },
      mounted() {
      },
      methods:{

          newProductVenta(){
             var esValido = true;
             const productVenta = {
                id: this.selectedProduct.id,
                producto: this.selectedProduct.nombre,
                categoria: this.selectedProduct.categoria,
                categoria_id: this.selectedProduct.categoria_id,
                precio: this.selectedProduct.precio,
                costo: this.selectedProduct.costo,
                n_serie : this.selectedProduct.n_serie,
                talle : this.selectedProduct.talle,
                color : this.selectedProduct.color,
                cantidad: this.cantidad,
                descuento: this.descuento
             }
             if(this.productsVenta.length > 0)
             {
              for(var product of this.productsVenta){
                if(product.id == productVenta.id){
                  this.$toasted.show('Este Producto ya fué agregado', { 
                   theme: "toasted-primary", 
                   position: "top-right", 
                   duration : 2000
                  });
                  esValido = false;
                  this.producto= '';
                  this.precio= '';
                  this.cantidad= 1;
                  this.descuento= 0;
                }
              }
             }
             if(esValido){
              this.productsVenta.push(productVenta);
              this.totalNeto += (this.precio * this.cantidad) - this.descuento;
              if(this.recargoActivate){
                this.cargarRecargo()
              }
              if(this.descuentoActivate){
                this.agregarDescuento()
              }
              if(this.promocion2x1Activate){
                this.promocion2x1() 
              } 
              if(this.forma_pago == 'Efectivo'){
                this.pagoEfectivo = this.totalNeto;
              } else {
                if(this.forma_pago=='Tarjeta'){
                  this.FormaTarjeta();
                  this.pagoEfectivo = 0;
                }
                if(this.forma_pago=='efectivoTarjeta'){this.FormaEyT();} 
              }
              

              this.pagoTarjeta= 0;

              this.producto= '';
              this.precio= '';
              this.cantidad= 1;
              this.descuento= 0;

              console.log(this.productsVenta);
             }
            
          },
          postClient(params){
            const promise = new Promise((resolve,reject)=>{
              axios.post('/clients',params)
              .then((response)=>{
                resolve(response)
              })
              .catch(err => {
                reject(err)
              })
            })
            return promise
          },
          postVenta(params){
            const promise = new Promise((resolve,reject)=>{
              axios.post('/ventas',params)
              .then((response)=>{
                resolve(response)
              })
              .catch(err => {
                reject(err)
              })
            })
            return promise
          },
          postCuenta(params){
            const promise = new Promise((resolve,reject)=>{
              axios.post('/cuentas',params)
              .then((response)=>{
                resolve(response)
              })
              .catch(err => {
                reject(err)
              })
            })
            return promise
          },  
          postProductsVendidos(params,venta_id){
            const promise = new Promise((resolve,reject)=>{
              axios.post('/productsvendidos/'+venta_id,params)
              .then((response)=>{
                resolve(response)
              })
              .catch(err => {
                reject(err)
              })
            })
            return promise
          },      
          postPagos(params){
            const promise = new Promise((resolve,reject)=>{
              axios.post('/pagos',params)
              .then((response)=>{
                resolve(response)
              })
              .catch(err => {
                reject(err)
              })
            })
            return promise
          },
          crearCliente(){
            const promise = new Promise((resolve,reject)=>{
            if(this.createClient)
            {
              var estadoCuenta = false;
              if(this.forma_pago == 'Cuenta')
              {
                estadoCuenta = true;
              }
              let client= {
                  nombre: this.cliente,
                  telefono: this.telefono,
                  email: this.email,
                  enabled: 1,
                  estado: 'ok',
                  cuenta: estadoCuenta
              }
              this.postClient(client)
              .then((response)=>{
                const new_client = response.data;
                resolve(new_client); 
              })
            } else {
              if(this.forma_pago == 'Cuenta')
              {
                // Modificar Cliente
                var params = {
                  cuenta: true
                }
                axios.put('/clients/crearcuenta/'+this.selectedClient.id, params).then(response=>{
                  console.log('Creando cuenta al Cliente');
                  console.log(response);
                  resolve(response.data);
                })
              } else {
                resolve(this.selectedClient);
              }
              
            }
          })
          return promise;
          },
          modiicarCuenta(){
            console.log('Hay que modificar la Cuenta');
            this.id = this.selectedClient.id;
            // Estado Cuenta
            var ventaEstado= 'Cuenta Corriente'
            var params = {
              cliente_id: this.id,
              forma_pago: this.forma_pago,
              pagoEfectivo: this.pagandoEfectivo,
              pagoTarjeta: this.pagandoTarjeta,
              total: this.pagandoEfectivo+this.pagandoTarjeta,
              estado: ventaEstado,
              enabled: 1
            }
            console.log(params);
            axios.post('/ventas', params)
              .then((response)=>{
                  const venta = response.data;
                  this.$emit('new', venta);
                  // Cuenta
                  var cuentaEstado = '';
                  if((this.totalNeto - (this.pagandoEfectivo+this.pagandoTarjeta)) > 0){
                    cuentaEstado = 'Deuda'
                  } else {
                    cuentaEstado = 'Sin Deuda'
                  }
                  var cuentaParams= {
                    cliente_id: venta.cliente_id,
                    total: (this.totalNeto+this.cuentaCliente.total),
                    pagado: (parseInt(this.pagandoEfectivo)+parseInt(this.pagandoTarjeta) + this.cuentaCliente.pagado),
                    deuda: ((this.totalNeto+this.cuentaCliente.total) - (this.pagandoEfectivo+this.pagandoTarjeta) - this.cuentaCliente.pagado),
                    estado: cuentaEstado,
                    batch: this.cuentaCliente.batch
                  }
                  axios.put('cuentas/'+this.cuentaCliente.id,cuentaParams).then((response)=>{
                    console.log(response);
                    var cuentaActualizada = response.data;
                    // Productos Venta Cuenta Corriente

                    //Agregar Products de la cuenta a los productos vendidos en la venta
                    for(var product of this.productsVenta)
                    {
                      let params = {
                        nombre: product.producto,
                        categoria_id: product.categoria_id,
                        cuenta_id : response.data.id,
                        n_serie : product.n_serie,
                        talle : product.talle,
                        color : product.color,
                        precio: product.precio,
                        costo: product.costo,
                        cantidad: product.cantidad,
                        descuento: product.descuento,
                        estado: 'Cuenta Corriente'
                      };
                      axios.post('productsvendidos/'+venta.id, params)
                           .then((response)=>{
                              axios.delete('products/'+product.id).then(response=>{
                                })
                           });
                    }
                    var descripcionPago = this.descripcion;
                    if(this.cuentaCliente.estado == 'Saldado'){
                      descripcionPago += ' (Abrir Cuenta)'
                    }
                    var pagosParams= {
                      cuenta_id: this.cuentaCliente.id,
                      venta_id: venta.id,
                      efectivo: this.pagandoEfectivo,
                      tarjeta: this.pagandoTarjeta,
                      pagado: this.pagandoEfectivo+this.pagandoTarjeta,
                      descripcion: descripcionPago,
                      batch : cuentaActualizada.batch
                    }
                    this.postPagos(pagosParams).then(response=>{
                      console.log(response);
                    })
                    if(this.listTarjetas.length>0){
                      // Tarjetas
                      this.listTarjetas.forEach((tarjeta)=>{
                        let parametros = {
                          nombre: tarjeta.nombre,
                          total: tarjeta.total,
                          venta_id : venta.id
                        }
                        axios.post('tarjetas', parametros).then((response)=>{
                          //console.log(response);
                        })
                      })
                    }
                  })
                  this.$toasted.show('Cuenta Corriente Creada', { 
                   theme: "toasted-primary", 
                   position: "top-right", 
                   duration : 2000
                  });
              })
          },
          saveVenta(){
            this.crearCliente().then(response=>{
              this.id = response.id
              var estadoCuenta = response.cuenta
                //////////////
                // Pago Tarjeta
                var totalTarjetas = 0; 
                this.listTarjetas.forEach((element)=>{
                  console.log("en forEach: "+element.total)
                  totalTarjetas +=  parseInt(element.total);
                })
                console.log('Tarjetas: '+ totalTarjetas);
                // Fin Tarjetas

                // Estado Cuenta
                var ventaEstado= '';
                var enEfectivo = parseInt(this.pagoEfectivo);
                var enTarjeta = totalTarjetas;
                var enTotal = this.totalNeto;
                var seña = '';
                var deuda = '';
                var promocion = '';
                var recargo = '';
                if(estadoCuenta && this.forma_pago == 'Cuenta'){
                  ventaEstado = 'Cuenta Corriente';
                  enEfectivo = this.pagandoEfectivo;
                  enTarjeta = this.pagandoTarjeta;
                  enTotal = this.pagandoEfectivo+this.pagandoTarjeta;

                } else if(this.forma_pago == 'Seña'){
                  seña= this.señaPagado;
                  enEfectivo= 0;
                  enTarjeta = 0;
                  ventaEstado = 'Seña';
                  deuda = (parseInt(this.totalNeto) - parseInt(this.señaPagado))
                }
                else {
                  ventaEstado = 'Finalizado'
                  if(this.promocion2x1Activate){
                    ventaEstado += ' (Promocion 2x1)'
                    promocion = this.promocion
                  }
                  if(this.descuentoActivate){
                    ventaEstado += ' (Descuento '+this.valorDescuento+'%)'
                    promocion = this.promocion
                  }
                }

                if(this.recargoActivate){
                  recargo = this.totalRecargo
                }
                // Fin Estado Cuenta

                var params = {
                  cliente_id: this.id,
                  forma_pago: this.forma_pago,
                  pagoEfectivo: enEfectivo,
                  pagoTarjeta: enTarjeta,
                  total: enTotal,
                  seña: seña,
                  deuda: deuda,
                  promocion: promocion,
                  recargo : recargo,
                  estado: ventaEstado,
                  enabled: 1,
                  descuento: this.totalDescuento
                }
                console.log('parametros');
                console.log(params);
                this.postVenta(params).then((response)=>{

                  const venta = response.data;
                  this.$emit('new', venta);
                  // Cuenta
                  if(venta.estado == 'Cuenta Corriente')
                  {
                      var cuentaEstado = '';
                      if((this.totalNeto - (this.pagandoEfectivo+this.pagandoTarjeta)) > 0){
                        cuentaEstado = 'Deuda'
                      } else {
                        cuentaEstado = 'Saldado'
                      }
                      var cuentaParams= {
                        cliente_id: venta.cliente_id,
                        total: this.totalNeto,
                        pagado: this.pagandoEfectivo+this.pagandoTarjeta,
                        estado: cuentaEstado,
                        deuda: (this.totalNeto-(this.pagandoEfectivo+this.pagandoTarjeta)),
                        batch: 1
                      }

                      this.postCuenta(cuentaParams)
                        .then((response)=>
                        {
                          var cuentaCreada = response.data
                          // Productos Venta Cuenta Corriente
                          for(var product of this.productsVenta)
                          { 
                            let cuentaID = response.data.id;
                            let estadoProducto = 'Cuenta Corriente';
                            let params = {
                              nombre: product.producto,
                              categoria_id: product.categoria_id,
                              cuenta_id : cuentaID,
                              n_serie : product.n_serie,
                              talle : product.talle,
                              color : product.color,
                              precio: product.precio,
                              costo: product.costo,
                              cantidad: product.cantidad,
                              descuento: product.descuento,
                              estado: estadoProducto
                            };
                            this.postProductsVendidos(params,venta.id)
                              .then((response)=>{
                                axios.delete('products/'+product.id).then(response=>{
                                  console.log('Product eliminado');
                                  console.log(response);
                                })  
                              })
                          }
                          // Pagos Cuenta Corriente
                          var paramsPagos= {
                            cuenta_id: cuentaCreada.id,
                            venta_id: venta.id,
                            efectivo: this.pagandoEfectivo,
                            tarjeta: this.pagandoTarjeta,
                            pagado: this.pagandoEfectivo+this.pagandoTarjeta,
                            descripcion: (this.descripcion+' (Abrir Cuenta)'),
                            batch: 1
                          }
                          this.postPagos(paramsPagos)
                            .then(response =>{
                            })
                        })
                         if(this.listTarjetas.length>0){
                          // Tarjetas
                          this.listTarjetas.forEach((tarjeta)=>{
                            let parametros = {
                              nombre: tarjeta.nombre,
                              total: tarjeta.total,
                              venta_id : venta.id
                            }
                            axios.post('tarjetas', parametros).then((response)=>{
                              //console.log(response);
                            })
                          })
                         }
                      this.$toasted.show('Cuenta Corriente Creada', { 
                       theme: "toasted-primary", 
                       position: "top-right", 
                       duration : 2000
                      });

                  }else if(venta.estado == 'Seña'){
                    // Productos Venta
                    for(var product of this.productsVenta)
                    {
                      let params = {
                        nombre: product.producto,
                        categoria_id: product.categoria_id,
                        cuenta_id : '',
                        n_serie : product.n_serie,
                        talle : product.talle,
                        color : product.color,
                        precio: product.precio,
                        costo: product.costo,
                        cantidad: product.cantidad,
                        descuento: product.descuento,
                        estado: 'Inventario('+product.id+')'
                      }
                      axios.post('productsvendidos/'+venta.id, params)
                           .then((response)=>{
                              console.log('Producto Registrado pero Sigue en inventario')
                              this.$toasted.show('Seña Realizada Satisfactoriamente', { 
                               theme: "toasted-primary", 
                               position: "top-right", 
                               duration : 2000
                              });
                           });
                    }
            
                  }
                  else
                  {
                      // Productos Venta
                      for(var product of this.productsVenta)
                      {
                        let params = {
                          nombre: product.producto,
                          categoria_id: product.categoria_id,
                          cuenta_id : '',
                          n_serie : product.n_serie,
                          talle : product.talle,
                          color : product.color,
                          precio: product.precio,
                          costo: product.costo,
                          cantidad: product.cantidad,
                          descuento: product.descuento,
                          estado: 'Vendido'
                        }
                        axios.post('productsvendidos/'+venta.id, params)
                             .then((response)=>{
                                axios.delete('products/'+product.id).then(response=>{
                                  console.log('Product eliminado');
                                  console.log(response);
                                })
                             });
                      }

                      // Tarjetas
                      this.listTarjetas.forEach((tarjeta)=>{
                        let parametros = {
                          nombre: tarjeta.nombre,
                          total: tarjeta.total,
                          venta_id : venta.id
                        }
                        axios.post('tarjetas', parametros).then((response)=>{
                          //console.log(response);
                        })
                      })
                      this.$toasted.show('Venta Realizada Satisfactoriamente', { 
                       theme: "toasted-primary", 
                       position: "top-right", 
                       duration : 2000
                      });
                  }

                });
            })
          },
          deleteProductVenta(index){
            console.log('eliminando producto ' + index)
            this.totalNeto -= this.productsVenta[index].precio
            console.log(this.totalNeto);
            console.log(this.productsVenta[index].precio)
            this.productsVenta.splice(index,1);
            if(this.productsVenta.length == 0){
              this.descuentoActivate= false;
              this.recargoActivate=false;
              this.totalNeto = 0;
            }
            if(this.productsVenta.length >= 2){
                this.activateAgregar = false;
            }else{
              this.activateAgregar = true;
            }

            if(this.recargoActivate){
              this.cargarRecargo()
            }
            if(this.descuentoActivate){
              this.agregarDescuento()
            }

          },
          onClickEdit(){
            this.disabled= false;
            this.cliente = this.editMode.cliente;
            this.telefono = this.editMode.telefono;
            this.email = this.editMode.email;
            this.forma_pago = this.editMode.forma_pago;
            this.tarjeta = this.editMode.tarjeta;
            this.editar = true;
            
            for(var product of this.productsVendidos){
              let productVenta = {
                id: product.product_id,
                producto: product.nombre,
                precio: product.precio,
                cantidad: product.cantidad,
                descuento: product.descuento
              }
              this.productsVenta.push(productVenta);
              this.totalNeto = this.totalNeto + (productVenta.precio * productVenta.cantidad) - productVenta.descuento;
            }
            console.log(this.totalNeto);
            
          },
          deleteVenta(id,indexEdit){
            this.productsVendidos.forEach(product=>{
              let params = {
                    nombre : product.nombre,               
                    categoria_id: product.categoria_id,
                    talle: product.talle,
                    color: product.color,
                    costo: product.costo,
                    precio: product.precio,
                    n_serie: product.n_serie,
                    enabled: 1,
                    estado: 'Inventario',
                    cantidadProducts: 1
                };
                axios.post('/products', params)
                .then((response)=>{
                      console.log('producto creado');
                      console.log(response);      
                });
            })
            axios.delete('/ventas/'+id).then(()=>{
                  this.$emit('delete',indexEdit);
                  this.$toasted.show('Venta Cancelada Satisfactoriamente', { 
                     theme: "toasted-primary", 
                     position: "top-right", 
                     duration : 2000
                  });
                })
          },
          exitEditMode(){
            this.$emit('exit');
          },
          selectProduct(product){
            this.selectedProduct = product;
            this.producto = this.selectedProduct.n_serie;
            this.precio = this.selectedProduct.precio;
            console.log(this.selectedProduct);
          },
          selectClient(cliente){
            this.selectedClient = cliente;
            this.cliente = this.selectedClient.nombre;
            this.telefono = this.selectedClient.telefono;
            this.email = this.selectedClient.email;

            //Habilitar Cuenta
            this.habilitarCuenta = true;
            this.habilitarSeña = true;
            if(this.selectedClient.cuenta)
            {
              this.cuentaActivada = true;
              axios.get('cuentas/'+this.selectedClient.id)
              .then((response)=>{
                this.cuentaCliente = response.data[0];
                console.log(this.cuentaCliente);
              }).catch((err)=>{
                console.log(err);
              })
            }
          },
          newClient(bool, nombre){
            this.createClient = bool;
            this.cliente = nombre;

            //Habilitar Cuenta
            this.habilitarCuenta = true;
            this.habilitarSeña = true;
          },
          onClickCancelar(){
            this.disabled = true;
            this.cliente = this.editMode.cliente;
            this.telefono = this.editMode.telefono;
            this.forma_pago = this.editMode.forma_pago;
            this.tarjeta = this.editMode.tarjeta;
            this.productsVenta = this.productsVendidos;
          },
          editVenta(indexEdit){
            var params = {
              usuario: 'admin',
              cliente_id: this.cliente,
              telefono: this.telefono,
              forma_pago: this.forma_pago,
              pagoEfectivo: this.pagoEfectivo,
              pagoTarjeta: this.pagoTarjeta,
              tarjeta: this.tarjeta,
              total: this.totalNeto
            }
            axios.put('/ventas/'+this.editMode.id, params)
                        .then((response)=>{
                            const venta = response.data;
                            this.$emit('edit', venta, indexEdit);
                            for(var product of this.productsVenta)
                            {
                              let params = {
                                cantidad: product.cantidad,
                                descuento: product.descuento
                              };
                              console.log(product.id);
                              axios.post('productsvendidos/'+venta.id+'/'+product.id, params)
                                   .then((response)=>{
                                      console.log(response);
                                   });
                            }
                });
          },
          tarjetaPagar(e){
            var tarjeta = e.target.id;
            var valor = e.target.valueAsNumber
            this.listTarjetas.forEach((element)=>{
              if(element.nombre == tarjeta){
                element.total = valor
              }
            })
            console.log(this.listTarjetas);
          },
          cargarTarjeta(){
            if(this.tarjeta != ''){
              let tarjeta = {
                nombre: this.tarjeta,
                total: 0
              }
              this.listTarjetas.push(tarjeta);
              console.log(this.listTarjetas);
              this.tarjeta = '';
            }
          },
          eliminarTarjeta(index){
            console.log(this.listTarjetas)
            this.listTarjetas.splice(index,1);
            console.log(this.listTarjetas);
            this.FormaTarjeta();
          },
          selectFormaPago(e){
            var formaPago = e.target.value;
            if (formaPago == 'Efectivo'){
              this.hechoDesactivado = false;
            }
            else  if(formaPago == 'Cuenta'){
              this.hechoDesactivado = false;
            }
            else if(formaPago == 'Seña') {
              this.hechoDesactivado = false;
            }

            if(this.forma_pago == 'Tarjeta'){
              this.FormaTarjeta();
              this.pagoEfectivo = 0;
            }
            if(this.forma_pago == 'efectivoTarjeta'){
              this.FormaEyT();
              this.pagoEfectivo = 0;
            }
          },
          dejaPagando(efectivo,tarjeta){
            this.pagandoEfectivo = parseInt(efectivo);
            this.pagandoTarjeta = parseInt(tarjeta);
            console.log(this.pagandoEfectivo)
            console.log(this.pagandoTarjeta)
          },
          Cuenta_agregarTarjetas(lista){
            lista.forEach(t=>{
              this.listTarjetas.forEach(tarjetas=>{
                if(tarjetas.nombre == t.nombre){
                  tarjetas.total = t.total
                }
              })
            })
            console.log('Lista Tarjetas');
            console.log(this.listTarjetas)
          },
          FormaTarjeta(e){
            var total = 0;
            this.listTarjetas.forEach(tarjeta=>{
              tarjeta.total = parseInt($('#'+tarjeta.nombre).val());
              if(isNaN(tarjeta.total)){
                tarjeta.total = 0;
              }
              console.log("El total de la tarjeta es"+tarjeta.total);
              let valor = tarjeta.total
              total += valor;
            })
            console.log(total);
            if(total == this.totalNeto){
              console.log('Son Iguales');
              this.hechoDesactivado = false;
            } else {
              this.hechoDesactivado = true;
            }
          },
          FormaEyT(e){
            var totalEnTarjetas = 0;
            this.listTarjetas.forEach(tarjeta=>{
              tarjeta.total = parseInt($('#'+tarjeta.nombre).val());
              if(isNaN(tarjeta.total)){
                tarjeta.total = 0;
              }
              console.log("El total de la tarjeta es"+tarjeta.total);
              let valor = tarjeta.total;
              totalEnTarjetas += valor;
            })
            console.log('en efectivo '+ parseInt(this.pagoEfectivo));
            console.log('en tarjeta '+ parseInt(totalEnTarjetas));
            console.log('en total '+ (parseInt(totalEnTarjetas)+parseInt(this.pagoEfectivo)));
            if((parseInt(totalEnTarjetas)+parseInt(this.pagoEfectivo))  == this.totalNeto){
              console.log('Son Iguales');
              this.hechoDesactivado = false;
            } else {
              this.hechoDesactivado = true;
            }
          },
          devolucion(venta){
            this.$emit('devolucion',venta);
            console.log('emitiendo una devolucion');
          },
          elegirPromocion(){
            if(this.promocion == '2x1'){
              this.promocion2x1Activate = true;
              console.log('2x1')
            } else {

              this.productsVenta.forEach(product=>{
                this.totalNeto = product.precio
              })
              console.log('2x1 desactivado')

              this.promocion2x1Activate = false;
              this.hechoDesactivado = false;
              
            }
            this.promocion2x1()

          },
          promocion2x1(){
            if(this.promocion2x1Activate){
              if((this.productsVenta.length%2) == 0 && this.productsVenta.length > 0){
                this.hechoDesactivado = false;
                this.totalNetoAnterior = this.totalNeto
                this.totalNeto = 0;
                var precios = [];
                this.productsVenta.forEach(element=>{
                  precios.push(element.precio)
                })
                precios.sort(function(a, b) {
                  return a - b;
                });
                console.log(precios);
                for (var i = this.productsVenta.length-1; i >= (this.productsVenta.length/2); i--) {
                  console.log(i);
                  console.log(precios[i])
                  this.totalNeto += precios[i]
                }


              } else {
                this.totalNeto = 0;
                this.hechoDesactivado = true;
              }
            }
          },
          cargarRecargo(){
            this.totalNeto = this.obtenerTotal()

            this.recargoActivate = true;
            this.TitulovalorRecargo= 'Recargo '+this.recargo+"%"
            var totalNetoFinal = 0;
            var precioFinal = Math.ceil((((this.recargo/100)* this.totalNeto ) ))
            var numeroString = String(precioFinal);
            var ultimoDigito = numeroString.slice(-1);
            if(ultimoDigito == 1 ){
                totalNetoFinal= precioFinal-1

            } else if(ultimoDigito == 2 ){
                totalNetoFinal= precioFinal-2

            } else if(ultimoDigito == 3){
                totalNetoFinal= precioFinal-3

            } else if(ultimoDigito == 4){
                totalNetoFinal= precioFinal-4

            } else if(ultimoDigito == 5){
                totalNetoFinal= precioFinal+5

            } else if(ultimoDigito == 6){
                totalNetoFinal= precioFinal+4

            } else if(ultimoDigito == 7){
                totalNetoFinal= precioFinal+3

            } else if(ultimoDigito == 8){
                totalNetoFinal= precioFinal+2

            } else if(ultimoDigito == 9){
                totalNetoFinal= precioFinal+1

            } else {
                totalNetoFinal= precioFinal
           }
           this.totalRecargo = totalNetoFinal;
           this.totalNeto = this.obtenerTotal('general') + totalNetoFinal - this.totalDescuento;
          },
          eliminarRecargo(){
            this.recargoActivate = false;
            this.totalNeto = 0
            this.totalNeto = this.obtenerTotal()
            if(this.descuentoActivate){
              this.agregarDescuento();
            }
          },
          //
          activarBoton(variable){
            if(variable){
              return false
            }else{
              return true
            }

          },
          agregarDescuento(){
            this.totalNeto = this.obtenerTotal()

            console.log(this.valorDescuento);
            this.descuentoActivate = true;
            this.TitulovalorDescuento = 'Descuento '+ this.valorDescuento+'%'
            var totalNetoFinal = 0;
            var precioFinal = Math.ceil((((this.valorDescuento/100)* this.totalNeto ) ))
            var numeroString = String(precioFinal);
            var ultimoDigito = numeroString.slice(-1);
            if(ultimoDigito == 1 ){
                totalNetoFinal= precioFinal-1

            } else if(ultimoDigito == 2 ){
                totalNetoFinal= precioFinal-2

            } else if(ultimoDigito == 3){
                totalNetoFinal= precioFinal-3

            } else if(ultimoDigito == 4){
                totalNetoFinal= precioFinal-4

            } else if(ultimoDigito == 5){
                totalNetoFinal= precioFinal+5

            } else if(ultimoDigito == 6){
                totalNetoFinal= precioFinal+4

            } else if(ultimoDigito == 7){
                totalNetoFinal= precioFinal+3

            } else if(ultimoDigito == 8){
                totalNetoFinal= precioFinal+2

            } else if(ultimoDigito == 9){
                totalNetoFinal= precioFinal+1

            } else {
                totalNetoFinal= precioFinal
           }
           this.totalDescuento = totalNetoFinal
           this.totalNeto = this.obtenerTotal('general') - totalNetoFinal + this.totalRecargo;
          },
          eliminarDescuento(){
            this.descuentoActivate = false;
            this.totalNeto = 0
            this.productsVenta.forEach(product=>{
              this.totalNeto+=product.precio
            })
            if(this.recargoActivate){
              this.cargarRecargo();
            }
          },
          obtenerTotal(destino=''){
            var calcularConDescuento= false
            var calcularConRecargo= false
            if(destino=='descuento'){
              calcularConDescuento= false
            }
            if(destino=='recargo'){
              calcularConRecargo= false
            }
            if(destino=='general'){
              calcularConRecargo= false
              calcularConDescuento= false
            }


            let totalNetoRetornar= 0
            this.productsVenta.forEach(product=>{
              totalNetoRetornar+=product.precio
            })
            if(this.recargoActivate && calcularConRecargo){
              var totalNetoFinal = 0;
              var precioFinal = Math.ceil((((this.recargo/100)* this.totalNeto ) ))
              var numeroString = String(precioFinal);
              var ultimoDigito = numeroString.slice(-1);
              if(ultimoDigito == 1 ){
                  totalNetoFinal= precioFinal-1

              } else if(ultimoDigito == 2 ){
                  totalNetoFinal= precioFinal-2

              } else if(ultimoDigito == 3){
                  totalNetoFinal= precioFinal-3

              } else if(ultimoDigito == 4){
                  totalNetoFinal= precioFinal-4

              } else if(ultimoDigito == 5){
                  totalNetoFinal= precioFinal+5

              } else if(ultimoDigito == 6){
                  totalNetoFinal= precioFinal+4

              } else if(ultimoDigito == 7){
                  totalNetoFinal= precioFinal+3

              } else if(ultimoDigito == 8){
                  totalNetoFinal= precioFinal+2

              } else if(ultimoDigito == 9){
                  totalNetoFinal= precioFinal+1

              } else {
                  totalNetoFinal= precioFinal
             }
             totalNetoRetornar += totalNetoFinal;
            }
            if(this.descuentoActivate && calcularConDescuento){
              var totalNetoFinal = 0;
              var precioFinal = Math.ceil((((this.valorDescuento/100)* this.totalNeto ) ))
              var numeroString = String(precioFinal);
              var ultimoDigito = numeroString.slice(-1);
              if(ultimoDigito == 1 ){
                  totalNetoFinal= precioFinal-1

              } else if(ultimoDigito == 2 ){
                  totalNetoFinal= precioFinal-2

              } else if(ultimoDigito == 3){
                  totalNetoFinal= precioFinal-3

              } else if(ultimoDigito == 4){
                  totalNetoFinal= precioFinal-4

              } else if(ultimoDigito == 5){
                  totalNetoFinal= precioFinal+5

              } else if(ultimoDigito == 6){
                  totalNetoFinal= precioFinal+4

              } else if(ultimoDigito == 7){
                  totalNetoFinal= precioFinal+3

              } else if(ultimoDigito == 8){
                  totalNetoFinal= precioFinal+2

              } else if(ultimoDigito == 9){
                  totalNetoFinal= precioFinal+1

              } else {
                  totalNetoFinal= precioFinal
             }
             totalNetoRetornar -= totalNetoFinal
            }
            return totalNetoRetornar
          },
          Cuenta_deleteProductVenta(){

          }

      },
      computed: {
      }
    }
</script>
<style>    
.card-body{
    margin-top: 10px;
}
.table-ventas{
    table-layout: fixed;
    width: 100%;
}
.td-venta {
    border: 1px solid blue;
    width: 100px;
    word-wrap: break-word;
}
.input-venta{
  width: 100%;
}
.paginate-links{
    text-align: center;
    margin-bottom: 0px;
}
.paginate-links li {
    cursor:pointer;
    border-radius: 3px;
    padding-top: 10px;
    padding-bottom: 5px;
}

</style>