<template>
    <div class="pt-3 pb-3">
        <div v-if="$store.state.usuario !== null">
            <router-link class="btn btn-text-dark waves-effect rounded-circle" to="/inicio">
                <i class="fas fa-arrow-left"></i>
            </router-link>
        </div>
        <div v-else>
            <router-link class="btn btn-text-dark waves-effect rounded-circle" to="/">
                <i class="fas fa-arrow-left"></i>
            </router-link>
        </div>
        <Pregunta :pregunta="$store.state.pregunta" keyPregunta="1" :modal_cambiar="modal_cambiar" :modal_elimiar="modal_elimiar"/>
        <!-- Modal para editar -->
        <ModalEditarPregunta :preguntaEditar="preguntaEditar" :id_pregunta="id_pregunta"/>
        <!-- Modal para eliminar-->
        <ModalEliminarPregunta :id_pregunta="id_pregunta"/>
        <comentario/>
        <div class="px-4 pt-4 pb-2 my-3"
        v-if="$store.state.commentarios == ''">
            <h2 class="text-center font-weight-bold">Sin comentarios...</h2>
        </div>
        <div class="pt-4 pb-2 my-3 px-lg-4" v-if="$store.state.usuario !== null">
            <div class="mb-3 input-group">
                <input type="text" class="form-control rounded-pill-left" v-model="$store.state.comentario" v-on:keyup.enter="comentar()" placeholder="comentario..." aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="px-3 btn btn-primary btn-sm waves-effect" v-on:click="comentar()" type="button" id="button-addon2">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        let intervalo = setInterval(() => {
            if (this.$store.state.commentarios !== null) {
                this.mi_like();
                window.clearInterval(intervalo);
            }
        }, 3000);
    },
    data() {
        return {
            comentario_editar: "",
            validador: /^[a-zA-ZÁ-ÿ\s]{1,255}$/,
            numeros: /^\d{1,255}$/,
            id_comentario: "",
            preguntaEditar: {
                titulo: '',
                descripcion: '',
                id_grupo: '',
            },
            id_pregunta: '',
        };
    },
    methods: {
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
        async mi_like() {
            let i = null;
            let likes = null;
            for (i of this.$store.state.commentarios) {
                for (likes of this.$store.state.likes_comentarios) {
                    if (likes.id_user == this.$store.state.usuario.id && likes.id_comentario == i.id) {
                        let ids = document.getElementById("comentario_like" + i.id);
                        ids.classList = "fa fa-heart h5 cursor-pointer text-danger";
                        ids.setAttribute("like", "Si");
                    }
                }
            }
        },
        comentar() {
            if (this.$store.state.usuario == null)
                return location.hash = "/login";
            const regular = /^.{1,400000000}$/;
            let pre = document.getElementById("carga");
            if (regular.test(this.$store.state.comentario)) {
                pre.classList.remove("d-none");
                pre.classList.add("d-flex");
                this.$store.dispatch("enviar_comentario");
            }
            else {
                if (this.$store.state.comentario != "" && !regular.test(this.$store.state.comentario)) {
                    alertify.error("Comentario muy extenso por favor envielo en dos partes");
                }
            }
        }
    },
}
</script>
