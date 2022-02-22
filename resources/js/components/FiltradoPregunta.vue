<template>
    <div>
        <div>
            <input class="form-control d-inline rounded-pill"
             type="text" v-on:keyup.enter="buscar()" placeholder="🔎 Buscar"
             v-model="$store.state.buscador">
        </div>
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
                if(this.$store.state.buscador !== ""){
                    const consulta = await fetch('filtrado/'+grupo+'/'+this.$store.state.buscador,{
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });
                    const respuesta = await consulta.json();
                    this.$store.state.preguntas = respuesta.preguntas;
                }
            }
            catch(error){}
            pre.classList.remove('d-flex');
            pre.classList.add('d-none');
        }
    },
}
</script>
