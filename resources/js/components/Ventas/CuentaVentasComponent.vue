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
              <td class="td-venta">{{totalNeto}}</td> 
          </tr> 
          <tr>
              <td colspan="5" class="text-right table-light td-venta"><strong>Deja Pagando</strong></td>
              <td class="td-venta"><input type="number" class="input-venta" v-model="pagado" v-on:keyup="insertPagado"></td> 
          </tr> 

          <tr>
              <td colspan="5" class="text-right table-light td-venta"><strong>Total a Pagar</strong></td>
              <td class="td-venta">{{totalNeto - pagado}}</td>  
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

        }
      },
      data(){
        return {
          pagado: 0

        };
      },
      mounted() {

      },
      methods:{
        insertPagado(e){
          var valorPagado = e.target.value
          this.$emit('dejaPagando', valorPagado);
        },
        deleteProductVenta(index){
          console.log('index: ')
          console.log(index);
            this.$emit('Cuenta_deleteProductVenta', index);
            console.log('eliminar producto');
        }

      },
      computed: {
        totalaPagar(){
          return this.totalNeto - this.pagado
        }

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
      border: 1px solid blue;
      width: 100px;
      word-wrap: break-word;
  }
  .input-venta{
    width: 100%;
  }
</style>
