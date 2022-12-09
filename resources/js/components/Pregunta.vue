<template>
    <div class="px-4 pt-4 pb-2 my-4 card-preg"  >
        <div>
            <img src="img/wave_publicacion.svg" class="position-absolute waves-card">
        </div>
        <div class="m-0 row position-relative">
            <div class="p-0 col-6">
                <span>{{ pregunta.nombre_apellido }}</span>
                <small class="d-block small-hora text-muted">{{pregunta.created_at}}</small>
            </div>
            <div class="p-0 col-6 d-flex justify-content-end" v-if="$store.state.usuario !== null">
                <div class="dropdown dropleft" v-if="pregunta.id_usuario == $store.state.usuario.id">
                    <span class="cursor-pointer" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">...</span>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <h6 class="cursor-pointer dropdown-item" v-on:click="modal_cambiar(pregunta)"
                            data-toggle="modal" data-target="#modelEditar">Editar</h6>
                        <h6 class="cursor-pointer dropdown-item" v-on:click="modal_elimiar(pregunta.id)"
                            data-toggle="modal" data-target="#modelEliminar">Eliminar</h6>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h2 class="font-weight-bold position-relative">{{ pregunta.titulo }}</h2>
            <p class="mb-1">
                <i class="fa fa-quote-left ss-small" aria-hidden="true"></i>
                {{pregunta.descripcion}}
                <i class="fa fa-quote-right ss-small" aria-hidden="true"></i>
            </p>
            <div class="mb-3">
                <small class="mr-3"><i class="fa fa-hashtag" aria-hidden="true"></i> Grupo</small>
                <small><i class="fa fa-hashtag" aria-hidden="true"></i> {{pregunta.grupo}}</small>
            </div>
        </div>
        <div>
            <span>
                <i class="cursor-pointer fa fa-regular fa-heart h5 waves-effect" :id="'corazon_'+pregunta.id" v-on:click="like(pregunta.id,keyPregunta)"
                    aria-hidden="true" like="No"></i>
                <span class="mr-2" :id="'likes'+pregunta.id">{{pregunta.likes}}</span>
            </span>
            <span>
                <router-link class="text-dark" :to="'/comentarios/'+pregunta.id">
                    <span>
                        <i class="cursor-pointer fa fa-comment h5" aria-hidden="true"></i>
                        {{ pregunta.comentarios }}
                    </span>
                </router-link>
            </span>
        </div>
    </div>
</template>
<script>
    import { myFetch } from '../helper/myFetch';
    export default {
        props: ['pregunta','keyPregunta','modal_cambiar','modal_elimiar'],
        methods: {
            async like(value,keyPregunta){
                if(this.$store.state.usuario == null)
                    return location.hash = "/login";

                try {
                    let response = await myFetch().post('like/'+value);
                    if(response.status !== 200) throw(response.res);
                } catch (error) {
                    alertify.error("Intenta de nuevo");
                    return 0;
                }

                let like = document.getElementById('corazon_'+value);
                if(like.getAttribute('like') == "No"){
                    this.$store.state.preguntas[keyPregunta].likes +=1;
                    like.classList = "fa fa-heart h5 cursor-pointer text-danger";
                    like.setAttribute('like','Si');
                }
                else {
                    like.classList = "fa fa-regular fa-heart h5 cursor-pointer";
                    this.$store.state.preguntas[keyPregunta].likes -=1;
                    like.setAttribute('like','No');
                }

            }
        },
    }
</script>
