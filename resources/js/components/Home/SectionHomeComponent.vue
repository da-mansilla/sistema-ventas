<template>
    <div class="card-content card w-100">
      <div class="card-header ">
        <h3>Inicio</h3>
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
                <h5 class="card-title"><h3>Egresos</h3></h5>
                <p class="card-text" style="color: red;">$750</p>
              </div>
            </div>
          </div>
        </div>

      	<div class="row pt-5">
      		<div class="col-md-6">
      			<canvas id="myChart" width="400" height="200"></canvas>
      		</div>
      		<div class="col-md-6">
      			<canvas id="myChart2" width="400" height="200"></canvas>
      		</div>
      		
      	</div>
        
			
			 
      </div>
      
    </div>
</template>

<script>
	import Chart from 'chart.js';
    export default {
        data(){
        	return{

        	}
            
        },
        mounted() {
        	this.graficoIngresos();
        	this.graficoVentas();
			
			
            
        },
        props: {
            
        },
        methods:{
        	graficoVentas(){
        		var ctx = document.getElementById('myChart');
				var myChart = new Chart(ctx, {
				    type: 'bar',
				    data: {
				        labels: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'],
				        datasets: [{
				            label: '',
				            data: [5, 4, 2, 5,3 ],
				            backgroundColor: [
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)'
				            ],
				            borderColor: [
				                'rgba(255, 99, 132, 1)',
				                'rgba(54, 162, 235, 1)',
				                'rgba(255, 206, 86, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(153, 102, 255, 1)'
				            ],
				            borderWidth: 1,
				            maxBarThickness: 50,
				            minBarLength: 10,
				        }]
				    },
				    options: {
				    	title: {
				            display: true,
				            text: 'Ventas de la Semana'
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
        	},
        	graficoIngresos(){
        		var ctx2 = document.getElementById('myChart2');
				var myChart2 = new Chart(ctx2, {
				    type: 'line',
				    data: {
				        labels: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'],
				        datasets: [{
				            label: '',
				            data: [1000, 1500, 750, 1200,1250 ],
				            backgroundColor: [
				                'rgba(54, 162, 235, 0.2)',
				            ],
				            borderColor: [
				                'rgba(54, 162, 235, 1)',
				            ],
				            borderWidth: 1,
				            maxBarThickness: 50,
				            minBarLength: 10,
				        }]
				    },
				    options: {
				    	title: {
				            display: true,
				            text: 'Ingresos'
				        },
				        legend: {
				            display: false
				        },
				        scales: {
				            yAxes: [{
				                ticks: {
				                	max: 1750,
				                    beginAtZero: true
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
