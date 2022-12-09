<template>
    <contenido>
        <preguntas />
    </contenido>
</template>
<script>
    export default {
        watch: {
            $route(to, from) {
                this.$store.state.referencia_grupo = this.$route.params.id;
                // Preguntas
                this.$store.dispatch('preguntasPorGrupo');
            }
        },
        mounted() {
            this.$store.state.referencia_grupo = this.$route.params.id;
            // Preguntas
            this.$store.dispatch('preguntasPorGrupo');
        },
    }
</script>
