<template>
    <div class="card-content card w-100">
      <div class="card-header">
        <h3>Informacion</h3>
      </div>
      <div class="card-body">
        <div class="row tarjetas">
          <div class="col-sm-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><h3>Ventas</h3></h5>
                <p class="card-text">10</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><h3>Ingresos</h3></h5>
                <p class="card-text" style="color: green;" >$6500</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"><h3>Productos Vendidos</h3></h5>
                <p class="card-text">35</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <h5><strong>Ventas</strong></h5>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Forma de Pago</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control">
                  </div>
                </div>
                <hr>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tipo</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Categoria</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Talle</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Color</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control">
                  </div>
                </div>
                <hr>
                <button class="btn btn-secondary float-right">Agregar</button>
              </div>
            </div>
            <div class="card mt-3">
              <div class="card-header text-center">
                <h5><strong>Fecha</strong></h5>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Ordenar Por</label>
                  <div class="col-sm-8">
                    <select class="form-control" v-model="ordenarPor">
                      <option value="dia">Dia</option>
                      <option value="semana">Semana</option>
                      <option value="mes">Mes</option>
                      <option value="year">Año</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row" v-if="ordenarPor == 'dia'">
                  <label class="col-sm-4 col-form-label">Dia</label>
                  <div class="col-sm-8">
                    <input type="date" name="" v-model="intervaloFecha">
                  </div>
                </div>
                <div class="form-group row" v-if="ordenarPor == 'semana'">
                  <label class="col-sm-4 col-form-label">Semana</label>
                  <div class="col-sm-8">
                    <input type="week" name="" v-model="intervaloFecha">
                  </div>
                </div>
                <div class="form-group row" v-if="ordenarPor == 'mes'">
                  <label class="col-sm-4 col-form-label">Mes</label>
                  <div class="col-sm-8">
                    <input type="month" name="" v-model="intervaloFecha" :placeholder="new Date().getMonth()">
                  </div>
                </div>
                <div class="form-group row" v-if="ordenarPor == 'year'">
                  <label class="col-sm-4 col-form-label">Año</label>
                  <div class="col-sm-8">
                    <select class="form-control"></select v-model="intervaloFecha">
                      <option>2020</option>
                    </select>
                  </div>
                </div>
                
                <button class="btn btn-secondary float-right" v-on:click="ordenarPorFecha">Agregar</button>
              </div>
              
            </div>
          </div>

          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <canvas id="myChart" height="100"></canvas>
                <canvas id="myChartt" height="100"></canvas>
                
              </div>
            </div>
          </div>
        
        </div>
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
            cantidadVentas: [],
            totalVentas: [],
            labelsFechas: [],
            labelsColor: [],
            ordenarPor: '',
            intervaloFecha: '',
            tituloCantidad: '',
            tituloIngresos: '',
          }

              
        },
        mounted() {
        },
        methods:{
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

            }

            var opc = {
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
            console.log(opc);
            axios.post('/datosventas',opc).then((response)=>{
              console.log(response.data);
              this.cantidadVentas = response.data[0];
              this.totalVentas = response.data[1];
              let cantidadDias = response.data[2];
              this.llenarLavels(opc);
              this.graficoVentas();
            })

          },
          graficoVentas(){
            var ctx = document.getElementById('myChart');

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
                        maxBarThickness: 50,
                        minBarLength: 10,
                    }]
                },
                options: {
                  title: {
                        display: true,
                        text: this.tituloCantidad
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
          
          var ctx = document.getElementById('myChartt');

            

            window.myChart2 = new Chart(ctx, {
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
          }
            
        },
        computed: {
        }
        
    }
</script>
<style>
</style>
