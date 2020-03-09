<template>
    <div>
        <table class="table table-bordered ">
          <thead>
            <tr class=" table-primary ">
              <th scope="col">Opciones</th>
              <th scope="col">Nombre</th>
              <th scope="col">Telefono</th>
              <th scope="col">Compras</th>
              <th scope="col">Email</th>
              <th scope="col">Estado</th>

            </tr>
          </thead>
          <tbody>

            <tr v-for="(client,index) in listaClients.data" :key="client.id">
              <th scope="row" >
                  <span v-if="editMode==(index+1)">
                  <button  type="button" class="btn btn-primary btn-sm" v-on:click="onClickUpdate(client,index)">Guardar</button>
                  <button  type="button" class="btn btn-secondary btn-sm" v-on:click="onClickCloseEdit">Cerrar</button>
                </span>
                <span v-else>
                  <button  type="button" class="btn btn-danger btn-sm" v-on:click="onClickDelete(client,index)"><i class="fas fa-times-circle"></i></button>
                  <button  type="button" class="btn btn-secondary btn-sm" v-on:click="onClickOpenEdit(index)"><i class="fas fa-edit"></i></button>
                </span>
              </th>
              <th>
                <input v-if="editMode==(index+1)" type="text" name="nombre" v-model="client.nombre">
                <span  v-else> {{client.nombre}} </span>
              </th>

              <th>
                  <input v-if="editMode==(index+1)" type="text" name="categoria" v-model="client.telefono">
                  <span  v-else> {{client.telefono}} </span>
              </th>

              <th>
                  {{client.compras}}
              </th>
               
              <th>
                  <input v-if="editMode==(index+1)" type="text" name="stock" v-model="client.email">
                  <span  v-else> {{client.email}} </span>
              </th>
               
              <th>
                  Ok
              </th>
                

            </tr>
            
          </tbody>
        </table>
            <pagination :data="listaClients" @pagination-change-page="getResults" class="float-right">
            </pagination>
    </div>
</template>

<script>
    export default {
        data(){
            return{
              editMode: 0,
              clients: [],
              listaClients: {}
            }
        },
        mounted() {
           this.getClients();
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
              this.clients = response.data.data;
              console.log(response.data);
            })
          },
          onClickOpenEdit(index){
              this.editMode = index+1;

          },
          onClickCloseEdit(){
              this.editMode = 0;
          },
          onClickUpdate(client,index){
            const params = {
              nombre: client.nombre,                
              telefono: client.telefono,
              email: client.email,
            }
            axios.put('/clients/'+client.id, params).then((response)=>{
              this.editMode = 0;
              console.log(response.data);
            })

          },
          onClickDelete(client,index){

              axios.put('/clients/disable/'+client.id).then((response)=>{
                this.$emit('delete', index);
              })
          }
        },
        computed: {
        }
        
    }
</script>
