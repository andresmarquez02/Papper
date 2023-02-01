import Vue from 'vue'
import VueRouter from 'vue-router'

//Vistas
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Index from '../views/Index.vue'
import Populars from '../views/Populars.vue'
import Recommends from '../views/Recommends.vue'
import Categories from '../views/Categories.vue'
import Commentaries from '../views/Commentaries.vue'
import PageNotFound from '../views/PageNotFound.vue'
import Profile from '../views/Profile.vue'
import Notifications from '../views/Notifications.vue'
// Componentes Admin
import CategoriesAdmin from '../views/admin/Categories.vue'
import DenunciationsAdmin from '../views/admin/Denunciations.vue'
import PostsDenunciations from '../views/admin/PostsDenunciations.vue'
import Users from '../views/admin/Users.vue'

//Middlewares
import guest from '../middlewares/guest'
import auth from '../middlewares/auth'
// Middleware Admin
import admin from '../middlewares/admin'

Vue.use(VueRouter);

const router = new VueRouter({
    base: 'http://127.0.0.1:8000/',
    // mode: 'history',
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index,
        },
        {
            path: '/commentaries/:id',
            name: 'commentaries',
            component: Commentaries,
        },
        {
            path: '/recommends',
            name: 'recommends',
            component: Recommends
        },
        {
            path: '/populars',
            name: 'populars',
            component: Populars,
        },
        {
            path: '/categories/:id',
            name: 'categories',
            component: Categories,
        },
        // Rutas para cuando esten deslogueados
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                middleware: guest
            }
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                middleware: guest
            }
        },
        // Rutas para cuando esten logueados
        {
            path: '/profile/:username',
            name: 'profile',
            component: Profile,
            meta: {
                middleware: auth
            }
        },
        {
            path: '/notifications',
            name: 'notifications',
            component: Notifications,
            meta: {
                middleware: auth
            }
        },
        // RUTAS ADMIN
        {
            path: '/admin/categories',
            name: 'categoriesAdmin',
            component: CategoriesAdmin,
            meta: {
                middleware: auth,
                middleware: admin,
            }
        },
        {
            path: '/admin/denunciations',
            name: 'denunciationsAdmin',
            component: DenunciationsAdmin,
            meta: {
                middleware: auth,
                middleware: admin,
            }
        },
        {
            path: '/admin/posts/denunciations',
            name: 'postsDenunciations',
            component: PostsDenunciations,
            meta: {
                middleware: auth,
                middleware: admin,
            }
        },
        {
            path: '/admin/users',
            name: 'users',
            component: Users,
            meta: {
                middleware: auth,
                middleware: admin,
            }
        },
        // Ruta 404
        {
            path: '*',
            component: PageNotFound,
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
