<template>
    <div class="ml-auto">
        <ul class="ml-auto nav">
            <template v-if="!usuario">
                <li class="nav-item">
                    <router-link class="nav-link text-dark" :to="{name: 'papper_login'}">Login</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link text-dark" :to="{name: 'papper_register'}">Registro</router-link>
                </li>
            </template>
            <template v-if="usuario">
                <li class="nav-item dropdown dropdown-menu-left">
                    <span class="nav-link dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ usuario !== null ? usuario.nombre_apellido : '' }}
                    </span>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <router-link :to="{name: 'perfil'}" class="dropdown-item">
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
</template>
<script>
    import Vuex from 'vuex';
    export default {
        methods: {
            // Funcion para desloguarme
            logout(){
                localStorage.setItem("logueado","No");
                location.href = "./logout";
            },
        },
        computed: {
            ...Vuex.mapState(['usuario']),
        },
    }
</script>
