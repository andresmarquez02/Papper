<template>
    <div class="pt-5">
        <main>
            <div class="m-0 row text-dark">
                <aside-left />
                <div class="col-md-9 col-sm-12 mb-sm-5" id="centetro">
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
