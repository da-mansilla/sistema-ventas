<template>
  <div>
    <div class="form-group d-flex justify-content-end">
      <h5 class="mb-0 pt-2 pr-2 align-bottom">Fecha: </h5>
      <input id="fechaVenta"type="date"  class="form-control w-25" v-model="fechaElegida">
      <button type="button" class="btn btn-success btn-sm" v-on:click="habilitarFecha">Buscar</button> 
      
    </div>
    <div class="row tarjetas" v-if="ventasSeña.length > 0" >

      <div class="col-sm-4" style="cursor:pointer;" v-on:click="mostrarVentas">
        <div class="card text-center">
          <div class="card-body">
            <h4 class="card-title">Ventas</h4>
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
            <h4 class="card-title">Ventas</h4>
            <h5 class="card-text" style="color: blue;">{{ventasHoy}}</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card text-center">
          <div class="card-body pointer"  v-on:click="detallesIngresos()">
            <h4 class="card-title " >Ingresos</h4>
            <h5 class="card-text" style="color: green;">${{ingresosHoy}}</h5>
            <span v-if="mostrarDetallesIngresos">
              <h5>Efectivo: ${{ingresosEfectivo}}  -  Tarjeta: ${{ingresosTarjeta}}</h5>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-2 mb-0" v-if="busquedaPorFecha">
      <h5 class="float-left">Fecha: {{$moment(fechaElegida).format("DD MMMM YYYY")}}</h5> 
      <button type="button" class="btn btn-secondary btn-sm float-left ml-2 mb-1" v-on:click="desabilitarFecha">Mostrar Todo</button>  
    </div>

    <div>
      <table class="table table-bordered mt-2">
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
               <button type="button" class="btn btn-secondary btn-sm" v-on:click="editVenta(index,venta)"><i class="far fa-eye"></i></button> 
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
              <span>{{$moment(venta.created_at).format("DD MMMM YYYY HH:mm:ss")}}</span>
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
      <pagination v-else :data="listaVentas" :limit="2" @pagination-change-page="getResults" class="float-right">
      </pagination>

    </div>
  </div>
</template>

<script>
    export default {
      props: {
        fechaTableVentas:{

        }

      },
      data(){
        return {
          listaVentas: {},
          ventasHoy: 0,
          ingresosHoy: 0,
          ventasSeña:[],
          verSeñas: false,
          ingresosEfectivo: 0,
          ingresosTarjeta: 0,
          mostrarDetallesIngresos:false,
          fechaElegida: new Date(),
          busquedaPorFecha: false


        
        };
      },
      mounted() {
        if(this.fechaTableVentas){
          console.log('si aparece');
          this.fechaElegida= this.fechaTableVentas;
          this.busquedaPorFecha = true;
          console.log(this.fechaElegida);
        }else {
          let day = this.fechaElegida.getDate();
          let month = parseInt(this.fechaElegida.getMonth()+1);
          let year = this.fechaElegida.getFullYear();
          let fechaCadena = day+"-"+month+"-"+year;
          this.fechaElegida = fechaCadena;
        }

          this.getResults();
          this.getTotal();
          this.getVentasSeña();
      },
      watch:{
        fechaTableVentas: function(){

        }
      },
      methods:{
          async getVentasSeña(page = 1){
            await axios.get('ventasseña?page=' + page).then(response=>{
              this.ventasSeña = response.data.data;
            })
          },
          async getTotal(){
            await axios.get('/ingresos/'+this.fechaElegida).then(response=>{
              this.ventasHoy = response.data[0].cantidad;

              this.ingresosEfectivo = parseInt(response.data[0].totalEfectivo);
              this.ingresosTarjeta = parseInt(response.data[0].totalTarjeta);
              if(this.ingresosEfectivo == null){ this.ingresosEfectivo = 0}
              if(this.ingresosTarjeta == NaN){ this.ingresosTarjeta = 0}

              this.ingresosHoy = parseInt(this.ingresosEfectivo+this.ingresosTarjeta)
              if(this.ingresosHoy == null){
                this.ingresosHoy = 0;
              }
            })
          },
          async getResults2(page = 1) {
            await axios.get('/ventas?page=' + page)
              .then(response => {
                this.listaVentas = response.data;
              });
          },
          editVenta(index,venta){
            let fechaEnviar = this.fechaElegida;
            this.fechaElegida = ''
            this.$emit('detail',index,venta,this.busquedaPorFecha,fechaEnviar);
            this.busquedaPorFecha = false;
          },
          editCuenta(index,venta){
            let fechaEnviar = this.fechaElegida;
            this.fechaElegida = ''
            this.$emit('detailCuenta',index,venta,this.busquedaPorFecha,fechaEnviar);
            this.busquedaPorFecha = false;
          },
          editSeña(venta){
            let fechaEnviar = this.fechaElegida;
            this.fechaElegida = ''
            this.$emit('detailSena',venta,this.busquedaPorFecha,fechaEnviar);
            this.busquedaPorFecha = false;
          },
          mostrarVentas(){
            this.getResults();
            this.getTotal();
            this.verSeñas = false;
          },
          mostrarSena(page = 1){
            axios.get('ventasseña?page=' + page).then(response=>{
              this.verSeñas = true;
              console.log(response.data);
              this.listaVentas = response.data;
            })
          },
          detallesIngresos(){
            if(this.mostrarDetallesIngresos){
              this.mostrarDetallesIngresos= false;
            } else {
              this.mostrarDetallesIngresos = true;
            }
          },
          habilitarFecha(){
            this.busquedaPorFecha=true;
            this.getResults()
            this.getTotal()
          },
          desabilitarFecha(){
            this.busquedaPorFecha=false;

            this.fechaElegida = new Date()

            let day = this.fechaElegida.getDate();
            let month = parseInt(this.fechaElegida.getMonth()+1);
            let year = this.fechaElegida.getFullYear();
            let fechaCadena = day+"-"+month+"-"+year;
            this.fechaElegida = fechaCadena;
            this.getResults()
            this.getTotal()
          },
          async getResults(page = 1){
            let param= {
              fecha:{
                fecha: this.fechaElegida,
                enabled: this.busquedaPorFecha
              }
            }
            await axios.post('ventasPorFecha?page=' + page,param).then(response=>{
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
    .pointer{
      cursor:pointer;
    }

</style>
