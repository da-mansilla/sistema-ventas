<template>
    <div class="card-content card w-100">
      <div class="card-header ">
        <h3>Clientes</h3>
      </div>
      <div class="card-body">
        <formclientes-component
          @new='addClient'>
          
        </formclientes-component>
        <div class="row tarjetas">
          <div class="col-sm-6">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><h3>Clientes</h3></h5>
                <p class="card-text">{{cantidad}}</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><h3></h3></h5>
                <p class="card-text"></p>
              </div>
            </div>
          </div>
        </div>
        <tableclientes-component
          :clients='clients'
          @delete="deleteClient">
          
        </tableclientes-component>
      </div>



    </div>
</template>

<script>
    export default {
      data(){
        return {
          clients:[],
          cantidad: 0
          
        };
      },
      mounted() {
        this.cantidadClientes();
      },
      methods:{
          cantidadClientes(){
            axios.get('cantidadClientes').then(response=>{
              let cantidad = response.data[0].cantidad
              this.cantidad = cantidad;
            })
          },
          addClient(client){
            this.clients.push(client);
          },
          deleteClient(index){
            this.clients.splice(index,1);
          }
      }
    }
</script>
