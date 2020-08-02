<template>
    <div>
        <table class="table table-bordered table-products mt-2">
          <thead>
            <tr class=" table-primary ">
              <th scope="col">Opciones</th>
              <th scope="col">Temporada</th>
              <th scope="col">Categoria</th>
              <th scope="col">Stock</th>
              <th scope="col">Tipo</th>
              <th scope="col">N° Serie</th>

            </tr>
          </thead>
          <tbody v-if="listaFiltrada.data.length">
            <tr v-for="(product,index) in listaFiltrada.data" :key="product.id">
              <th scope="row" >
                <span>
                  <button  type="button" class="btn btn-secondary btn-sm" data-toggle="modal" :data-target="`#FiltroModalDetalles${index}`"> + </button>
                  <!--
                  <button  type="button" class="btn btn-secondary btn-sm" v-on:click="onClickOpenEdit(index)"><i class="fas fa-edit"></i></button>
                  -->
                </span>
              </th>
              <th>
                <span> {{product.products[0].nombre}} </span>
              </th>
              <th>
                <span> {{product.products[0].categoria}} </span>
              </th>
              <th>
                <span> {{product.products.length}} </span>
              </th>
              <th>
                <span> {{product.products[0].tipo}} </span>
              </th>
              <th>
                <span> {{product.n_serie}} </span>
              </th>


              <!-- Modal Detalles-->
              <div class="modal fade " :id="`FiltroModalDetalles${index}`" tabindex="-1" role="dialog" aria-labelledby="FiltroModalDetallesTitle" aria-hidden="true">
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
                          </div>
                          <div class="card-body">
                              <table class="table mt-0">
                                <thead>
                                  <tr class=" table-primary">
                                    <th scope="col"></th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Talle</th>
                                    <th scope="col">Precio</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="productos in product.products" :key="productos.id">
                                    <th>
                                      <button  type="button" class="btn btn-danger btn-sm" v-on:click="onClickDelete(productos,index)"><i class="fas fa-times-circle"></i></button>
                                    </th>
                                    <th>{{productos.color}}</th>
                                    <th>{{productos.talle}}</th>
                                    <th style="color:green;">${{productos.precio}}</th>
                                  </tr>
                                </tbody>
                                  
                              </table>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </tr>
          </tbody>

          

        </table>
        <span>Mostrando {{(listaFiltrada.current_page-1) * 5}} - {{(listaFiltrada.current_page) * 5}} de {{listaFiltrada.total}} elementos</span>

            <pagination  :data="listaFiltrada" :limit="2" @pagination-change-page="filtrar" class="float-right"></pagination>
        

    </div>
</template>

<script>
    export default {
        props: {
            filtros:{

            },
            listaFiltrada:{
            },
            informacionListaFiltrada:{

            }

        },
        data(){
            return {
              editMode: 0,
              listStock: [],
              listaProducts: {}
                
            }
              
              
        },
        mounted() {
          this.getResults();
          console.log('Filtrosss');
        },
        methods:{
            filtrar(page = 1){
              this.$emit('filtrarOtraVez',page);
            },
            getResults(page = 1) {
              axios.get('/stock?page=' + page)
                .then(response => {
                  this.listaProducts = response.data;
                });
            },
            onClickDelete(product,index){
              var answer = window.confirm("¿Está seguro que desea eliminar?")
              if (answer) {
                  axios.delete('/products/'+product.id).then(()=>{
                    this.$toasted.show('Producto Eliminado Exitosamente', { 
                     theme: "toasted-primary", 
                     position: "top-right", 
                     duration : 2000
                    });
                    this.filtrar();
                    $("#FiltroModalDetalles"+index).modal('hide')
                  })
              }
                
            },
            onClickOpenEdit(index){
                this.editMode = index+1;

            },
            onClickCloseEdit(){
                this.editMode = 0;
            },
            onClickUpdate(product,index){
              const params = {
                nombre: product.nombre,                
                categoria: product.categoria,
                stock: product.stock,
                precio: product.precio,
                n_serie: product.n_serie
              }
              axios.put('/products/'+product.id, params).then((response)=>{
                this.editMode = 0;
                const new_product = response.data;
                this.$emit('updateProduct', new_product, index);
                this.$toasted.show('Producto Actualizado Exitosamente', { 
                 theme: "toasted-primary", 
                 position: "top-right", 
                 duration : 2000
                });
              })
            }
        },
        watch:{
          listaFiltrada: function(){
            console.log('La lista cambioo')
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
