<template>
    <div class="pt-3 pb-3">
        <div v-if="post !== null">
            <post :post="post" keyPost="1" :setDenunciations="setDenunciations"/>
            <denunciations-post :denunciations="denunciations" />
        </div>
        <div  v-for="(commentary, key) in commentaries" :key="commentary.id">
            <commentary :commentary="commentary" :commentaries="commentaries" :keyCommentary="key" :modelDelete="modelDelete" />
        </div>
        <div v-if="commentaries !== ''">
            <div v-if="user !== ''">
                <delete-commentary :commentaryId="commentaryId" :getCommentaries="getCommentaries"/>
            </div>
        </div>
        <div class="px-4 pt-4 pb-2 my-3" v-if="commentaries === ''">
            <h2 class="text-center font-weight-bold">Sin commentaries...</h2>
        </div>
        <create-commentary :getCommentaries="getCommentaries" :postId="post.id" />
    </div>
</template>
<script>
    import Vuex from 'vuex';
    import { myFetch } from '../helper/myFetch';

    export default {
        data() {
            return {
                commentaries :[],
                post: [],
                commentaryId: 0,
                denunciations: {}
            };
        },
        mounted() {
            this.getCommentaries();
        },
        methods: {
            async getCommentaries(){
                this.loading(true);
                try {
                    let response = await myFetch().get('commentaries/'+this.$route.params.id);
                    this.commentaries = response.res.commentaries;
                    this.post = response.res.post;
                    this.loading(false);
                } catch (error) {
                    this.loading(false);
                    alertify.error("ha ocurrido un error, porfavor recarga la pagina");
                }

            },
            modelDelete(id){
                this.commentaryId = id;
            },
            setDenunciations(denunciations){
                this.denunciations = denunciations;
            },
            ...Vuex.mapMutations(['loading']),
        },
        computed: {
            ...Vuex.mapState(['user']),
        },
    }
</script>
