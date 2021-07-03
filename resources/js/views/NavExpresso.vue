<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-light bg-light mx-md-4 py-4">
            <span class="navbar-brand font-weight-bolder h4 text-dark">Expresso</span>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <router-link :to="{name: 'home_expresso'}" class="nav-link h6 font-weight-bold">INICIO <span class="sr-only">Inicio</span>
                        </router-link>
                    </li>
                    <li class="nav-item ">
                        <router-link :to="{name: 'tienda'}" class="nav-link h6 font-weight-bold">TIENDA <span class="sr-only">Tienda</span>
                        </router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <div class="nav-link dropdown-toggle cursor-pointer pt-1">
                            <span id="dropdownId" data-toggle="dropdown" class="h6 font-weight-bold" aria-haspopup="true"  aria-expanded="false">ACERCA DE
                            </span>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <router-link :to="{name: 'sobre'}" class="dropdown-item cursor-pointer" >REPARTIDORES</router-link>
                                <router-link :to="{name: 'sobre'}" class="dropdown-item cursor-pointer">COMERCIOS ASOC.</router-link>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <span class="nav-link h6 font-weight-bold">CONTACTOS <span class="sr-only">Contactos</span>
                        </span>
                    </li>
                    <li class="nav-item dropdown" v-if="usuario != ''">
                        <div class="nav-link dropdown-toggle cursor-pointer pt-1">
                            <span id="dropdownUSER" data-toggle="dropdown" class="h6 font-weight-bold text-uppercase" aria-haspopup="true"  aria-expanded="false">{{usuario.nombre}}
                            </span>
                            <div class="dropdown-menu" aria-labelledby="dropdownUSER">
                                <span class="dropdown-item cursor-pointer" v-on:click="deleteSub()">ELIMINAR MI SUBSCRIPCION</span>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item " v-else>
                        <a href="#home_expresso" class="nav-link h6 font-weight-bold">SUBSCRIBIRME <span class="sr-only">subscribirme</span>
                        </a>
                    </li>
                    <li class="nav-item" :class="el_carrito">
                        <span class="position-relative h6 nav-link" v-if="$store.state.enCarrito != ''">
                            <i class="fa fa-shopping-cart text-dark" role="button" v-on:click="map_created()" aria-hidden="true"></i><span class="badge badge-danger mr-2">{{$store.state.enCarrito.length}}</span>
                        </span>
                        <span class="position-relative h6 nav-link" v-else>
                            <i class="fa fa-shopping-cart text-dark" role="button" v-on:click="map_created()" aria-hidden="true"></i><span class="badge badge-danger mr-2">0</span>
                        </span>
                    </li>
                    <li class="nav-item ">
                        <span class=" nav-link h6">
                            <i class="fa fa-bell mr-2" role="button" aria-hidden="true" v-on:click="alert()"></i>
                        </span>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>
<script>
import {mapState, mapMutations} from 'vuex'
export default {
    methods: {
        ...mapMutations('expresso',['deleteSub','alert']),
        map_created(){
            if(this.$store.state.enCarrito.length > 0){
                let map = document.getElementById('map_comprar');
                map.click();
            }
            else{
                alertify.error("No tiene productos en su carrito");
            }
        },
    },
    computed: {
        ...mapState('expresso',['usuario','el_carrito'])
    },
}
</script>