<template>
	<div class="container-fluid mt-5 position-relative">
		<div class="m-2">
			<div class="row justify-content-center bg-primary">
				<h2 class=" pt-1 text-white ">Resumen</h2>
			</div>
			<div class="row mt-3">
				<div class="col-3">
					<select class="form-control" ref="select" @click="ver">
						<option v-for="categoria in categorias_ordenadas" >{{categoria}}</option>
					</select>
				</div>
				<div class="col-3">
					<h4 class="ml-3 mb-2"><strong>{{categoria_seleccionada}}: {{cantidad_productos}}</strong></h4>
					<div class=" text-center">
						<div class="list-group" id="lista_tipos" role="tablist">
					      <a  @click="abrir_lista_colores" class="list-group-item list-group-item-action" id="list-talles-niño" data-toggle="list" href="#talles_niño" role="tab"><h5>Niños : <strong>{{ cantidad_productos_niños }}</strong></h5></a>

					      <a @click="abrir_lista_colores" class="list-group-item list-group-item-action" id="list-talles-niña" data-toggle="list" href="#talles_niña" role="tab"><h5>Niñas : <strong>{{ cantidad_productos_niñas }}</strong></h5></a>

					      <a @click="abrir_lista_colores" class="list-group-item list-group-item-action" id="list-talles-unisex" data-toggle="list" href="#talles_unisex" role="tab"><h5>Unisex : <strong>{{ cantidad_productos_unisex }}</strong></h5></a>
					    </div>
					</div>
				</div>
				<div class="col-3">
					<h4 class=" mb-2"><strong>Talles Disponibles</strong></h4>
					<div data-spy="scroll" data-offset="0" style="height: 200px; overflow-y:scroll;">
						<div class="overflow-auto">
							<div class="tab-content">
							    <div class="tab-pane fade" id="talles_niño" role="tabpanel" aria-labelledby="list-talles-niño">
							      	<ul v-for="talles in talles_productos_niños" class="list-group">
									  <li :id="talles"class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5" @click="click_on_talle" style="cursor: pointer;">
									   	{{talles}}
									    <span class="badge badge-primary badge-pill text-black h4">{{cantidad_talle('niño',talles)}}</span>
									  </li>
									</ul>
							  	</div>


							    <div class="tab-pane fade" id="talles_niña" role="tabpanel" aria-labelledby="list-talles-niña">
							     	<ul v-for="talles in talles_productos_niñas" class="list-group">
									  <li :id="talles" class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5" @click="click_on_talle" style="cursor: pointer;">
									    {{talles}}
									    <span class="badge badge-primary badge-pill text-black h4">{{cantidad_talle('niña',talles)}}</span>
									  </li>

									</ul>
							  	</div>

							  	 <div class="tab-pane fade" id="talles_unisex" role="tabpanel" aria-labelledby="list-talles-unisex">
							     	<ul v-for="talles in talles_productos_unisex" class="list-group">
									  <li :id="talles" class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5" @click="click_on_talle" style="cursor: pointer;">
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
					<div data-spy="scroll"  data-offset="0" style="height: 200px; overflow-y:scroll;">
					 	 <div class="overflow-auto">
							<div class="tab-content">
							    <div class="tab-pane fade" id="" role="tabpanel" aria-labelledby="">
							      	<ul  class="list-group">
									  <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5">
									   	
									    <span class="badge badge-primary badge-pill text-black h4"></span>
									  </li>
									</ul>
							  	</div>


							    <div class="tab-pane fade" id="" role="tabpanel" aria-labelledby="">
							     	<ul  class="list-group">
									  <li  class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5">
									    
									    <span class="badge badge-primary badge-pill text-black h4"></span>
									  </li>

									</ul>
							  	</div>

							  	 <div class="tab-pane fade" id="" role="tabpanel" aria-labelledby="">
							     	<ul  class="list-group">
									  <li  class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action h5">
									    
									    <span class="badge badge-primary badge-pill text-black h4"></span>
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
</template>
<script>
	export default{
		props:{
			categorias:{}
		},
		data(){
			return{
				categoria_seleccionada: '',
				categoria_niños: false,
				categoria_niñas: false,
				categoria_unisex: false,

				cantidad_productos_niñas: 0,
				cantidad_productos_niños: 0,
				cantidad_productos_unisex: 0,

				productos_niñas: [],
				productos_niños: [],
				productos_unisex: []

			}
		},
		mounted(){
			this.categoria_seleccionada = this.$refs.select.value
		},
		methods:{
			ver(){
				this.categoria_seleccionada = this.$refs.select.value
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
				console.log(ev);
			},
			abrir_lista_colores(){
				$('#lista_tipos').on('click', function (e) {
				  e.preventDefault()
				  $(this).tab('show')
				})
			}

		},
		watch:{
			 categoria_seleccionada:  async function(){
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
				console.log(categorias_seleccionadas)
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
				await axios.post('/productsPorCategoria',categoriasID)
					.then(response=>{
						console.log(response.data);
						this.cantidad_productos_niñas  = 0
						this.cantidad_productos_niños  = 0
						this.cantidad_productos_unisex = 0

						this.productos_niñas  = []
						this.productos_niños  = []
						this.productos_unisex = []
						response.data.forEach(product=>{
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
						})
					})
				
			}
		},
		computed:{
			categorias_ordenadas(){
				var categorias_ordenadas = []
				this.categorias.forEach(cat=>{
					let chart = cat.nombre.charAt(0).toUpperCase()
					let string = cat.nombre.replace(cat.nombre.charAt(0),chart)
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
				console.log(talles_productos_niños)
				return talles_productos_niños
			},
			talles_productos_niñas(){
				let talles_productos_niñas = []
				this.productos_niñas.forEach(product=>{
					if(talles_productos_niñas.indexOf(product.talle) == -1){
						talles_productos_niñas.push(product.talle)
					}
				})
				console.log(talles_productos_niñas)
				return talles_productos_niñas
			},
			talles_productos_unisex(){
				let talles_productos_unisex = []
				this.productos_unisex.forEach(product=>{
					if(talles_productos_unisex.indexOf(product.talle) == -1){
						talles_productos_unisex.push(product.talle)
					}
				})
				console.log(talles_productos_unisex)
				return talles_productos_unisex
			}
			
		}
	}

</script>