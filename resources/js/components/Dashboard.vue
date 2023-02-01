<template>
    <div>
        <div class="bg-black-30 h-100 position-absolute w-100" :class="showNav ? 'd-block' : 'd-none'" style="z-index:5" v-on:click="setShowNav()"></div>
        <div class="pt-3 bg-light min-vh-100 d-flex align-items-stretch content-body">
            <!-- Barra lateral -->
            <div class="px-2 py-4 overflow-auto bg-white position-fixed asidebar" :class="showNav">
                <aside-left />
            </div>
            <!-- Fin de barra lateral -->
            <!-- Contenido -->
            <div class="w-100 d-flex flex-column" style="min-height:97vh;">
                <main class="px-4">
                    <!-- Barra superior -->
                    <div class="p-3 bg-white rounded-lg shadow-sm d-flex">
                        <span class="mr-2 nav-item d-flex align-items-center button-asidenav" v-on:click="setShowNav">
                            <i class="mr-2 fa fa-bars" aria-hidden="true"></i>
                        </span>
                        <search-post/>
                        <nav-bar />
                    </div>
                    <!-- Fin de la barra superior -->
                </main>
                <div class="m-0 row text-dark">
                    <div class="px-4 my-3 col-12">
                        <span class="btn btn-text-dark waves-effect rounded-circle" v-on:click="() =>  $router.go(-1)">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="btn btn-text-dark waves-effect rounded-circle" v-on:click="() =>  this.$router.go(1)">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                    <!-- Publicaciones -->
                    <div class="px-4 col-12" id="centetro">
                        <slot></slot>
                    </div>
                    <!-- FIn de publicaciones -->
                </div>
                <create-post />
                <div class="px-0 pt-3 pb-4 mt-auto text-center col-12" style="max-height: 70px;">
                    <a href="https://andresmarquez02.github.io/" target="_blank"> <i class="fa fa-heart text-danger" aria-hidden="true"></i> Creado por Andres Marquez - {{ date.getFullYear() }}</a>
                </div>
            </div>
            <!-- FIn de contenido -->
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex'
    export default {
        data() {
            return {
                date: new Date(),
            }
        },
        methods: {
            ...Vuex.mapMutations(['setShowNav']),
        },
        computed: {
            ...Vuex.mapState(['showNav']),
        },
    }
</script>
