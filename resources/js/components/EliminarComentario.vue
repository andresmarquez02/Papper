<template>
    <div class="modal" id="modelEliminarc" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <h2>Esta seguro de eliminar este comentario?</h2>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> No</button>
                        <button type="button" class="btn btn-dange waves-effectr" data-dismiss="modal" v-on:click="eliminar()"><i class="fa fa-trash" aria-hidden="true"></i> Si</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex';
    import { myFetch } from '../helper/myFetch';
    export default {
        props: ['idComentario'],
        methods: {
            // Funcion para eliminar
            async eliminar(){
                try{
                    const response = await myFetch().post('eliminar/comentario/'+this.idComentario,{});
                    if(response.status == 200){
                        this.$store.state.commentarios = this.commentarios.filter(comentario => comentario.id != this.idComentario);
                        this.loading(false);
                        alertify.success(response.res.exito);
                    }
                    else{
                        throw(response.res);
                    }
                }
                catch(errors){
                    this.loading(true);
                    console.log(errors);
                    let { err } = errors.errors;
                    if(err !== undefined) return alertify.error(err[0]);
                }
            },
            // Mapeo de la mutacion loading para el preload
            ...Vuex.mapMutations(['loading']),
        },
        computed: {
            // Mapeo de comentarios
            ...Vuex.mapState(['commentarios']),
        },
    }
</script>
