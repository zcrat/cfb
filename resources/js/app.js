
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import Vuex from 'vuex'
import VueToastr2 from 'vue-toastr-2';
import 'vue-toastr-2/dist/vue-toastr-2.min.css';

import vSelect from 'vue-select';

import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

import BootstrapVue from 'bootstrap-vue'

import VueSignaturePad from 'vue-signature-pad';

import Multiselect from 'vue-multiselect';





window.toastr = require('toastr');
require('./bootstrap');

window.$ = window.jQuery = require('jquery');
window.Vue = require('vue');
Vue.use(BootstrapVue);
Vue.use(VueToastr2);
Vue.component('v-select', vSelect);
Vue.use(Datetime);
Vue.use(VueSignaturePad);
Vue.use(Vuex);
Vue.component('multiselect', Multiselect);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('empresa-component', require('./components/EmpresaComponent.vue').default);
Vue.component('customer-component', require('./components/CustomerComponent.vue').default);
Vue.component('recepcion-vehicular-component', require('./components/RecepcionVehicularComponent.vue').default);
Vue.component('articulo-component', require('./components/Articulo.vue').default);
Vue.component('categoria-component', require('./components/Categoria.vue').default);
Vue.component('dashboard-component', require('./components/Dashboard.vue').default);
Vue.component('ingreso-component', require('./components/Ingreso.vue').default);
Vue.component('proveedor-component', require('./components/Proveedor.vue').default);
Vue.component('venta-component', require('./components/Venta.vue').default);
Vue.component('cliente-component', require('./components/Cliente.vue').default);
Vue.component('usuario-component', require('./components/User.vue').default);
Vue.component('rol-component', require('./components/Rol.vue').default);
Vue.component('cingreso-component', require('./components/ConsultaIngreso.vue').default);
Vue.component('cventa-component', require('./components/ConsultaVenta.vue').default);
Vue.component('notification-component', require('./components/Notification.vue').default);
Vue.component('cotizacion-component', require('./components/Cotizacion.vue').default);
Vue.component('facturacion-component', require('./components/Facturas.vue').default);
Vue.component('config-factura-component', require('./components/config_factura.vue').default);
Vue.component('reporte-inspeccion-component', require('./components/ReporteInspeccionVehicular.vue').default);
Vue.component('hoja-de-conceptos-component', require('./components/HojaDeConceptos.vue').default);
Vue.component('reporte-grua-component', require('./components/ReporteGrua.vue').default);
Vue.component('orden-compra-component', require('./components/ordenCompra.vue').default);
Vue.component('orden-reparacion-component', require('./components/ordenReparacion.vue').default);
Vue.component('asgnar-tecnico-recepcion', require('./components/AsignarTecnicoRecepcion.vue').default);
Vue.component('mi-recepciones',require('./components/MiRecepciones.vue').default);
Vue.component('sucursales-component',require('./components/Sucursales.vue').default);
Vue.component('cotizacion2021-component', require('./components/Cotizacion2021.vue').default);
Vue.component('productos-grupos-component', require('./components/ProductosGrupos.vue').default);
Vue.component('bancos-component', require('./components/Bancos.vue').default);
Vue.component('cuentas-component', require('./components/Cuentas.vue').default);
Vue.component('operaciones-caja-component', require('./components/OperacionesCaja.vue').default);
Vue.component('presupuesto-component', require('./components/Presupuestos.vue').default);
Vue.component('ordenes-component', require('./components/Ordenes.vue').default);
Vue.component('aprobaciones-taller-component', require('./components/AprobacionesTaller.vue').default);
Vue.component('aprobaciones-cfe-component', require('./components/AprobacionesCFE.vue').default);
Vue.component('presupuestos-akumas-component', require('./components/PresupuestosAkumas.vue').default);
Vue.component('aprobaciones-akumas-component', require('./components/AprobacionesAkumas.vue').default);
Vue.component('reportes-akumas-component', require('./components/ReportesAkumas.vue').default);
Vue.component('contratos-component', require('./components/Contratos.vue').default);
Vue.component('cuentasporcobrar-component', require('./components/CuentasPorCobrar.vue').default);
Vue.component('inicio-cfe-component', require('./components/inicioCfe.vue').default);
Vue.component('inicio-akumas-component', require('./components/inicioAkumas.vue').default);
Vue.component('aprobaciones-cfe2-component', require('./components/AprobacionesCFEAll.vue').default);
Vue.component('ubicaciones-component', require('./components/Ubicaciones.vue').default);
Vue.component('areas-component', require('./components/Areas.vue').default);
Vue.component('categorias-cfe-component', require('./components/CategoriasCFE.vue').default);
Vue.component('categorias-akumas-component', require('./components/CategoriasAkumas.vue').default);
Vue.component('tipos-cfe-component', require('./components/TiposCFE.vue').default);
Vue.component('tipos-akumas-component', require('./components/TiposAkumas.vue').default);
Vue.component('conceptos-cfe-component', require('./components/ConceptosCFE.vue').default);
Vue.component('conceptos-akumas-component', require('./components/ConceptosAkumas.vue').default);
Vue.component('operaciones-bancos-component', require('./components/OperacionesBancos.vue').default);
Vue.component('saldos-component', require('./components/Saldos.vue').default);
Vue.component('facturas-contrato-component', require('./components/FacturasPorContrato.vue').default);

