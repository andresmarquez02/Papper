<template>
    <div class="img_home">
        <nav class="navbar navbar-expand-sm navbar-dark w-100 fixed-top shadow-lg" id="nav_bar">
            <a class="navbar-brand" href="#">Papper</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" v-on:click="bar()" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item pb-xs-3">
                        <span class="mr-2 " :class="active" v-on:click="buttons(1)">
                            <router-link class="btn btn-light rounded-pill" id="get" :to="{name: 'papper_login'}">Login</router-link>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span :class="active2" v-on:click="buttons(2)">
                            <router-link class="btn btn-dark rounded-pill" id="gett" :to="{name: 'papper_register'}">Registro</router-link>
                        </span>
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
                top.classList.add("bg-purple-blue");
            }
            else{
                top.classList.remove("bg-purple-blue");
            }
        }
        let token = document.querySelector('meta#token').getAttribute('content');
        this.$store.state.token = token;
    },
    data(){
        return {
            active: 'active',
            active2: '',
            pulse: 0,
        }
    },
    methods: {
        buttons(value){
            if(value === 1){
                this.active = "active";
                this.active2 = "";
                localStorage.setItem('active','1');
                localStorage.setItem('grupo','0')
            }
            else if(value === 2){
                this.active2 = "active";
                this.active = "";
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
