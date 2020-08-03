import Toasted from 'vue-toasted';
import VuePaginate from 'vue-paginate';
import moment from 'moment';
import VueMoment from 'vue-moment';

// Load Locales ('en' comes loaded by default)
require('moment/locale/es');

// Choose Locale
moment.locale('es');

const $ = require('jquery');
window.$ = $

require('./bootstrap');
window.Vue = require('vue');

Vue.component('pagination', require('laravel-vue-pagination'));
//Home
Vue.component('sectionhome-component', require('./components/Home/SectionHomeComponent.vue').default);
// Inventario
Vue.component('sectionproducts-component', require('./components/Inventario/SectionProductsComponent.vue').default);
Vue.component('tableproducts-component', require('./components/Inventario/TableProductsComponent.vue').default);
Vue.component('formproducts-component', require('./components/Inventario/FormProductsComponent.vue').default);
Vue.component('formcategorias-component', require('./components/Inventario/FormCategoriasComponent.vue').default);
Vue.component('tablecategorias-component', require('./components/Inventario/TableCategoriasComponent.vue').default);
Vue.component('tablefiltro-component', require('./components/Inventario/TableFiltroComponent.vue').default);
Vue.component('resumeninventario-component', require('./components/Inventario/ResumenComponent.vue').default);
Vue.component('precioproducts-component', require('./components/Inventario/PrecioProductsComponent.vue').default);
Vue.component('filtroproducts-component', require('./components/Inventario/FiltroProductsComponent.vue').default);

// Ventas
Vue.component('sectionventas-component', require('./components/Ventas/SectionVentasComponent.vue').default);
Vue.component('formventas-component', require('./components/Ventas/FormVentasComponent.vue').default);
Vue.component('formcuentas-component', require('./components/Ventas/FormCuentasComponent.vue').default);
Vue.component('formsena-component', require('./components/Ventas/FormSenaComponent.vue').default);
Vue.component('tableventas-component', require('./components/Ventas/TableVentasComponent.vue').default);
Vue.component('tablecuentas-component', require('./components/Ventas/TableCuentasComponent.vue').default);
Vue.component('modalclientes-component', require('./components/Ventas/ModalClientVentasComponent.vue').default);
Vue.component('modalproducts-component', require('./components/Ventas/ModalProductVentasComponent.vue').default);
Vue.component('cuenta-component', require('./components/Ventas/CuentaVentasComponent.vue').default);
Vue.component('devolucion-component', require('./components/Ventas/DevolucionVentasComponent.vue').default);
// Clientes
Vue.component('sectionclientes-component', require('./components/Clientes/SectionClientesComponent.vue').default);
Vue.component('tableclientes-component', require('./components/Clientes/TableClientesComponent.vue').default);
Vue.component('formclientes-component', require('./components/Clientes/FormClientesComponent.vue').default);
// Informacion
Vue.component('informacionsection-component', require('./components/Informacion/informacionSectionComponent.vue').default);
Vue.component('resumenInformacion-component', require('./components/Informacion/ResumenInformacionComponent.vue').default);
// Proveedores
Vue.component('sectionproveedores-component', require('./components/Proveedores/SectionProveedoresComponent.vue').default);
Vue.component('formproveedores-component', require('./components/Proveedores/FormProveedoresComponent.vue').default);
Vue.component('tableproveedores-component', require('./components/Proveedores/TableProveedoresComponent.vue').default);
Vue.component('detalleproveedores-component', require('./components/Proveedores/DetalleProveedoresComponent.vue').default);
// Precio
Vue.component('preciosection-component', require('./components/Atajos/SectionPrecioComponent.vue').default);
Vue.use(Toasted);
Vue.use(VuePaginate);
Vue.use(moment);
Vue.use(VueMoment,{moment});


const app = new Vue({
    el: '#app',
    data :{
        menu : 1,
        notifications: []
    }
});
