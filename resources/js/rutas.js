import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './views/Login.vue'
import Registro from './views/Registro.vue'
import Preguntas from './components/Inicio.vue'
import Comentarios from './components/Comentarios.vue'
import Cuatro from './components/404.vue'

Vue.use(VueRouter);
export default new VueRouter({
    base: process.env.BASE_URL,
    routes: [
        {
            path:'/',
            name: 'papper_login',
            component: Login
        },
        {
            path:'/register',
            name: 'papper_register',
            component: Registro
        },
        {
            path:'/comentarios',
            name: 'comentarios',
            component: Comentarios
        },
        {
            path:'/inicio',
            name: 'inicio',
            component: Preguntas
        },
        {
            path:'/no-back-button',
            name: 'atras',
            component: Login
        },
        {
            path:'*',
            component: Cuatro
        },
    ]
});
