<template>
    <contenido>
        <ver-pregunta />

    </contenido>
</template>
<script>
    export default {
        created() {
            this.$store.state.id_pregunta = this.$route.params.id;
            this.$store.dispatch('comentarios');
        },
    }
</script>
