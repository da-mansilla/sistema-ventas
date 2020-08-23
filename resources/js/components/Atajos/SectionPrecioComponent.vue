<template>
    <div class="card-content card w-100">
      <div class="card-header ">
        <h1 class="display-4 mb-0 text-gray-800">Precio</h1>
      </div>
      <div class="card-body">

      <div class="row justify-content-center">  
        <div class="col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-lg font-weight-bold text-success text-uppercase mb-1">N° de Serie</div>
                  <input type="text" class="form-control"v-model="n_serie" v-on:keydown.enter="filtrar">
                </div>
                <div class="col-auto">

                  <i class="fas fa-search fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h2 class="h2 lead">N° de Serie: {{titulo}}</h2>
      <!--
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
        <h4>N° de Serie: {{titulo}}</h4>
      -->

        <div>
          <table class="table ">
              <thead>
                <tr class=" table-info ">

                  <th scope="col"><strong><h4>Categoria</h4></strong></th>
                  <th scope="col"><strong><h4>Tipo</h4></strong></th>
                  <th scope="col"><strong><h4>N° Serie</h4></strong></th>
                  <th scope="col"><strong><h4>Talle</h4></strong></th>
                  <th scope="col"><strong><h4>Color</h4></strong></th>
                  <th scope="col"><strong><h4>Precio</h4></strong></th>

                </tr>
              </thead>
              
              <tbody >
                <tr v-for="(product,index) in listaProducts" :key="product.id">
                  <th>
                    <span> {{product.categoria}} </span>
                  </th>
                  <th>
                    <span> {{product.tipo}} </span>
                  </th>
                  <th>
                    <span> {{product.n_serie}} </span>
                  </th>
                  <th>
                    <span> {{product.talle}} </span>
                  </th>
                  <th>
                    <span> {{product.color}} </span>
                  </th>
                  <th>
                    <span style="color: green; font-size: 16px;"> ${{product.precio}} </span>
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
                                      <tr v-for="(productos,index) in product.products" :key="productos.id" class="align-middle">
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
          filtro : {},
          titulo: ''

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
            this.titulo = this.n_serie
            var numSerie = 0;
            var inicio = this.n_serie.indexOf('%');
            console.log(inicio);
            if(inicio == -1){
              numSerie = this.n_serie
            } else {
              numSerie = this.n_serie.substring(0,inicio);  
            }
            axios.get('productosPorSerie/'+numSerie).then(response=>{
              console.log(response.data);
              this.listaProducts = response.data;
              this.n_serie = '';
            })

            

            
          }

        },
        computed: {
        }

    }
</script>
