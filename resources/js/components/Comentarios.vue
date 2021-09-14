<template>
    <div class="pt-5">
        <main class="pt-5">
            <div class="row m-0 text-dark">
                <div class="col-md-12 col-xs-12 mb-sm-5">
                    <ver-pregunta />
                </div>
            </div>
       </main>
        <crear-pregunta />
    </div>
</template>
<script>
export default {
    created() {
        this.$store.state.id_pregunta = this.$route.params.id;
        this.$store.dispatch('comentarios');
    },
}
</script>
