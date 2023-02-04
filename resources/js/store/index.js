import Vue from 'vue'
import Vuex from 'vuex'
import { myFetch } from '../helper/myFetch';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        posts: [],
        user: null,
        categories: [],
        notifications: [],
        id: '',
        notPosts: '',
        postId: '',
        showNav: '',
        usernameProfile: 0,
        userProfile: [],
        countPosts: 0
    },
    mutations: {
        setPosts(state, data) {
            let { posts } = data.res;
            state.posts = posts
            if (state.posts == "") {
                state.notPosts = "No hay publicaciones hechas...";
            }
        },

        setCategories(state, data) {
            state.categories = data.res.categories
        },

        setUser(state, data) {
            if (data.status === 200) {
                state.user = data.res.user;
                localStorage.setItem("authenticate", true);
                localStorage.setItem("role", state.user.role_id);
            } else {
                localStorage.setItem("authenticate", false);
                localStorage.setItem("role", 0);
            }
        },

        setNotifications(state, data) {
            state.notifications = data.res.notifications;
        },

        setShowNav(state) {
            window.onresize = function() {
                if (document.querySelector('body').clientWidth <= 840) {
                    if (state.showNav) {
                        document.querySelector('body').classList.remove("modal-open");
                        return state.showNav = "";
                    }
                    state.showNav = "showNav";
                    document.querySelector('body').classList.add("modal-open");
                }
            }
            if (document.querySelector('body').clientWidth <= 840) {
                if (state.showNav) {
                    document.querySelector('body').classList.remove("modal-open");
                    return state.showNav = "";
                }
                state.showNav = "showNav";
                document.querySelector('body').classList.add("modal-open");
            }
        },

        loading(state, type) {
            // Selector de carga
            let carga = document.querySelector("#carga");
            if (type) {
                // Poner el loading en marcha
                carga.classList.remove("d-none");
                carga.classList.add("d-flex");
            } else {
                // Quitar el loading
                carga.classList.remove("d-flex");
                carga.classList.add("d-none");
            }
        },
        deletePostStore(state, postId) {
            state.posts = state.posts.filter(post => (post.id != postId));
        }
    },
    actions: {
        async getPosts({ commit, state }) {
            commit("loading", 1);
            let response = await myFetch().get("posts");
            commit('setPosts', response);
            commit("loading", 0);
        },

        async getPostsPopulars({ commit, state }) {
            commit("loading", 1);
            let response = await myFetch().get("posts/populars");
            commit('setPosts', response);
            commit("loading", 0);
        },

        async getPostsRecommends({ commit, state }) {
            commit("loading", 1);
            let response = await myFetch().get("posts/recommends");
            commit('setPosts', response);
            commit("loading", 0);
        },

        async getPostsByCategory({ commit, state }) {
            commit("loading", 1);
            let response = await myFetch().get(`posts/${state.postId}`);
            commit("loading", 0);
            commit('setPosts', response);
        },

        async getPostsDenuncied({ commit, state }) {
            commit("loading", 1);
            let response = await myFetch().get(`admin/posts/denuncied`);
            commit("loading", 0);
            commit('setPosts', response);
        },

        async getPostsUser({ commit, state }) {
            commit("loading", 1);
            let response = await myFetch().get(`profile/${state.usernameProfile}`);
            commit('setPosts', response);
            state.userProfile = response.res.user;
            state.countPosts = response.res.countPosts;
            commit("loading", 0);
        },

        async getUser({ commit }) {
            if (localStorage.getItem("authenticate") == "true") {
                commit("loading", 1);
                let response = await myFetch().post('user', { body: {} });
                commit("loading", 0);
                commit('setUser', response);
            }
        },

        async getCategories({ commit }) {
            commit("loading", 1);
            try {
                let response = await myFetch().get('categories');
                commit('setCategories', response);
            } catch (error) {
                alertify.error("ha ocurrido un error, porfavor recarga la pagina");
            }
            commit("loading", 0);
        },

        async getNotifications({ commit, state }) {
            commit("loading", 1);
            try {
                let response = await myFetch().get('notifications');
                commit('setNotifications', response);
            } catch (error) {
                alertify.error("ha ocurrido un error, porfavor recarga la pagina");
            }
            commit("loading", 0);
        },
    },
})
