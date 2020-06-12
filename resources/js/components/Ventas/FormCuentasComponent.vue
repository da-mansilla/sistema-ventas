<template>

      <div class="card-body">
        <form>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Cliente</label>
              <span v-if="cuentaMode">
                <input type="text" class="form-control" v-bind:placeholder="cuentaMode.nombre" disabled>
              </span>
              <span v-else>
                <input type="text" class="form-control" v-bind:placeholder="editMode.cliente" disabled>
              </span>
            </div>

            <div class="form-group col-md-3">
              <label for="inputPassword4">Telefono</label>
              <span v-if="cuentaMode">
                <input type="text" class="form-control" v-bind:placeholder="cuentaMode.telefono" disabled>
              </span>
              <span v-else>
                <input type="text" class="form-control" v-bind:placeholder="editMode.telefono" disabled>
              </span>
            </div>

            <div class="form-group col-md-3">
              <label for="inputPassword4">Email</label>
              <span v-if="cuentaMode">
                <input type="email" class="form-control" v-bind:placeholder="cuentaMode.email" disabled>
              </span>
              <span v-else>
                <input type="text" class="form-control" v-bind:placeholder="editMode.email" disabled>
              </span>
            </div>

          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">Forma de Pago</label>
              <input type="text" class="form-control" placeholder="Cuenta Corriente" disabled>
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

            <tbody v-if="cuentaMode">
              <tr v-for="product in cuentaMode.cuenta[0].products" v-if="product.estado == 'Cuenta Corriente'" :key="product.id">
                <th>{{product.n_serie}}</th>
                <th>{{product.categoria}}</th>
                <th>{{product.color}}</th>
                <th>{{product.talle}}</th>
                <th>{{product.created_at}}</th>
                <th>{{product.precio}}</th>
              </tr>
              <tr>
                  <td colspan="5" class="text-right table-light td-venta" ><strong>Total Neto</strong></td>
                  <td class="td-venta">{{cuentaMode.cuenta[0].total}}</td> 
              </tr> 

              <tr>
                  <td colspan="5" class="text-right table-secondary td-venta totalPagado" data-toggle="modal" data-target="#exampleModalScrollable" v-on:click="verPagos"><strong>Total Pagado</strong></td>
                  <td class="td-venta">{{this.cuentaMode.cuenta[0].pagado}}</td> 
              </tr> 


              <tr>
                  <td colspan="5" class="text-right table-light td-venta"><strong>Total a Pagar</strong></td>
                  <td class="td-venta">{{this.cuentaMode.cuenta[0].deuda}}</td> 
              </tr> 
            </tbody>
            <tbody v-else>

              <tr v-for="product in productsVendidos" :key="product.id">
                <th>{{product.n_serie}}</th>
                <th>{{product.categoria}}</th>
                <th>{{product.color}}</th>
                <th>{{product.talle}}</th>
                <th>{{product.created_at}}</th>
                <th>${{product.precio}}</th>
              </tr>
              <tr v-if="productsVendidos.length > 0">
                  <td colspan="5" class="text-right table-light td-venta" ><strong>Total Neto</strong></td>
                  <td class="td-venta">${{Total_Neto()}}</td> 
              </tr> 
              <!-- -->

              <tr v-if="editMode.pagoEfectivo>0">
                  <td colspan="5" class="text-right td-venta table-secondary"><strong>Efectivo</strong></td>
                  <td  class="td-venta">${{editMode.pagoEfectivo}}</td> 
              </tr> 

              <tr v-if="editMode.tarjetas.length>0" v-for="tarjeta in editMode.tarjetas" :key="tarjeta.id">
                  <td colspan="5" class="text-right td-venta table-secondary"><strong>{{tarjeta.nombre}}</strong></td>
                  <td  class="td-venta">${{tarjeta.total}}</td> 
              </tr> 

              <tr>
                  <td colspan="5" class="text-right td-venta "><strong>Total Pagado</strong></td>
                  <td  class="td-venta">${{editMode.total}}</td> 
              </tr> 
              <!-- -->
              <tr>
                  <td colspan="5" class="text-right table-light td-venta" style="font-size: 19px;"><strong>Total a Pagar</strong></td>
                  <td v-if="productsVendidos.length == 0"class="td-venta" style="color:green;font-size: 19px;">{{editMode.deuda}}</td> 
                  <td v-else style="color:green;font-size: 19px;">${{Math.abs(Total_Neto() - editMode.total)}}</td> 
              </tr> 
            </tbody>
          </table>

          <hr>

          <div class="form-row justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg ml-5" v-on:click="exitEditMode">Salir</button> 
          </div>
          <div>
          </div>
        

          <!-- Modal -->
          <div v-if="cuentaMode" class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 v-if="modalPagina == 1" class="modal-title" id="exampleModalScrollableTitle">Pagos</h4>
                  <h4 v-if="modalPagina == 2" class="modal-title" id="exampleModalScrollableTitle">Nuevo Pago</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <button v-if="modalPagina == 1 && cuentaMode.cuenta[0].estado !== 'Saldado' " v-on:click="nuevoPago"class="btn btn-success">Nuevo Pago <i class="fas fa-plus-circle"></i></button>
                  <button v-if="modalPagina == 1" v-on:click="pagosAnterior"class="btn btn-secondary">Pagos Anteriores <i class="fas fa-arrow-circle-left"></i></button>
                  <button v-if="modalPagina == 1 && batchCargado !== this.cuentaMode.cuenta[0].batch" v-on:click="pagosPosterior"class="btn btn-secondary">Volver<i class="fas fa-arrow-circle-right"></i></button>

                  <button v-if="modalPagina == 2" v-on:click="volver"class="btn btn-secondary">Atras <i class="fas fa-arrow-circle-left"></i></button>
                  <hr>
                  <div v-if="modalPagina == 1">

                    <table class="table table-bordered mt-2" v-bind:class="{'table-active' : enBatchAnterior}">
                      <thead>
                        <tr class=" table-primary" >
                          <th></th>
                          <th>Fecha</th>
                          <th>Descripcion</th>
                          <th>Pago</th>
                        </tr>

                      </thead>  
                      <tbody>
                        
                        <tr v-for="pago in listPagosMostrar" :key="pago.id"> 
                          <th>{{pago.batch}}</th>
                          <th>{{pago.created_at}}</th>
                          <th>{{pago.descripcion}}</th>
                          <th>${{pago.pagado}}</th>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right table-light td-venta" ><strong>Total Neto</strong></td>
                            <td v-if="!enBatchAnterior"class="td-venta">{{cuentaMode.cuenta[0].pagado}}</td> 
                            <td v-else class="td-venta">${{totalDePagos}}</td> 
                        </tr> 
                      </tbody>
                    </table>

                  </div>

                  <div v-if="modalPagina == 2">
                    <div class="form-group row mt-3" >
                      <div class="col-sm-4">
                        Total Neto
                        <input class="form-control" disabled :value="cuentaMode.cuenta[0].total">
                      </div>
                      <div class="col-sm-4">
                        Total Pagado
                        <input class="form-control" disabled :value="cuentaMode.cuenta[0].pagado">
                      </div>
                      <div class="col-sm-4">
                        <strong>Total a Pagar</strong>
                        <input class="form-control" disabled :value="cuentaMode.cuenta[0].deuda - valorPago">
                      </div>
                    </div>

                    <div class="form-group row" >
                      <div class="col-sm-6">
                        <label>Forma de Pago</label>
                        <select class="form-control"  value="Efectivo" required v-model="formaPago">
                          <option selected>Efectivo</option>
                          <option>Tarjeta</option>
                          <option value="efectivoTarjeta">Efectivo y Tarjeta</option>
                        </select>
                      </div>
                      <div class="col-sm-6" v-if="formaPago == 'Tarjeta' || formaPago == 'efectivoTarjeta'">
                        <label>Tarjeta</label>
                        <select class="d-block form-control" v-model="tarjetaElegida" required="">
                          <option selected="Debito">Debito</option>
                          <option>Visa</option>
                          <option>MasterCard</option>
                          <option value="TarjetaNaranja">Tarjeta Naranja</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row" >
                      
                      <div class="col-sm-4" v-if="formaPago == 'Efectivo' || formaPago == 'efectivoTarjeta'">
                        <label for="inputPago">Efectivo</label>
                        <input type="number" class="form-control" v-model="pagandoEfectivo" v-on:keyup="ingresarValorPago">
                      </div>


                      <div class="col-sm-4" v-if="formaPago == 'Tarjeta' || formaPago == 'efectivoTarjeta'">
                        <label for="inputPago">Tarjeta</label>
                        <input type="number" class="form-control" v-model="pagandoTarjeta" v-on:keyup="ingresarValorPago">
                      </div>

                      <div class="col-sm-4" style="padding-top:31px;" v-if="formaPago == 'Efectivo' || formaPago == 'Tarjeta'" v-on:click="saldarDeuda">
                        <button class="btn btn-success">Saldar Cuenta</button>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputPago" class="col-sm-4 col-form-label">Descripcion</label>
                      <div class="input-group col-sm-6">
                        <textarea class="form-control" v-model="descripcionPago"></textarea>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <button class="btn btn-primary ml-3" v-on:click="agregarPago">Guardar</button>
                    </div>



                  </div>
                </div>
                <div class="modal-footer">
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
        cuentaMode:{

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
            listProductsCuenta: [],
            ver : false,
            modalPagina: 1,
            valorPago: 0,
            descripcionPago: '',
            listPagosMostrar: [],
            batchCargado: '',
            enBatchAnterior: false,
            formaPago:'Efectivo',
            pagandoEfectivo: 0,
            pagandoTarjeta: 0,
            tarjetaElegida: 'Debito'

        };
      },
      mounted() {
        $('#exampleModalScrollable').on('hidden.bs.modal', this.cerrarModal);
        console.log(this.cuentaCliente);
        if(this.cuentaClient){
          this.ver = true;
        }
      },
      watch:{
        formaPago: function(){
          this.pagandoEfectivo = 0
          this.pagandoTarjeta = 0
          this.valorPago = 0
        } 
      },
      methods:{ 
          cerrarModal(){
            this.listProductsCuenta= [];
            this.listPagosMostrar= [];
            this.enBatchAnterior = false;
            this.batchCargado = '';
            this.descripcionPago= '';
            this.modalPagina = 1;
            this.ver = false;
            this.valorPago = 0;
                
            },
          getCuenta($client_id){
            const promise = new Promise((resolve,reject)=>{
              axios.get('cuentas/'+$client_id)
              .then((response)=>{
                resolve(response);
              }).catch((err)=>{
                reject(err);
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
          putCuenta(params,cuenta_id){
            const promise = new Promise((resolve,reject)=>{
              axios.put('cuentas/'+cuenta_id,params)
              .then((response)=>{
                resolve(response)
              })
              .catch(err => {
                reject(err)
              })
            })
            return promise
          },
          exitEditMode(){
            this.$emit('exitCuentaMode');
          },
          Total_Neto(){
            var total= 0;
            this.productsVendidos.forEach(product=>{
              total += product.precio
            })
            return total
          },
          nuevoPago(){
            this.modalPagina = 2;
            console.log('Nuevo Pago');
          },
          volver(){
            this.modalPagina = 1;
          },
          saldarDeuda(){
            if(this.formaPago == 'Efectivo'){
              this.pagandoEfectivo = this.cuentaMode.cuenta[0].deuda;
              this.valorPago = this.pagandoEfectivo
            }
            if(this.formaPago == 'Tarjeta'){
              this.pagandoTarjeta = this.cuentaMode.cuenta[0].deuda;
              this.valorPago = this.pagandoTarjeta
            }
          },
          verPagos(){
            this.batchCargado = this.cuentaMode.cuenta[0].batch;
            this.cuentaMode.cuenta[0].pagos.forEach(pago=>{
              if(pago.batch == this.batchCargado){
                this.listPagosMostrar.push(pago)
              }
            })
            console.log(this.listPagosMostrar);
          },
          pagosAnterior(){
            if(this.batchCargado > 1){
              this.enBatchAnterior = true;
              this.batchCargado -= 1;
              this.listPagosMostrar= [];
              this.mostrarPagos(this.batchCargado);
            }

          },
          pagosPosterior(){
            this.batchCargado += 1
            if(this.batchCargado == this.cuentaMode.cuenta[0].batch){
              this.enBatchAnterior = false;
            }
            this.listPagosMostrar= [];
            this.mostrarPagos(this.batchCargado);

          },
          mostrarPagos(batch){
            this.cuentaMode.cuenta[0].pagos.forEach(pago=>{
                if(pago.batch == batch){
                  this.listPagosMostrar.push(pago)
                }
              })
          },
          agregarPago(){
            var paramVenta= {
                cliente_id: this.cuentaMode.id,
                forma_pago: 'Cuenta',
                pagoEfectivo: parseInt(this.pagandoEfectivo),
                pagoTarjeta: parseInt(this.pagandoTarjeta),
                total: parseInt(this.valorPago),
                deuda: (parseInt(this.cuentaMode.cuenta[0].deuda) - parseInt(this.valorPago)),
                estado: 'Cuenta Corriente',
                enabled: 1
            }
            axios.post('/ventas',paramVenta).then((response)=>{
                console.log(response.data)
                var ventaID = response.data.id;
                var desc = this.descripcionPago
                if((this.cuentaMode.cuenta[0].deuda - this.valorPago) == 0){
                  desc += ' (Cerrar Cuenta)'
                }
                var paramsPago = {
                  cuenta_id: this.cuentaMode.cuenta[0].id,
                  venta_id: response.data.id,
                  tarjeta:this.pagandoTarjeta,
                  efectivo: this.pagandoEfectivo,
                  pagado: this.valorPago,
                  descripcion: desc,
                  batch: this.cuentaMode.cuenta[0].batch
                }
                this.postPagos(paramsPago).then(response=>{
                  console.log('Pago Generado');
                  console.log(response.data);
                  var estadoCuenta = 'Deuda';
                  var batchCuenta = parseInt(this.cuentaMode.cuenta[0].batch);

                  var total = this.cuentaMode.cuenta[0].total;
                  var pagado= (parseInt(this.cuentaMode.cuenta[0].pagado) + parseInt(this.valorPago));
                  if((this.cuentaMode.cuenta[0].deuda - this.valorPago) == 0){
                    estadoCuenta = 'Saldado';
                    batchCuenta += 1;
                    total= 0;
                    pagado = 0;
                    this.cuentaMode.cuenta[0].products.forEach(product=>{
                      if(product.estado == 'Cuenta Corriente'){
                        axios.put('finalizarproducto/'+product.id).then(response=>{
                          console.log(response);
                        })  

                      }
                    })
                  }
                  var paramsCuenta = {
                    total: total,
                    pagado: pagado,
                    deuda: (this.cuentaMode.cuenta[0].deuda - this.valorPago),
                    estado: estadoCuenta,
                    batch : batchCuenta
                  }
                  console.log(paramsCuenta);
                  return this.putCuenta(paramsCuenta, this.cuentaMode.cuenta[0].id)
                  })
                  .then(response=>{
                    console.log('Cuenta Modificada');
                    console.log(response);
                    this.$emit('nuevoPago',this.cuentaMode.id);
                    $('#exampleModalScrollable').modal('hide')
                  })
                  .catch(err=>{
                    console.log(err);
                  })
                  if(this.formaPago == 'Tarjeta' || this.formaPago == 'efectivoTarjeta'){
                      let parametros = {
                        nombre: this.tarjetaElegida,
                        total: this.pagandoTarjeta,
                        venta_id : ventaID
                      }
                      axios.post('tarjetas', parametros).then((response)=>{
                        //console.log(response);
                      })

                   }
              })
          },
          ingresarValorPago(){
            if(isNaN(this.pagandoEfectivo)){
              this.pagandoEfectivo = 0
            }
            if(isNaN(this.pagandoTarjeta)){
              this.pagandoTarjeta = 0
            }


            if(this.formaPago == 'Efectivo'){
              this.valorPago = parseInt(this.pagandoEfectivo)
              this.pagandoTarjeta = 0
            }
            if(this.formaPago == 'Tarjeta'){
              this.valorPago = parseInt(this.pagandoTarjeta)
              this.pagandoEfectivo = 0
            }
            if(this.formaPago == 'efectivoTarjeta'){
              this.valorPago = parseInt(this.pagandoEfectivo)+parseInt(this.pagandoTarjeta)
            }
          }
        },


      computed: {
        totalDePagos(){
          var total = 0;
          this.listPagosMostrar.forEach(pago=>{
            total += pago.pagado;
          })
          return total;
        }
        
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