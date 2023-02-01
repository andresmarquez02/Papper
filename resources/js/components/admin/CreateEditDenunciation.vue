<template>
    <!-- Modal -->
    <div class="modal fade" id="modelCreateEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ denunciation.id === 0 ? "Crear" : "Actualizar" }} Denuncia</h5>
                        <button type="button" class="close" id="closeCreateEditDenunciation" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="" method="get" v-on:submit.prevent="actionDenunciation">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="mb-2 ml-2">Denuncia</label>
                            <input type="text"
                                maxlength="254"
                                minlength="5"
                                class="form-control rounded-pill"
                                :class="{
                                    'is-invalid': submitted && $v.denunciation.denunciation.$error
                                }"
                                name="denunciation"
                                v-model="denunciation.denunciation"
                            >
                            <small
                                v-if="submitted && !$v.denunciation.denunciation.required"
                                class="invalid-feedback"
                            >
                                La denuncia es requerida
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-opacity-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-opacity-primary rounded-pill waves-effect" :class='denunciation.id === 0 ? "btn-text-primary" : "btn-text-warning"'>
                            {{ denunciation.id === 0 ? "Crear" : "Actualizar" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex'
    import { myFetch } from '../../helper/myFetch';
    import { required, minLength } from "vuelidate/lib/validators";

    export default {
        props: ['denunciation','getDenunciations'],
        data() {
            return {
                submitted: false,
            }
        },
        validations: {
            denunciation: {
                denunciation: { required, minLength: minLength(2) },
            }
        },
        methods: {
            async actionDenunciation(){
                this.submitted = true;
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return;
                }

                this.loading(true);
                try {
                    if(this.denunciation.id === 0){
                        this.createDenunciation();
                    } else {
                        this.updateDenunciation();
                    }
                    this.closeModel();
                    this.getDenunciations();
                } catch (error) {
                    alertify.error("Ha ocurrido un error inesperado intenta mas tarde");
                }
                this.loading(false);

            },
            async createDenunciation(){
                await myFetch().post("admin/denunciations", {
                    body: {
                        denunciation: this.denunciation.denunciation
                    }
                });
                alertify.success("Denuncia creada con exito");
            },
            async updateDenunciation(){
                await myFetch().put(`admin/denunciations/${this.denunciation.id}`, {
                    body: {
                        denunciation: this.denunciation.denunciation
                    }
                });
                alertify.success("Denuncia actualizada con exito");
            },
            closeModel(){
                document.querySelector('#closeCreateEditDenunciation').click();
            },
            ...Vuex.mapMutations(['loading']),
        },
    }
</script>
