<template>
  <div>

    <div class="row tarjetas" v-if="ventasSeña.length > 0" >

      <div class="col-sm-4" style="cursor:pointer;" v-on:click="mostrarVentas">
        <div class="card text-center">
          <div class="card-body">
            <h4 class="card-title">Ventas de hoy</h4>
            <h5 class="card-text" style="color: blue;">{{ventasHoy}}</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card text-center">
          <div class="card-body">
            <h4 class="card-title">Ingresos</h4>
            <h5 class="card-text" style="color: green;">${{ingresosHoy}}</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-4" style="cursor:pointer;" v-on:click="mostrarSena">
        <div class="card text-center" >
          <div class="card-body"> 
            <h4 class="card-title">Ventas en Seña</h4>
            <h5 class="card-text" style="color: blue;">{{ ventasSeña.length }}</h5>
          </div>
        </div>
      </div>

    </div>

    <div class="row tarjetas" v-else>
      <div class="col-sm-6">
        <div class="card text-center">
          <div class="card-body">
            <h4 class="card-title">Ventas de hoy</h4>
            <h5 class="card-text" style="color: blue;">{{ventasHoy}}</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card text-center">
          <div class="card-body">
            <h4 class="card-title">Ingresos</h4>
            <h5 class="card-text" style="color: green;">${{ingresosHoy}}</h5>
          </div>
        </div>
      </div>
    </div>


    <div>
      <table class="table table-bordered ">
        <thead >
          <tr class=" table-info ">
            <th scope="col">Opciones</th>
            <th scope="col">Usuario</th>
            <th scope="col">Cliente</th>
            <th scope="col">Fecha y Hora</th>
            <th scope="col">Total</th>
            <th scope="col">Estado</th>

          </tr>
        </thead>
        <tbody>
          <tr v-for="(venta,index) in listaVentas.data" :key="venta.id" v-bind:class="{'venta-cancelada' : venta.estado == 'Cancelado'}">
            <th scope="row" >
              <span v-if="venta.estado == 'Cuenta Corriente'">

              <button type="button" class="btn btn-primary btn-sm" v-on:click="editCuenta(index,venta)"><i class="far fa-eye"></i></button>
               
              </span>
              <span v-else-if="venta.estado == 'Cancelado'">
               <button type="button" class="btn btn-secondary btn-sm" v-on:click="editVenta(venta)"><i class="far fa-eye"></i></button> 
              </span>
              <span v-else-if="venta.estado == 'Seña'">
               <button type="button" class="btn btn-success btn-sm" v-on:click="editSeña(venta)"><i class="far fa-eye"></i></button> 
              </span>
              <span v-else>
               <button type="button" class="btn btn-success btn-sm" v-on:click="editVenta(index,venta)"><i class="far fa-eye"></i></button> 
              </span>


            </th>
            <th>
              <span>admin</span>
            </th>
            <th>
              <span>{{venta.cliente}}</span>
            </th>
            <th>
              <span>{{venta.created_at}}</span>
            </th>
            <th>
              <span>${{venta.total}}</span>
            </th>
            <th>
              <span v-if="venta.estado == 'Seña'" v-bind:class="{'colorRojo' : venta.estado == 'Seña'}">{{venta.estado}}</span>
              <span v-else v-bind:class="{'colorGris' : venta.estado == 'Cancelado'}">{{venta.estado}}</span>
            </th>

          </tr>
        </tbody>
      </table>
      <pagination v-if="verSeñas" :data="listaVentas" @pagination-change-page="getVentasSeña" class="float-right">
      </pagination>
      <pagination v-else :data="listaVentas" @pagination-change-page="getResults" class="float-right">
      </pagination>

    </div>
  </div>
</template>

<script>
    export default {
      props: {

      },
      data(){
        return {
          listaVentas: {},
          ventasHoy: 0,
          ingresosHoy: 0,
          ventasSeña:[],
          verSeñas: false


        
        };
      },
      mounted() {
          this.getResults();
          this.getTotal();
          this.getVentasSeña();
      },
      methods:{
          getVentasSeña(page = 1){
            axios.get('ventasseña?page=' + page).then(response=>{
              console.log(response.data.data);
              this.ventasSeña = response.data.data;
            })
          },
          getTotal(){
            axios.get('/ingresos').then(response=>{
              this.ventasHoy = response.data[0].cantidad;
              this.ingresosHoy = response.data[0].total
              if(this.ingresosHoy == null){
                this.ingresosHoy = 0;
              }
            })
          },
          getResults(page = 1) {
            axios.get('/ventas?page=' + page)
              .then(response => {
                this.listaVentas = response.data;
              });
          },
          editVenta(index,venta){
            this.$emit('detail',index,venta);
          },
          editCuenta(index,venta){
            this.$emit('detailCuenta',index,venta);
          },
          editSeña(venta){
            this.$emit('detailSena',venta);
          },
          mostrarVentas(){
            console.log('click');
            this.getResults();
            this.getTotal();
            this.verSeñas = false;
          },
          mostrarSena(page = 1){
            console.log('click');
            axios.get('ventasseña?page=' + page).then(response=>{
              this.verSeñas = true;
              console.log(response.data);
              this.listaVentas = response.data;
            })
          }
      },
      computed: {
        /*
          ventasHoy(){
            var listVentas = [];
            this.ventas.forEach(venta=>{
              if(venta.estado != 'Cancelado'){
                listVentas.push(venta);
              }
            })
            return listVentas.length
          },
          ingresos(){
            var total = 0;
            for(var i of this.ventas){
              if(i.estado != 'Cancelado'){
                total = total + i.total;
              }
            }
            return total;
          }
        */
        }
    }
</script>
<style>
    .venta-cancelada{
        background-color: rgba(0, 0, 0, 0.03);
    }
    .colorGris{
        color: gray;
    }
    .colorRojo{
        color: red;
    }

</style>
