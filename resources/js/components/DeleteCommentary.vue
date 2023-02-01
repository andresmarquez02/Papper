<template>
    <div class="modal" id="modelDelteComentary" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Comentario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <h5>¿Esta seguro de eliminar este comentario?</h5>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-text-dark waves-effect rounded-pill" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i>Cancelar</button>
                        <button type="button" class="btn btn-text-danger waves-effect rounded-pill" data-dismiss="modal" v-on:click="deleteComentary()"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
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
        props: ['comentaryId','getCommentaries'],
        methods: {
            // Funcion para eliminar
            async deleteComentary(){
                this.loading(true);
                try{
                    const response = await myFetch().post('delete/commentary/'+this.comentaryId,{});
                    if(response.status == 200){
                        this.getCommentaries();
                        alertify.success("Comentario eliminado con exito.");
                    } else {
                        throw(response.res);
                    }
                    this.loading(false);
                }
                catch(errors){
                    this.loading(false);
                    alertify.error("Error inesperado, intenta mas tarde.");
                }
            },
            // Mapeo de la mutacion loading para el preload
            ...Vuex.mapMutations(['loading']),
        },
    }
</script>
