<template>
    <div class="pt-1 mt-5">
        <div class="m-0 mt-5 row d-flex justify-content-center">
            <div class="p-4 rounded shadow-sm col-10">
                <p class="px-3 d-flex justify-content-end">
                    <span class="border border-dark rounded-circle d-flex justify-content-center align-items-center" style="height:2rem;width:2rem" role="button">
                        <i class="fa fa-retweet" v-on:click="notificaciones_recall()"
                    aria-hidden="true"></i>
                    </span>
                </p>
                <router-link class="py-3 dropdown-item" v-for="notificacion in $store.state.notificaciones" :key="notificacion.id"
                :to="'/comentarios/'+notificacion.id_pregunta">
                    {{ notificacion.descripcion }}
                </router-link>
                <span class="dropdown-item" v-if="$store.state.notificaciones == ''">
                No tienes notificaciones</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted(){
        this.notificaciones_generales();
    },
    methods:{
        notificaciones_generales(){
            this.$store.dispatch('notificaciones_ver');
        },
        notificaciones_recall(){
            this.$store.dispatch('notificaciones_ver_recall');
        },
    }
}
</script>