Vue.component('ordenesb2023-component', require('./components/OrdenesB2023.vue').default);
Vue.component('presupuestob2023-component', require('./components/PresupuestosB2023.vue').default);
Vue.component('aprobaciones-tallerb2023-component', require('./components/AprobacionesTallerB2023.vue').default);
Vue.component('aprobaciones-cfeb2023-component', require('./components/AprobacionesCFEB2023.vue').default);
Vue.component('aprobaciones-cfe2b2023-component', require('./components/AprobacionesCFEAllB2023.vue').default);
Vue.component('inicio-cfeb2023-component', require('./components/inicioCfeB2023.vue').default);
Vue.component('cventab2023-component', require('./components/ConsultaVentaB2023.vue').default);

Vue.component('ordeneso2023-component', require('./components/OrdenesO2023.vue').default);
Vue.component('presupuestoo2023-component', require('./components/PresupuestosO2023.vue').default);
Vue.component('aprobaciones-tallero2023-component', require('./components/AprobacionesTallerO2023.vue').default);
Vue.component('aprobaciones-cfeo2023-component', require('./components/AprobacionesCFEO2023.vue').default);
Vue.component('aprobaciones-cfe2o2023-component', require('./components/AprobacionesCFEAllO2023.vue').default);
Vue.component('inicio-cfeo2023-component', require('./components/inicioCfeO2023.vue').default);
Vue.component('cventao2023-component', require('./components/ConsultaVentaO2023.vue').default);

Vue.component('tareas-component', require('./components/Tareas.vue').default);
Vue.component('tareas-admin-component', require('./components/TareasAdmin.vue').default);

Vue.component('presupuestos-akumas2023-component', require('./components/PresupuestosAkumas2023.vue').default);
Vue.component('aprobaciones-akumas2023-component', require('./components/AprobacionesAkumas2023.vue').default);
Vue.component('reportes-akumas2023-component', require('./components/ReportesAkumas2023.vue').default);
Vue.component('inicio-akumas2023-component', require('./components/inicioAkumas2023.vue').default);

Vue.component('tecnicos-component', require('./components/Tecnicos.vue').default);
Vue.component('trasladistas-component', require('./components/Trasladistas.vue').default);
Vue.component('vehiculos-component', require('./components/Vehiculos.vue').default);
Vue.component('tareaseje-component', require('./components/TareasEjecutivas.vue').default);

Vue.component('conceptos-akumas2023-component', require('./components/ConceptosAkumas2023.vue').default);

Vue.component('recepcion-vehicular-bajio2022', require('./components/RecepcionBajio2022.vue').default);
Vue.component('recepcion-vehicular-bajio2023', require('./components/RecepcionBajio2023.vue').default);
Vue.component('recepcion-vehicular-occidente2023', require('./components/RecepcionOccidente2023.vue').default);
Vue.component('recepcion-vehicular-akumas', require('./components/RecepcionAkumas.vue').default);
Vue.component('recepcion-vehicular-akumas2023', require('./components/RecepcionAkumas2023.vue').default);


Vue.component('entradas-salidas-component', require('./components/EntradasSalidas.vue').default);
Vue.component('ordenes-pagadas-component', require('./components/OrdenesPagadas.vue').default);
Vue.component('ordenes-foraneas-component', require('./components/OrdenesForaneas.vue').default);
Vue.component('es-foraneas-component', require('./components/ESForaneas.vue').default);


