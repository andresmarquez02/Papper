<template>
   <div>
        <div class="modal" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h4">Nueva Publicación</h5>
                            <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <form action="" v-on:submit.prevent="publicar" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Título</label>
                                <input type="text" class="form-control rounded-pill" v-model="titulo" minlength="1" maxlength="254" placeholder="Alguien me puede ayudar con este codígo?"
                                :class="{
                                    'is-invalid': submitted && $v.titulo.$error
                                    }"
                                />
                                <div
                                    v-if="submitted && !$v.titulo.required"
                                    class="invalid-feedback"
                                >
                                    El titulo es requerido
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Grupo</label>
                                <select class="form-control rounded-pill" v-model="grupo"
                                :class="{
                                    'is-invalid': submitted && $v.grupo.$error
                                    }"
                                >
                                    <option selected>Selecciona</option>
                                    <option v-for="grupo in $store.state.grupos" :value="grupo.id" v-bind:key="grupo.id">{{ grupo.grupo }}</option>
                                </select>
                                <div
                                    v-if="submitted && !$v.grupo.required"
                                    class="invalid-feedback"
                                >
                                    El grupo es requerido
                                </div>
                            </div>
                            <div class="mb-0 form-group">
                                <label for="">Descripción</label>
                                <textarea class="form-control" v-model="descripcion" minlength="1" maxlength="254" rows="3" placeholder="<?php echo Hola Mundo;?>"
                                    :class="{
                                        'is-invalid': submitted && $v.descripcion.$error
                                    }"
                                ></textarea>
                                <div
                                    v-if="submitted && !$v.descripcion.required"
                                    class="invalid-feedback"
                                >
                                    La descripcion es requerida
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" v-on:click="publicar()" class="btn btn-text-primary rounded-pill waves-effect">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { required, minLength } from "vuelidate/lib/validators";
    import { myFetch } from '../helper/myFetch';
    export default {
        data(){
            return{
                titulo: '',
                grupo: '',
                descripcion: '',
                submitted: false
            }
        },
        validations: {
            titulo: {required, minLength: minLength(5)},
            grupo: {required},
            descripcion: {required, minLength: minLength(5)},
        },
        methods: {
            async publicar(){
                this.submitted = true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }
                try{
                    let consulta = await myFetch().post("guardar", {
                        body: {
                            'titulo': this.titulo,
                            'descripcion': this.descripcion,
                            'grupo': this.grupo
                        }
                    });
                    if(consulta.status == 200){
                        alertify.success(consulta.res.exito);
                        this.recarga_preguntas();
                        let obj = document.getElementById('close');
                        obj.click();
                        this.titulo = "";
                        this.descripcion = "";
                        this.grupo = "";
                        return;
                    }
                    throw([respuesta,consulta.status])
                }
                catch(errors){
                    if(errors[1] == 422){
                        if(errors[0].errors.usuario)
                            return alertify.error(errors[0].errors.usuario);
                        if(errors[0].errors.correo)
                            return alertify.error(errors[0].errors.correo);
                        if(errors[0].errors.contrasena)
                            return alertify.error(errors[0].errors.contrasena);
                    }
                    else if(errors[1] == 500){
                        if(errors[0].error)
                            alertify.error(errors[0].error);
                    }
                }
            },
            recarga_preguntas(){
                this.$store.dispatch('preguntas_get');
            }
        },
    }
</script>
