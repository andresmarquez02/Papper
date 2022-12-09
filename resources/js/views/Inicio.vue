<template>
    <contenido>
        <preguntas />
    </contenido>
</template>
<script>
    export default {
        created() {
            // Preguntas
            this.$store.dispatch('preguntas');
            // Datos de los usuarios
            this.$store.dispatch('datos_user');
        },
    }
</script>
