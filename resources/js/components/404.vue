<template>
    <div style="overflow-x: hidden">
        <div class="w-100 vh-100 d-flex justify-content-center align-items-center row m-0">
            <div class="col-md-5">
                <h1 class="display-1 font-weight-bold text-center text-white">Pagina no Encontrada</h1>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-dark btn-lg rounded-pill shadow-sm" href="./" role="button">Ir al inicio</a>
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
