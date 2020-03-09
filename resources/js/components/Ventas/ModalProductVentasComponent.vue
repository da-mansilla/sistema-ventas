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
	                  <tbody>
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
	                <pagination :data="listaProductos" :limit="3" @pagination-change-page="getResults" class="float-right">
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
          	listaProductos: {}


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
          console.log('Pagina numero ' + this.page);
        },
        busquedaProduct(){
          if(this.serieProduct == ''){
            console.log('vacio');
            this.getResults();
          }
        	console.log('busqueda');
          this.productsResult = [];
          var inicio = this.serieProduct.indexOf('%');
          var numSerie = this.serieProduct.substring(0,inicio);
          axios.get('buscarProducto/'+numSerie).then(response=>{
            console.log(response.data);
            response.data.forEach(element=>{
              this.listaProductos.data = [];
              this.listaProductos.data.push(element)
            })
          })
          //console.log(this.productsResult);
        },
      }
    }
</script>
