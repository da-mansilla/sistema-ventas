<template>
  <div class="card-body">

      <div class="form-row">
        <div class="form-group col-md-6">

          <label for="inputEmail4">Cliente</label>
          <input type="text" class="form-control" v-bind:placeholder="ventaDevolucion.cliente" disabled >

        </div>
        <div class="form-group col-md-3">

          <label for="inputPassword4">Telefono</label>
          <input type="text" class="form-control" v-bind:placeholder="ventaDevolucion.telefono" disabled>

        </div>
        <div class="form-group col-md-3">

          <label for="inputPassword4">Email</label>
          <input type="email" class="form-control" v-bind:placeholder="ventaDevolucion.email"  disabled>

        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">

          <label for="exampleFormControlSelect1">Forma de Pago</label>
          <input type="text" class="form-control" v-bind:placeholder="ventaDevolucion.forma_pago"  disabled>

        </div>

        <div class="form-group col-md-6">

          <label for="exampleFormControlSelect1">Tarjeta</label>
          <input type="text" class="form-control" v-bind:placeholder="ventaDevolucion.tarjeta" disabled>
   
        </div>
      </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="inputCity">Producto</label>
             <!-- Button trigger modal
            <input type="text" class="form-control" v-model="producto">
             -->
             <input type="text" class="form-control btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" v-model="producto">
            
          </div>
          <div class="form-group col-md-2">
            <label for="inputState">Precio</label>
            <input type="number" class="form-control" v-model="precio" disabled="">
          </div>
          <div class="form-group col-md-3">
            <label for="inputState">Cantidad</label>
            <input type="number" class="form-control" v-model="cantidad">
          </div>
          <div class="form-group col-md-3">
            <label for="inputZip">Descuento</label>
            <input type="number" class="form-control" v-model="descuento">
          </div>
        </div>
        
        <div class="form-row row justify-content-end">
          <div class="form-group">
            <button class="btn btn-success btn-lg" v-on:click="newProductVenta()">Agregar</button>         
          </div>
        </div>

        

      <hr>


    <hr>
      <div>
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
          <tbody>
            <tr v-for="(productVenta,index) in ventaDevolucion.products" :key="productVenta.id" :id="productVenta.id">
              <td>
                <button type="button" :id="'boton'+productVenta.id"class="btn btn-danger btn-sm"  v-on:click="removeProduct(productVenta,index)">X</button>
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
            <tr v-for="(productVenta,index) in nuevosProducts" :key="productVenta.id">
              <td>
                <button type="button" class="btn btn-danger btn-sm" v-on:click="eliminarProductVenta(productVenta,index)">X</button>
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
            <tr v-if="ventaDevolucion.pagoEfectivo > 0">
                <td colspan="7" class="text-right table-light td-venta"><strong>Total Efectivo</strong></td>
                <td class="td-venta" v-bind:value="ventaDevolucion.pagoEfectivo">{{ventaDevolucion.pagoEfectivo}}</td> 
            </tr> 
            <tr v-if="ventaDevolucion.pagoTarjeta > 0">
                <td colspan="7" class="text-right table-light td-venta"><strong>Total Tarjeta</strong></td>
                <td class="td-venta" v-bind:value="ventaDevolucion.pagoEfectivo">{{ventaDevolucion.pagoTarjeta}}</td> 
            </tr> 
            <tr>
                <td colspan="7" class="text-right table-light td-venta"><strong>Total Pagado</strong></td>
                <td class="td-venta" v-bind:value="ventaDevolucion.pagoEfectivo">{{ventaDevolucion.total}}</td> 
            </tr> 

            <tr>
                <td colspan="7" class="text-right table-light"><strong>Nuevo Total</strong></td>
                <td>{{ventaDevolucion.total + totalSumar - totalRestar}}$</td> 
            </tr>

            <tr v-if="(ventaDevolucion.total + totalSumar - totalRestar) > ventaDevolucion.total">
                <td colspan="7" class="text-right table-light"><strong>Diferencia (a Pagar)</strong></td>
                <td v-bind:class="'colorRojo'">
                  {{ diferencia }}$
                </td> 
            </tr>  
            <tr v-else >
                <td colspan="7" class="text-right table-light"><strong>Diferencia (Devolver)</strong></td>
                <td v-bind:class="'colorVerde'"> 
                  {{ diferencia }}$
                </td>
            </tr> 
          </tbody>

          
        </table>
      </div>

      <hr>


        <div class="form-row justify-content-end">        

          <button type="submit" class="btn btn-primary btn-lg ml-5" v-on:click="exitventaDevolucion">Salir</button> 
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-success btn-lg ml-5" data-toggle="modal" data-target="#confirmar">
            Hecho
          </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="confirmar" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Confirmación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <h5>¿Estas seguro de modificar esta compra?</h5>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="modificarCompra">Guardar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Productos-->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <modalproducts-component
          @selectProduct="selectProduct">
            
          </modalproducts-component>
        </div>



    
      

  </div>
</template>

