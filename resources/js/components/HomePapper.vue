<template>
    <div>
        <header class="fixed-top">
            <nav class="navbar navbar-expand-md navbar-dark bg-purple-blue">
                <a class="navbar-brand" href="#/inicio" v-on:click.prevent="por_grupo(0)">{{ $store.state.usuario !== null ? $store.state.usuario.nombre_apellido : '' }}</a>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation" v-on:click="navbar()">
                    <i class="fa" :class="icon_nav" aria-hidden="true"></i>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="mt-2 ml-auto navbar-nav mt-lg-0">
                        <li class="nav-item">
                            <span type="button" class="nav-link" data-toggle="modal" data-target="#modelId">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;
                                Crear publicación
                            </span>
                        </li>
                        <li class="nav-item" v-on:click.prevent="por_grupo(0)">
                            <router-link :to="{name: 'inicio'}" class="nav-link">
                                <i class="fa fa-home" aria-hidden="true"></i>&nbsp;
                                Inicio
                            </router-link>
                        </li>
                        <li class="nav-item" v-on:click.prevent="por_grupo('-2')">
                            <router-link :to="{name: 'perfil'}" class="nav-link">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                                Perfil
                            </router-link>
                        </li>
                        <li class="nav-item dropdown d-md-block d-none">
                            <span class="nav-link" type="button" id="triggerIds" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" v-on:click.prevent="notificaciones_generales()">
                                <i class="fa fa-bell" aria-hidden="true"></i>&nbsp;
                                Notificaciones
                            </span>
                            <div class="dropdown-menu w-100" style="min-width:25.5rem;max-height: 90vh;
                            overflow-y: auto;overflow-x:hidden;left:-10rem;top:3.35rem" aria-labelledby="triggerIds">
                                <p class="px-3 d-flex justify-content-end">
                                    <span class="border border-dark rounded-circle d-flex justify-content-center align-items-center" style="height:2rem;width:2rem" role="button">
                                        <i class="fa fa-retweet" v-on:click="notificaciones_recall()"
                                    aria-hidden="true"></i>
                                    </span>
                                </p>
                                <router-link class="dropdown-item" v-for="notificacion in $store.state.notificaciones" :key="notificacion.id"
                                :to="'/comentarios/'+notificacion.id_pregunta">
                                    {{ notificacion.descripcion }}
                                </router-link>
                                <span class="dropdown-item" v-if="$store.state.notificaciones == ''">
                                No tienes notificaciones</span>
                            </div>
                        </li>
                        <li class="nav-item dropdown d-md-none d-block">
                            <router-link :to="{name: 'notificaciones'}" class="nav-link">
                                <i class="fa fa-bell" aria-hidden="true"></i>&nbsp;
                                Notificaciones
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link" role="button" v-on:click="logout()" data-toggle="tooltip" data-placement="top"
                            title="Salir">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;
                                Salir
                            </span>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div>
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
export default {
    created() {
        this.pregg();
    },
    data() {
        return {
            icon_nav: 'fa-bars'
        }
    },
    mounted() {
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
        },
        logout(){
            localStorage.setItem("logueado","No");
            location.href = "./logout";
        },
        navbar(){
            if( this.icon_nav === "fa-bars")
                return this.icon_nav = "fa-times";
            this.icon_nav = "fa-bars"
        }
    },
}
</script>
