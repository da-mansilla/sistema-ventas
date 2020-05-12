<template>
    <div>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar</button>
        

        <div class="row tarjetas">
          <div class="col-sm-6">
            <div class="card text-center">
              <div class="card-body">
                <h3 class="card-title">Proveedores </h3>
                <p class="card-text">3</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text"></p>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-bordered table-products ">
          <thead>
            <tr class=" table-primary ">
              <th scope="col"></th>
              <th scope="col">Empresa</th>
              <th scope="col">Ciudad</th>
              <th scope="col">Direccion</th>
              <th scope="col">Telefono</th>
              <th scope="col">Contacto</th>


            </tr>
          </thead>
          <tbody>

            <tr v-for="proveedor in listProveedores" :key="proveedor.id">
              <th scope="row" >
                <button  type="button" class="btn btn-secondary btn-sm" v-on:click="verProveedor(proveedor)"> + </button>
              </th>
              <th> {{proveedor.empresa}} </th>
              <th> {{proveedor.ciudad}} </th>
              <th> {{proveedor.direccion}} </th>
              <th> {{proveedor.telefono}} </th>
              <th> {{proveedor.contacto}} </th>

            </tr>         
          </tbody>
        </table>

        
    </div>
</template>

<script>
    export default {
        props: {
        },
        data(){
            return {
              listProveedores : []
            }
              
        },
        mounted() {
          this.getProveedores();
        },
        methods:{
          getProveedores(){
            axios.get('/proveedors')
            .then(response=>{
              this.listProveedores = response.data;
            })
            .catch(err => console.log(err))
          },
          verProveedor(proveedor){
            this.$emit('verProveedor',proveedor);
          }
        },
        computed: {
        }
        
    }
</script>
<style>
.table-products{
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
