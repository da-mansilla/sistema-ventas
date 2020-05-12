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

                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg">Empresa</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg"  required v-model="Proveedor.empresa">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="pr-0  col-sm-2 col-form-label col-form-label-lg">Razon Social</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg"  required v-model="Proveedor.razon_social">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg">Direccion</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg"  required v-model="Proveedor.direccion">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg">Ciudad</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control form-control-lg"  required v-model="Proveedor.ciudad">
                        </div>
                        <label class="pr-0 col-sm-2 col-form-label col-form-label-lg">CPA</label>
                        <div class="col-sm-4">
                          <input type="number" class="form-control form-control-lg"  required v-model="Proveedor.cpa">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg">Telefono</label>
                        <div class="col-sm-4">
                          <input type="number" class="form-control form-control-lg"  required v-model="Proveedor.telefono">
                        </div>
                        <label class="pr-0 col-sm-2 col-form-label col-form-label-lg">Contacto</label>
                        <div class="col-sm-4">
                          <input type="number" class="form-control form-control-lg"  required v-model="Proveedor.contacto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                          <label class="col-form-label col-form-label-lg">Cuenta</label>
                        </div>
                        <div class="col-sm-10">
                          <table class="table table-bordered mt-0">
                            <thead>
                              <tr class=" thead-dark ">
                                <th scope="col">Titular</th>
                                <th scope="col">Tipo de Cuenta</th>
                                <th scope="col">N° Cuenta</th>
                                <th scope="col">CBU</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th><input type="text" class="form-control" v-model="Cuenta.titular"></th>
                                <th><input type="text" class="form-control" v-model="Cuenta.tipo"></th>
                                <th><input type="number" class="form-control" v-model="Cuenta.n_cuenta"></th>
                                <th><input type="number" class="form-control" v-model="Cuenta.cbu"></th>
                                <th><button  type="button" class="btn btn-success btn-sm" @click="addCuenta"> + </button></th>
                              </tr>
                              <tr v-for="cuenta in listCuentas" class="">
                                <th>{{ cuenta.titular }}</th>
                                <th>{{ cuenta.tipo }}</th>
                                <th>{{ cuenta.n_cuenta }}</th>
                                <th>{{ cuenta.cbu }}</th>
                                <th><button  type="button" class="btn btn-danger btn-sm"> + </button></th>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                    </div>
   
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" @click="addProveedor">Guardar</button>
              </div>
                
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
          Proveedor: {
            empresa: '',
            razon_social: '',
            direccion: '',
            ciudad: '',
            cpa: '',
            telefono: '',
            contacto: ''
          },
          Cuenta: {
            titular: '',
            proveedor_id: '',
            tipo: '',
            n_cuenta: '',
            cbu: ''
          },
          listCuentas: []


    		}
    	},
        mounted() {
            //$('#exampleModal').on('hidden.bs.modal', this.cerrarModal);
        },
        methods: {
          addCuenta(){
            this.listCuentas.push(this.Cuenta);
          },
          addProveedor(){
            console.log(this.Proveedor);

            axios.post('/proveedors',this.Proveedor)
            .then(response=>{
              console.log(response);
              var proveedorId = response.data.id
              this.listCuentas.forEach(cuenta=>{
                cuenta.proveedor_id = proveedorId;
                axios.post('/cuenta_bancarias',cuenta)
                .then(response=> console.log(response.data))
                .catch(err => console.log(err))

              })
            })
            .catch(err =>{
              console.log('error');
              console.log(err.response.data.errors);
            })
          },


        }
    }
</script>
