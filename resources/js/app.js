/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import {Form, HasError, AlertError } from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2'
import {store} from "./store/store";

// import axios from 'axios'

// axios.defaults.baseURL = "api/"

window.Form = Form;
window.Swal = Swal;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


Vue.use(VueRouter)
let routes = [
    { path: '/dashboard', component: require('./views/DashboardComponent.vue').default},
    { path: '/profile', component: require('./views/ProfileComponent.vue').default},
    { path: '/users', component: require('./views/UsersComponent.vue').default},
    { path: '/users-create', component: require('./views/CreateUserComponent.vue').default},
    { path: '/users-edit/:id', component: require('./views/CreateUserComponent.vue').default},
    { path: '/users-details/:id', component: require('./views/showUserComponent.vue').default},
  ]


  const router = new VueRouter({
    mode: "history",
    routes // short for `routes: routes`
  })

// --------------------------------------------------------------------

const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

    Vue.use(VueProgressBar, options)

    // this filter makes text to uppercase
    Vue.filter('upText', function(value){
        if (!value) { return }
        return value.charAt(0).toUpperCase() + value.slice(1)
    });

    // this filter changes the date to an EU format
    Vue.filter('euDate', function (date) {
        try{
            return moment(date).subtract(1, 'days').format("DD.MM.YYYY");
        } catch {
            console.error('displaying the date in the eu format was not possible maybe because it\'s null or has no value');
        }
    });



/**
 * The following block of code may be used to automatically register your
 * Vue views. It will recursively scan this directory for the Vue
 * views and automatically register them with their "basename".
 *
 * Eg. ./views/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./views/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding views to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store: store,
    el: '#app',
    router
});
