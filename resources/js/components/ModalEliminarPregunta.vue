<template>
    <div class="modal fade" id="modelEliminar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Publicacion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <h5>Esta seguro de eliminar esta publicacion?</h5>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-text-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-text-danger rounded-pill waves-effect" data-dismiss="modal" v-on:click="eliminar()">Eliminar</button>
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
        props: ['id_pregunta'],
        methods: {
            ...Vuex.mapMutations(["loading"]),
            async eliminar(){
                let response = await myFetch().del('eliminar/pregunta/'+this.id_pregunta);
                if(response.status === 200){
                    this.$store.dispatch('preguntas');
                    alertify.success("Publicacion eliminada con exito.");
                    return 0;
                }
                else{
                    alertify.error("Error inesperado, intenta mas tarde.");
                }
            }
        },
    }
</script>
