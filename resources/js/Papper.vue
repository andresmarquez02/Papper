<template>
    <div class="position-relative">
        <router-view></router-view>
        <a href="https://github.com/andresmarquez02" target="_blank" class="shadow-sm position-fixed rounded-circle bg-dark d-flex justify-content-center align-items-center text-decoration-none btn-whatsapp" style="right:5.2rem;">
            <i class="mb-0 text-white fa fa-github h4" aria-hidden="true"></i>
        </a>
        <a href="https://api.whatsapp.com/send/?phone=%2B584129298833&text&app_absent=0" target="_blank" class="shadow-sm position-fixed rounded-circle bg-success d-flex justify-content-center align-items-center text-decoration-none btn-whatsapp">
            <i class="mb-0 text-white fa fa-whatsapp h4" aria-hidden="true"></i>
        </a>
    </div>
</template>
<script>
    import Vuex from 'vuex'
    export default {
        created() {
            // Categorias
            this.getCategories();
            // Datos de los usuarios
            this.getUser();
        },
        mounted() {
            // Obetencion de variable de localStorage para saber si esta logueado
            let authenticate = localStorage.getItem("authenticate")
            // Verificacion de logueo
            if(authenticate === null){
                localStorage.setItem("authenticate",false);
            }
        },
        methods: {
            ...Vuex.mapActions(['getCategories','getUser']),
        },
    }
</script>
<style>
    .btn-whatsapp{
        height:50px;
        width:50px;
        bottom:1.5rem;
        right:1.5rem;
        z-index: 5000;
    }
</style>
