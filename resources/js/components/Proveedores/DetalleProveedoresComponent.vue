<template>
  <div>
    <div class="mb-3">
      <button type="button" class="btn btn-success">Nuevo Pago</button>
      <button type="button" class="btn btn-success">Remito</button>
      
    </div>



        <div class="accordion" id="accordionExample">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h2 class="mb-0 d-flex justify-content-center">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <h4>Cheecky</h4>
                </button>
              </h2>
            </div>

            <div id="collapseOne" class="collaps show" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <label>Empresa:</label>
                    <h5>{{detailProveedor.empresa}}</h5>
                  </div>
                  <div class="col-md-6">
                    <label>Razon Social:</label>
                    <h5>{{detailProveedor.razon_social}}</h5>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <label>Ciudad:</label>
                    <h5>{{detailProveedor.ciudad}}</h5>
                  </div>
                  <div class="col-md-4">
                    <label>Direccion</label>
                    <h5>{{detailProveedor.direccion}}</h5>
                  </div>
                  <div class="col-md-4">
                    <label>Código Postal</label>
                    <h5>{{detailProveedor.cpa}}</h5>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                    <label>Teléfono:</label>
                    <h5>{{detailProveedor.telefono}}</h5>
                  </div>
                  <div class="col-md-6">
                    <label>Contacto</label>
                    <h5>{{detailProveedor.contacto}}</h5>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-2">
                    <label>Cuentas:</label>
                  </div>
                  <div class="col-md-10">
                    <table class="table table-bordered mt-0">
                      <thead>
                        <tr class=" thead-dark ">
                          <th scope="col">Titular</th>
                          <th scope="col">Tipo de Cuenta</th>
                          <th scope="col">N° Cuenta</th>
                          <th scope="col">CBU</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="cuenta in detailListCuentas" :key="cuenta.id">
                          <th>{{cuenta.titular}}</th>
                          <th>{{cuenta.tipo}}</th>
                          <th>{{cuenta.n_cuenta}}</th>
                          <th>{{cuenta.cbu}}</th>
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
    export default {
      props:{
        detailProveedor: {},
        detailListCuentas: {}
      },
      data(){
        return {
         


        };
      },
      mounted() {


      },
      methods:{
       

        },
        computed: {
        }

    }
</script>
