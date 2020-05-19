<template>
    <div class="card-content card w-100">
      <div class="card-header ">
        <h3>Productos</h3>
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

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar</button>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalPrecio">Precio</button>

        <div class="row tarjetas">
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
        </div>
          

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
          cantidadCategorias: 0,
          filtros: {},
          modalFiltro: false

        };
      },
      mounted() {

          this.getCantidadProducts();
          this.getCantidadCategorias();
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
            async getCantidadCategorias(){
              
                let cantidad = await axios.get('/cantidadcategorias')
                this.cantidadCategorias = cantidad.data.length
              
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
        }

    }
</script>
