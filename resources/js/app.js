/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries.
 */

require('./bootstrap');
import VueRouter from 'vue-router';

window.Vue = require('vue');

import { BTable } from 'bootstrap-vue';
import { Form } from 'vform';

Vue.component('b-table', BTable);

Vue.use(VueRouter);

window.Form = Form;

const routes = [
    {path: '/', component: require('./components/MovieBooking.vue').default},
    {path: '/registration', component: require('./components/Registration.vue').default},
    {path: '/login', component: require('./components/Login.vue').default},
    {path: '/logout', component: require('./components/Logout.vue').default},
    {path: '/booking-history', component: require('./components/BookingHistory.vue').default},
    {path: '/booking-cancel-show', component: require('./components/BookingCancel').default}
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: '#app',
    router: router
});
