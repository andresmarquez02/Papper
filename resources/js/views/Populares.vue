<template>
    <contenido>
        <preguntas />
    </contenido>
</template>
<script>
export default {
    created() {
        // Preguntas
        this.$store.dispatch('preguntasPopulares');
    },
}
</script>
