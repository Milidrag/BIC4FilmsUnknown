/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import vue from 'vue';

window.Vue = vue;
import { NavbarPlugin } from 'bootstrap-vue';
Vue.use(NavbarPlugin);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('query-message', require('./components/base/QueryMessage.vue').default);
Vue.component('datatable-light', require('./components/base/DatatableLight.vue').default);
Vue.component('dialog-modal', require('./components/base/DialogModal.vue').default);
Vue.component('dialog-form-input', require('./components/base/DialogFormInput.vue').default);
Vue.component('dialog-form-select', require('./components/base/DialogFormSelect.vue').default);
Vue.component('dialog-control', require('./components/DialogControl.vue').default);
Vue.component('table-control', require('./components/TableControl.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    // data: function() {
    //     return {
    //         allFilms: []
    //     }
    // },
    // created() {
    //     axios.get('/public/index.php/list/film').then(res => (
    //         // console.log(res)
    //         this.allFilms = res.data
    //     ) );
    // }
});
