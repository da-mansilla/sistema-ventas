<template>
    <div>
        <!-- Button trigger modal -->

        <!-- Modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form autocomplete="off">
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg">Nombre</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg"  required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg"></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg"  required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg"></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg"  required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg"></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg"  required>
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
    import Toasted from 'vue-toasted';

    export default {
        props: {

        },
    	data(){
    		return {


    		}
    	},
        mounted() {
            //$('#exampleModal').on('hidden.bs.modal', this.cerrarModal);
        },
        methods: {
            cerrarModal(){

            },

        }
    }
</script>
