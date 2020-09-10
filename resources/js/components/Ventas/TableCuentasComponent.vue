<template>
  <div>
    <div class="row tarjetas">
      <div class="col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Cuentas Activas</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{cantidadCuentasActivas}}</div>
                    </div>
                    <div class="col-auto">

                      <i class="fas fa-tag fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Por Cobrar</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{cobrarCuenta}}</div>
                    </div>
                    <div class="col-auto">

                      <i class="fas fa-tag fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      <!--
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
    -->
    </div>
    

    <div>
      <table class="table  " v-if="cargado">
        <thead>
          <tr class=" table-info ">
            <th scope="col"><strong> <h4>Opciones</h4></strong></th>
            <th scope="col"><strong> <h4>Cliente</h4></strong></th>
            <th scope="col"><strong> <h4>Productos</h4></strong></th>
            <th scope="col"><strong> <h4>Total</h4></strong></th>
            <th scope="col"><strong> <h4>Pagado</h4></strong></th>
            <th scope="col"><strong> <h4>Deuda</h4></strong></th>
            <th scope="col"><strong> <h4>Estado</h4></strong></th>

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
            console.log('list cuentas')
            console.log(this.listaCuentas)
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
