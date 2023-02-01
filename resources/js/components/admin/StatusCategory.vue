<template>
    <!-- Modal -->
    <div class="modal fade" id="modelStatus" tabindex="-1" role="dialog" aria-labelledby="modelStatus" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Estatus de Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    ¿Esta seguro de cambiar el estatus de esta categoria
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-opacity-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-opacity-primary rounded-pill waves-effect" data-dismiss="modal" v-on:click="changeStatusCategory">Aceptar y cambiar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex'
    import { myFetch } from '../../helper/myFetch';

    export default {
        props: ['category', 'getCategories'],
        methods: {
            async changeStatusCategory(){
                this.loading(true);
                try {
                    await myFetch().get(`admin/categories/${this.category.id}`);
                    alertify.success("Categoria cambiada de estatus");
                    this.getCategories();
                } catch (error) {
                    alertify.error("Error inesperado intenta mas tarde");
                }
                this.loading(false);
            },
            ...Vuex.mapMutations(['loading']),
        }
    }
</script>
