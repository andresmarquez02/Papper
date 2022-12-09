<template>
    <div>
        <div class="px-4 pt-4 pb-2 my-3 bg-purble-90 card-comentari" v-for="comentario in commentarios" :key="comentario.id">
            <div class="m-0 row">
                <div class="p-0 col-6">
                    <span>{{  comentario.nombre_apellido }}</span>
                    <small class="d-block small-hora text-muted">{{comentario.created_at}}</small>
                </div>
                <div class="p-0 col-6 d-flex justify-content-end" v-if="usuario !== null">
                    <div class="dropdown dropleft">
                        <span class="cursor-pointer" id="triggerIdss" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">...</span>
                        <div class="dropdown-menu dropleft" style="right:0" v-if="comentario.id_usuario == usuario.id" aria-labelledby="triggerIdss">
                            <h6 class="cursor-pointer dropdown-item" v-on:click="modal_elimiar(comentario.id)"
                             data-toggle="modal" data-target="#modelEliminarc">Eliminar</h6>
                        </div>
                    </div>
                </div>
            </div>
            <p class="comment" v-html="comentario.comentario"></p>
            <div>
                <span>
                    <i
                        class="cursor-pointer fa fa-regular fa-heart h5"
                        :id="'comentario_like'+comentario.id"
                        v-on:click="like_comentario($event,comentario.id)"
                        aria-hidden="true"
                        like="false"
                    >
                    </i>
                    <span class="mr-2" :id="'likes_c'+comentario.id">{{comentario.likes}}</span>
                </span>
            </div>
        </div>
        <eliminarComentario :idComentario="idComentario"/>
    </div>
</template>
<script>
    import Vuex from "vuex";
    import { myFetch } from '../helper/myFetch';
    export default {
        data() {
            return {
                idComentario: 0,
            }
        },
        methods: {
            async like_comentario(event,value){
                // Si el usuario no esta logueado lo redirige al login
                if(this.usuario == null) {
                    return location.hash = "/login";
                }

                let { like } = event.target.attributes;
                //Condicional para que se pinte el corazon de tojo o se quite el like
                if(like.nodeValue === "true"){
                    // LLamado de la funcion para que haga la suma o resta para no repetir tanto codigo, se le pasa un true o false para saber que va a hacer, una suma o una resta
                    this.likeDislike(value,true)
                    // Agregado de clases
                    event.target.className = "cursor-pointer fa-regular fa fa-heart h5";
                    like.nodeValue = false;
                }
                else{
                    // LLamado de la funcion para que haga la suma o resta para no repetir tanto codigo, se le pasa un true o false para saber que va a hacer, una suma o una resta
                    this.likeDislike(value,false)
                    // Agregado de clases
                    event.target.className = "cursor-pointer text-danger fa fa-heart h5";
                    like.nodeValue = true;
                }
                // Fetch para que se guarde en la bd
                await myFetch().post('like/comentarios/'+value,{});

            },
            // Funcion para suma o resta de like
            likeDislike(value,type){
                // Array de los comentarios
                this.commentarios.find(element => {
                    if(element.id == value){
                        if(type)
                            return element.likes -= 1;
                        else
                            return element.likes += 1;
                    }
                });
            },
            modal_elimiar(id){
                this.idComentario = id;
            },
        },
        computed: {
            ...Vuex.mapState(['usuario','commentarios']),
        },
    }
</script>
