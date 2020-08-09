<template>
	<div class="card mt-3">
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
	</div>
</template>
<script>
	export default{
		props:{
			listVentasDetalle:{}
		},
		data(){
			return{

			}
		}
	}
</script>