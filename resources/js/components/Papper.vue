<template>
    <div class="img_home">
        <nav class="navbar navbar-expand-sm navbar-dark w-100 fixed-top shadow-lg" id="nav_bar">
            <a class="navbar-brand" href="#/">Papper</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" v-on:click="bar()" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <router-link id="get" v-on:click="buttons(1)" class="nav-link" :to="{name: 'papper_login'}">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link id="gett" v-on:click="buttons(2)" class="nav-link" :to="{name: 'papper_register'}">Registro</router-link>
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
        let loged = localStorage.getItem("logueado")
        if(loged === null)localStorage.setItem("logueado","No");

    },
    data(){
        return {
            active: '',
            active2: '',
            pulse: 0,
        }
    },
    methods: {
        buttons(value){
            if(value === 1){
                localStorage.setItem('active','1');
                localStorage.setItem('grupo','0')
            }
            else if(value === 2){
                localStorage.setItem('active','2');
                localStorage.setItem('grupo','0')
            }
        },
        bar(){
            let top = document.getElementById('nav_bar');
            if(this.pulse == 0){
                top.classList.add("bg-purple-blue-2");
                this.pulse = 1;
            }
            else{
                top.classList.remove("bg-purple-blue-2");
                this.pulse = 0;
            }
        }
    },
}
</script>
