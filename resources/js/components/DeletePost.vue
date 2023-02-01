<template>
    <div class="modal fade" id="modelDeletePost" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Publicacion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <h5>¿Esta seguro que quieres eliminar esta publicación?</h5>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="mr-2 btn btn-opacity-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-opacity-danger rounded-pill waves-effect" data-dismiss="modal" v-on:click="deletePost()">Si, eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { myFetch } from '../helper/myFetch';
    import Vuex from 'vuex'

    export default {
        props: ['postId'],
        methods: {
            ...Vuex.mapMutations(["loading"]),
            ...Vuex.mapActions(['getPosts']),

            async deletePost(){
                this.loading(true);
                let response = await myFetch().del('delete/post/'+this.postId);
                if(response.status === 200){
                    this.getPosts();
                    this.loading(false);
                    alertify.success("Publicacion eliminada con exito.");
                    return 0;
                }
                else{
                    this.loading(false);
                    alertify.error("Error inesperado, intenta mas tarde.");
                }
            }
        },
    }
</script>
