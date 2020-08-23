<template>
    <div>
        <table class="table">
          <thead>
            <tr class=" table-info ">
              <th scope="col"><h4><strong>Opciones</strong></h4></th>
              <th scope="col"><h4><strong>Temporada</strong></h4></th>
              <th scope="col"><h4><strong>Categoria</strong></h4></th>
              <th scope="col"><h4><strong>Stock</strong></h4></th>
              <th scope="col"><h4><strong>Tipo</strong></h4></th>
              <th scope="col"><h4><strong>N° Serie</strong></h4></th>

            </tr>
          </thead>
          
          <tbody >
            <tr v-for="(product,index) in listaProducts.data" :key="product.id">
              <th scope="row" >
                <span>
                  <button  type="button" class="btn btn-secondary btn-sm" data-toggle="modal" :data-target="`#exampleModalCenter${index}`"> + </button>
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
              <div class="modal fade " :id="`exampleModalCenter${index}`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                  <tr class=" table-info">
                                    <th scope="col"></th>
                                    <th scope="col"><h5><strong>Color</strong></h5></th>
                                    <th scope="col"><h5><strong>Talle</strong></h5></th>
                                    <th scope="col"><h5><strong>Precio</strong></h5></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="productos in product.products" :key="productos.id">
                                    <th>
                                      <button  type="button" class="btn btn-danger btn-sm" v-on:click="onClickDelete(productos,index)"><i class="fas fa-times-circle"></i></button>
                                    </th>
                                    <th>{{productos.color}}</th>
                                    <th>{{productos.talle}}</th>

                                    <th class="justify-content-center" style="color:green;">${{productos.precio}}</th>
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
        
        <pagination  :data="listaProducts" :limit="2" @pagination-change-page="getResults" class="float-right"></pagination>
        <span>Mostrando {{(listaProducts.current_page-1) * 5}} - {{(listaProducts.current_page) * 5}} de {{listaProducts.total}} elementos</span>

    </div>
</template>

<script>
    export default {
        props: {
            filtros:{

            },
            listaFiltrada:{
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
        },
        methods:{
            filtrar(page = 1){
              axios.post('/filtrar?page=',this.filtros).then(response=>{
                console.log(response);
                this.listaFiltrada = response.data;
              })
            },
            getResults(page = 1) {
              axios.get('/stock?page=' + page)
                .then(response => {
                  this.listaProducts = response.data;
                });
            },
            onClickDelete(product,index){
              var answer = window.confirm("¿Está seguro que desea elimminar?")
              if (answer) {
                  axios.delete('/products/'+product.id).then(()=>{
                    this.$toasted.show('Producto Eliminado Exitosamente', { 
                     theme: "toasted-primary", 
                     position: "top-right", 
                     duration : 2000
                    });
                    this.getResults();
                    $("#exampleModalCenter"+index).modal('hide')
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
