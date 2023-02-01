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
                    <form action="" v-on:submit.prevent="createPost()" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Título</label>
                                <input type="text" class="form-control rounded-pill" v-model="title" minlength="1" maxlength="254" placeholder="Alguien me puede ayudar con este codígo?"
                                :class="{
                                    'is-invalid': submitted && $v.title.$error
                                    }"
                                />
                                <div
                                    v-if="submitted && !$v.title.required"
                                    class="invalid-feedback"
                                >
                                    El titulo es requerido
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Categoria</label>
                                <select class="form-control rounded-pill" v-model="category"
                                :class="{
                                    'is-invalid': submitted && $v.category.$error
                                    }"
                                >
                                    <option selected>Selecciona</option>
                                    <option v-for="category in categories" :value="category.id" v-bind:key="category.id">{{ category.category }}</option>
                                </select>
                                <div
                                    v-if="submitted && !$v.category.required"
                                    class="invalid-feedback"
                                >
                                    La categoria es requerida
                                </div>
                            </div>
                            <div class="mb-0 form-group">
                                <label for="">Descripción</label>
                                <textarea class="form-control" v-model="description" minlength="1" maxlength="254" rows="3" placeholder="<?php echo Hola Mundo;?>"
                                    :class="{
                                        'is-invalid': submitted && $v.description.$error
                                    }"
                                ></textarea>
                                <div
                                    v-if="submitted && !$v.description.required"
                                    class="invalid-feedback"
                                >
                                    La descripción es requerida
                                </div>
                            </div>
                        </div>
                        <div class="pb-4 modal-footer">
                            <button type="button" class="mr-2 btn btn-opacity-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-opacity-primary rounded-pill waves-effect">
                                Crear Publicación
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
    import Vuex from 'vuex';

    export default {
        data(){
            return{
                title: '',
                category: '',
                description: '',
                submitted: false
            }
        },
        validations: {
            title: {required, minLength: minLength(5)},
            category: {required},
            description: {required, minLength: minLength(5)},
        },
        methods: {
            async createPost(){
                this.submitted = true;
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return;
                }

                try{
                    let response = await myFetch().post("create/post", {
                        body: {
                            'title': this.title,
                            'description': this.description,
                            'category': this.category
                        }
                    });
                    if(response.status == 200){
                        alertify.success(response.res.success);
                        this.$router.go();
                        let obj = document.getElementById('close');
                        obj.click();
                        this.title = "";
                        this.description = "";
                        this.category = "";
                        this.submitted = false;
                        return;
                    }
                    throw([response,response.status])
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
            ...Vuex.mapActions(['getPosts']),
        },
        computed: {
            ...Vuex.mapState(['categories']),
        },
    }
</script>
