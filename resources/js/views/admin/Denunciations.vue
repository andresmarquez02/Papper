<template>
    <dashboard>
        <div class="mt-5 mb-4">
            <div class="bg-white shadow-sm rounded p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <input
                                class="ml-1 form-control d-inline rounded-pill w-100 w-md-50 w-xl-40"
                                type="text" placeholder="🔎 Buscar"
                                v-model="query"
                                @keyup="searchDenunciation()"
                            >
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-opacity-primary waves-effect rounded-pill" v-on:click="denunciation = {id: 0, denunciation: ''}" data-toggle="modal" data-target="#modelCreateEdit">Nueva Denuncia</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Denuncia</th>
                                <th>Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item of denunciations" :key="item.id">
                                <td>{{ item.id }}</td>
                                <td>{{ item.denunciation }}</td>
                                <td>
                                    <span class="px-2 py-1 badge rounded-pill" :class='item.status ? "badge-success" : "badge-danger"'>
                                        <i class="fa" :class="item.status ? 'fa-check-circle-o' : 'fa-times-circle-o'" aria-hidden="true"></i>
                                        {{ item.status ? "Activa" : "Inactiva"}}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-opacity-warning rounded-pill waves-effect" v-on:click="denunciation = item" data-toggle="modal" data-target="#modelCreateEdit">Editar</button>
                                    <button type="button" class="btn rounded-pill waves-effect" :class='item.status ? "btn-opacity-danger" : "btn-opacity-success"' data-toggle="modal" data-target="#modelStatus" v-on:click="denunciation = item">
                                        {{ item.status ? "Inactivar" : "Activar"}}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <editsert-denunciation :denunciation="denunciation" :getDenunciations="getDenunciations" />
                <status-denunciation :denunciation="denunciation" :getDenunciations="getDenunciations" />
            </div>
        </div>
    </dashboard>
</template>
<script>
    import Vuex from "vuex";
    import { myFetch } from "../../helper/myFetch";
    export default {
        data() {
            return {
                denunciations: [],
                denunciationsAll: [],
                query: '',
                denunciation: {
                    id: 0,
                    denunciation: '',
                }
            }
        },
        mounted() {
            this.getDenunciations();
        },
        methods: {
            searchDenunciation(){
                this.denunciations = this.denunciationsAll;
                this.denunciations = this.denunciations.filter((denunciation) => {
                    if(this.query != ""){
                        return denunciation.denunciation.toLocaleLowerCase().indexOf(this.query.toLocaleLowerCase()) >= 0;
                    } else {
                        return denunciation;
                    }
                });
            },
            async getDenunciations(){
                this.loading(true);
                try {
                    let response = await myFetch().get('admin/denunciations');
                    this.denunciations = response.res.denunciations;
                    this.denunciationsAll = response.res.denunciations;
                    this.loading(false);
                } catch (error) {
                    this.loading(false);
                    alertify.error("Ha ocurrido un error, recarga la pagina.");
                }

            },
            ...Vuex.mapMutations(['loading']),
        },
    }
</script>
