<template>
	<div>
	
	<!-- Modal -->
	<div class="modal fade" id="ModalFiltro" tabindex="-1" role="dialog" aria-labelledby="ModalFiltroTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="ModalFiltroTitle">Filtro</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-md-3 pl-4">
		        	<div class="row">
		        		<div class="form-group">
		        			<div >
		        				<h5 class="text-center">Tipo</h5>
		        			</div>
		        			<div >
				        		<div class="form-check">
								  <input class="form-check-input" type="checkbox" name="Niños" id="exampleRadios1" v-on:click="elegirTipo" checked>
								  <label class="form-check-label" for="exampleRadios1">
								    Niños
								  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="checkbox" name="Niñas" id="exampleRadios2" v-on:click="elegirTipo" checked>
								  <label class="form-check-label" for="exampleRadios2">
								    Niñas
								  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="checkbox" name="Unisex" id="exampleRadios3" v-on:click="elegirTipo" checked>
								  <label class="form-check-label" for="exampleRadios3">
								    Unisex
								  </label>
								</div>
		        			</div>
		        			<hr>
		        		</div>
		        		<hr>
		        	</div>

			        <div class="row">
			        	<div class="form-group">
			        		<div>
		        				<h5 class="">Temporada</h5>
		        			</div>
		        			<div class="input-group pr-3">
				        		<select class="form-control" v-model="temporadaElegida">
				        			<option value=""></option>
								  <option v-for="item in listado" >{{item}}</option>

								</select>
				        	</div>
			        		<hr>
			        	</div>
		        	</div>
		        </div>
		        <div class="col-md-9">
		        	<div class="row">
		        		<div class="accordion w-100" id="accordionExample">
						  <div class="card">
						    <div class="card-header" id="headingOne">
						      <h2 class="mb-0">
						        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          Por Categoria
						        </button>
						      </h2>
						    </div>

						    <div id="collapseOne" class="collapse show w-100" aria-labelledby="headingOne" data-parent="#accordionExample">
						      <div class="card-body">
					        	<div class="input-group w-100" >
								  <select class="form-control" v-model="categoriaSeleccionada">
								  	<option v-for="categoria in sortedArray">{{categoria.nombre.replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())))}} ({{categoria.tipo}})</option>
								  </select>
								  <div class="input-group-append">
								    <button class="btn btn-outline-secondary" type="button" v-on:click="agregarCategoria"><i class="fas fa-plus"></i></button>
								  </div>
								  <div class="input-group-append">
								    <button type="button" class="btn btn-outline-secondary" data-toggle="popover" title="Categorias Agregadas" :data-content="mostrarListaCategoria()"><i class="fas fa-info-circle"></i></button>
								  </div>
								  
								</div>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingTwo">
						      <h2 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						          Por Precio
						        </button>
						      </h2>
						    </div>
						    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
						      <div class="card-body pl-1 pr-1">
						        <div class="input-group w-100" >

								  	<div class="input-group">
									  <div class="input-group-prepend">
									    <span class="input-group-text">Desde</span>
									  </div>
									  <input type="number" aria-label="First name" class="form-control" v-model="precioDesde">
									  <div class="input-group-prepend">
									    <span class="input-group-text">$</span>
									  </div>
  									  <div class="input-group-prepend pl-1">
									    <span class="input-group-text">Hasta</span>
									  </div>
									  <input type="number" aria-label="Last name" class="form-control" v-model="precioHasta">
									  <div class="input-group-prepend">
									    <span class="input-group-text">$</span>
									  </div>
									</div>

								</div>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingThree">
						      <h2 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						          Por Fecha Ingreso
						        </button>
						      </h2>
						    </div>
						    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
						      <div class="card-body pl-0 pr-0">
						        <div class="input-group w-100" >
						        	<div class="input-group mb-3">
						        		<select class="form-control" v-model="fechaElegida" v-on:click="mostrarFecha">
										  <option value="hoy">Hoy</option>
										  <option value="ayer">Ayer</option>
										  <option value="semana">Esta Semana</option>
										  <option value="mes">Este Mes</option>
										  <option value="year">Este Año</option>
										  <option value="otro">Ingresar Fecha</option>
										</select>
						        	</div>
								  	<div v-if="mostrarfechas" class="input-group">
									  <input type="date" aria-label="First name" class="form-control" v-model="fechaDesde">

  									  <div class="input-group-prepend">
									    <span class="input-group-text">-</span>
									  </div>
									  <input type="date" aria-label="Last name" class="form-control" v-model="fechaHasta">

									</div>

								</div>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingFour">
						      <h2 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						          Por Producto
						        </button>
						      </h2>
						    </div>

						    <div id="collapseFour" class="collapse w-100" aria-labelledby="headingFour" data-parent="#accordionExample">
						      <div class="card-body">
					        	<div class="input-group w-100" >
								  <input type="text" class="form-control" placeholder="N° Serie" aria-label="Recipient's username" v-model="productSeleccionado">
								  <div class="input-group-append">
								    <button class="btn btn-outline-secondary" type="button" v-on:click="agregarProducto"><i class="fas fa-plus"></i></button>
								  </div>
								  <div class="input-group-append">
								    <button type="button" class="btn btn-outline-secondary" data-toggle="popover" title="Productos Agregados" :data-content="mostrarListaProducts()"><i class="fas fa-info-circle"></i></button>
								  </div>
								</div>
						      </div>
						    </div>
						  </div>
						</div>
		        	</div>
		        </div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" v-on:click="filtrar">Filtrar</button>
	      </div>
	    </div>
	  </div>
	</div>

	</div>

