<template>
    <div class="card-content card w-100">
      <div class="card-header" >
        <h1 v-if="pagina==1" class="display-4 mb-0 text-gray-800">Ventas</h1>
        <h3 v-if="pagina==4" class="display-4 mb-0 text-gray-800">Cuenta Corriente</h3>
      </div>
      <div class="card-body">
        <span v-if='pagina==1 || pagina==4'>
          <!--
          <button v-if="pagina != 4" type="button" class="btn barra-lateral" v-on:click="onClickCuenta">
            <span class="h5 text-white">Ir a Cuenta Corriente </span>
            <span class="badge badge-light mr-1">{{ cantidadCuentasActivas }}</span>
          </button>

          <button v-if="pagina != 1"type="button" class="btn barra-lateral" v-on:click="onClickInicio"><span class="h5 text-white">Ir a Ventas </span></button>

          <button type="button" class="btn barra-lateral" v-on:click="onClickNuevaVenta()"><span class="h5 text-white">Nueva Venta</span> <i class="fas fa-plus-circle text-white"></i></button>
          -->
          <button v-if="pagina != 4" type="button" v-on:click="onClickCuenta" class="btn btn-success shadow btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-check"></i>
            </span>
            <span class="text h5">Ir a Cuenta Corriente</span>
          </button>

          <button v-if="pagina != 1" type="button" v-on:click="onClickInicio" class="btn btn-success shadow btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-check"></i>
            </span>
            <span class="text h5">Ir a Ventas</span>
          </button>

          <button type="button" v-on:click="onClickNuevaVenta()" class="btn btn-success shadow btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-plus-circle"></i>
            </span>
            <span class="text h5">Nueva Venta</span>
          </button>


        </span>
        

        <span v-if="pagina==1">
          <tableventas-component
           :ventas="ventas"
           :fechaTableVentas="fechaTableVentas"
           @detail='detail'
           @detailCuenta='detailCuenta'
           @detailSena='detailSena'>
            
          </tableventas-component>
        </span>

        <span v-if="pagina==4">
          <tablecuentas-component
           :ventas="ventas"
           @verCuenta='verCuenta'>
            
          </tablecuentas-component>
        </span>

        <span v-if="pagina==2">
          <formventas-component
           :editMode= 'editMode'
           :indexEdit= 'indexEdit'
           :productsVendidos= 'productsVendidos'
           @new='addVenta'
           @edit='edit'
           @delete='deleteVenta'
           @exit='exit'
           @devolucion="devolucion">
            
          </formventas-component>
        </span>

        <span v-if="pagina==3">
          <formcuentas-component
           :editMode= 'editMode'
           :productsVendidos= 'productsVendidos'
           :cuentaCliente= 'cuentaCliente'
           :cuentaMode="cuentaMode"
           @new='addVenta'
           @edit='edit'
           @delete='deleteVenta'
           @exitCuentaMode='exitCuentaMode'
           @nuevoPago='nuevoPago'>

            
          </formcuentas-component>
        </span>
        <span v-if="pagina==6">
          <formsena-component
           :productsVendidos= 'productsVendidos'
           :señaMode="señaMode"
           @exitSena="exitSena">



            
          </formsena-component>
        </span>

        <span v-if="pagina==5">
          <devolucion-component
          :ventaDevolucion="ventaDevolucion"
          @updateVenta="updateVenta"
          @exitDevolucion="exitDevolucion">
          </devolucion-component>
        </span>
 
      </div>
      
    </div>
</template>

