<template>
    <div class="w-50-100">
        <div class="px-2">
            <input class="form-control d-inline rounded-pill bg-white-50 border-white-50"
             type="text" v-on:keyup.enter="buscar()" placeholder="Buscar"
             v-model="$store.state.buscador">
            <!--<button class="btn btn-outline-primary rounded-pill"  v-on:click="buscar()"
             type="button">Buscar</button>-->
        </div>
        <!--<div class="col-md-4 col-sm-12 col-xs-12 pr-4 d_sm_none">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-dark rounded-pill" data-toggle="modal" data-target="#modelId">
                    Crear publicación
                </button>
            </div>
        </div>-->
    </div>
</template>
<script>
export default {
    methods: {
        async buscar(){
            let pre = document.getElementById('carga');
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            let token = document.querySelector('meta#token').getAttribute('content');
            try{
                let grupo = localStorage.getItem('grupo');
                const consulta = await fetch('filtrado/'+grupo+'/'+this.$store.state.buscador,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const respuesta = await consulta.json();
                this.$store.state.preguntas = respuesta.preguntas;
                pre.classList.remove('d-flex');
                pre.classList.add('d-none');
            }
            catch(error){}
        }
    },
}
</script>
