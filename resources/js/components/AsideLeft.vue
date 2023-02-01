<template>
    <div style="word-break:break-all">
        <div class="list-group">
            <span class="p-0 mb-2 list-group-item list-group-item-action no-hover">
                <h2 class="mb-0 text-center text-dark">
                    <img :src="$router.options.base+'img/logo.png'" style="height:4rem" alt="">
                </h2>
            </span>
            <template v-if="user">
                <template v-if="user.role_id === 1">
                    <div class="px-4 py-2 small text-uppercase muted--text" >
                        Opciones Admin
                    </div>
                    <span v-on:click="setShowNav">
                        <router-link class="list-group-item list-group-item-action waves-effect" :to="{name: 'categoriesAdmin'}">
                            <i class="fa fa-project-diagram" aria-hidden="true"></i> &nbsp;
                            Categorias
                        </router-link>
                    </span>
                    <span v-on:click="setShowNav">
                        <router-link class="list-group-item list-group-item-action waves-effect" :to="{name: 'denunciationsAdmin'}">
                            <i class="fa fa-fire" aria-hidden="true"></i> &nbsp;
                            Denuncias
                        </router-link>
                    </span>
                    <span v-on:click="setShowNav">
                        <router-link class="list-group-item list-group-item-action waves-effect" :to="{name: 'postsDenunciations'}">
                            <i class="fa fa-tags" aria-hidden="true"></i>&nbsp;
                            Publicaciones denunciadas
                        </router-link>
                    </span>
                    <span v-on:click="setShowNav">
                        <router-link class="list-group-item list-group-item-action waves-effect" :to="{name: 'users'}">
                            <i class="fa fa-users" aria-hidden="true"></i> &nbsp;
                            Usuarios
                        </router-link>
                    </span>
                    <div class="px-4 py-2 small text-uppercase muted--text" >
                        Opciones Generales
                    </div>
                </template>
            </template>
            <span v-on:click="setShowNav">
                <router-link class="list-group-item list-group-item-action waves-effect" to="/">
                    <i class="mr-2 fa fa-home" aria-hidden="true"></i>
                    {{ user ? 'Inicio' : 'Todos' }}
                </router-link>
            </span>
            <template v-if="user">
                <template v-if="user.role_id !== 1">
                    <span v-on:click="setShowNav">
                        <span class="list-group-item list-group-item-action waves-effect" data-toggle="modal" data-target="#modelId">
                            <i class="mr-2 fa fa-plus-circle" aria-hidden="true"></i>
                            Crear Publicación
                        </span>
                    </span>
                    <span v-on:click="setShowNav">
                        <router-link class="list-group-item list-group-item-action waves-effect" :to="{name: 'profile', params: {username: user.username}}">
                            <i class="fa fa-user-circle" aria-hidden="true"></i> &nbsp;
                            Perfil
                        </router-link>
                    </span>
                    <span v-on:click="setShowNav">
                        <router-link class="list-group-item list-group-item-action waves-effect" :to="{name: 'notifications'}">
                            <i class="mr-2 fa fa-bell" aria-hidden="true"></i>&nbsp;
                            Notificaciones
                        </router-link>
                    </span>
                </template>
            </template>
            <span v-on:click="setShowNav">
                <router-link class="list-group-item list-group-item-action waves-effect" to="/populars">
                    <i class="mr-2 fa fa-bullhorn" aria-hidden="true"></i>
                    Populares
                </router-link>
            </span>
            <span v-on:click="setShowNav">
                <router-link class="list-group-item list-group-item-action waves-effect" to="/recommends">
                    <i class="mr-2 fa fa-check-circle" aria-hidden="true"></i>
                    Recomendado
                </router-link>
            </span>
            <div id="accordianId" role="tablist" aria-multiselectable="true">
                <div>
                    <div role="tab" id="section1HeaderId">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordianId" href="#section1ContentId" aria-expanded="true" aria-controls="section1ContentId" class="list-group-item list-group-item-action waves-effect">
                                <i class="mr-2 fa fa-sitemap" aria-hidden="true"></i>
                                Categorias
                            </a>
                        </h5>
                    </div>
                    <div id="section1ContentId" class="collapse in" role="tabpanel" aria-labelledby="section1HeaderId">
                        <span v-on:click="setShowNav" v-bind:key="category.id" v-for="category in categories">
                            <router-link class="px-4 py-1 d-block text-muted"
                            :to="{name: 'categories', params: {id: category.id}}" v-on:click="setShowNav">
                                {{ category.category }}
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
            ...Vuex.mapState(['user', 'categories']),
        },
        methods: {
            ...Vuex.mapMutations(['setShowNav']),
        },
    }
</script>
<style>
    .muted--text{
        color: #6c757d80 !important
    }
</style>
