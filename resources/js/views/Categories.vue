<template>
    <dashboard>
        <posts />
    </dashboard>
</template>
<script>
    import Vuex from 'vuex'
    export default {
        watch: {
            $route(to, from) {
                this.$store.state.postId = this.$route.params.id;
                // Publicaciones
                this.getPostsByCategory();
            }
        },
        mounted() {
            this.$store.state.postId = this.$route.params.id;
            // Publicaciones
            this.getPostsByCategory();
        },
        methods:{
            ...Vuex.mapActions(['getPostsByCategory']),
        }
    }
</script>
