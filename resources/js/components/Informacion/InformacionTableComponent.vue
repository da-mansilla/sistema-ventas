<template>
	<div class="card mt-3">
      	<div class="card-header text-center bg-primary">
        	<h3 class="text-white"><strong>Detalles</strong></h3>
      	</div>
      	<div class="row">
      		<div class="col-2 ">
      			<div class="list-group mt-1">
      				<div data-spy="scroll" data-offset="0" style="height: 500px; overflow-y:scroll;">
						<div class="overflow-auto">
							<a class="list-group-item list-group-item-action list-group-item-primary"><h4 class="text-center">Ventas: 25</h4></a>

							<button v-for="(venta,index) in listVentasDetalle" @click="activate_detalle_venta(venta)":key="venta.id" type="button" class="list-group-item list-group-item-action">
							  <h4 >Venta: #{{index}}</h4>
							</button> 
						</div>
					</div>
				</div>

      		</div>
      		<div class="container">
      			<div class="row justify-content-center mt-5">
      				<div class="col-4">
      					<div class="card text-white mb-3" style="max-width: 18rem;">
						  <div class="card-header bg-primary"><h4 class="text-center">Hora</h4></div>
						  <div class="card-body">
						    <h2 class="text-center text-dark">{{$moment(venta_detalle.created_at).format("HH:mm:ss")}}</h2>
						  </div>
						</div>
      				</div>
      				<div class="col-4">
      					<div class="card text-white mb-3" style="max-width: 18rem;">
						  <div class="card-header bg-primary"><h4 class="text-center">Ingresos</h4></div>
						  <div class="card-body">
						    <h2 class="text-center text-dark">${{venta_detalle.total}}</h2>
						  </div>
						</div>
      				</div>
      				<div class="col-4">
      					<div class="card text-white mb-3" style="max-width: 18rem;">
						  <div class="card-header bg-primary"><h4 class="text-center">Productos</h4></div>
						  <div class="card-body">
						    <h2 class="text-center text-dark">{{venta_cantidad_productos(venta_detalle.productos)}}</h2>
						  </div>
						</div>
      				</div>
      			</div>


      			<div class="row justify-content-between">
				    <div class="col-4">
				      	<div class="card text-white mb-3" style="max-width: 18rem;">
							<div class="card-header bg-primary"><h4 class="text-center">Forma de Pago</h4></div>
							<div class="card-body">
							    <h2 class="text-center text-dark">{{venta_detalle.forma_pago}}</h2>
							</div>
						</div>
				    </div>
				    <div class="col-4">
				      	<div class="card text-white mb-3" style="max-width: 18rem;">
							<div class="card-header bg-primary"><h4 class="text-center">Cliente</h4></div>
							<div class="card-body">
							    <h2 class="text-center text-dark">{{venta_nombre_cliente(venta_detalle.cliente)}}</h2>
							</div>
						</div>
				    </div>
				    <div class="col-4">
				      	<div class="card text-white mb-3" style="max-width: 18rem;">
							<div class="card-header bg-primary"><h4 class="text-center">Promocion</h4></div>
							<div class="card-body">
							    <h2 class="text-center text-dark">{{venta_tiene_promocion(venta_detalle.promocion)}}</h2>
							</div>
						</div>
				    </div>
				</div>
      			<ul class="list-group list-group-horizontal">
				  
				  
				  
				</ul>
      			<h3 class="display-5">Productos</h3>
      			<table class="table table-bordered table-products mt-0">
                  	<thead>
	                    <tr class=" bg-primary">
	                      <th  class="text-center text-white" scope="col"><h5>N° Serie</h5></th>
	                      <th  class="text-center text-white" scope="col"><h5>Categoria</h5></th>
	                      <th  class="text-center text-white" scope="col"><h5>Precio</h5></th>
	                      <th  class="text-center text-white" scope="col"><h5>Talle</h5></th>
	                      <th  class="text-center text-white" scope="col"><h5>Color</h5></th>
	                      

	                    </tr>
                  	</thead>
                  
	                <tbody >
	                    <tr >
	                      <th>
	                        <span>IBE456848  </span>
	                      </th>
	                      <th>
	                        <span>Campera  </span>
	                      </th>
	                      <th>
	                        <span>1500$  </span>
	                      </th>
	                      <th>
	                        <span>XL </span>
	                      </th>
	                      <th>
	                        <span>Rojo </span>
	                      </th>
	    
	                    </tr>
	                </tbody>

                </table>
      		</div>
      	</div>
	</div>
