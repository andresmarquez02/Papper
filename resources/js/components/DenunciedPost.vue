<template>
    <!-- Modal -->
    <div class="modal fade" id="modelDenunciedPost" tabindex="-1" role="dialog" aria-labelledby="modelDenunciedPost" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Denunciar Publicacion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="" method="post" v-on:submit.prevent="denunciedPost">
                    <div class="modal-body">
                        <label for="" class="d-block mb-1">Denuncias</label>
                        <small id="helpId" class="text-muted mb-2">Marque las causas por las que quiere denunciar esta publicacion</small>
                        <div class="form-check" v-for="(denunciation, index) in denunciations" :key="index">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="denunciations[]" v-model="denunciationsPost" :id="denunciation.id" :value="denunciation.id">
                            {{ denunciation.denunciation }}
                          </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-text-dark rounded-pill waver-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-text-primary rounded-pill waver-effect">Denunciar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex';
    import { myFetch } from '../helper/myFetch';
    export default {
        props: ['denunciations','postId'],
        data() {
            return {
                denunciationsPost: []
            }
        },
        methods: {
            async denunciedPost(){
                this.loading(true);
                try {
                    let response = await myFetch().post(`denuncied/post/${this.postId}`,{
                        body:{
                            denunciations: this.denunciationsPost
                        }
                    });

                    if(response.status === 200){
                        alertify.success("Publicacion denunciada");
                    } else if(response.status === 425){
                        alertify.error("Ya has denunciado esta publicacion");
                    } else {
                        throw(response);
                    }

                } catch (error) {
                    alertify.error("Ha ocurrido un error inesperado, porfavor intenta mas tarde");
                }
                this.loading(false);
            },
            ...Vuex.mapMutations(['loading']),
        },
    }
</script>
