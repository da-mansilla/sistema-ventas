<template>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header md-1">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
          <div class="card">
              <div class="card-header">
                  <div class="form-row">
                         <input type="text" class="form-control w-75" v-model="nombreNewClient" v-on:keyup="busquedaClient">
                         <button class="btn btn-primary btn-sm w-25" data-dismiss="modal" v-on:click="newClient()">Nuevo Cliente</button>                               
                  </div>
              </div>
              <div class="card-body">
                  <table class="table mt-0">
                    <thead>
                      <tr class=" table-primary">
                        <th scope="col"></th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Compras</th>
                        <th scope="col">Cuenta</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(client,index) in listaClients.data" :key="client.id">
                        <td>
                          <button type="button" class="btn btn-success btn-sm" data-dismiss="modal" v-on:click="selectClient(client,index)">Ok</button>
                        </td>
                        <td>
                          {{client.nombre}}
                        </td>
                        <td>
                          {{client.compras}}
                        </td>
                        <td>
                          <span v-if="client.cuenta == 1">Si</span>
                          <span v-else>No</span>

                        </td>
                      </tr>
                    </tbody>
                  </table>
                    <pagination :data="listaClients" :limit="2" @pagination-change-page="getResults" class="float-right">
                    </pagination>
              </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
      data(){
        return {
          cliente: '',
          telefono: '',
          email: '',
          selectedClient: '',
          nombreNewClient: '',
          createClient: false,
          cliente: '',
          dbclients: [],
          clientsResult: [],
          paginate: ['clientsResult'],
          page: 1,
          listaClients: {}

        };
      },
      mounted() {
        this.getResults();
      },
      methods:{
        getResults(page = 1) {
          axios.get('/clients?page=' + page)
            .then(response => {
              this.listaClients = response.data;
            });
        },
        getClients(){
            axios.get('/clients').then((response)=>{
              this.dbclients = response.data;
              this.clientsResult = this.dbclients;
            });
        },
        busquedaClient(){
          var nombreBuscar = this.nombreNewClient;
          if(nombreBuscar == ''){
            this.getResults();
          } else {
            axios.get('/clients/buscar/'+nombreBuscar).then(response=>{
              this.listaClients = response.data;
            })
          }
          /*
          this.listaClients = [];
          for(var client of this.dbclients)
          {
            var nombre = client.nombre.toLowerCase();
            if(nombre.startsWith(this.nombreNewClient.toLowerCase())){
                this.listaClients.push(client);  
            }
          }
          */
        },
        newClient(){
          this.createClient = true;
          this.cliente = this.nombreNewClient
          this.$emit('newClient',this.createClient, this.cliente );
        },
        selectClient(client,index){
          console.log(client);
          //var indice = index + ( (this.page-1) * 3);
          this.selectedClient = client;
          this.cliente = this.selectedClient.nombre;
          this.telefono = this.selectedClient.telefono;
          this.email = this.selectedClient.email;
          this.$emit('selectClient', this.selectedClient);
        },
        paginateChange(toPage, fromPage){
          this.page = toPage;
        }
      }
    }
</script>
