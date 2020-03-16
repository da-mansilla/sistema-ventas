<template>
    <div class="card-content card w-100">
      <div class="card-header ">
        <h3>Precio</h3>
      </div>
      <div class="card-body">
      
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6 ">
            <div class="card text-center">
              <div class="card-body">
                <h3 class="card-title">N° de Serie </h3>
                <input type="text" class="form-control"v-model="n_serie" v-on:keydown.enter="filtrar">
              </div>
            </div>
          </div>
        </div>


        <div>
          <table class="table table-bordered table-products ">
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
                                      <tr class=" table-primary">
                                        <th scope="col">Color</th>
                                        <th scope="col">Talle</th>
                                        <th scope="col">Precio</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="(productos,index) in product.products" :key="productos.id">
                                        <th>{{productos.color}}</th>
                                        <th>{{productos.talle}}</th>
                                        <th>{{productos.precio}}</th>
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
            
            <pagination  :data="listaProducts" @pagination-change-page="getResults" class="float-right"></pagination>

        </div>
      </div>
  </div>
</template>

<script>
    export default {
      data(){
        return {
          listaProducts: {},
          n_serie : '',
          filtro : {}

        };
      },
      mounted() {

      },
      methods:{
        getResults(page = 1){
          axios.post('/filtrar?page=' + page,this.filtro).then(response=>{
            console.log(response.data);
            this.listaProducts = response.data;

          })
        },
        filtrar(){
            var productos = [];
            var inicio = this.n_serie.indexOf('%');
            console.log(inicio);
            if(inicio == -1){
              productos.push(this.n_serie)
            } else {
              var numSerie = this.n_serie.substring(0,inicio);  
              productos.push(numSerie)
            }
            console.log('filtrar');

            
            let opciones={
               tipo : {
                Niño: true,
                Niña: true,
                Unisex: true
               },
               categoria: {
                enabled: false,
                categorias: []
               },
               precio: {
                enabled: false,
                desde: '',
                hasta: ''
               },
               temporada: {
                enabled: false,
                temporada: ''
               },
               producto: {
                enabled: true,
                productos: productos
               },
               fecha: {
                enabled: false,
                fecha: '',
                intervaloFechas: '',
                fechaDesde: '',
                fechaHasta: ''
               }
            };
            this.filtro = opciones;
            console.log(this.filtro);
            this.getResults();
            
          }

        },
        computed: {
        }

    }
</script>
