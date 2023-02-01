<template>
    <div class="modal" id="modelEditPost" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Publicación</h5>
                    <button type="button" id="cerrarEditar" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form v-on:submit.prevent="updatePost()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Titulo</label>
                            <input type="text"
                                class="form-control rounded-pill"
                                v-model="post.title"
                                :class="{
                                    'is-invalid': submitted && $v.post.title.$error
                                }"
                            >
                            <div
                                v-if="submitted && !$v.post.title.required"
                                class="invalid-feedback"
                            >
                                El titulo es requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Categoria</label>
                            <select
                                class="form-control rounded-pill"
                                v-model="post.category_id"
                                :class="{
                                    'is-invalid': submitted && $v.post.category_id.$error
                                }"
                            >
                                <option v-for="category in categories" :value="category.id" v-bind:key="category.id">
                                    {{ category.category }}
                                </option>
                            </select>
                            <div
                                v-if="submitted && !$v.post.category_id.required"
                                class="invalid-feedback"
                            >
                                La categoria es requerida
                            </div>
                        </div>
                        <div class="mb-0 form-group">
                            <label for="">Descripción</label>
                            <textarea
                                class="rounded-md form-control"
                                v-model="post.description"
                                rows="3"
                                :class="{
                                    'is-invalid': submitted && $v.post.description.$error
                                }"
                            ></textarea>
                            <div
                                v-if="submitted && !$v.post.description.required"
                                class="invalid-feedback"
                            >
                                La descripcion es requerida
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 modal-footer">
                        <button type="button" class="mr-2 btn btn-opacity-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-opacity-warning rounded-pill waves-effect"
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
        props: ['post'],
        data() {
            return {
                submitted: false
            }
        },
        validations: {
            post: {
                id: {required},
                title: { required, minLength: minLength(6) },
                category_id: { required },
                description: { required, minLength: minLength(6) },
            },
        },
        methods: {
            ...Vuex.mapMutations(["loading"]),
            ...Vuex.mapActions(['getPosts']),

            async updatePost(){
                this.submitted = true;

                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }
                this.loading(true);
                try {
                    this.post.category = this.post.category_id;
                    let response = await myFetch().put('update/post/'+this.post.id,{
                        body: this.post
                    });
                    if(response.status === 200){
                        this.getPosts();
                        let obj = document.getElementById('cerrarEditar');
                        obj.click();
                        alertify.success("Publicacion actualizada con exito");
                    }
                    else throw([response.res]);
                    this.loading(false);

                } catch (errors) {
                    this.loading(false);
                    alertify.error("Error inesperado, intenta mas tarde");
                }

            },
        },
        computed: {
            ...Vuex.mapState(['categories']),
        },
    }
</script>