</template>
<script >
export default {

    	data(){
    		return {
    			tipoNiño: true,
    			tipoNiña: true,
    			tipoUnisex: true,
    			categoriaSeleccionada: '',
    			productSeleccionado: '',
    			sugerenciasList: [],
    			categoriasList: [],
    			productsList: [],
    			temporadasList : [],
    			precioDesde: 0,
    			precioHasta: 0,
    			temporadaElegida: '',
    			fechaElegida:'',
    			listado: [],
    			mostrarfechas: false,
    			fechaDesde: '',
    			fechaHasta: ''
    			
    		}
    	},
        mounted() {
        	this.getCategorias();
        	this.getTemporadas();
            console.log('Component mounted.');
            $(function () {
			  $('[data-toggle="popover"]').popover()
			});
        },
        methods: {
            getCategorias(){
              axios.get('/categoriastodas').then((response)=>{
                this.categorias= response.data;
                this.categorias.forEach((element)=>{
            		if(this.tipoNiño && element.tipo == 'Niño')
            		{
	            		this.sugerenciasList.push(element);
            		}
            		if(this.tipoNiña && element.tipo == 'Niña')
            		{
	            		this.sugerenciasList.push(element);
            		}
            		if(this.tipoUnisex && element.tipo == 'Unisex')
            		{
	            		this.sugerenciasList.push(element);
            		}
            	})
              })
            },
        	getTemporadas(){
        		axios.get('/temporadas').then(response=>{
        			response.data.forEach(element=>{
        				this.listado.push(element.nombre)
        			})

        		})
        	},
        	elegirTipo(e){
        		if(e.target.name == 'Niños'){
        			if(e.target.checked){
        				this.tipoNiño = true;
	        		} else {
	        			this.tipoNiño = false;
	        		}
        		}
        		if(e.target.name == 'Niñas'){
        			if(e.target.checked){
        				this.tipoNiña = true;
	        		} else {
	        			this.tipoNiña = false;
	        		}
        		}
        		if(e.target.name == 'Unisex'){
        			if(e.target.checked){
        				this.tipoUnisex = true;
	        		} else {
	        			this.tipoUnisex = false;
	        		}
        		}
        		this.busqueda();


            },
            busqueda(){
            	this.sugerenciasList = [];
            	this.categorias.forEach((element)=>{
            		if(this.tipoNiño && element.tipo == 'Niño')
            		{
	            		this.sugerenciasList.push(element);
            		}
            		if(this.tipoNiña && element.tipo == 'Niña')
            		{
	            		this.sugerenciasList.push(element);
            		}
            		if(this.tipoUnisex && element.tipo == 'Unisex')
            		{
	            		this.sugerenciasList.push(element);
            		}
            	})
            },
            agregarCategoria(){
            	//console.log(this.categoriaSeleccionada);
                this.categorias.forEach((elemento)=>{
                    var inicio = this.categoriaSeleccionada.indexOf('(');
                    var final = this.categoriaSeleccionada.indexOf(')');
                    var categoriaComparar = this.categoriaSeleccionada.substring(0,inicio-1);
                    var tipoComparar = this.categoriaSeleccionada.substring(inicio+1,final);

                    if(elemento.tipo.toLowerCase() == tipoComparar.toLowerCase()){
                        if(elemento.nombre.toLowerCase() == categoriaComparar.toLowerCase()){
                        	this.categoriasList.push(elemento);
                        }
                	}

                })
                this.categoriaSeleccionada = '';
                console.log(this.categoriasList);
            },
            agregarProducto(){
            	var inicio = this.productSeleccionado.indexOf('%');
                var numSerie = this.productSeleccionado.substring(0,inicio);

            	this.productsList.push(numSerie);


            	this.productSeleccionado = '';
            	console.log(this.productsList);
            },
            mostrarListaCategoria(){
            	var html = '';
            	this.categoriasList.forEach((element)=>{
            		html += element.nombre+'('+element.tipo+'),'
            	})
            	return html;
            },
            mostrarListaProducts(){
            	var html = '';
            	this.productsList.forEach((element)=>{
            		html += element+','
            	})
            	return html;
            },
            mostrarFecha(){
            	if(this.fechaElegida == 'otro'){
            		this.mostrarfechas = true;
            	} else {
            		this.mostrarfechas = false;
            	}
            	console.log('Mostrar fechas');
            },
            filtrar(){
            	var filtrarCategorias = false;
            	if(this.categoriasList.length > 0){
            		filtrarCategorias = true;
            	}
            	var filtrarPrecio = false;
            	if(this.precioDesde != 0 || this.precioHasta != 0){
            		filtrarPrecio = true;
            		console.log('filtro precio activado')
            	}
            	var filtrarTemporada = false;
            	if(this.temporadaElegida != ''){
            		filtrarTemporada = true;
            		console.log('filtro temporada activado');
            	}
            	var filtrarProducto = false;
            	if(this.productsList.length > 0){
            		filtrarProducto = true;
            		console.log('filtro Producto activado');
            	}
            	var filtrarFecha = false;
            	var intervaloFechas = false;
            	if(this.fechaElegida != ''){
            		filtrarFecha = true;
            		if(this.fechaDesde != '' && this.fechaHasta != ''){
            			intervaloFechas = true;
            			filtrarFecha = false;

            		}
            		console.log('filtro Fecha activado');
            	}
            	let opciones={
            		 tipo : {
            		 	Niño: this.tipoNiño,
            		 	Niña: this.tipoNiña,
            		 	Unisex: this.tipoUnisex
            		 },
            		 categoria: {
            		 	enabled: filtrarCategorias,
            		 	categorias: this.categoriasList
            		 },
            		 precio: {
            		 	enabled: filtrarPrecio,
            		 	desde: parseInt(this.precioDesde),
            		 	hasta: parseInt(this.precioHasta)
            		 },
            		 temporada: {
            		 	enabled: filtrarTemporada,
            		 	temporada: this.temporadaElegida
            		 },
            		 producto: {
            		 	enabled: filtrarProducto,
            		 	productos: this.productsList
            		 },
            		 fecha: {
            		 	enabled: filtrarFecha,
            		 	fecha: this.fechaElegida,
            		 	intervaloFechas: intervaloFechas,
            		 	fechaDesde: this.fechaDesde,
            		 	fechaHasta: this.fechaHasta
            		 }
            	};
            	this.$emit('filtrar',opciones);
                $("#ModalFiltro").modal('hide')
            	this.categoriasList = [];
            	this.fechaElegida = '';
            	this.productsList = [];
            	console.log(opciones);
            }

        	

        },
        computed: {
            sortedArray: function() {
                function compare(a, b) {
                  if (a.nombre.toLowerCase() < b.nombre.toLowerCase() )
                    return -1;
                  if (a.nombre > b.nombre)
                    return 1;
                  return 0;
                }

                return this.sugerenciasList.sort(compare);

            }
        }
    }
</script>