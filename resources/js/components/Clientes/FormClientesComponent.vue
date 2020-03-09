<template>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar</button>
         
        <!-- Modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form v-on:submit.prevent="addClient()" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nombre</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg" id="colFormLabelLg" v-model="nombre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Telefono</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg" id="colFormLabelLg" v-model="telefono">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control form-control-lg" id="colFormLabelLg" v-model="email">
                        </div>
                    </div>
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Agregar</button>
              </div>
              </form>
                
            </div>
          </div>
        </div>
            
        
    </div>

</template>

<script>
    export default {
    	data(){
    		return {
                nombre: '',
                telefono: '',
                email: ''
    		}
    	},
        mounted() {
        },
        methods: {
            addClient(){
                let client= {
                    nombre: this.nombre,
                    telefono: this.telefono,
                    email: this.email,
                    enabled: 1,
                    cuenta: false,
                    estado: 'ok'
                };
                axios.post('/clients',client).then((response)=>{
                    this.$emit('new', response.data);
                    this.nombre= '';
                    this.telefono= '';
                    this.email= '';
                })

            }
        }
    }
</script>
