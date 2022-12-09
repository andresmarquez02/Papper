<template>
    <contenido>
        <preguntas />
    </contenido>
</template>
<script>
    export default {
        created() {
            this.$store.dispatch('preguntas_get');
        }
    }
</script>
