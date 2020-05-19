<template>
  <div>
    <div class="row tarjetas">
      <div class="col-sm-6">
        <div class="card text-center">
          <div class="card-body">
            <h4 class="card-title">Cuentas Activas</h4>
            <h5 class="card-text" style="color: blue;">{{cantidadCuentasActivas}}</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card text-center">
          <div class="card-body">
            <h4 class="card-title">Por Cobrar</h4>
            <h5 class="card-text" style="color: red;">{{cobrarCuenta}}</h5>
          </div>
        </div>
      </div>
    </div>
    

    <div>
      <table class="table table-bordered " v-if="cargado">
        <thead>
          <tr class=" table-primary ">
            <th scope="col">Opciones</th>
            <th scope="col">Cliente</th>
            <th scope="col">Productos</th>
            <th scope="col">Total</th>
            <th scope="col">Pagado</th>
            <th scope="col">Deuda</th>
            <th scope="col">Estado</th>

          </tr>
        </thead>
        <tbody>

          <tr v-for="client in listaCuentas.data" :key="client.id" >
            <th scope="row" >
              <button type="button" class="btn btn-primary btn-sm" v-on:click="verCuenta(client)"><i class="far fa-eye"></i></button>
               
            </th>
            <th>
             {{client.nombre}}
            </th>
            <th>
             {{client.cuenta[0].products.length}}
            </th>
            <th>
             {{client.cuenta[0].total}}
            </th>
            <th>
             {{client.cuenta[0].pagado}}
            </th>
            <th>
             {{client.cuenta[0].deuda}}
            </th>
            <th>
              <span v-bind:class="{'colorRojo' : client.cuenta[0].estado == 'Deuda'}">{{client.cuenta[0].estado}}</span>
            </th>

          </tr>


          
        </tbody>
      </table>
      <pagination :data="listaCuentas" @pagination-change-page="getResults" class="float-right">

      </pagination>
    </div>
  </div>
</template>

<script>
    export default {
      props: {
      },
      data(){
        return {
          listClients : [],
          cargado: false,
          listaCuentas: {},
          cantidadCuentasActivas: 0,
          cobrarCuenta: 0
        
        };
      },
      mounted() {
          this.getResults();
          this.getCuenta().then(response=>{
            this.listClients = response.data;
            this.cargado = true;
            this.getCantidad();
            this.getCobrar();
          })
      },
      methods:{
        getCantidad(){
          axios.get('cuentasCantidad').then(response=>{
              console.log(response.data[0]);
              this.cantidadCuentasActivas = response.data[0].cantidad;
          })
        },
        getCobrar(){
          axios.get('cuentasCobrar').then(response=>{
              console.log(response.data[0]);
              this.cobrarCuenta = response.data[0].cobrar;
              if(response.data[0].cobrar== null){
                this.cobrarCuenta = 0
              } else {

              }
          })
        },
        getResults(page = 1) {
            axios.get('/clientsCuentas?page=' + page)
              .then(response => {
                this.listaCuentas = response.data;
                console.log(this.listaCuentas);
              });
        },
        getCuenta(){
          const promise = new Promise((resolve,reject)=>{
            axios.get('clientsCuentas')
            .then((response)=>{
              resolve(response.data);
            }).catch((err)=>{
              reject(err);
            })
          })
          return promise;
        },
        verCuenta(client){
          this.$emit('verCuenta',client);
        }
      }
    }

</script>
<style>
    .venta-cancelada{
        background-color: rgba(0, 0, 0, 0.03);
    }
    .colorGris{
        color: gray;
    }
    .colorRojo{
        color: red;
    }

</style>
