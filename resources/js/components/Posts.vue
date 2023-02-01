<template>
    <div>
        <div v-for="(post, key) in posts" v-bind:key="key">
            <post :post="post" :keyPost="key" :posts="posts" :modelEdit="modelEdit" :modelDelete="modelDelete" :setDenunciations="setDenunciations"/>
        </div>
        <edit-post :post="postEdit"/>
        <!-- Modal -->
        <delete-post :postId="postId"/>
        <denunciations-post :denunciations="denunciations" />
        <denuncied-post :denunciations="denunciations" :postId="postId" />
        <div v-if='posts == ""'>
            <br><br>
            <div class="px-4 py-2 text-center">
                <h2>No hay publicaciones realizadas</h2>
            </div>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex';

    export default {
        data(){
            return{
                postEdit: {},
                postId: '',
                denunciations: {},
            }
        },
        methods: {
            modelEdit(post){
                this.postEdit = post;
            },
            modelDelete(id){
                this.postId = id;
            },
            setDenunciations(denunciations,id = 0){
                this.denunciations = denunciations;
                this.postId = id;
            }
        },
        computed: {
            ...Vuex.mapState(['posts']),
        },
    }
</script>
