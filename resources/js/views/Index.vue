<template>
    <dashboard>
        <posts />
    </dashboard>
</template>
<script lang="js">
    import Vuex from 'vuex';
    export default {
        created() {
            // Publicaciones
            this.getPosts();
            // Datos de los usuarios
            this.getUser();
        },
        methods: {
            ...Vuex.mapActions(['getPosts','getUser']),
        },
    }
</script>
