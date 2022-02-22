<template>
    <div class="img_home">
        <nav class="navbar navbar-expand-sm navbar-dark bg-purple-blue w-100 fixed-top" id="nav_bar">
            <a class="navbar-brand" href="#/">Papper</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" v-on:click="navbar()" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa" :class="icon_nav" aria-hidden="true"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="mt-2 ml-auto navbar-nav mt-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'papper_login'}">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'papper_register'}">Registro</router-link>
                    </li>
                </ul>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    mounted() {
        let token = document.querySelector('meta#token').getAttribute('content');
        this.$store.state.token = token;
        let loged = localStorage.getItem("logueado")
        if(loged === null)localStorage.setItem("logueado","No");
        else localStorage.setItem("logueado","No");

    },
    data(){
        return {
            icon_nav: 'fa-bars'
        }
    },
    methods: {
        navbar(){
            if( this.icon_nav === "fa-bars")
                return this.icon_nav = "fa-times";
            this.icon_nav = "fa-bars"
        }
    },
}
</script>
