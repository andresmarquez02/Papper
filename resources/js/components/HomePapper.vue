<template>
    <div class="img_home" style="background-attachment: fixed">
       <header class="fixed-top">
            <nav class="navbar navbar-expand-sm bg-purple-blue shadow navbar-dark">
                <a class="navbar-brand" href="#" v-on:click.prevent="por_grupo(0)">{{ $store.state.usuario.nombre_apellido }}</a>
                <button class="navbar-toggler btn btn-light rounded-pill d-lg-none" type="button" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation" data-toggle="modal" data-target="#modelId">Crear publicación</button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                           <span type="button" class="nav-link h5" data-toggle="modal" data-target="#modelId">
                                Crear publicación
                            </span>
                        </li>
                        <li class="nav-item" :class="inicio" v-on:click.prevent="por_grupo(0)">
                             <router-link :to="{name: 'inicio'}" class="nav-link h5">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Inicio</router-link>
                        </li>
                        <li class="nav-item" :class="perfil" v-on:click.prevent="por_grupo('-2')">
                             <router-link :to="{name: 'inicio'}" class="nav-link h5">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            Perfil</router-link>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link h5" href="#" type="button" id="triggerIds" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" v-on:click.prevent="notificaciones_generales()">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                Notificaciones
                                <span class="sr-only">Notificaciones</span>
                            </a>
                            <div class="dropdown-menu w-100" style="min-width:15rem;max-height: 90vh;
                            overflow-y: auto;overflow-x:hidden;" aria-labelledby="triggerIds">
                                <p class="px-3 d-flex justify-content-end">
                                    <i class="fa fa-retweet bg-dark text-white rounded-circle p-2" v-on:click="notificaciones_recall()"
                                    aria-hidden="true"></i>
                                </p>
                                <a class="dropdown-item" href="#" v-for="notificacion in $store.state.notificaciones">
                                    {{ notificacion.descripcion }}
                                </a>
                                <a class="dropdown-item" href="#" v-if="$store.state.notificaciones == ''">
                                No tienes notificaciones</a>
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
       <router-view></router-view>
       <div class="fixed-bottom bg-purple-blue d_sm_block">
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
                            <a class="nav-link btn btn-light" href="#" type="button" id="triggerIds" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                <span class="sr-only">Notificaciones</span>
                            </a>
                            <div class="dropdown-menu w-100" style="min-width:15rem;max-height: 90vh;
                            overflow-y: auto;overflow-x:hidden;" aria-labelledby="triggerIds">
                                <p class="px-3 d-flex justify-content-end">
                                    <i class="fa fa-retweet bg-dark text-white rounded-circle p-2" v-on:click="notificaciones_recall()"
                                    aria-hidden="true"></i>
                                </p>
                                <a class="dropdown-item" href="#" v-for="notificacion in $store.state.notificaciones">
                                    {{ notificacion.descripcion }}
                                </a>
                                <a class="dropdown-item" href="#" v-if="$store.state.notificaciones == ''">
                                No tienes notificaciones</a>
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
    mounted() {
        this.pregg();
        location.hash = "/inicio";
    },
    data(){
        return{
            inicio: 'active',
            perfil: '',
        }
    },
    methods: {
        pregg(){
            this.$store.dispatch('preguntas_get');
            this.$store.dispatch('datos_user');
            this.$store.dispatch('groups');
        },
        por_grupo(value){
            if(value == '-2'){
                this.inicio = "";
                this.perfil= "active";
            }
            else{
                this.inicio = "active";
                this.perfil= "";
            }
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