Vue.component('acuse-foraneos-component', require('./components/AnexosForaneosAcuse.vue').default);
Vue.component('anexos-foraneos-component', require('./components/AnexosForaneos.vue').default);
Vue.component('aprobaciones-foraneos-component', require('./components/AnexosForaneosAprobaciones.vue').default);
Vue.component('start-foraneos-component', require('./components/AnexosForaneosStart.vue').default);
Vue.component('reportes-foraneos-component', require('./components/AnexosForaneosReportes.vue').default);

Vue.component('conceptos-foraneos-component', require('./components/ConceptosForaneos.vue').default);
Vue.component('categorias-foraneos-component', require('./components/CategoriasForaneas.vue').default);
Vue.component('tipos-foraneos-component', require('./components/TiposForaneos.vue').default);

Vue.component('hoja-conceptos-akumas-2023-component', require('./components/HojaConceptosA2023.vue').default);
Vue.component('hoja-conceptos-akumas-component', require('./components/HojaConceptosA.vue').default);
Vue.component('hoja-conceptos-occidente-2023-component', require('./components/HojaConceptosO2023.vue').default);
Vue.component('hoja-conceptos-bajio-2023-component', require('./components/HojaConceptosB2023.vue').default);



Vue.component('categorias-akumas2024-component', require('./components/CategoriasAkumas2024.vue').default);
Vue.component('tipos-akumas2024-component', require('./components/TiposAkumas2024.vue').default);



Vue.component('recepcion-cfe-eco', require('./components/RecepcionCFEECO.vue').default);
Vue.component('hoja-conceptos-cfe-eco-component', require('./components/HojaConceptosCFEECO.vue').default);
Vue.component('ordenes-cfe-eco-component', require('./components/OrdenesCFEECO.vue').default);
Vue.component('presupuestoo-cfe-eco-component', require('./components/PresupuestosCFEECO.vue').default);
Vue.component('aprobaciones-taller-cfe-eco-component', require('./components/AprobacionesTallerCFEECO.vue').default);

Vue.component('recepcion-akumas-eco', require('./components/RecepcionAkumasECO.vue').default);
Vue.component('hoja-conceptos-akumas-eco-component', require('./components/HojaConceptosAkumasECO.vue').default);
Vue.component('ordenes-akumas-eco-component', require('./components/PresupuestosAkumasEco.vue').default);
Vue.component('aprobaciones-taller-akumas-eco-component', require('./components/AprobacionesAkumasEco.vue').default);


Vue.component('acuse-foraneos-eco-component', require('./components/AnexosForaneosAcuseEco.vue').default);
Vue.component('anexos-foraneos-eco-component', require('./components/AnexosForaneosEco.vue').default);
Vue.component('aprobaciones-foraneos-eco-component', require('./components/AnexosForaneosAprobacionesEco.vue').default);
Vue.component('start-foraneos-eco-component', require('./components/AnexosForaneosStartEco.vue').default);
Vue.component('reportes-foraneos-eco-component', require('./components/AnexosForaneosReportesEco.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const store = new Vuex.Store({
    state:{ 
        menuc: 0
    },
    mutations:{
        facturacion(state) {
            state.menuc = 15
          },
        presupuestosAkumas(state) {
            state.menuc = 34
          },
        presupuestosAkumas2023(state) {
            state.menuc = 69
        },
        presupuestosOccidente2023(state) {
            state.menuc = 60
        },
        presupuestosBajio2023(state) {
            state.menuc = 53
        },
        presupuestosBajio2022(state) {
            state.menuc = 31
        },
        hojaConceptos(state) {
            state.menuc = 18
        }
    }

});
const app = new Vue({
    el: '#app',
    store:store,
    data :{
        menu : 0,
        notifications: []
    },
    created() {
        let me = this;
        axios.post('notification/get').then(function(response){
            //console.log(response.data);
            me.notifications=response.data;
        }).catch(function(error){
            console.log(error);
        });

        //var userId = $('meta[name="userId"]').attr('content');

        //Echo.private('App.User.' + userId).notification((notification) => {
           // console-log(notification);
          //  me.notifications.unshift(notification);
       // });
    }
});
