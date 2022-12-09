<template>
    <div>
        <div class="bg-black-30 h-100 position-absolute w-100" :class="showNav ? 'd-block' : 'd-none'" style="z-index:5" v-on:click="setShowNav()"></div>
        <div class="pt-3 bg-light min-vh-100 d-flex align-items-stretch content-body">
            <!-- Barra lateral -->
            <div class="py-4 px-2 bg-white position-fixed asidebar" :class="showNav">
                <aside-left />
            </div>
            <!-- Fin de barra lateral -->
            <!-- Contenido -->
            <div class="w-100">
                <main class="px-4">
                    <!-- Barra superior -->
                    <div class="p-3 bg-white rounded-lg shadow-sm d-flex">
                        <span class="nav-item d-flex align-items-center button-asidenav mr-2" v-on:click="setShowNav">
                            <i class="fa fa-bars mr-2" aria-hidden="true"></i>
                        </span>
                        <filtrado-pregunta/>
                        <navBar></navBar>
                    </div>
                    <!-- Fin de la barra superior -->
                </main>
                <div class="m-0 row text-dark">
                    <!-- Preguntas -->
                    <div class="px-4 col-12" id="centetro">
                        <slot></slot>
                    </div>
                    <!-- FIn de preguntas -->
                </div>
                <crear-pregunta />
            </div>
            <!-- FIn de contenido -->
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex'
    export default {
        methods: {
            ...Vuex.mapMutations(['setShowNav']),
        },
        computed: {
            ...Vuex.mapState(['showNav']),
        },
    }
</script>
