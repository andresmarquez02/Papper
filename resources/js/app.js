/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

Vue.component('papper', require('./components/Papper.vue').default);
Vue.component('login', require('./views/Login.vue').default);
Vue.component('registro', require('./views/Registro.vue').default);
Vue.component('papper-home', require('./components/HomePapper.vue').default);
Vue.component('preguntas', require('./views/Preguntas.vue').default);
Vue.component('crear-pregunta', require('./views/CrearPregunta.vue').default);
Vue.component('filtrado-pregunta', require('./views/FiltradoPregunta.vue').default);
Vue.component('ver-pregunta', require('./views/VerPregunta.vue').default);
Vue.component('aside-left', require('./views/AsideLeft.vue').default);
Vue.component('aside-right', require('./views/AsideRight.vue').default);
Vue.component('inicio', require('./components/Inicio.vue').default);

import router from './rutas.js'
import store from './store.js'

const app = new Vue({
    el: '#app',
    router,
    store,
});
