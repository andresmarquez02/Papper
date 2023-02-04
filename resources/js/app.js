// Bootstrap
require('./bootstrap');
// Vue
window.Vue = require('vue').default;
// Componentes principales
Vue.component('papper', require('./Papper.vue').default);
// Componentes de estructuras de la aplicacion
Vue.component('aside-left', require('./components/AsideLeft.vue').default);
Vue.component('nav-bar', require('./components/NavBar.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);

// Componentes de publicaciones
Vue.component('posts', require('./components/Posts.vue').default);
Vue.component('post', require('./components/Post.vue').default);
Vue.component('edit-post', require('./components/EditPost.vue').default);
Vue.component('delete-post', require('./components/DeletePost.vue').default);
Vue.component('create-post', require('./components/CreatePost.vue').default);
Vue.component('search-post', require('./components/SearchPost.vue').default);
Vue.component('denuncied-post', require('./components/DenunciedPost.vue').default);

// Componentes de comentarioss
Vue.component('see-post', require('./components/SeePost.vue').default);
Vue.component('commentary', require('./components/Commentary.vue').default);
Vue.component('delete-commentary', require('./components/DeleteCommentary.vue').default);
Vue.component('create-commentary', require('./components/CreateCommentary.vue').default);

// Componentes ADMIN
// Componentens de categorias ADMIN
Vue.component('editsert-category', require('./components/admin/CreateEditCategory.vue').default);
Vue.component('status-category', require('./components/admin/StatusCategory.vue').default);
// Componentes de denuncias ADMIN
Vue.component('editsert-denunciation', require('./components/admin/CreateEditDenunciation.vue').default);
Vue.component('status-denunciation', require('./components/admin/StatusDenunciation.vue').default);
// COmponentes de publicaciones denunciados
Vue.component('denunciations-post', require('./components/admin/DenunciationsPost.vue').default);
// Componentes para usuarios
Vue.component('user', require('./components/admin/User.vue').default);


// Rutas
import router from './routes/index.js'
// Estado
import store from './store/index.js'
// Vuelidate para las validaciones
import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

// Instancia de vue
const app = new Vue({
    el: '#app',
    router,
    store,
});
