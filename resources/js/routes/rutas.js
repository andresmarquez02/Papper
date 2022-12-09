import Vue from 'vue'
import VueRouter from 'vue-router'

//Vistas
import Login from '../views/Login.vue'
import Registro from '../views/Registro.vue'
import Inicio from '../views/Inicio.vue'
import Populares from '../views/Populares.vue'
import Recomendado from '../views/Recomendado.vue'
import Grupos from '../views/Grupos.vue'
import Comentarios from '../views/Comentarios.vue'
import Cuatro from '../views/404.vue'
import MiPerfil from '../views/Perfil.vue'
import Notificaciones from '../views/Notificaciones.vue'

//Middlewares
import auth from '../middlewares/auth'
import log from '../middlewares/log'

Vue.use(VueRouter);

const router = new VueRouter({
    base: process.env.BASE_URL,
    // mode: 'history',
    routes: [{
            path: '/',
            name: 'principal',
            component: Inicio,
        },
        {
            path: '/comentarios/:id',
            name: 'comentarios',
            component: Comentarios,
        },
        {
            path: '/recomendado',
            name: 'recomendado',
            component: Recomendado
        },
        {
            path: '/populares',
            name: 'populares',
            component: Populares,
        },
        {
            path: '/grupo/:id',
            name: 'grupo',
            component: Grupos,
        },
        // Rutas para cuando esten deslogueados
        {
            path: '/login',
            name: 'papper_login',
            component: Login,
            meta: {
                middleware: auth
            }
        },
        {
            path: '/register',
            name: 'papper_register',
            component: Registro,
            meta: {
                middleware: auth
            }
        },
        // Rutas para cuando esten logueados
        {
            path: '/perfil',
            name: 'perfil',
            component: MiPerfil,
            meta: {
                middleware: log
            }
        },
        {
            path: '/notificaciones',
            name: 'notificaciones',
            component: Notificaciones,
            meta: {
                middleware: log
            }
        },
        // Ruta 404
        {
            path: '*',
            component: Cuatro,
        },
    ]
});

function nextFactory(context, middleware, index) {
    const subsequentMiddleware = middleware[index];
    if (!subsequentMiddleware) return context.next;

    return (...parameters) => {
        context.next(...parameters);
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({...context, next: nextMiddleware });
    };
}

router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware) ?
            to.meta.middleware : [to.meta.middleware];

        const context = {
            from,
            next,
            router,
            to,
        };
        const nextMiddleware = nextFactory(context, middleware, 1);

        return middleware[0]({...context, next: nextMiddleware });
    }
    return next();
});

export default router;