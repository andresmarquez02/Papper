<template>
    <div class="pt-5">
        <main class="pt-5">
            <div class="row m-0 text-dark">
                <div class="col-md-12 col-xs-12 mb-sm-5">
                    <ver-pregunta />
                </div>
            </div>
       </main>
    </div>
</template>
<script>
export default {
    created() {
        let value = JSON.parse(localStorage.getItem('datas'));
        let confirma = localStorage.getItem('confirm');
        this.$store.state.pregunta = value;
        this.$store.state.esLike = confirma;
        this.$store.dispatch('comentarios');
    },
}
</script>
