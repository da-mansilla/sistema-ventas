<template>
    <div class="card-content card w-100">
      <div class="card-header">
        <h3>Informacion</h3>
      </div>
      <div class="card-body">
        <div class="row tarjetas">
          <div class="col-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Ventas</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ ventasTotal }}</div>
                  </div>
                  <div class="col-auto">

                    <i class="fas fa-tshirt fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Ingresos</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ ventasTotalIngresos }}</div>
                  </div>
                  <div class="col-auto">

                    <i class="fas fa-tshirt fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Productos Vendidos</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ productosTotalesVendidos }}</div>
                  </div>
                  <div class="col-auto">

                    <i class="fas fa-tshirt fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--
          <div class="col-sm-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><h3>Ventas</h3></h5>
                <p class="card-text">{{ventasTotal}}</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><h3>Ingresos</h3></h5>
                <p class="card-text" style="color: green;" >${{ventasTotalIngresos}}</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><h3>Productos Vendidos</h3></h5>
                <p class="card-text">{{productosTotalesVendidos}}</p>
              </div>
            </div>
          </div>
        -->
        </div>

        <div class="m-3">

            <div class="card">
              <div class="card-header text-center bg-info">
                <h4 class="text-white"><strong>Ventas</strong></h4>
              </div>
              <div class="card-body">

                
                <div class="row  align-items-end">
                  <div class="col-3">

                      <h4 class="text-center"><strong>Ordenar Por</strong></h4>

                        <select class="form-control" v-model="ordenarPor">
                          <option value="semana">Semana</option>
                          <option value="mes">Mes</option>
                          <option value="year">Año</option>
                        </select>


                  </div>


                  <div class="col-3">
                    

                    <div v-if="ordenarPor == 'semana'">
                      <h4 class="text-center"><strong>Semana</strong></h4>

                        <input class="form-control" type="week"  v-model="intervaloFecha">

                    </div>
                    <div v-if="ordenarPor == 'mes'">
                      <h4 class="text-center"><strong>Mes</strong></h4>

                        <input type="month" class="form-control" v-model="intervaloFecha" :placeholder="new Date().getMonth()">

                    </div>
                    <div v-if="ordenarPor == 'year'">
                      <h4 class="text-center"><strong>Año</strong></h4>

                        <select class="form-control" v-model="intervaloFecha">
                          <option>2020</option>
                        </select>

                    </div>

                  </div>

                  <div class="col-3">
                    
                  </div>


                  <div class="col-3">
                    <div class="">
                      <button class="btn btn-secondary w-75  mr-3" v-on:click="ordenarPorFecha"><h5 class="mb-0">Agregar</h5></button> 
                    </div>
                  </div>

                </div>
  
              </div>
            </div>

            <resumenInformacion-component
              :opc="opc"
              :listaVentasInformacion="listaVentasInformacion"
              :lista_productos_vendidos="lista_productos_vendidos"

              @filtrar='filtrar'>
              
            </resumenInformacion-component>

        
        </div>

        <div class="">
          <div class="row">
            <div class="col">
              <div class="card position-relative">
                <canvas id="canvas1" height="250" v-on:click="detalleVenta"></canvas>
              </div>
            </div>
            <div class="col position-relative">
              <div class="card">
                <canvas id="canvas2" height="250" v-on:click="detalleVenta"></canvas>
              </div>
            </div>
            <div class="col">
              <div class="card bg-light mb-3">
                  <div class="card-header">Info</div>
                  <div class="card-body">
                    <div class="row">
                      <h5>
                          Ventas: {{ventasTotal}} - <span style="color:green;">${{ventasTotalIngresos}}</span>
                      </h5>
                    </div>
                    <div class="row">
                      <h5>
                          Ventas en Efectivo: {{ventasEfectivo}} - <span style="color:green;">${{ventasEfectivoTotal}}</span>
                      </h5>
                    </div>
                    <div class="row">
                      <h5>
                          Ventas con Tarjeta: {{ventasTarjeta}} - <span style="color:green;">${{ventasTarjetaTotal}}</span>
                      </h5>
                    </div>
                    <div class="row">
                      <h5>
                          Ventas con Efectivo y Tarjeta : {{ventasEfectivoTarjeta}} - <span style="color:green;">${{ventasEfectivoTarjetaTotal}}</span>
                      </h5>
                    </div>
                    <br>
                    <div class="row">
                      <h5>
                          Productos Vendidos: {{productosTotalesVendidos}}
                      </h5>
                    </div>
                    
                  </div>
                  

              </div>
            </div>
            
          </div>

          
        </div>

        

            
            <tableInformacion-component
              :listVentasDetalle='listVentasDetalle'>
            </tableInformacion-component>




      </div>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data(){
          var lista = [];
          var colores = [];
          for(let i= 1; i <= 30; i++){
                lista.push(i);
                colores.push('rgba(255, 99, 132, 1)');
          }
          return {
            categorias: [],
            cantidadVentas: [],
            totalVentas: [],
            labelsFechas: [],
            labelsColor: [],
            ordenarPor: 'mes',
            intervaloFecha: '',
            tituloCantidad: '',
            tituloIngresos: '',
            listaCategorias: [],
            listaTemporadas: [],
            listaVentasInformacion: [],
            ventasTotal:0,
            ventasTotalIngresos:0,
            ventasEfectivo: 0,
            ventasEfectivoTotal:0,
            ventasTarjeta: 0,
            ventasTarjetaTotal:0,
            ventasEfectivoTarjeta: 0,
            ventasEfectivoTarjetaTotal:0,
            productosTotalesVendidos:0,
            click: false,
            click2: false,
            indexVenta: 0,
            listVentasDetalle: [],
            opc:{},
            lista_productos_vendidos: []
          }

              
        },
        mounted() {
          this.graficoVentas();
          this.llenarGrafico();
        },
        methods:{


          llenarGrafico(){
                var ordenarPorMes = true;
                var ordenarPorDia = false;
                var ordenarPorSemana = false;
                var ordenarPorYear = false;

                let mesHoy = new Date().getMonth() + 1

                let yearHoy = new Date().getFullYear()

                let fechaHoy = yearHoy+"-"+mesHoy;
                this.intervaloFecha = fechaHoy;
                console.log(fechaHoy);
                var input = new Date(fechaHoy)
                input.setDate(input.getDate() + 1)


                var desde = new Date(input);
                console.log(desde);
                var hasta = new Date(input.setMonth(input.getMonth() + 1))
                console.log(hasta)



              this.opc = {
                fecha: {
                  dia:{
                    enabled: ordenarPorDia
                  },
                  semana:{
                    enabled: ordenarPorSemana,
                    desde: desde,
                    hasta: hasta
                  },
                  mes: {
                    enabled: ordenarPorMes,
                    desde: desde,
                    hasta: hasta
                  },
                  year: {
                    enabled: ordenarPorYear
                  }
                }
              };
              axios.post('/datosventas',this.opc).then((response)=>{
                console.log(response.data);
                this.cantidadVentas = response.data[0];
                this.totalVentas = response.data[1];
                this.listaVentasInformacion = response.data[2]

                this.lista_productos_vendidos= []
                console.log('Lista Venta')
                console.log(this.listaVentasInformacion);
                this.listaVentasInformacion.forEach(element=>{
                  if(element !== 0){
                    element.forEach(venta=>{
                      venta.productos.forEach(product=>{
                        this.lista_productos_vendidos.push(product)

                      })
                    })
                  }
                })

                this.llenarLavels(this.opc);
                this.graficoVentas();
                this.informacion();
              })


          },
          informacion(){
            this.ventasEfectivo= 0;
            this.ventasEfectivoTotal= 0;

            this.ventasTarjeta= 0;
            this.ventasTarjetaTotal= 0;

            this.ventasEfectivoTarjeta= 0;
            this.ventasEfectivoTarjetaTotal= 0;

            this.ventasTotal= 0;
            this.ventasTotalIngresos= 0;

            this.productosTotalesVendidos = 0;
            var cantidadVentasEfectivo= 0;
            var totalVentasEfectivo= 0;

            var cantidadVentasTarjeta= 0;
            var totalVentasTarjeta= 0;

            var cantidadVentasEfectivoTarjeta= 0;
            var totalVentasEfectivoTarjeta= 0;

            var productosTotalesVendidos = 0;

            this.listaVentasInformacion.forEach(element=>{
              if(element !== 0){
                element.forEach(venta=>{
                  //Ventas Efectivo
                  if(venta.forma_pago == 'Efectivo' || venta.forma_pago == 'Seña' || venta.forma_pago == 'Cuenta'){
                    totalVentasEfectivo += venta.pagoEfectivo
                    cantidadVentasEfectivo++
                  }
                  //Ventas Tarjeta
                  if(venta.forma_pago == 'Tarjeta'){
                    totalVentasTarjeta += venta.pagoTarjeta
                    cantidadVentasTarjeta++
                  }
                  //Ventas Efectivo Tarjeta
                  if(venta.forma_pago == 'efectivoTarjeta'){
                    totalVentasEfectivoTarjeta += venta.pagoEfectivo+venta.pagoTarjeta
                    cantidadVentasEfectivoTarjeta++
                  }
                  venta.productos.forEach(productos=>{
                    productosTotalesVendidos++
                  })
                })
              }
            })

            this.ventasEfectivo= cantidadVentasEfectivo
            this.ventasEfectivoTotal= totalVentasEfectivo

            this.ventasTarjeta= cantidadVentasTarjeta
            this.ventasTarjetaTotal= totalVentasTarjeta

            this.ventasEfectivoTarjeta= cantidadVentasEfectivoTarjeta
            this.ventasEfectivoTarjetaTotal= totalVentasEfectivoTarjeta

            this.ventasTotal= cantidadVentasEfectivo+cantidadVentasTarjeta+cantidadVentasEfectivoTarjeta
            this.ventasTotalIngresos= totalVentasEfectivo+totalVentasTarjeta+totalVentasEfectivoTarjeta

            this.productosTotalesVendidos = productosTotalesVendidos;

          },
          getTemporadas(){
            axios.get('/temporadas').then(response=>{
              response.data.forEach(element=>{
                this.listaTemporadas.push(element.nombre)
              })

            })
          },
          datosVentas(){
            axios.post('/datosventas').then(response=>{
              this.cantidadVentas = response.data[0];
              this.totalVentas = response.data[1]

              this.graficoVentas();
            })
          },
          llenarLavels(opc){
            this.labelsColor = [];
            this.labelsFechas= [];
            if(opc.fecha.dia.enabled){

            } else if(opc.fecha.semana.enabled){
              for(let i= 1; i <= 7; i++){
                this.labelsColor.push('rgba(255, 99, 132, 1)');
              }
              this.labelsFechas = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
              this.tituloCantidad = 'Ventas de la Semana';
              this.tituloIngresos = 'Ingresos de la Semana;'
            } else if(opc.fecha.mes.enabled){
              for(let i= 1; i <= 31; i++){
                this.labelsColor.push('rgba(255, 99, 132, 1)');
                this.labelsFechas.push(i);
              }
              this.tituloCantidad = 'Ventas del Mes';
              this.tituloIngresos = 'Ingresos del Mes;'
            } else if(opc.fecha.year.enabled){
              for(let i= 1; i <= 12; i++){
                this.labelsColor.push('rgba(255, 99, 132, 1)');
                this.labelsFechas.push(i);
              }
              this.tituloCantidad = 'Ventas del Año';
              this.tituloIngresos = 'Ingresos del Año;'
            }
          },
          ordenarPorFecha(){
            var ordenarPorDia = false;
            var ordenarPorSemana = false;
            var ordenarPorMes = false;
            var ordenarPorYear = false;

            if(this.ordenarPor == 'dia'){

            } else if(this.ordenarPor == 'semana'){
              ordenarPorSemana = true;

              var indice = this.intervaloFecha.indexOf('W');
              var semana = parseInt(this.intervaloFecha.slice(indice+1));

              let year = new Date().getFullYear()
              let inicio = new Date(year+"-01-01")
              let restar = inicio.getDay() - 1;
              inicio.setDate(inicio.getDate()-restar)

              var desde = new Date(inicio.setDate(inicio.getDate()+(semana*7-7)))
              console.log(desde);
              var hasta = new Date(inicio.setDate(inicio.getDate()+6))
              console.log(hasta);
            } else if(this.ordenarPor == 'mes'){
              ordenarPorMes = true;

              var input = new Date(this.intervaloFecha)
              input.setDate(input.getDate() + 1)

              var desde = new Date(input);
              console.log(desde);
              var hasta = new Date(input.setMonth(input.getMonth() + 1))
              console.log(hasta)
            } else if(this.ordenarPor == 'year'){
              console.log(this.intervaloFecha);
              ordenarPorYear = true;
              let year = parseInt(this.intervaloFecha)
              var desde = new Date(year+"-01-02")
              console.log(desde)
              
              let yearLater = parseInt(this.intervaloFecha)+1
              var hasta = new Date(yearLater+"-01-02")
              console.log(hasta)

            }

            this.opc = {
              fecha: {
                dia:{
                  enabled: ordenarPorDia
                },
                semana:{
                  enabled: ordenarPorSemana,
                  desde: desde,
                  hasta: hasta
                },
                mes: {
                  enabled: ordenarPorMes,
                  desde: desde,
                  hasta: hasta
                },
                year: {
                  enabled: ordenarPorYear,
                  desde: desde,
                  hasta: hasta
                }
              }
            };
            console.log(this.opc);
            axios.post('/datosventas',this.opc).then((response)=>{
              console.log(response.data);
              this.cantidadVentas = response.data[0];
              this.totalVentas = response.data[1];
              this.listaVentasInformacion = response.data[2]

              this.lista_productos_vendidos= []
              console.log('Lista Venta')
              console.log(this.listaVentasInformacion);
              this.listaVentasInformacion.forEach(element=>{
                if(element !== 0){
                  element.forEach(venta=>{
                    venta.productos.forEach(product=>{
                      this.lista_productos_vendidos.push(product)

                    })
                  })
                }
              })

              console.log(this.listaVentasInformacion);
              this.llenarLavels(this.opc);
              this.graficoVentas();
              this.informacion();
            })

          },
          detalleVenta(evt){
              console.log(evt);
              let canvas = evt.path[0].id
              if(canvas == 'canvas1'){
                var param1 = window.myChart1.getElementAtEvent(evt);
              }else {
                var param1 = window.myChart2.getElementAtEvent(evt);
              }
              if(param1.length > 0){
                this.indexVenta = param1[0]._index
                console.log(this.listaVentasInformacion[this.indexVenta])
                this.listVentasDetalle = this.listaVentasInformacion[this.indexVenta];
              }

          },
          graficoVentas(){

            var ctx = document.getElementById('canvas1');
            

            if(window.myChart1){
              window.myChart1.clear();
              window.myChart1.destroy();
            }
            if(window.myChart2){
              window.myChart2.clear();
              window.myChart2.destroy();
            }

            window.myChart1 = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.labelsFechas,
                    datasets: [{
                        label: '',
                        data: this.cantidadVentas,
                        backgroundColor: this.labelsColor,

                        borderWidth: 1,
                        maxBarThickness: 5,
                        minBarLength: 10,

                    }]
                },
                options: {
                  layout:{},
                  title: {
                        display: true,
                        text: this.tituloCantidad,
                        'onClick': this.alertFunction
                    },
                    legend: {
                        display: false,
                        'onClick': this.alertFunction
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1,
                                steps: 10,
                                stepValue: 5,
                            }
                        }]
                    }
                }
            });


          var ctx2 = document.getElementById('canvas2');

            

            window.myChart2 = new Chart(ctx2, {
                type: 'line',

                data: {
                    labels: this.labelsFechas,
                    datasets: [{
                      fill:false,
                      lineTension: 0.3,
                        label: '',
                        data: this.totalVentas,
                        backgroundColor: this.labelsColor,
                        borderColor: [
                            'rgba(255, 99, 132, 1)',

                        ],
                        borderWidth: 1,
                        scaleSteps : 1

                    }]
                },

                options: {
                  fill: false,
                  steppedLine: true,
                  title: {
                        display: true,
                        text: this.tituloIngresos
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                steppedLine: true
                            }
                        }]
                    }
                }
            });

            
          },
          filtrar(){

          }
          
            
        },
        computed: {
        }
          
        
    }
</script>
<style>
</style>
