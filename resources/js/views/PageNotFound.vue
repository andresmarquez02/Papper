<template>
    <div style="overflow-x: hidden">
        <div class="m-0 w-100 vh-100 d-flex justify-content-center align-items-center row bg-font">
            <div class="col-md-5">
                <h1 class="mb-1 text-center text-white font-weight-bold display-3">404</h1>
                <h1 class="text-center text-white font-weight-bold display-4">Uppsss...</h1>
                <h1 class="text-center text-white font-weight-bold">La pagina que buscas no esta disponible.</h1>
                <div class="mt-3 d-flex justify-content-center">
                    <router-link class="shadow-sm btn btn-light btn-lg rounded-pill waves-effect" :to="{name: 'index'}">Ir al inicio</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
