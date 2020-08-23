<template>
    <div class="card-content card w-100">
      <div class="card-header ">
        <h1 class="display-4 mb-0 text-gray-800">Productos</h1>
      </div>
      <div class="card-body">
        
        <formproducts-component
            @new='addProduct'>
        </formproducts-component>

        <precioproducts-component
          :listStock='listStock'
          :categorias='categorias'> 
        </precioproducts-component>
            <!-- Button trigger modal -->
  <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#ModalFiltro" v-on:click="cargarFiltro">
    <i class="fas fa-align-justify"></i>
  </button>

        <filtroproducts-component v-if="modalFiltro"
          :listStock='listStock'
          @filtrar='filtrar'>
        </filtroproducts-component>
        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-success shadow btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-check"></i>
          </span>
          <span class="text h5">Agregar</span>
        </button>
        <button type="button" data-toggle="modal" data-target="#ModalPrecio" class="btn btn-success shadow btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-check"></i>
          </span>
          <span class="text h5">Precio</span>
        </button>
        <!--
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar</button>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalPrecio">Precio</button>
    -->
        <div class="row tarjetas">

          <div class="col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Productos</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ cantidadProducts }}</div>
                  </div>
                  <div class="col-auto">

                    <i class="fas fa-tshirt fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Categorias</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ cantidadCategorias }}</div>
                  </div>
                  <div class="col-auto">

                    <i class="fas fa-boxes fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!--
          <div class="col-sm-6">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><a v-on:click="abrirProductos"><h3 style="cursor: pointer;"> Productos </h3></a></h5>
                <p class="card-text">{{ cantidadProducts }}</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"> <a v-on:click="abrirCategoria"><h3 style="cursor: pointer;"> Categorias </h3></a></h5>
                <p class="card-text">{{cantidadCategorias}}</p>
              </div>
            </div>
          </div>
        -->
        </div>

        <!-- Tablas -->

        <resumeninventario-component
          :categorias='categorias'
          @filtrar='filtrar'>
          
        </resumeninventario-component>

        <tableproducts-component v-if="pagina==1"
        :listStock='listStock'
        :listaFiltrada='listaFiltrada'
        :filtros="filtros"
        @updateProduct="updateProduct"
        @deleteProduct="deleteProduct">
          
        </tableproducts-component>
        <tablefiltro-component v-if="pagina==3"
        :listaFiltrada='listaFiltrada'
        :filtros="filtros"
        :informacionListaFiltrada="informacionListaFiltrada"
        @updateProduct="updateProduct"
        @deleteProduct="deleteProduct"
        @filtrarOtraVez="filtrarOtraVez">
        </tablefiltro-component>

        <tablecategorias-component v-if="pagina==2">
        </tablecategorias-component>

        

        <!-- Resumen -->

          
 
      </div>
    </div>
</template>

<script>
    export default {
      data(){
        return {
          listStock: [],
          categorias: [],
          pagina: 1,
          listaFiltrada: [],
          informacionListaFiltrada: [],
          cantidadProducts: 0,
          filtros: {},
          modalFiltro: false,
          abrir_resumen: false

        };
      },
      mounted() {

          this.getCantidadProducts();
          this.getCategorias();
      },
      methods:{
            async getCategorias(){
                let respuesta = await axios.get('/categoriastodas')
                this.categorias= respuesta.data;
            },
            async getCantidadProducts(){
                let respuesta = await axios.get('/cantidadProducts')
                this.cantidadProducts = respuesta.data[0].cantidad
            },
            addProduct(){
                this.getCategorias();
                this.getCantidadProducts();
                this.getCantidadCategorias();
                console.log('producto añadido');
            },
            deleteProduct(index){
               this.products.splice(index, 1);
            },
            updateProduct(product, index){
               this.products[index]=product;
            },
            abrirCategoria(){
              this.pagina = 2;
            },
            abrirProductos(){
              this.pagina = 1;
            },
            filtrarOtraVez(page = 1){
              axios.post('/filtrar?page=' + page,this.filtros).then(response=>{
                console.log(response.data);
                this.listaFiltrada = response.data;

              })
            },
            cargarFiltro(){
              this.modalFiltro = true;
            },
            async filtrar(opc){
              await axios.post('/filtrar',opc).then(response=>{
                console.log(response.data);
                this.listaFiltrada = response.data;
                this.filtros = opc;
                axios.post('informacionFiltro',opc).then(response=>{
                  console.log(response.data);
                  this.informacionListaFiltrada= response.data;
                  this.pagina =3 ;
                })
                
              })
              
             
            }
        },
        computed: {
          cantidadCategorias(){
            return this.categorias.length
          }
        }

    }
</script>
