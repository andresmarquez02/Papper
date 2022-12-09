<template>
    <div class="align-items-center d-flex">
        <div class="input-group">
            <select
                class="form-control rounded-pill"
                v-model="grupo"
            >
                <option value="0" selected> Todos </option>
                <option v-for="grupo in $store.state.grupos" :value="grupo.id" v-bind:key="grupo.id">{{ grupo.grupo }}</option>
            </select>
            <input
                class="form-control d-inline rounded-pill ml-1"
                type="text" v-on:keyup.enter="buscar()" placeholder="🔎 Buscar"
                v-model="$store.state.buscador"
            >
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex';
    import { myFetch } from '../helper/myFetch';

export default {
    data() {
        return {
            grupo: 0,
        }
    },
    methods: {
        ...Vuex.mapMutations(["loading"]),
        async buscar(){
            this.loading(true);
            try{
                if(this.grupo === '')  this.grupo = 0;

                if(this.$store.state.buscador !== ""){
                    let response = await myFetch().get('preguntas/buscar/'+this.grupo+'/'+this.$store.state.buscador);
                    this.$store.state.preguntas = response.res.preguntas;
                }
            }
            catch(error){
                this.$store.state.preguntas = [];
            }
            this.loading(false);
        }
    },
}
</script>
