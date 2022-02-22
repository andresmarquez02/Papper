<template>
    <div style="overflow-x: hidden">
        <div class="m-0 w-100 vh-100 d-flex justify-content-center align-items-center row">
            <div class="col-md-5">
                <h1 class="text-center text-white display-1 font-weight-bold">Pagina no Encontrada</h1>
                <div class="d-flex justify-content-center">
                    <router-link class="shadow-sm btn btn-dark btn-lg rounded-pill waves-effect" :to="{name: 'principal'}">Ir al inicio</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        window.location.hash = "/inicio"
    },
}
</script>
