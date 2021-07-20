<template>
    <div class="img_home" style="background-attachment: fixed">
       <header class="fixed-top">
            <nav  class="navbar navbar-expand-md navbar-dark w-100 fixed-top shadow-lg" id="nav_bar">
                <a class="navbar-brand" href="#/inicio" v-on:click.prevent="por_grupo(0)">{{ $store.state.usuario.nombre_apellido }}</a>
                <button class="navbar-toggler btn btn-light rounded-pill d-lg-none" type="button" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation" data-toggle="modal" data-target="#modelId">Crear publicación</button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                           <span type="button" class="nav-link h5" data-toggle="modal" data-target="#modelId">
                                Crear publicación
                            </span>
                        </li>
                        <li class="nav-item" v-on:click.prevent="por_grupo(0)">
                             <router-link :to="{name: 'inicio'}" class="nav-link h5">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Inicio</router-link>
                        </li>
                        <li class="nav-item" v-on:click.prevent="por_grupo('-2')">
                            <router-link :to="{name: 'perfil'}" class="nav-link h5">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            Perfil</router-link>
                        </li>
                        <li class="nav-item dropdown">
                            <span class="nav-link h5" type="button" id="triggerIds" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" v-on:click.prevent="notificaciones_generales()">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                Notificaciones
                                <span class="sr-only">Notificaciones</span>
                            </span>
                            <div class="dropdown-menu w-100" style="min-width:15rem;max-height: 90vh;
                            overflow-y: auto;overflow-x:hidden;" aria-labelledby="triggerIds">
                                <p class="px-3 d-flex justify-content-end">
                                    <span class="border border-dark rounded-circle d-flex justify-content-center align-items-center" style="height:2rem;width:2rem" role="button">
                                        <i class="fa fa-retweet" v-on:click="notificaciones_recall()"
                                    aria-hidden="true"></i>
                                    </span>
                                </p>
                                <span class="dropdown-item" v-for="notificacion in $store.state.notificaciones" :key="notificacion.id">
                                    {{ notificacion.descripcion }}
                                </span>
                                <span class="dropdown-item" v-if="$store.state.notificaciones == ''">
                                No tienes notificaciones</span>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h5" href="./logout">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                Salir
                                <span class="sr-only">Salir</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
       </header>
       <div style="min-height:100vh"><router-view></router-view></div>
        <div class="fixed-bottom bg-purple-blue d-md-none d-block">
            <div class="d-flex justify-content-center w-100">
                <div>
                    <ul class="nav my-1">
                        <li class="nav-item active mr-2" v-on:click.prevent="por_grupo(0)">
                            <router-link :to="{name: 'inicio'}" class="nav-link btn btn-light" data-toggle="tooltip"
                            data-placement="top" title="Inicio">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span class="sr-only">Inicio</span></router-link>
                        </li>
                        <li class="nav-item active mr-2" v-on:click.prevent="por_grupo('-2')">
                            <router-link :to="{name: 'inicio'}" class="nav-link btn btn-light" data-toggle="tooltip"
                             data-placement="top" title="Mi perfil">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            <span class="sr-only">Mi perfil</span></router-link>
                        </li>
                        <li class="nav-item dropdown mr-2" data-toggle="tooltip" data-placement="top"
                            title="Notificaciones">
                            <span class="nav-link btn btn-light" type="button" id="triggerIds" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                <span class="sr-only">Notificaciones</span>
                            </span>
                            <div class="dropdown-menu w-100" style="min-width:15rem;max-height: 90vh;
                            overflow-y: auto;overflow-x:hidden;" aria-labelledby="triggerIds">
                                <p class="px-3 d-flex justify-content-end">
                                    <span class="bg-dark text-white rounded-circle d-flex justify-content-center align-items-center" style="height:2rem;width:2rem" role="button">
                                        <i class="fa fa-retweet" v-on:click="notificaciones_recall()"
                                    aria-hidden="true"></i>
                                    </span>
                                </p>
                                <span class="dropdown-item" v-for="notificacion in $store.state.notificaciones" :key="notificacion.id">
                                    {{ notificacion.descripcion }}
                                </span>
                                <span class="dropdown-item" v-if="$store.state.notificaciones == ''">
                                No tienes notificaciones</span>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-light" href="./logout" data-toggle="tooltip" data-placement="top"
                            title="Salir">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span class="sr-only">Salir</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    created() {
        this.pregg();
        if(location.hash !== "#/comentarios" && location.hash !== "#/perfil") location.hash ="/inicio";
    },
    mounted() {
        let top = document.getElementById('nav_bar');
        window.onscroll = function(){
            var y = window.scrollY;
            if(y > 20){
                top.classList.remove("top");
                top.classList.add("bg-purple-blue");
            }
            else{
                top.classList.add("top");
                top.classList.remove("bg-purple-blue");
            }
        }
        let token = document.querySelector('meta#token').getAttribute('content');
        this.$store.state.token = token;
        let container = document.querySelector(".dropdown-menu");
        container.addEventListener("click", (event) => event.stopPropagation());
    },
    methods: {
        pregg(){
            this.$store.dispatch('preguntas_get');
            this.$store.dispatch('datos_user');
            this.$store.dispatch('groups');
        },
        por_grupo(value){
            localStorage.setItem('grupo',value)
            this.$store.dispatch('preguntas_get');
        },
        notificaciones_generales(){
            this.$store.dispatch('notificaciones_ver');
        },
        notificaciones_recall(){
            this.$store.dispatch('notificaciones_ver_recall');
        }
    },
}
</script>
