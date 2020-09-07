/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import Vue from "vue";
import VueRouter from 'vue-router'
import DateFilter from './common/date.filter'
import SentenceCaseFilter from './common/sentenceCase.filter'
import limitCharFilter from './common/lmitChar.filter'
import booleanFilter from './common/boolen.filter'
import Swal from 'sweetalert2'
import store from "./store";
import Gate from "./Gate"
import i18n from "./i18n"

window.Swal = Swal;
window.Slug = require('slug');

Slug.defaults.mode = 'rfc3986';
Vue.config.productionTip = false;

Vue.use(VueRouter)
Vue.component('web-main', require('./webMain.vue').default);
Vue.component('admin-main', require('./adminMain.vue').default);

const router = new VueRouter({
    mode: "history",
    routes: [
        { path: '/dashboard', component: require('./views/DashboardComponent.vue').default},
        { path: '/profile', component: require('./views/profile/ProfileComponent.vue').default},
        { path: '/users', component: require('./views/user/UsersComponent.vue').default},
        { path: '/users/:id', name: 'showUser', component: require('./views/user/ShowUserComponent.vue').default},
        { path: '/users/create', name: 'createUser', component: require('./views/user/CreateUserComponent.vue').default},
        { path: '/users/edit/:id', name: 'editUser', component: require('./views/user/CreateUserComponent.vue').default},
        { path: '/developer', component: require('./views/developerComponent.vue').default},
        { path: '/articles', name: 'articles', component: require('./views/article/ArticleComponent.vue').default},
        { path: '/articles/:slug', name: 'showArticles', component: require('./views/article/ShowArticleComponent.vue').default},
        { path: '/articles/create', name: 'createArticles', component: require('./views/article/EditArticleComponent.vue').default},
        { path: '/articles/edit/:slug', name: 'editArticles', component: require('./views/article/EditArticleComponent.vue').default},
        // { path: '', name: 'home', components: { web: require('./views/HomeComponent.vue').default}},
        // { path: '/blog', name: 'blog', components:{ web: require('./views/blog/BlogComponent.vue').default }},
        // { path: '/me', name: 'me', components:{ web: require('./views/about/AboutComponent.vue').default }},

        { path: '/:locale',
            components: { web: require('./views/parentComponent.vue').default },
            beforeEnter: (to, from, next) => {
                const locale = to.params.locale
                const supported_locales = ('en,de,al').split(',');

                if (!supported_locales.includes(locale)) { return next('en')}
                if (i18n.locale !== locale) {
                    i18n.locale = locale;
                }
                return next()
            },
            children: [
                {
                    path: '',
                    name: 'Home',
                    components: { web: require('./views/HomeComponent.vue').default }
                },
                {
                    path: 'me',
                    name: 'me',
                    components:{ web: require('./views/about/AboutComponent.vue').default }
                },
                {
                    path: 'blog',
                    name: 'blog',
                    components: { web: require('./views/blog/BlogComponent.vue').default}
                },
                {
                    path: '*',
                    redirect() {
                        require('./views/HomeComponent.vue').default
                    }
                }
            ]
        },
        { path: '*', components: { web: require('./views/HomeComponent.vue').default }},
    ] // short for `routes: routes`
})

// gate prototype
Vue.prototype.$gate = new Gate(window.user);

// this filter makes text to uppercase
Vue.filter("upText", SentenceCaseFilter);
// this filter changes the date to an EU format
Vue.filter('euDate', DateFilter);
// limit Character display
Vue.filter('str_limit', limitCharFilter)
// display boolean value
Vue.filter('bool', booleanFilter)

/**
 * The following block of code may be used to automatically register your
 * Vue views. It will recursively scan this directory for the Vue
 * views and automatically register them with their "basename".
 *
 * Eg. ./views/DashboardComponent.vue -> <example-component></example-component>
 */

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./views/DashboardComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding views to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    i18n,
    store: store,
    el: '#app',
    router
});
