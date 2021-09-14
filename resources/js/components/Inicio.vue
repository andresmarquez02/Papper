<template>
    <div class="pt-5">
        <main class="pt-5">
            <div class="row m-0 text-dark">
                <div class="col-md-2 col-sm-12"></div>
                <div class="col-lg-10 col-md-12 col-sm-12">
                    <div class="d-flex justify-content-center mt-2">
                        <filtrado-pregunta />
                    </div>
                </div>
                <aside-left />
                <div class="col-md-10 col-sm-12 mb-sm-5" id="centetro">
                    <preguntas />
                </div>
            </div>
       </main>
       <crear-pregunta />
    </div>
</template>
<script>
export default {
    created() {
        this.pregg();
    },
    methods: {
        pregg(){
            this.$store.dispatch('preguntas_get');
             this.$store.dispatch('groups');
        },
    },
}
</script>
