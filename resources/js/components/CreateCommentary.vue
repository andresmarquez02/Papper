<template>
    <div>
        <div class="pt-4 mt-3 mb-2 px-lg-4" v-if="user !== null">
            <form v-on:submit.prevent="createCommentary()">
                <div class="mb-1 input-group">
                    <textarea class="form-control" v-model="commentary" placeholder="comentario..." aria-describedby="button-addon2"
                    :class="{
                      'is-invalid': submitted && $v.commentary.$error
                    }"></textarea>
                    <div class="input-group-append">
                        <button class="px-3 btn btn-opacity-primary waves-effect-light" type="submit" id="button-addon2">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div
                    v-if="submitted && !$v.commentary.required"
                    class="ml-2 invalid-feedback d-block small"
                >
                    Para poder enviar un comentario debes escribir algo
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex';
    import { myFetch } from '../helper/myFetch';
    import { required, minLength } from "vuelidate/lib/validators";

    export default {
        props: ['getCommentaries',"postId"],
        data() {
            return {
                commentary: '',
                submitted: false,
            };
        },
        validations: {
            commentary: { required, minLength: minLength(2)},
        },
        methods: {
            async createCommentary() {
                this.submitted = true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }

                this.loading(true);
                try {
                    const response = await myFetch().post(`create/commentary/${this.postId}`, {
                        body: { 'commentary': this.commentary }
                    });
                    if (response.status == 200) {
                        this.commentary = '';
                        this.submitted = false;
                        this.loading(false);
                        this.getCommentaries();
                        alertify.success("Comentario Publicado.");
                    } else {
                        throw (response.res);
                    }
                } catch (error) {
                    this.loading(false);
                    this.submitted = false;
                    alertify.error("ha ocurrido un error, porfavor recarga la pagina :)");
                }
            },
            ...Vuex.mapMutations(['loading']),
        },
        computed: {
            ...Vuex.mapState(['user']),
        },
    }
</script>

