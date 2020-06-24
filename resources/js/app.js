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

window.Form = Form;
window.Swal = Swal;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


Vue.use(VueRouter)
let routes = [
    { path: '/dashboard', component: require('./components/DashboardComponent.vue').default},
    { path: '/profile', component: require('./components/ProfileComponent.vue').default},
    { path: '/users', component: require('./components/UsersComponent.vue').default},
    { path: '/users-create', component: require('./components/CreateUserComponent.vue').default},
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
        try{
            return value.charAt(0).toUpperCase() + value.slice(1)
        } catch {
            console.error('text to uppercase is null or has no value');
        }
    });

    // this filter changes the date to an EU format
    Vue.filter('euDate', function (date) {
        try{
            return moment(date).subtract(1, 'days').format("DD MM YYYY");
        } catch {
            console.error('displaying the date in the eu format was not possible maybe because it\'s null or has no value');
        }
    });

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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
