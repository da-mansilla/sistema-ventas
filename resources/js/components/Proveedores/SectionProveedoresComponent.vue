<template>
    <div class="card-content card w-100">
      <div class="card-header ">
        <h3>Proveedores</h3>
      </div>
      <div class="card-body">
        

        
        <span v-if="pagina==1">
          <formproveedores-component>
          </formproveedores-component>

          <tableproveedores-component
          @verProveedor="verProveedor">
          </tableproveedores-component>
        </span>

        <span v-if="pagina==2">
          <detalleproveedores-component
            :detailProveedor="detailProveedor"
            :detailListCuentas="detailListCuentas">
          </detalleproveedores-component>
        </span>

 
      </div>
    </div>
</template>

<script>
    export default {
      data(){
        return {
          pagina: 1,
          detailProveedor: '',
          detailListCuentas: []


        };
      },
      mounted() {


      },
      methods:{
        verProveedor(proveedor){
          this.pagina = 2;
          axios.get('/cuenta_bancarias/'+proveedor.id).then(response=>{
            var cuentas = response.data;
            cuentas.forEach(cuenta=>{
              this.detailListCuentas.push(cuenta)
            })
          })
          this.detailProveedor = proveedor;
        }

        },
        computed: {
        }

    }
</script>
