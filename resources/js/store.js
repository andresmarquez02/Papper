import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        personas:[],
        cargos:[],
        paises:[],
        regiones:[],
        preguntas:[],
        usuario:[],
        grupos: [],
        likes_generales: [],
        referencia_grupo: [],
        notificaciones: [],
        commentarios: [],
        nombre_filtrar: localStorage.getItem('grupo'),
        nombre: '',
        id: '',
        vermas: '',
        token: '',
        buscador: '',
        no_encontro_nada: '',
        pregunta: '',
        esLike:"",
        comentario: '',
        contador: 0,
        act_user: 'opopopop',
        enCarrito: '',
    },
    mutations:{
        traerDatos(state,datos){
            let orden = localStorage.getItem('orden');
            let orden_final = orden ? orden.split(',') : [];
            let pasar = [];
            if(orden_final != ""){
                for(var i = 0;i < orden_final.length;i++){
                    for(var j = 0;j < datos.length;j++){
                        if(datos[j].id == orden_final[i]){
                            pasar.push(datos[j]);
                        }
                    }
                }
                state.personas = pasar;
            }
            else{
                state.personas = datos
            }
        },
        datos(state,datos){
            state.cargos = datos.cargos
            state.paises = datos.paises
            // console.log(datos);
        },
        get_preguntas(state,datos){
            state.contador = 0;
            state.preguntas = datos.preguntas
            state.referencia_grupo = datos.grupo
            if(state.preguntas == ""){
                state.no_encontro_nada = "No hay resultados...";
            }else{
                state.no_encontro_nada = "";
            }
            let pre = document.getElementById('carga');
            pre.classList.remove('d-flex');
            pre.classList.add('d-none');
            // state.likes_generales = datos.likes
            // console.log(datos);
        },
        get_grupos(state,datos){
            state.grupos = datos
            // console.log(datos);
        },
        usuarios(state,datos){
            state.usuario = datos
            // console.log(datos);
        },
        get_notificaciones(state,datos){
            state.notificaciones = datos;
        },
        get_comentarios(state,datos){
            state.commentarios = datos;
            state.comentario = "";
            let pre = document.getElementById('carga')
            pre.classList.remove('d-flex');
            pre.classList.add('d-none');
        }
    },
    actions: {
        get_usuarios({commit}){
            fetch('users')
            .then(data => data.json())
            .then(data => {
                commit('traerDatos',data);
            })
        },
        get_information({commit}){
            fetch('datos')
            .then(data => data.json())
            .then(data => {
                commit('datos',data);
            })
        },
        async preguntas_get({commit,state}){
            let token = document.querySelector('meta#token').getAttribute('content');
            let pre = document.getElementById('carga')
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            state.nombre_filtrar = localStorage.getItem('grupo');
            try {
                const consulta = await fetch('preguntas/'+state.nombre_filtrar,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const resultado = await consulta.json();
                // console.log(resultado);
                commit('get_preguntas',resultado);
            } catch (error) {
                const consulta = await fetch('preguntas/'+state.nombre_filtrar,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const resultado = await consulta.json();
                commit('get_preguntas',resultado);
            }
        },
        async datos_user({commit}){
            let token = document.querySelector('meta#token').getAttribute('content');
            try{
                const consulta = await fetch('usuario',{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                })
                const respuesta = await consulta.json();
                commit('usuarios',respuesta);
            }catch(error){
                const consulta = await fetch('usuario',{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                })
                const respuesta = await consulta.json();
                commit('usuarios',respuesta);
            }
        },
        async groups({commit}){
            try{
                const consulta = await fetch('grupos');
                const respuesta = await consulta.json();
                commit('get_grupos',respuesta);
            }catch(error){
                const consulta = await fetch('grupos');
                const respuesta = await consulta.json();
                commit('get_grupos',respuesta);
            }
        },
        async notificaciones_ver({commit,state}){
            if(state.notificaciones == ""){
                try{
                    const consulta = await fetch('notificaciones');
                    const respuesta = await consulta.json();
                    commit('get_notificaciones',respuesta);
                }catch(error){
                    const consulta = await fetch('notificaciones');
                    const respuesta = await consulta.json();
                    commit('get_notificaciones',respuesta);
                }
            }
            else{
                commit('get_notificaciones',state.notificaciones);
            }
        },
        async notificaciones_ver_recall({commit,state}){
            try{
                const consulta = await fetch('notificaciones');
                const respuesta = await consulta.json();
                commit('get_notificaciones',respuesta);
            }catch(error){
                const consulta = await fetch('notificaciones');
                const respuesta = await consulta.json();
                commit('get_notificaciones',respuesta);
            }
        },
        async comentarios({commit,state}){
            let pre = document.getElementById('carga');
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            let token = document.querySelector('meta#token').getAttribute('content');
            try{
                const consulta = await fetch('comentarios/'+state.pregunta.id,{
                    method: 'POST',
                    headers:{
                        'X-CSRF-TOKEN': token
                    }
                });
                const respuesta = await consulta.json();
                commit('get_comentarios',respuesta);
            }catch(error){
                const consulta = await fetch('comentarios/'+state.pregunta.id,{
                    method: 'POST',
                    headers:{
                        'X-CSRF-TOKEN': token
                    }
                });
                const respuesta = await consulta.json();
                commit('get_comentarios',respuesta);
            }

        },
        async enviar_comentario({state}){
            try{
                let token = document.querySelector('meta#token').getAttribute('content');
                let formulario = new FormData();
                formulario.append('comentario',state.comentario);
                const consulta = await fetch('enviar/comentarios/'+state.pregunta.id,{
                    method: 'POST',
                    body: formulario,
                    headers:{
                        'X-CSRF-TOKEN': token
                    }
                });
                const respuesta = await consulta.text();
                if(respuesta == "1"){
                    this.dispatch('comentarios');
                    alertify.success("Publlicado");
                }
                else{
                    alertify.error("Error inesperado por favor vuela a enviar el comentario");
                }
            }
            catch(error){}
        }
    },
})
