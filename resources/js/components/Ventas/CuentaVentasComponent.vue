<template>
  <div>
    <div v-if="cuentaCliente.estado == 'Deuda' ">
      <h4>Cuenta Corriente</h4>
      <table class="table table-bordered "  v-if="cuentaActivada">
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
          <tr v-for="product in cuentaCliente.products" :key="product.id">

            <th>{{product.n_serie}}</th>
            <th>{{product.categoria}}</th>
            <th>{{product.color}}</th>
            <th>{{product.talle}}</th>
            <th>{{product.created_at}}</th>
            <th>{{product.precio}}</th>

          </tr>
          <tr>
              <td colspan="5" class="text-right table-light td-venta" ><strong>Total Neto</strong></td>
              <td v-if="cuentaActivada" class="td-venta">{{cuentaCliente.total}}</td> 
          </tr> 

          <tr >
              <td colspan="5" class="text-right table-secondary td-venta totalPagado"><strong>Total Pagado</strong></td>
              <td class="td-venta">{{cuentaCliente.pagado}}</td> 
          </tr> 

          <tr>
              <td colspan="5" class="text-right table-light td-venta"><strong>Total a Pagar</strong></td>
              <td class="td-venta" >{{(cuentaCliente.total) - cuentaCliente.pagado}}</td>
          </tr>
        </tbody>
      </table>
  </div>   
      <hr>

      <table class="table table-bordered ">
        <thead>
          <tr class=" table-primary ">
            <th scope="col"></th>
            <th scope="col">N° Serie</th>
            <th scope="col">Categoria</th>
            <th scope="col">Color</th>
            <th scope="col">Talle</th>
            <th scope="col">Precio</th>

          </tr>

        </thead>
        <tbody>


          <tr v-for="(product,index) in productsVenta" :key="product.id">
            <th>
              <button type="button" class="btn btn-danger btn-sm" v-on:click="deleteProductVenta(index)">X</button>
            </th>
            <th>{{product.n_serie}}</th>
            <th>{{product.categoria}}</th>
            <th>{{product.color}}</th>
            <th>{{product.talle}}</th>
            <th>{{product.precio}}</th>

          </tr>
          <tr>
              <td colspan="5" class="text-right table-light td-venta" ><strong>Total Neto</strong></td>
              <td class="td-venta">${{totalNeto}}</td> 
          </tr> 

          <tr v-if="Cuenta_formaPago == 'Efectivo'">
              <td colspan="5" class="text-right table-light td-venta"><strong>Efectivo</strong></td>
              <td class="td-venta"><input type="number" class="input-venta" v-model="pagadoEfectivo" v-on:keyup="insertPagado"></td> 
          </tr>

          <tr v-if="Cuenta_formaPago == 'Tarjeta'" v-for='(tarjeta,index) in listTarjetas'>
              <td colspan="5" class="text-right table-light td-venta">
                <button type="button" class="btn btn-danger btn-sm" v-on:click="eliminarTarjeta(index)">X</button>
                <strong>{{tarjeta.nombre}}</strong>
              </td>
              <td class="td-venta"><input :id="tarjeta.nombre" type="number" class="input-venta" v-on:keyup="FormaTarjeta"></td> 
          </tr> 

          <tr v-if="Cuenta_formaPago == 'efectivoTarjeta'">
              <td colspan="5" class="text-right table-light td-venta"><strong>Efectivo</strong></td>
              <td class="td-venta"><input type="number" class="input-venta" v-model="pagadoEfectivo" v-on:keyup="insertPagado"></td> 
          </tr>
          <tr v-if="Cuenta_formaPago == 'efectivoTarjeta'" v-for='(tarjeta,index) in listTarjetas'>
              <td colspan="5" class="text-right table-light td-venta">
                <button type="button" class="btn btn-danger btn-sm" v-on:click="eliminarTarjeta(index)">X</button>
                <strong>{{tarjeta.nombre}}</strong>
              </td>
              <td class="td-venta"><input :id="tarjeta.nombre" type="number" class="input-venta" v-on:keyup="FormaTarjeta"></td> 
          </tr>  

          <tr>
              <td colspan="5" class="text-right table-light td-venta"><strong>Total a Pagar</strong></td>
              <td class="td-venta">${{totalNeto - (pagadoEfectivo) - pagadoTarjeta }}</td>  
          </tr> 


          
        </tbody>
      </table>

      
  </div>
</template>

<script>
    export default {
      props: {
        productsVenta:{
          type: Array
        },
        totalNeto:{

        },
        cuentaActivada:{

        },
        cuentaCliente:{

        },
        Cuenta_formaPago:{

        },
        listTarjetas:{

        }
      },
      data(){
        return {
          pagadoEfectivo: 0,
          pagadoTarjeta: 0

        };
      },
      mounted() {

      },
      methods:{
        insertPagado(e){
          var valorPagadoEfectivo=0
          var valorPagadoTarjeta=0
          if(this.Cuenta_formaPago == 'Efectivo'){
            valorPagadoEfectivo=this.pagadoEfectivo
            valorPagadoTarjeta=0
          }
          if(this.Cuenta_formaPago == 'Tarjeta'){
            valorPagadoEfectivo=0
            valorPagadoTarjeta=this.pagadoTarjeta
          }
          if(this.Cuenta_formaPago == 'efectivoTarjeta'){
            valorPagadoEfectivo= this.pagadoEfectivo
            valorPagadoTarjeta= this.pagadoTarjeta
          }

          if(isNaN(this.pagadoEfectivo)){
            this.pagadoEfectivo = 0
          }
          if(isNaN(this.pagadoTarjeta)){
            this.pagadoTarjeta = 0
          }
          console.log(this.pagadoEfectivo)
          console.log(this.pagadoTarjeta)
          this.$emit('dejaPagando', valorPagadoEfectivo,valorPagadoTarjeta);
        },
        deleteProductVenta(index){
          console.log('index: ')
          console.log(index);
            this.$emit('Cuenta_deleteProductVenta', index);
            console.log('eliminar producto');
        },
        eliminarTarjeta(index){
          this.$emit('Cuenta_eliminarTarjeta',index);
        },
        FormaTarjeta(){
          this.pagadoTarjeta= 0;
          var total = 0;
          var Cuenta_listaTarjetas = []
          this.listTarjetas.forEach(t=>{
            let valorTarjeta = parseInt($('#'+t.nombre).val());
            if(isNaN(valorTarjeta)){
              valorTarjeta = 0;
            }
            console.log("El total de la tarjeta"+t.nombre+" es"+valorTarjeta);
            let tarjeta = {
              nombre:t.nombre,
              total:valorTarjeta
            }
            this.pagadoTarjeta+=valorTarjeta
            Cuenta_listaTarjetas.push(tarjeta);
          })
          console.log(Cuenta_listaTarjetas);
          this.$emit('Cuenta_FormaTarjeta',Cuenta_listaTarjetas);
          this.insertPagado();
        },

      },
      computed: {


      }
    }
</script>
<style>
  .totalPagado{
    text-decoration: none;
    padding: 10px;

    cursor: pointer;
    border: 2px solid #0016b0;
  }
  .totalPagado:hover{
    background-color: rgba(0,0,0,.075);
  }
  .table-ventas{
    table-layout: fixed;
    width: 100%;
  }
  .td-venta {
      border: 1px solid;
      width: 100px;
      word-wrap: break-word;
  }
  .input-venta{
    width: 100%;
  }
</style>
