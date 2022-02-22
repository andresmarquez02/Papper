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
Vue.component('preguntas', require('./components/Preguntas.vue').default);
Vue.component('crear-pregunta', require('./components/CrearPregunta.vue').default);
Vue.component('filtrado-pregunta', require('./components/FiltradoPregunta.vue').default);
Vue.component('ver-pregunta', require('./components/VerPregunta.vue').default);
Vue.component('aside-left', require('./components/AsideLeft.vue').default);
Vue.component('comentario', require('./components/Comentario.vue').default);
Vue.component('inicio', require('./views/Inicio.vue').default);
Vue.component('perfil', require('./views/Perfil.vue').default);
Vue.component('notificaciones', require('./views/Notificaciones.vue').default);

import router from './routes/rutas.js'
import store from './store/store.js'

const app = new Vue({
    el: '#app',
    router,
    store,
});
