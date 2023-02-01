<template>
    <dashboard>
        <see-post />
    </dashboard>
</template>
<script lang="js">
    import Vuex from 'vuex';

    export default {
        watch: {
            $route(to, from) {
                this.getPosts();
            }
        },
        mounted() {
            this.getPosts();
        },
        methods: {
            ...Vuex.mapActions(['getPosts']),
        },
    }
</script>
