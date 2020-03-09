<template>
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
	                <div class="form-row">
	                       <input type="text" class="form-control" v-model="serieProduct" v-on:keydown.enter="busquedaProduct">                               
	                </div>
	            </div>
	            <div class="card-body">
	                <table class="table mt-0">
	                  <thead>
	                    <tr class="table-primary">
						  <th scope="col"></th>		
	                      <th scope="col">N° Serie</th>
	                      <th scope="col">Precio</th>
	                      <th scope="col">Color</th>
	                      <th scope="col">Talle</th>
	                    </tr>
	                  </thead>
	                  <tbody v-if="activateBusqueda">
                      	<tr v-for="(product,index) in listaProductosBusqueda.data" :key="product.id">
	                        <td>
		                        <button type="button" class="btn btn-success btn-sm " data-dismiss="modal" v-on:click="selectProduct(product)">Ok</button>
		                    </td>
	                        <td>
	                        	{{product.n_serie}}
	                        </td>
	                        <td>
	                        	{{product.precio}}
	                        </td>
	                        <td>
	                        	{{product.color}}
	                        </td>
	                        <td>
	                        	{{product.talle}}
	                        </td>
	                    </tr>
	                    
	                    </tbody>
                      <tbody v-else>
                        <tr v-for="(product,index) in listaProductos.data" :key="product.id">
                          <td>
                            <button type="button" class="btn btn-success btn-sm " data-dismiss="modal" v-on:click="selectProduct(product)">Ok</button>
                        </td>
                          <td>
                            {{product.n_serie}}
                          </td>
                          <td>
                            {{product.precio}}
                          </td>
                          <td>
                            {{product.color}}
                          </td>
                          <td>
                            {{product.talle}}
                          </td>
                      </tr>
                      
                      </tbody>
	                </table>
	                <pagination v-if="activateBusqueda" :data="listaProductosBusqueda" :limit="3" @pagination-change-page="getResultsBusqueda" class="float-right">
                  </pagination>
                  <pagination v-else :data="listaProductos" :limit="3" @pagination-change-page="getResults" class="float-right">
                  </pagination>
	            </div>
	        </div>
	      </div>
	    </div>
	  </div>

</template>
<script>
    export default {
      data(){
        return {
        	product: '',
        	precio: '',
        	serieProduct: '',
          	page: 1,
          	selectedProduct: '',
			dbproducts: [],
          	productsResult: [],
          	paginate: ['productsResult'],
          	listaProductos: {},
            activateBusqueda: false,
            listaProductosBusqueda: {},
            serieBuscar: ''


        };
      },
      mounted() {
        this.getResults()
      },
      methods:{
      	getResults(page = 1) {
          axios.get('/products?page=' + page)
            .then(response => {
              this.listaProductos = response.data;
            });
        },
        getResultsBusqueda(page = 1) {
          axios.get('/buscarProducto/'+this.serieBuscar+'?page=' + page)
            .then(response => {
              this.listaProductosBusqueda = response.data;
            });
        },

      	getProducts(){
            axios.get('/stock').then((response)=>{
              this.dbproducts = response.data.data;
              this.dbproducts.forEach((element)=>{
              	element.products.forEach((product)=>{
              		this.productsResult.push(product)
              	})
              })

            });
        },
        selectProduct(product){
            this.selectedProduct = product;
            this.producto = this.selectedProduct.nombre;
            this.precio = this.selectedProduct.precio;
            this.$emit('selectProduct', this.selectedProduct);
            this.serieProduct= '';
         },
        paginateChange(toPage, fromPage){
          this.page = toPage;
        },
        busquedaProduct(){
          console.log(this.serieProduct);
          if(this.serieProduct == ''){
            this.getResults();
            this.activateBusqueda = false;
          }
          else {
            this.activateBusqueda = true
            this.productsResult = [];
            var inicio = this.serieProduct.indexOf('%');
            console.log(inicio);
            if(inicio == -1){
              this.serieBuscar = this.serieProduct;
            } else {
              this.serieBuscar = this.serieProduct.substring(0,inicio);
            }
            console.log(this.serieBuscar);
            this.getResultsBusqueda()

          }
          /*
          axios.get('buscarProducto/'+numSerie).then(response=>{
            console.log(response.data);
            response.data.forEach(element=>{
              this.listaProductos.data = [];
              this.listaProductos.data.push(element)
            })
          })
          //console.log(this.productsResult);
          */
        },
      }
    }
</script>