<script>
    export default {
      props: {
        ventaDevolucion:{

        }
      },
      data(){
        return {
          selectedProduct: '',
          producto: '',
          precio: '',
          cantidad: 1,
          descuento: '',
          totalNeto: 0,
          remove : false,
          nuevosProducts: [],
          productsRemovidos: [],
          nuevoTotal: 0,
          totalSumar: 0,
          totalRestar: 0
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
             if(this.nuevosProducts.length > 0)
             {
              for(var product of this.nuevosProducts){
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
              this.nuevosProducts.push(productVenta);
              this.totalSumar += productVenta.precio 
              /*
              this.totalNeto += (this.precio * this.cantidad) - this.descuento;
              this.pagoEfectivo = this.totalNeto;
              this.pagoTarjeta= 0;
              */
              this.producto= '';
              this.precio= '';
              this.cantidad= 1;
              this.descuento= 0;
              
              console.log(this.nuevosProducts);
             }
            
          },
        selectProduct(product){
          this.selectedProduct = product;
          this.producto = this.selectedProduct.n_serie;
          this.precio = this.selectedProduct.precio;
          console.log(this.selectedProduct);
        },
        exitventaDevolucion(){
          this.$emit('exitDevolucion');
          console.log('salir');
        },
        removeProduct(product,index){
          var fila = $('#'+product.id);
          if($('#'+product.id).hasClass('removido')){
            $('#'+product.id).removeClass('removido');

            $('#boton'+product.id).addClass('btn-danger');
            $('#boton'+product.id).removeClass('btn-secondary');

            this.totalRestar -= product.precio;
            this.productsRemovidos.splice(index,1);
            console.log(this.productsRemovidos);
          }else{
            $('#'+product.id).addClass('removido');

            $('#boton'+product.id).addClass('btn-secondary');
            $('#boton'+product.id).removeClass('btn-danger');

            this.totalRestar += product.precio;
            this.productsRemovidos.push(product);
            console.log(this.productsRemovidos);
          }

        },
        eliminarProductVenta(product,index){
          this.nuevosProducts.splice(index,1);
          this.totalRestar += product.precio;
        },
        modificarCompra(){
          this.ventaDevolucion.products.forEach(product=>{
            if(this.productsRemovidos.includes(product)){
              console.log('Esto producto fue removido');
              console.log(product);
              const params = {
                  nombre : product.nombre,               
                  categoria_id: product.categoria_id,
                  talle: product.talle,
                  color: product.color,
                  costo: product.costo,
                  precio: product.precio,
                  n_serie: product.n_serie,
                  enabled: 1,
                  estado: 'Inventario'
              };
              axios.post('/products', params)
              .then((response)=>{
                    console.log('producto creado');
                    console.log(response);      
              });
            } else {
              this.nuevosProducts.push(product);
            }
          })

          var pagoExtra = 0;
          if((this.ventaDevolucion.total + this.totalSumar - this.totalRestar) > this.ventaDevolucion.total){
            pagoExtra = (this.ventaDevolucion.total + this.totalSumar - this.totalRestar) - this.ventaDevolucion.total
          } else {
            pagoExtra = this.ventaDevolucion.total - (this.ventaDevolucion.total + this.totalSumar - this.totalRestar)
          }
          // Formas de Venta
          var efectivo = 0;
          var tarjeta = 9;

          if(this.ventaDevolucion.forma_pago == 'Efectivo'){
            efectivo = this.ventaDevolucion.total + this.totalSumar - this.totalRestar;
          }
          else if(this.ventaDevolucion.forma_pago == 'Tarjeta'){
            tarjeta =  this.ventaDevolucion.total + this.totalSumar - this.totalRestar;
          }
          let paramsVenta = {
            cliente_id : this.ventaDevolucion.cliente_id,
            forma_pago : this.ventaDevolucion.forma_pago,
            pagoEfectivo : efectivo,
            pagoTarjeta : tarjeta,
            total : this.ventaDevolucion.total + this.totalSumar - this.totalRestar,
            estado: 'Devolucion'
          }
          axios.put('/ventas/'+this.ventaDevolucion.id, paramsVenta).then(response=>{
            console.log('Venta Actualizada');
            console.log(response);

            // Products venta
            if(this.nuevosProducts.length > 0){
              this.nuevosProducts.forEach(product=>{
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
                };
                axios.post('productsvendidos/'+this.ventaDevolucion.id, params)
                     .then((response)=>{
                      axios.delete('products/'+product.id).then(response=>{
                                })
                      console.log('Producto Añadido');
                      console.log(response);
                });
              })
            }
            this.totalRestar = 0;
            this.totalSumar = 0;
            this.nuevosProducts = [];
            this.$emit('updateVenta');
          })
        
      }
    },
      computed: {
        diferencia(){
          return Math.abs( (this.ventaDevolucion.total + this.totalSumar - this.totalRestar) - this.ventaDevolucion.total)
          
        }
      }
  }
    
</script>
<style>
    .removido{
        background-color: rgba(0, 0, 0, 0.03);
    }
    .colorRojo{
        color:red;
    }
    .colorVerde{
        color:green;
    }

</style>
