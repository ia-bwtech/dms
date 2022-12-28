/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

// import moment from 'moment';
import moment from 'moment-timezone';
moment.tz.setDefault('America/New_York');
import VueContentPlaceholders from 'vue-content-placeholders';
import Swal from 'sweetalert2';
import Vue from 'vue';
import LaravelVuePagination from 'laravel-vue-pagination';

window.Swal = Swal;

Vue.prototype.moment = moment;
Vue.use(VueContentPlaceholders);
// Vue.use(LaravelVuePagination);

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
Vue.component('odds-component', require('./components/odds.vue').default);
Vue.component('leaderboard-component', require('./components/leaderboard.vue').default);
Vue.component('verified-component', require('./components/Verified.vue').default);
Vue.component('hunch-records', require('./components/hunch-records.vue').default);
Vue.component('top-sports', require('./components/HomeTopSportsCappers.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
