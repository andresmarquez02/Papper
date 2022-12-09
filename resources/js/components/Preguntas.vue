<template>
    <div>
        <div v-if="$store.state.referencia_grupo.grupo != undefined && $store.state.referencia_grupo.grupo != ''
        && $store.state.referencia_grupo.grupo != null">
            <div style="padding-top: 1.5rem;">
                <span class="px-4 cursor-pointer text-decoration h2 font-weight-bold"
                v-on:click="per_grupo($store.state.referencia_grupo.id)">
                    <i class="fa fa-hashtag" aria-hidden="true"></i>
                    {{ $store.state.referencia_grupo.grupo !== null ? $store.state.referencia_grupo.grupo : "" }}
                </span>
            </div>
        </div>
        <div v-for="(pregunta, key) in $store.state.preguntas" v-bind:key="key">
            <Pregunta :pregunta="pregunta" :keyPregunta="key" :modal_cambiar="modal_cambiar" :modal_elimiar="modal_elimiar"/>
        </div>
        <ModalEditarPregunta :preguntaEditar="preguntaEditar" :id_pregunta="id_pregunta"/>
        <!-- Modal -->
        <ModalEliminarPregunta :id_pregunta="id_pregunta"/>
    </div>
</template>
<script>
export default {
    mounted() {
        let interval = setInterval(()=> {
            if(this.$store.state.preguntas.length > 0){
                this.mi_like();
                window.clearInterval(interval);
            }
        },3000);
    },
    data(){
        return{
            preguntaEditar: {
                titulo: '',
                descripcion: '',
                id_grupo: '',
            },
            id_pregunta: '',
        }
    },
    methods: {
        async mi_like(){
            let i = null;
            let likes = null;
            for(i of this.$store.state.preguntas){
                for( likes of this.$store.state.likes_generales){
                    if(likes.id_pregunta == i.id && likes.id_usuario == this.$store.state.usuario.id){
                        let ids = document.getElementById('corazon_'+i.id);
                        ids.classList = "fa fa-heart h5 cursor-pointer text-danger";
                        ids.setAttribute('like','Si');
                    }
                }
            }
        },
        modal_cambiar(pregunta){
            this.preguntaEditar = {
                titulo: pregunta.titulo,
                descripcion: pregunta.descripcion,
                id_grupo: pregunta.id_grupo
            };
            this.id_pregunta = pregunta.id;
        },
        modal_elimiar(id){
            this.id_pregunta = id;
        },
    }
}
</script>
