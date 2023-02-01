<template>
    <!-- Modal -->
    <div class="modal fade" id="modelDenunciation" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Denuncias Recibidas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(denunciation,key) of denunciations" :key="denunciation.id">{{key+1}} - {{ denunciation.denunciation }}</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-text-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-text-primary rounded-pill waves-effect" data-dismiss="modal" v-if="denunciations != ''" v-on:click="closePost">Bloquear Publicacion</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Vuex from 'vuex';
import { myFetch } from "../../helper/myFetch";
export default {
    props: ['denunciations'],
    methods: {
        async closePost(){
            let name = this.$router.history.current.name;
            this.loading(true);
            try {

                let response = await myFetch().post(`admin/close/post/${this.denunciations[0].post_id}`);
                if(response.status == 200){
                    alertify.success("Bloqueo exitoso");
                } else {
                    throw(response);
                }
            } catch (error) {
                alertify.error("Error inesperado intenta mas tarde");
            }
            this.loading(false);

            if(this.$router.history.current.name === "commentaries"){
                return this.$router.back();
            }

            return this.$router.go();
        },
        ...Vuex.mapActions(['getPosts']),
        ...Vuex.mapMutations(['loading']),
    },
}
</script>
