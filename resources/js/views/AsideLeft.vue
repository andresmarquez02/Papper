<template>
    <div class="col-md-2 col-sm-12" style="word-break:break-all">
        <ul class="list-group pt-3 my-3 position-fixed-md col-lg-2 pr-0">
            <li class="list-group-item" v-on:click="por_grupo(-1)">Populares</li>
            <li class="list-group-item" style="cursor:not-allowed !important">Recomendados</li>
            <li class="list-group-item dropdown">
                <div class="dropdown-toggle" id="dropdownId" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">Grupo</div>
                    <div class="dropdown-menu bg-white dropright w-100" style="min-width:11rem;max-height:14rem;overflow-y:auto"
                    aria-labelledby="dropdownId">
                    <span class="dropdown-item p-1" v-for="grupo in $store.state.grupos" v-on:click="por_grupo(grupo.id)">
                        {{ grupo.grupo }}
                    </span>
                    <span class="dropdown-item p-1" v-on:click="por_grupo(0)">
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
