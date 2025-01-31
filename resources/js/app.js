/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios';

Vue.use(axios);
import BootstrapVue from 'bootstrap-vue';
// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Vuelidate from 'vuelidate';
import Multiselect from 'vue-multiselect';
import ImageUploader from 'vue-image-upload-resize'


Vue.use(ImageUploader);
import 'vue-multiselect/dist/vue-multiselect.min.css'
// register globally
Vue.component('multiselect', Multiselect)
import SuiVue from 'semantic-ui-vue';
import VueMoment from 'vue-moment';

Vue.use(VueMoment);
Vue.use(Vuelidate);
Vue.use(BootstrapVue);
Vue.use(SuiVue);
// import 'semantic-ui-css/semantic.min.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor );
import { DataTables, DataTablesServer } from 'vue-data-tables'
Vue.use(DataTables)
Vue.use(DataTablesServer)

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('asset-list', require('./components/assets/assets-list.vue').default);
Vue.component('asset-details', require('./components/Pages/Assets/AssetDetails').default);
Vue.component('create-new-asset', require('./components/assets/CreateNewAsset').default);
Vue.component('add-component-to-asset', require('./components/components/ComponentModalForm').default);

Vue.component('component-list', require('./components/components/components-list').default);
Vue.component('component-index', require('./components/components/ComponentIndex').default);
Vue.component('customers-list', require('./components/Customers/CustomersList.vue').default);
Vue.component('customer-details', require('./components/Customers/CustomerDetails.vue').default);
Vue.component('customer-create-form', require('./components/Customers/CustomerCreateForm.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
});
