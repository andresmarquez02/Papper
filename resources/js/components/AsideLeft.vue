<template>
    <div class="col-md-3 col-sm-12" style="word-break:break-all">
        <ul class="pt-4 pr-0 my-3 list-group position-fixed-md col-lg-3">
            <li class="p-0 mb-5 list-group-item no-hover">
                <filtrado-pregunta/>
            </li>
            <li class="list-group-item waves-effect" v-on:click="por_grupo(0)">Todos</li>
            <li class="list-group-item waves-effect" v-on:click="por_grupo(-1)">Populares</li>
            <li class="list-group-item waves-effect" v-on:click="por_grupo(7)">Recomendado</li>
            <li class="list-group-item dropdown">
                <div class="dropdown-toggle" id="dropdownId" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">Grupo</div>
                    <div class="bg-white dropdown-menu dropright w-100" style="min-width:11rem;max-height:14rem;overflow-y:auto"
                    aria-labelledby="dropdownId">
                    <span class="p-1 dropdown-item" v-bind:key="grupo.id" v-for="grupo in $store.state.grupos" v-on:click="por_grupo(grupo.id)">
                        {{ grupo.grupo }}
                    </span>
                    <span class="p-1 dropdown-item" v-on:click="por_grupo(0)">
                    Todo
                    </span>
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    methods: {
        por_grupo(value){
            if(value == '-2'){
                this.inicio = "";
                this.perfil= "active";
            }
            else{
                this.inicio = "active";
                this.perfil= "";
            }
            localStorage.setItem('grupo',value)
            this.$store.dispatch('preguntas_get');
        },
    },
}
</script>
