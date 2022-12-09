// Bootstrap
require('./bootstrap');

// Vue
window.Vue = require('vue');

// Componentes principales
Vue.component('papper', require('./Papper.vue').default);

// Vistas
Vue.component('login', require('./views/Login.vue').default);
Vue.component('registro', require('./views/Registro.vue').default);

// Componentes
// Componentes de preguntas
Vue.component('preguntas', require('./components/Preguntas.vue').default);
Vue.component('Pregunta', require('./components/Pregunta.vue').default);
Vue.component('ModalEditarPregunta', require('./components/ModalEditarPregunta.vue').default);
Vue.component('ModalEliminarPregunta', require('./components/ModalEliminarPregunta.vue').default);
Vue.component('crear-pregunta', require('./components/CrearPregunta.vue').default);
Vue.component('filtrado-pregunta', require('./components/FiltradoPregunta.vue').default);
Vue.component('ver-pregunta', require('./components/VerPregunta.vue').default);
Vue.component('aside-left', require('./components/AsideLeft.vue').default);
Vue.component('comentario', require('./components/Comentario.vue').default);
Vue.component('navBar', require('./components/NavBar.vue').default);
Vue.component('contenido', require('./components/Contenido.vue').default);
Vue.component('eliminarComentario', require('./components/EliminarComentario.vue').default);

// Rutas
import router from './routes/rutas.js'

// Estado
import store from './store/store.js'
import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

// Instancia de vue
const app = new Vue({
    el: '#app',
    router,
    store,
});