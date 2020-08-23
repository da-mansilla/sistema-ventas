<template>
	<div class="container-fluid mt-2 px-0 position-relative">

		<div class="accordion" id="accordionExample">
		  <div class="card">
		    <div class="justify-content-center " id="headingOne">
		      <h2 class="mb-0 pt-1">
		        <button class="btn btn-info btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" @click="ver">
		          <h2 class="text-white text-center"><i class="fas fa-angle-double-down"></i></h2>
		        </button>
		      </h2>
		    </div>

		    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
			    <div class="card-body">
			    	<div class="row mt-1">
						<div class="col-3">
							<h4 class=" mb-2"><strong>Categorias</strong></h4>
							<select class="form-control" ref="select" @click="ver">
								<option v-for="categoria in categorias_ordenadas" >{{categoria}}</option>
							</select>
						</div>
						<div class="col-3">
							<h4 class="ml-3 mb-2"><strong>{{categoria_seleccionada}}: {{cantidad_productos}}</strong></h4>
							<div class=" text-center">
								<div class="list-group" id="lista_tipos" role="tablist">
							      <a @click="seleccionar_tipo('niño')"   class="list-group-item list-group-item-action" id="list-talles-niño" data-toggle="list" href="#talles_niño" role="tab"><h5>Niños : <strong>{{ cantidad_productos_niños }}</strong></h5></a>

							      <a @click="seleccionar_tipo('niña')"  class="list-group-item list-group-item-action" id="list-talles-niña" data-toggle="list" href="#talles_niña" role="tab"><h5>Niñas : <strong>{{ cantidad_productos_niñas }}</strong></h5></a>

							      <a @click="seleccionar_tipo('unisex')"  class="list-group-item list-group-item-action" id="list-talles-unisex" data-toggle="list" href="#talles_unisex" role="tab"><h5>Unisex : <strong>{{ cantidad_productos_unisex }}</strong></h5></a>
							    </div>
							</div>
						</div>
						<div class="col-3">
							<h4 class=" mb-2"><strong>Talles Disponibles</strong></h4>
							<div data-spy="scroll" data-offset="0" style="height: 163px; overflow-y:scroll;">
								<div class="overflow-auto">
									<div class="tab-content">
									    <div class="tab-pane fade" id="talles_niño" role="tabpanel" aria-labelledby="list-talles-niño">
									      	<ul v-for="talles in talles_productos_niños" class="list-group">
											  <li :id=" 'niño_'+talles" v-bind:class="{'active': talle_elegido == talles}"class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5 my-0" @click="click_on_talle" style="cursor: pointer;">
											   	{{talles}}
											    <span class="badge badge-primary badge-pill text-black h4">{{cantidad_talle('niño',talles)}}</span>
											  </li>
											</ul>
									  	</div>


									    <div class="tab-pane fade" id="talles_niña" role="tabpanel" aria-labelledby="list-talles-niña">
									     	<ul v-for="talles in talles_productos_niñas" class="list-group">
											  <li :id=" 'niña_'+talles" v-bind:class="{'active': talle_elegido == talles}"class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5 my-0" @click="click_on_talle" style="cursor: pointer;">
											    {{talles}}
											    <span class="badge badge-primary badge-pill text-black h4">{{cantidad_talle('niña',talles)}}</span>
											  </li>

											</ul>
									  	</div>

									  	 <div class="tab-pane fade" id="talles_unisex" role="tabpanel" aria-labelledby="list-talles-unisex">
									     	<ul v-for="talles in talles_productos_unisex" class="list-group">
											  <li :id=" 'unisex_'+talles" v-bind:class="{'active': talle_elegido == talles}"class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5 my-0" @click="click_on_talle" style="cursor: pointer;">
											    {{talles}}
											    <span class="badge badge-primary badge-pill text-black h4">{{cantidad_talle('unisex',talles)}}</span>
											  </li>

											</ul>
									  	</div>

								    </div>
									
								</div>
							</div>
						</div>
						<div class="col 3">
							<h4 class=" mb-2"><strong>Colores Disponibles</strong></h4>
							<div data-spy="scroll"  data-offset="0" style="height: 163px; overflow-y:scroll;">
							 	 <div class="overflow-auto">
									<ul v-for="color in colores_list" class="list-group" id="lista_colores">
									  <li :id="color" @click="click_on_color" v-bind:class="{'active': color_elegido == color}" class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5 my-0">
									    {{color_format(color)}}
									    <span class="badge badge-primary badge-pill h4">{{cantidad_colores(color)}}</span>
									  </li>
									</ul>
									
								</div>
							</div>
						</div>
					</div>  
			    </div>
		    </div>
		  </div>
		</div>




		
	</div>
