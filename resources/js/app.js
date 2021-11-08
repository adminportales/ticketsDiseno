/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./scripts/crearTicket');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

Vue.component('change-photo', require('./components/ChangePhoto.vue').default);
Vue.component('notify', require('./components/Notify.vue').default);
Vue.component('change-priority', require('./components/ChangePriority.vue').default);
Vue.component('change-designer-assigment', require('./components/ChangeDesignerAssigment.vue').default);
Vue.component('change-status-designer', require('./components/ChangeStatusDesigner.vue').default);
Vue.component('apex', require('./components/Apex.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
*/

const app = new Vue({
    el: '#appVue',
});
