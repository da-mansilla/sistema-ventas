<template>

      <div class="card-body">
        <form>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Cliente</label>
              <span v-if="señaMode">
                <input type="text" class="form-control" :value="señaMode[0].cliente" disabled>
              </span>
            </div>

            <div class="form-group col-md-3">
              <label for="inputPassword4">Telefono</label>
              <span v-if="señaMode">
                <input type="text" class="form-control" :value="señaMode[0].telefono" disabled>
              </span>
            </div>

            <div class="form-group col-md-3">
              <label for="inputPassword4">Email</label>
              <span v-if="señaMode">
                <input type="email" class="form-control" :value="señaMode[0].email" disabled>
              </span>

            </div>

          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">Forma de Pago</label>
              <input type="text" class="form-control" placeholder="Seña" disabled>
            </div>
            <div class="form-group col-md-6" v-if="señaMode">
              <label for="exampleFormControlSelect1">Vencimiento</label>
              <h5 class="mt-2">{{fechaVencimiento(señaMode[0].created_at)}} Faltan {{faltanFecha(señaMode[0].created_at)}} dias</h5>
            </div>
          </div>


        </form>

        <hr>
          <table class="table table-bordered ">
            <thead>
              <tr class=" table-primary ">
                <th scope="col">N° Serie</th>
                <th scope="col">Categoria</th>
                <th scope="col">Color</th>
                <th scope="col">Talle</th>
                <th scope="col">Fecha</th>
                <th scope="col">Precio</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="product in productsVendidos"  :key="product.id">
                <th>{{product.n_serie}}</th>
                <th>{{product.categoria}}</th>
                <th>{{product.color}}</th>
                <th>{{product.talle}}</th>
                <th>{{product.created_at}}</th>
                <th>{{product.precio}}</th>
              </tr>
              <tr v-if="señaMode">
                  <td colspan="5" class="text-right table-light td-venta" ><strong>Total Neto</strong></td>
                  <td class="td-venta">{{señaMode[0].total}}</td> 
              </tr> 

              <tr v-if="señaMode">
                  <td colspan="5" class="text-right table-secondary td-venta totalPagado" data-toggle="modal" data-target="#exampleModalScrollable"><strong>Total Pagado</strong></td>
                  <td class="td-venta">{{señaMode[0].seña}}</td> 
              </tr> 


              <tr v-if="señaMode">
                  <td colspan="5" class="text-right table-light td-venta"><strong>Total a Pagar</strong></td>
                  <td class="td-venta">{{señaMode[0].deuda}}</td> 
              </tr> 
            </tbody>
          </table>

          <hr>

          <div class="form-row justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg ml-5" v-on:click="exitSena">Salir</button> 
          </div>
          <div>
          </div>
        

          <!-- Modal           -->
          <div v-if="señaMode" class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 v-if="modalPagina == 1" class="modal-title" id="exampleModalScrollableTitle">Deuda</h4>
                  <h4 v-if="modalPagina == 2" class="modal-title" id="exampleModalScrollableTitle">Nuevo Pago</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div >
                    <div class="form-group row mt-3" >
                      <div class="col-sm-4">
                        Total Neto
                        <input class="form-control" :value="señaMode[0].total" disabled >
                      </div>
                      <div class="col-sm-4">
                        Seña
                        <input class="form-control" :value="señaMode[0].seña" disabled >
                      </div>
                      <div class="col-sm-4">
                        Total a Pagar
                        <input class="form-control" :value="señaMode[0].deuda - pagoDeuda" disabled >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Vencimiento</label>
                      <div class="input-group col-sm-5">
                        15-03-2019 (faltan 7 dias)
                      </div>
                    </div>
                    <div class="form-group row" >
                      <label for="inputPago" class="col-sm-3 col-form-label">Pagar</label>
                      <div class="input-group col-sm-5">
                        <input type="number" class="form-control" v-model="pagoDeuda" disabled >
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" style="cursor: default;" type="button" id="button-addon2"><i class="fas fa-dollar-sign"></i></button>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <button class="btn btn-success" v-on:click="saldarDeuda">Saldar Deuda</button>
                      </div>
                    </div>




                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-primary ml-3" :disabled="habilitarGuardar"  data-dismiss="modal" v-on:click="guardar">Guardar</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>

 
      </div>


</template>

<script>
    export default {
      props: {
        señaMode:{

        },
        editMode:{

        },
        productsVendidos:{

        },
        cuentaCliente:{

        }
      },
      data(){
        return {
            totalNeto: 0,
            ver : false,
            modalPagina: 1,
            pagoDeuda: 0,
            habilitarGuardar: true


        };
      },
      mounted() {
        $('#exampleModalScrollable').on('hidden.bs.modal', this.cerrarModal);

      },
      methods:{ 
          cerrarModal(){

            },
          exitSena(){
            this.$emit('exitSena');
          },
          fechaVencimiento(fecha){
          var venta = new Date(fecha);
          var fechaRetornar = new Date(venta.setDate(venta.getDate()+15));
          return fechaRetornar.toLocaleDateString();
          },
          faltanFecha(fecha){
          var hoy = new Date();
          var venta = new Date(fecha);
          var fechaRetornar = new Date(venta.setDate(venta.getDate()+15));

          var resultado = fechaRetornar.getDate() - hoy.getDate()
          return resultado;            
          },
          volver(){
            this.modalPagina = 1;
          },
          saldarDeuda(){
            this.pagoDeuda= this.señaMode[0].deuda;
            this.habilitarGuardar = false;
          },
          guardar(){
            var paramsVenta= {
              cliente_id: this.señaMode[0].cliente_id,
              forma_pago: this.señaMode[0].forma_pago,
              pagoEfectivo: this.señaMode[0].total,
              pagoTarjeta: 0,
              total: this.señaMode[0].total,
              seña: 0,
              deuda: 0,
              estado: 'Finalizado'
            }
            axios.put('ventas/'+this.señaMode[0].id,paramsVenta).then(response=>{
              console.log('Venta Finalizada');
              console.log(response.data);
              var venta = response.data;
              this.productsVendidos.forEach(product=>{
                var comienzo = product.estado.indexOf('(');
                var fin = product.estado.indexOf(')');
                var idProducto = product.estado.slice(comienzo+1,fin)
                axios.delete('products/'+idProducto).then(response=>{
                  console.log('Producto Eliminado de Inventario');
                  console.log(response.data);

                })
                let paramsProduct = {
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
                axios.post('productsvendidos/'+venta.id, paramsProduct).then((response)=>
                {
                  console.log('Producto Registrado pero Sigue en inventario')
                  this.$toasted.show('Seña Realizada Satisfactoriamente', { 
                     theme: "toasted-primary", 
                     position: "top-right", 
                     duration : 2000
                  });
                  this.$emit('exitSena');
                });

              })

            })
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