</template>
<script>
	export default{
		props:{
			opc:{},
			listaVentasInformacion:{},
			lista_productos_vendidos:{}
			
		},
		data(){
			return{
				categorias: [],

				categoria_seleccionada: '',
				categoria_niños: false,
				categoria_niñas: false,
				categoria_unisex: false,
				
				tipo_seleccionado: 'Niño',

				cantidad_productos_niñas: 0,
				cantidad_productos_niños: 0,
				cantidad_productos_unisex: 0,

				productos_niñas: [],
				productos_niños: [],
				productos_unisex: [],

				talle_elegido: '',

				color_elegido: '',

				colores_list: [],


			}
		},
		mounted(){
			this.getCategorias()
			this.categoria_seleccionada = this.$refs.select.value
		},
		methods:{
	        async getCategorias(){
	            let respuesta = await axios.get('/categoriasProductsVendidos')
	            this.categorias= respuesta.data;
	            console.log(this.categorias);
	        },
			ver(){
				this.categoria_seleccionada = this.$refs.select.value

			},
			seleccionar_tipo(tipo){
				this.color_elegido= ''
				this.colores_list = []
				this.talle_elegido = ''
				if(tipo == 'niño'){
					this.tipo_seleccionado = 'Niño'
				}
				if(tipo == 'niña'){
					this.tipo_seleccionado = 'Niña'
				}
				if(tipo == 'unisex'){
					this.tipo_seleccionado = 'Unisex'
				}
				this.filtrar()
			},
			cantidad_talle(tipo,talle){
				if(tipo == 'niño'){
					let cantidad = 0
					this.productos_niños.forEach(product=>{
						if(product.talle == talle){
							cantidad++
						}
					})
					return cantidad
				}
				if(tipo == 'niña'){
					let cantidad = 0
					this.productos_niñas.forEach(product=>{
						if(product.talle == talle){
							cantidad++
						}
					})
					return cantidad
				}
				if(tipo == 'unisex'){
					let cantidad = 0
					this.productos_unisex.forEach(product=>{
						if(product.talle == talle){
							cantidad++
						}
					})
					return cantidad
				}

			},
			click_on_talle(ev){
				this.color_elegido = ''
				let target = ev.target.id;
				let index = target.indexOf('_')
				let tipo = target.slice(0,index)
				let talle = target.slice(index+1)
				this.talle_elegido = talle
				this.colores_list = []
				if(tipo == 'niño'){
					this.productos_niños.forEach(product=>{
						if(this.colores_list.indexOf(product.color) == -1 && product.talle == talle){
							this.colores_list.push(product.color)
						}
					})
				}
				if(tipo == 'niña'){
					this.productos_niñas.forEach(product=>{
						if(this.colores_list.indexOf(product.color) == -1 && product.talle == talle){
							this.colores_list.push(product.color)
						}
					})

				}
				if(tipo == 'unisex'){
					this.productos_unisex.forEach(product=>{
						if(this.colores_list.indexOf(product.color) == -1 && product.talle == talle){
							this.colores_list.push(product.color)
						}
					})

				}
				this.filtrar()
			},
			click_on_color(ev){
				this.color_elegido = ev.target.id;
				this.filtrar()
			},
			cantidad_colores(color){
				let count = 0
				if(this.tipo_seleccionado == 'Niño'){
					this.productos_niños.forEach(product=>{
						if(product.talle == this.talle_elegido){
							if(product.color == color){
								count++
							}
						}
					})
					return count
				}
				if(this.tipo_seleccionado == 'Niña'){
					this.productos_niñas.forEach(product=>{
						if(product.talle == this.talle_elegido){
							if(product.color == color){
								count++
							}
						}
					})
					return count
				}
				if(this.tipo_seleccionado == 'Unisex'){
					this.productos_unisex.forEach(product=>{
						if(product.talle == this.talle_elegido){
							if(product.color == color){
								count++
							}
						}
					})
					return count
				}
			},
			color_format(color){
				if(color !== '' && color !== null){
					let chart = color.charAt(0).toUpperCase()
					let string = color.replace(color.charAt(0),chart)
	                return string;
				}

			},


			filtrar(){
				// Categoria
            	var filtrarCategorias = true;
            	var listCategorias = []
				this.categorias.forEach(categoria=>{
					if(categoria.nombre.toLowerCase() == this.categoria_seleccionada.toLowerCase()){
						listCategorias.push(categoria)
					}
				})          

				// Tipo
				let enabled_niño = false
				let enabled_niña = false
				let enabled_unisex = false
				if(this.tipo_seleccionado == 'Niño'){
					enabled_niño = true
				}
				if(this.tipo_seleccionado == 'Niña'){
					enabled_niña = true
				}
				if(this.tipo_seleccionado == 'Unisex'){
					enabled_unisex = true
				}  

				// Talle
				let enabled_talle = false
				let talle = ''
				if(this.talle_elegido !== ''){
					enabled_talle = true
					talle = this.talle_elegido
				}

				// Color
				let enabled_color = false
				let color = ''
				if(this.color_elegido !== ''){
					enabled_color = true
					color = this.color_elegido
				}

            	let opciones={
            		 tipo : {
            		 	Niño: enabled_niño,
            		 	Niña: enabled_niña,
            		 	Unisex: enabled_unisex
            		 },
            		 categoria: {
            		 	enabled: filtrarCategorias,
            		 	categorias: listCategorias
            		 },
            		 precio: {
            		 	enabled: false,
            		 	desde: 0,
            		 	hasta: 0
            		 },
            		 temporada: {
            		 	enabled: false,
            		 	temporada: ''
            		 },
            		 producto: {
            		 	enabled: false,
            		 	productos: ''
            		 },
            		 fecha: {
            		 	enabled: false,
            		 	fecha: '',
            		 	intervaloFechas: false,
            		 	fechaDesde: '',
            		 	fechaHasta: ''
            		 },
            		 talle:{
            		 	enabled: enabled_talle,
            		 	talle: talle
            		 },
            		 color:{
            		 	enabled: enabled_color,
            		 	color: color
            		 }

            	};
            	this.$emit('filtrar',opciones);

            	console.log(opciones);
            }


		},
		watch:{
			 categoria_seleccionada:  function(){
			 	this.colores_list = []
			 	this.talle_elegido = ''
			 	this.color_elegido = ''

				let categorias_seleccionadas = []
				this.categorias.forEach(categoria=>{
					if(categoria.nombre == this.categoria_seleccionada.toLowerCase()){
						categorias_seleccionadas.push(categoria)
					}
				})
				let niños = false
				let niñas = false
				let unisex = false
				this.categoria_niños= false;
				this.categoria_niñas= false;
				this.categoria_unisex= false;
				categorias_seleccionadas.forEach(categoria=>{
					if(categoria.tipo == 'Niño'){
						this.categoria_niños = categoria
						niños = false

					}

					if(categoria.tipo == 'Niña'){
						this.categoria_niñas = categoria
						niñas = false

					}

					if(categoria.tipo == 'Unisex'){
						this.categoria_unisex = categoria
						unisex = false

					}
				})

				let categoriasID = []
				categorias_seleccionadas.forEach(categoria=>{
					categoriasID.push(categoria.id)
				})

				this.cantidad_productos_niñas  = 0
				this.cantidad_productos_niños  = 0
				this.cantidad_productos_unisex = 0

				this.productos_niñas  = []
				this.productos_niños  = []
				this.productos_unisex = []

				this.lista_productos_vendidos.forEach(product=>{
					if(product.nombre == this.categoria_seleccionada.toLowerCase())
					{
						
						if(product.tipo == 'Niño'){
							this.cantidad_productos_niños++
							this.productos_niños.push(product)
						}
						if(product.tipo == 'Niña'){
							this.cantidad_productos_niñas++
							this.productos_niñas.push(product)
						}
						if(product.tipo == 'Unisex'){
							this.cantidad_productos_unisex++
							this.productos_unisex.push(product)
						}
					}

				})

				
			}
		},
		computed:{
			categorias_ordenadas(){
				var categorias_ordenadas = []

				let por_semana = false
				let por_mes = false
				let por_year = false
				let lista_categorias = []

				console.log('Lista de Productos Vendidos')
				console.log(this.lista_productos_vendidos)

				this.lista_productos_vendidos.forEach(product=>{
					if(lista_categorias.indexOf(product.nombre) == -1){
						lista_categorias.push(product.nombre)
					}
				})
				/*
				this.listaVentasInformacion.forEach(element=>{
					if(element !== 0){
						element.forEach(venta=>{
							venta.productos.forEach(product=>{
								if(lista_categorias.indexOf(product.nombre) == -1){
									lista_categorias.push(product.nombre)
								}
							})
						})
					}
				})
				*/
				console.log('Lista de Categorias')
				console.log(lista_categorias);
				/*
				let categorias_listadas = []
				if(this.opc.fecha.semana.enabled){	por_semana = true	}
				if(this.opc.fecha.mes.enabled)	 {	por_mes = true 		}
				if(this.opc.fecha.year.enabled)	 {	por_year = true 	}

				this.categorias.forEach(categoria=>{
					if(por_semana){

					}
				})
				*/
				lista_categorias.forEach(cat=>{
					let chart = cat.charAt(0).toUpperCase()
					let string = cat.replace(cat.charAt(0),chart)
					if(categorias_ordenadas.indexOf(string) == -1){
						categorias_ordenadas.push(string)
					}
				})
				function compare(a, b) {
                  if (a.toLowerCase() < b.toLowerCase() )
                    return -1;
                  if (a > b)
                    return 1;
                  return 0;
                }
                
                return categorias_ordenadas.sort(compare);
			},
			cantidad_productos(){
				return this.cantidad_productos_niñas + this.cantidad_productos_niños+ this.cantidad_productos_unisex
			},
			talles_productos_niños(){
				let talles_productos_niños = []
				this.productos_niños.forEach(product=>{
					if(talles_productos_niños.indexOf(product.talle) == -1){
						talles_productos_niños.push(product.talle)
					}
				})
				return talles_productos_niños
			},
			talles_productos_niñas(){
				let talles_productos_niñas = []
				this.productos_niñas.forEach(product=>{
					if(talles_productos_niñas.indexOf(product.talle) == -1){
						talles_productos_niñas.push(product.talle)
					}
				})
				return talles_productos_niñas
			},
			
			talles_productos_unisex(){
				let talles_productos_unisex = []
				this.productos_unisex.forEach(product=>{
					if(talles_productos_unisex.indexOf(product.talle) == -1){
						talles_productos_unisex.push(product.talle)
					}
				})
				return talles_productos_unisex
			}

			
		}
	}

</script>