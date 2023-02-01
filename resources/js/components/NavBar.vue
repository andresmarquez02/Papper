<template>
    <div class="ml-auto">
        <div class="">
            <ul class="ml-auto nav">
                <template v-if="!user">
                    <li class="nav-item">
                        <router-link class="nav-link text-dark" :to="{name: 'login'}">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link text-dark" :to="{name: 'register'}">Registro</router-link>
                    </li>
                </template>
                <template v-if="user">
                    <li class="nav-item dropdown dropdown-menu-left">
                        <span class="nav-link dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ user !== null ? user.username : '' }}
                        </span>
                        <div class="dropdown-menu drop-menu-left" aria-labelledby="triggerId">
                            <router-link :to="{name: 'profile', params: {username: user.username}}" class="dropdown-item">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                                Perfil
                            </router-link>
                            <span class="dropdown-item" role="button" v-on:click="logout()" data-toggle="tooltip" data-placement="top" title="Salir">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;
                                Salir
                            </span>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex';
    export default {
        methods: {
            // Funcion para desloguarme
            logout(){
                localStorage.setItem("authenticate", false);
                localStorage.setItem("role",0);
                location.href = "./logout";
            },
        },
        computed: {
            ...Vuex.mapState(['user']),
        },
    }
</script>
<style lang="css">
    .drop-menu-left{
        transform: translate3d(-52px, 41px, 0px) !important;
    }
</style>
