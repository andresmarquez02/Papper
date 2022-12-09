<template>
    <div style="word-break:break-all">
        <div class="list-group">
            <span class="p-0 mb-2 list-group-item list-group-item-action no-hover">
                <h2 class="text-center text-dark mb-0">
                    <img src="img/logo.png" style="height:4rem" alt="">
                </h2>
            </span>
            <span v-on:click="setShowNav">
                <router-link class="list-group-item list-group-item-action waves-effect" to="/">
                    <i class="fa fa-home mr-2" aria-hidden="true"></i>
                    {{ usuario ? 'Inicio' : 'Todos' }}
                </router-link>
            </span>
            <template v-if="usuario">
                <span v-on:click="setShowNav">
                    <span class="list-group-item list-group-item-action waves-effect" data-toggle="modal" data-target="#modelId">
                        <i class="fa fa-plus-circle mr-2" aria-hidden="true"></i>
                        Crear Publicación
                    </span>
                </span>
                <span v-on:click="setShowNav">
                    <router-link class="list-group-item list-group-item-action waves-effect" :to="{name: 'perfil'}">
                        <i class="fa fa-user-circle" aria-hidden="true"></i> &nbsp;
                        Perfil
                    </router-link>
                </span>
                <span v-on:click="setShowNav">
                    <router-link class="list-group-item list-group-item-action waves-effect" :to="{name: 'notificaciones'}">
                        <i class="fa fa-bell mr-2" aria-hidden="true"></i>&nbsp;
                        Notificaciones
                    </router-link>
                </span>
            </template>
            <span v-on:click="setShowNav">
                <router-link class="list-group-item list-group-item-action waves-effect" to="/populares">
                    <i class="fa fa-bullhorn mr-2" aria-hidden="true"></i>
                    Populares
                </router-link>
            </span>
            <span v-on:click="setShowNav">
                <router-link class="list-group-item list-group-item-action waves-effect" to="/recomendado">
                    <i class="fa fa-check-circle mr-2" aria-hidden="true"></i>
                    Recomendado
                </router-link>
            </span>
            <div id="accordianId" role="tablist" aria-multiselectable="true">
                <div>
                    <div role="tab" id="section1HeaderId">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordianId" href="#section1ContentId" aria-expanded="true" aria-controls="section1ContentId" class="list-group-item list-group-item-action waves-effect">
                                <i class="fa fa-check-circle mr-2" aria-hidden="true"></i>
                                Grupo
                            </a>
                        </h5>
                    </div>
                    <div id="section1ContentId" class="collapse in" role="tabpanel" aria-labelledby="section1HeaderId">
                        <span v-on:click="setShowNav" v-bind:key="grupo.id" v-for="grupo in grupos">
                            <router-link class="d-block px-4 py-1 text-muted"
                            :to="'../grupo/'+grupo.id" v-on:click="setShowNav">
                                {{ grupo.grupo }}
                            </router-link>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="js">
    import Vuex from "vuex";
    export default {
        computed: {
            ...Vuex.mapState(['usuario', 'grupos']),
        },
        methods: {
            ...Vuex.mapMutations(['setShowNav']),
        },
    }
</script>
