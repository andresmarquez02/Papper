<template>
    <div>
        <div class="col-12 px-md-2 px-0 mb-4 tienda position-relative w-100 px-md-5 pt-md-3">
            <nav-expresso class="position-absolute w-calc"></nav-expresso>
            <div class="d-flex justify-content-center align-items-center vh-tienda">
                <div class="text-center text-white w-md-50-sm-95 pt-sm-3">
                    <div class="display-4 title">
                        Acerca de Nosotros
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0 pt-4 px-12">
            <div class="col-12 text-center text-dark py-3">
                <small class="text_info title font-weight-light">¿Acerca?</small>
            </div>
            <div class="col-md-4 col-sm-12 px-3 pb-5 vh-75" v-for="ll in info">
                <div class="px-3 position-relative">
                    <div class="px-0">
                        <img :src="'img/'+ll.img" class="w-100 rounded vh-40" alt="">
                    </div>
                    <div class="p-3 rounded shadow-sm bg-white position-absolute ubic_information">
                        <div>
                            <h4 class="title">{{ll.titulo}}</h4>
                            <small class="text_info">
                                Expresso tu mejor opcion
                            </small>
                            <div>
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Illum hic accusantium 
                                error neque atque maxime nobis modi iure dicta.
                            </div>
                            <br>
                            <br>
                            <div class="text-center pb-3">
                                <span class="bg-info text-white rounded-0 px-3 py-2">
                                Más información
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapMutations} from 'vuex'
export default {
    mounted() {
        this.no_fede();
    },
    data() {
        return {
            info: [
                {info: 1,titulo: 'Repartidores',img:'repartidor.PNG'},
                {info: 2,titulo: 'Marketing',img:'galery7.PNG'},
                {info: 3,titulo: 'Comercios asociados',img:'asoc.PNG'},
            ],
        }
    },
    methods: {
        ...mapMutations('expresso',['no_fede']),
    },
}
</script>