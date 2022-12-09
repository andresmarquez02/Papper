<template>
    <div class="modal" id="modelEditar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Publicación</h5>
                    <button type="button" id="cerrarEditar" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form v-on:submit.prevent="cambiar()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Titulo</label>
                            <input type="text"
                                class="form-control rounded-pill"
                                v-model="preguntaEditar.titulo"
                                :class="{
                                    'is-invalid': submitted && $v.preguntaEditar.titulo.$error
                                }"
                            >
                            <div
                                v-if="submitted && !$v.preguntaEditar.id_grupo.required"
                                class="invalid-feedback"
                            >
                                El titulo es requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Grupo</label>
                            <select
                                class="form-control rounded-pill"
                                v-model="preguntaEditar.id_grupo"
                                :class="{
                                    'is-invalid': submitted && $v.preguntaEditar.id_grupo.$error
                                }"
                            >
                                <option v-for="grupo in $store.state.grupos" :value="grupo.id" v-bind:key="grupo.id">{{ grupo.grupo }}</option>
                            </select>
                            <div
                                v-if="submitted && !$v.preguntaEditar.id_grupo.required"
                                class="invalid-feedback"
                            >
                                El grupo es requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Descripción</label>
                            <textarea
                                class="rounded-md form-control"
                                v-model="preguntaEditar.descripcion"
                                rows="3"
                                :class="{
                                    'is-invalid': submitted && $v.preguntaEditar.descripcion.$error
                                }"
                            ></textarea>
                            <div
                                v-if="submitted && !$v.preguntaEditar.descripcion.required"
                                class="invalid-feedback"
                            >
                                La descripcion es requerida
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-text-warning rounded-pill waves-effect"
                        >Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import { myFetch } from '../helper/myFetch';
    import { required, minLength } from "vuelidate/lib/validators";
    import Vuex from 'vuex'

    export default {
        props: ['preguntaEditar','id_pregunta'],
        data() {
            return {
                submitted: false
            }
        },
        validations: {
            preguntaEditar: {
                titulo: { required, minLength: minLength(6) },
                id_grupo: { required },
                descripcion: { required, minLength: minLength(6) },
            },
            id_pregunta: { required }
        },
        methods: {
            ...Vuex.mapMutations(["loading"]),
            async cambiar(){
                this.submitted = true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }
                this.loading(true);
                try {
                    let response = await myFetch().put('actualizar/pregunta/'+this.id_pregunta,{
                        body: this.preguntaEditar
                    });
                    if(response.status === 200){
                        this.$store.dispatch('preguntas');
                        let obj = document.getElementById('cerrarEditar');
                        obj.click();
                        alertify.success("Pregunta actualizada con exito");
                    }
                    else throw([response.res]);

                } catch (errors) {
                    alertify.error("Error inesperado, intenta mas tarde");
                }
                this.loading(false);
            },
        },
    }
</script>
