<template>
    <!-- Modal -->
    <div class="modal fade" id="modelCreateEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ category.id === 0 ? "Crear" : "Actualizar" }} Categoria</h5>
                        <button type="button" class="close" id="closeCreateEditCategory" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="" method="get" v-on:submit.prevent="actionCategory">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="mb-2 ml-2">Categoria</label>
                            <input type="text"
                                maxlength="254"
                                minlength="5"
                                class="form-control rounded-pill"
                                :class="{
                                    'is-invalid': submitted && $v.category.category.$error
                                }"
                                name="category"
                                v-model="category.category"
                            >
                            <small
                                v-if="submitted && !$v.category.category.required"
                                class="invalid-feedback"
                            >
                                La categoria es requerida
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-opacity-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn rounded-pill waves-effect" :class='category.id === 0 ? "btn-opacity-primary" : "btn-opacity-warning"'>
                            {{ category.id === 0 ? "Crear" : "Actualizar" }}
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
        props: ['category','getCategories'],
        data() {
            return {
                submitted: false,
            }
        },
        validations: {
            category: {
                category: { required, minLength: minLength(2) },
            }
        },
        methods: {
            async actionCategory(){
                this.submitted = true;
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return;
                }

                this.loading(true);
                try {
                    if(this.category.id === 0){
                        this.createCategory();
                    } else {
                        this.updateCategory();
                    }
                    this.closeModel();
                    this.getCategories();
                } catch (error) {
                    alertify.error("Ha ocurrido un error inesperado intenta mas tarde");
                }
                this.loading(false);

            },
            async createCategory(){
                await myFetch().post("admin/categories", {
                    body: {
                        category: this.category.category
                    }
                });
                alertify.success("Categoria creada con exito");
            },
            async updateCategory(){
                await myFetch().put(`admin/categories/${this.category.id}`, {
                    body: {
                        category: this.category.category
                    }
                });
                alertify.success("Categoria actualizada con exito");
            },
            closeModel(){
                document.querySelector('#closeCreateEditCategory').click();
            },
            ...Vuex.mapMutations(['loading']),
        },
    }
</script>
