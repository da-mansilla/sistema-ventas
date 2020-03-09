<template>
    <div class="card-content card w-100">
      <div class="card-header ">
        <h3>Proveedores</h3>
      </div>
      <div class="card-body">
        

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar</button>
        

        <div class="row tarjetas">
          <div class="col-sm-6">
            <div class="card text-center">
              <div class="card-body">
                <h3 class="card-title">Proveedores </h3>
                <p class="card-text">3</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text"></p>
              </div>
            </div>
          </div>
        </div>

        <formproveedores-component>
        </formproveedores-component>
          

 
      </div>
    </div>
</template>

<script>
    export default {
      data(){
        return {

          filtros: {}

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
