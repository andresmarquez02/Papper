import Vue from 'vue'
import Vuex from 'vuex'
import { myFetch } from '../helper/myFetch';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        preguntas: [],
        usuario: null,
        grupos: [],
        likes_generales: [],
        referencia_grupo: [],
        notificaciones: [],
        commentarios: [],
        likes_comentarios: [],
        nombre_filtrar: localStorage.getItem('grupo'),
        nombre: '',
        id: '',
        vermas: '',
        token: '',
        buscador: '',
        no_encontro_nada: '',
        pregunta: '',
        esLike: "",
        comentario: '',
        contador: 0,
        id_pregunta: '',
        showNav: '',
    },
    mutations: {
        setPreguntas(state, datos) {
            let { preguntas } = datos.res;
            state.contador = 0;
            state.preguntas = preguntas
            if (state.preguntas == "") {
                state.no_encontro_nada = "No hay resultados...";
            }
        },
        get_grupos(state, datos) {
            state.grupos = datos
                // console.log(datos);
        },
        usuarios(state, datos) {
            state.usuario = datos
            localStorage.setItem("logueado", "Si");
            // console.log(datos);
        },
        get_notificaciones(state, datos) {
            let pre = document.getElementById('carga')
            pre.classList.remove('d-flex');
            pre.classList.add('d-none');
            state.notificaciones = datos;
        },
        get_comentarios(state, datos) {
            state.commentarios = datos.comentarios;
            state.pregunta = datos.pregunta;
            state.esLike = datos.esLike;
            state.comentario = "";
            state.likes_comentarios = datos.likes_comentarios;
            let pre = document.getElementById('carga')
            pre.classList.remove('d-flex');
            pre.classList.add('d-none');
        },
        setToken(state, token) {
            state.token = token;
        },
        setShowNav(state) {
            window.onresize = function() {
                if (document.querySelector('body').clientWidth <= 840) {
                    if (state.showNav) {
                        return state.showNav = "";
                    }
                    state.showNav = "showNav";
                }
            }
            if (document.querySelector('body').clientWidth <= 840) {
                if (state.showNav) {
                    return state.showNav = "";
                }
                state.showNav = "showNav";
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
        }
    },
    actions: {
        get_usuarios({ commit }) {
            fetch('users')
                .then(data => data.json())
                .then(data => {
                    commit('traerDatos', data);
                })
        },
        get_information({ commit }) {
            fetch('datos')
                .then(data => data.json())
                .then(data => {
                    commit('datos', data);
                })
        },

        async preguntas({ commit, state }) {
            commit("loading", 1);
            let resultado = await myFetch().get("preguntas");
            commit("loading", 0);
            commit('setPreguntas', resultado);
        },

        async preguntasPopulares({ commit, state }) {
            commit("loading", 1);
            let resultado = await myFetch().get("preguntas/populares");
            commit("loading", 0);
            commit('setPreguntas', resultado);
        },

        async preguntasRecomendadas({ commit, state }) {
            commit("loading", 1);
            let resultado = await myFetch().get("preguntas/recomendadas");
            commit("loading", 0);
            commit('setPreguntas', resultado);
        },

        async preguntasPorGrupo({ commit, state }) {
            commit("loading", 1);
            let resultado = await myFetch().get(`preguntas/${state.referencia_grupo}`);
            commit("loading", 0);
            commit('setPreguntas', resultado);
        },

        async buscarPreguntas({ commit, state }) {
            commit("loading", 1);
            let resultado = await myFetch().get(`preguntas/buscar/{grupo}/{palabra}`);
            commit("loading", 0);
            commit('setPreguntas', resultado);
        },

        async datos_user({ commit }) {
            let token = document.querySelector('meta#token').getAttribute('content');
            try {
                const consulta = await fetch('usuario', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                })
                const respuesta = await consulta.json();
                commit('usuarios', respuesta);
            } catch (error) {

            }
        },

        async groups({ commit }) {
            try {
                const consulta = await fetch('grupos');
                const respuesta = await consulta.json();
                commit('get_grupos', respuesta);
            } catch (error) {
                alertify.error("ha ocurrido un error, porfavor recarga la pagina de grupo");
            }
        },

        async notificaciones_ver({ commit, state }) {
            let pre = document.getElementById('carga')
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            if (state.notificaciones == "") {
                try {
                    const consulta = await fetch('notificaciones');

                    const respuesta = await consulta.json();
                    commit('get_notificaciones', respuesta);
                } catch (error) {
                    alertify.error("ha ocurrido un error, porfavor recarga la pagina");
                }
            } else {
                commit('get_notificaciones', state.notificaciones);
            }
        },

        async notificaciones_ver_recall({ commit, state }) {
            let pre = document.getElementById('carga')
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            try {
                const consulta = await fetch('notificaciones');

                const respuesta = await consulta.json();
                commit('get_notificaciones', respuesta);
            } catch (error) {
                alertify.error("ha ocurrido un error, porfavor recarga la pagina");
            }

        },
        async comentarios({ commit, state }) {
            commit("loading", 1);
            try {
                const response = await myFetch().get('comentarios/' + state.id_pregunta);
                commit('get_comentarios', response);
            } catch (error) {
                alertify.error("ha ocurrido un error, porfavor recarga la pagina");
            }
            commit("loading", 0);
        },
        async enviar_comentario({ state }) {
            try {
                const response = await myFetch().post('enviar/comentarios/' + state.pregunta.id, {
                    body: { 'comentario': state.comentario }
                });
                if (response.status === 200) {
                    this.dispatch('comentarios');
                    alertify.success("Publicado");
                } else {
                    throw (response.res);
                }
            } catch (error) {
                alertify.error("ha ocurrido un error, porfavor recarga la pagina");
            }
        }
    },
})