</template>
<script>
	export default{
		props:{
			listVentasDetalle:{}
		},
		data(){
			return{
				venta_detalle_activate: false,
				venta_detalle: {}


			}
		},
			methods:{
				obtenerPromocionVenta(estado){
	            let indexInicio = estado.indexOf('(');
	            let indexFinal = estado.indexOf(')');
	            let promocion = estado.slice(indexInicio+1,indexFinal)
	            console.log(promocion);
	            return promocion
	         },
	        activate_detalle_venta(venta){
	          	console.log(venta);
	          	this.venta_detalle = venta
	          	this.venta_detalle_activate = true
	        },
	        venta_nombre_cliente(cliente){
				if(cliente !== null){
					return cliente
				}else{
					return '----'
				}
			},
			venta_tiene_promocion(promocion){
				if(promocion !== null){
					return promocion
				}else{
					return 'No'
				}
			},
			venta_cantidad_productos(productos){
				if(typeof(productos) !== "undefined"){
					let count = 0
					productos.forEach(product=>{
						count++

					})
					return count
				} else {
					return '----'
				}
			}

		},
		computed:{

		}


		/*


		<div class="card-header text-center">
            <h5><strong>Ventas</strong></h5>
          </div>
          <div class="card-body">
			<div class="">
		        <div class="accordion" id="accordionExample">
		          <div v-for="(venta,index) in listVentasDetalle" :key="venta.id" class="card">
		            <div class="card-header" id="headingOne">
		              <h2 class="mb-0">
		                <button class="btn btn-link btn-block text-left" style="text-decoration: none" type="button" data-toggle="collapse" :data-target="`#collapseOne${index}`" aria-expanded="true" aria-controls="collapseOne">
		                  <h3 >{{$moment(venta.created_at).format("DD MMMM YYYY HH:mm:ss")}}</h3>
		                </button>
		              </h2>
		            </div>

		            <div :id="`collapseOne${index}`" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
		              <div class="card-body">
		                <table class="table table-bordered table-products mt-0">
		                  <thead>
		                    <tr class=" table-primary ">
		                      <th scope="col">Cliente</th>
		                      <th scope="col">Promocion</th>
		                      <th scope="col">Cuenta Corriente</th>
		                      <th scope="col">Pago Efectivo</th>
		                      <th scope="col">Pago en Tarjeta</th>
		                      <th scope="col">Total</th>
		                      

		                    </tr>
		                  </thead>
		                  
		                  <tbody >
		                    <tr >
		                      <th>
		                        <span>{{venta.cliente}}  </span>
		                      </th>
		                      <th>
		                        <span v-if="venta.promocion">{{obtenerPromocionVenta(venta.estado)}}</span>
		                        <span v-else>No</span>
		                      </th>
		                      <th>
		                        <span v-if="venta.estado == 'Cuenta Corriente'">Si</span>
		                        <span v-else>No</span>
		                      </th>
		                      <th>
		                        <span>{{venta.pagoEfectivo}}  </span>
		                      </th>
		                      <th>
		                        <span>{{venta.pagoTarjeta}} </span>
		                      </th>
		                      <th>
		                        <span>{{venta.total}} </span>
		                      </th>


		                      
		                    </tr>
		                  </tbody>

		                </table>
		                <h4>Productos</h4>
		                <table class="table table-bordered table-products mt-0">
		                  <thead>
		                    <tr class=" table-primary ">
		                      <th scope="col">N° Serie</th>
		                      <th scope="col">Categoria</th>
		                      <th scope="col">Precio</th>
		                      <th scope="col">Talle</th>
		                      <th scope="col">Color</th>
		                      

		                    </tr>
		                  </thead>
		                  
		                  <tbody >
		                    <tr v-for="producto in venta.productos" >
		                      <th>
		                        <span>{{producto.n_serie}}  </span>
		                      </th>
		                      <th>
		                        <span>{{producto.nombre}}  </span>
		                      </th>
		                      <th>
		                        <span>{{producto.precio}}  </span>
		                      </th>
		                      <th>
		                        <span>{{producto.talle}} </span>
		                      </th>
		                      <th>
		                        <span>{{producto.color}} </span>
		                      </th>
		    
		                    </tr>
		                  </tbody>

		                </table>
		              </div>
		            </div>
		          </div>
		        </div>
		    </div>
		</div>
		*/

	}
</script>