<script>
    export default {
      data(){
        return {
          pagina: 1,
          ventas:[],
          editMode: '',
          indexEdit: '',
          productsVendidos: '',
          cuentaCliente: '',
          cuentaMode:'',
          señaMode: '',
          ventaDevolucion: '',
          ventasHoy : '',
          ingresosHoy: '',
          cantidadCuentasActivas: 0,
          habilitarFechaTableVentas : false,
          fechaTableVentas: '',
          habilitarFechaTableCuentas : false,
          fechaTableCuentas: '',


        
        };
      },
      mounted() {
        this.getCantidad()
      },
      methods:{
            getCantidad(){
              axios.get('cuentasCantidad').then(response=>{
                  this.cantidadCuentasActivas = response.data[0].cantidad;
              })
            },
            getVenta(id){
              const promise = new Promise((resolve,reject)=>{
                axios.get('ventas/'+id)
                .then((response)=>{
                  resolve(response);
                }).catch((err)=>{
                  reject(err);
                })
              })
              return promise
            },
            getCuenta($client_id){
              const promise = new Promise((resolve,reject)=>{
                axios.get('cuentas/'+$client_id)
                .then((response)=>{
                  resolve(response);
                }).catch((err)=>{
                  reject(err);
                })
              })
              return promise
            },
            getProductsVendidos($venta_id){
              const promise = new Promise((resolve,reject)=>{
                axios.get('/productsvendidos/'+$venta_id)
                .then((response)=>{
                  resolve(response);
                }).catch((err)=>{
                  reject(err);
                })
              })
              return promise
            },
            onClickInicio(){
              this.pagina=1
            },
            onClickNuevaVenta(){
              this.pagina=2
            },
            onClickCuenta(){
              this.pagina=4
            },
            addVenta(venta){
              this.pagina=1;
              this.getCantidad();
            },
            detail(index,venta,busquedaPorFecha,fecha){
              if(busquedaPorFecha){
                this.fechaTableVentas = fecha
              }
              this.getProductsVendidos(venta.id)
              .then((response)=>{
                this.pagina = 2;
                this.indexEdit = index;
                this.productsVendidos = response.data;
                return this.getVenta(venta.id)
              })
              .then(response=>{
                this.editMode = response.data[0];
              })
            },
            detailCuenta(index,venta,busquedaPorFecha,fecha){
              if(busquedaPorFecha){
                this.fechaTableVentas = fecha
              }
              this.getProductsVendidos(venta.id)
              .then((response)=>{
                this.pagina = 3;
                this.productsVendidos = response.data;
                 return this.getVenta(venta.id)
              })
              .then(response=>{ 
                this.editMode = response.data[0];
                return this.getCuenta(venta.cliente_id)
              })
              .then((response)=>{
                this.cuentaCliente = response.data[0];
              })
              .catch(err => console.log(err))
            },
            detailSena(venta,busquedaPorFecha,fecha){
              if(busquedaPorFecha){
                this.fechaTableVentas = fecha
              }
              this.habilitarFechaTableVentas= busquedaPorFecha
              console.log('Ver Seña');
              this.getProductsVendidos(venta.id).then(response=>{
                this.pagina=6;
                this.productsVendidos = response.data;
                console.log(this.productsVendidos);
                return this.getVenta(venta.id);
              })
              .then(response=>{
                this.señaMode = response.data;
                console.log(this.señaMode);
              })

            },
            deleteVenta(i){
              this.pagina=1;
              this.editMode= '';
            },
            exit(){
              this.pagina=1;
              this.editMode= '';
            },
            exitDevolucion(){
              this.pagina = 1
            },
            exitCuentaMode(){
              this.pagina=1;
              this.cuentaMode = '';
            },
            exitSena(){
              this.pagina = 1;
              this.señaMode = ''
            },
            edit(venta,index){
              this.pagina=1;
              this.ventas.splice(index,1);
              this.ventas.push(venta);
              this.editMode= '';
            },
            verCuenta(client){
              this.cuentaMode = client;
              console.log(this.cuentaMode);
              this.pagina=3;
            },
            nuevoPago(cliente_id){
              console.log('Id enviado: ', cliente_id);
              this.pagina = 4;
            },
            devolucion(venta){
              this.getProductsVendidos(venta.id).then(response=>{
                this.ventaDevolucion = venta;
                this.pagina = 5;
                this.ventaDevolucion.products = response.data;
                console.log('Una devolucion');
              })
            },
            updateVenta(){
              this.getVentas();
              this.pagina = 1;

            }
           
        }
    }
</script>
