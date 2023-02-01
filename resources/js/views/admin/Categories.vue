<template>
    <dashboard>
        <div class="mt-5 mb-4">
            <div class="p-4 bg-white rounded shadow-sm">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <div class="input-group">
                            <input
                                class="ml-1 form-control d-inline rounded-pill w-100 w-md-50 w-xl-40"
                                type="text" placeholder="🔎 Buscar"
                                v-model="query"
                                @keyup="searchCategory()"
                            >
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-opacity-primary waves-effect rounded-pill" v-on:click="category = {id: 0, category: ''}" data-toggle="modal" data-target="#modelCreateEdit">Nueva Categoria</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Categoria</th>
                                <th>Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item of categories" :key="item.id">
                                <td>{{ item.id }}</td>
                                <td>{{ item.category }}</td>
                                <td>
                                    <span class="px-2 py-1 badge rounded-pill" :class='item.status ? "badge-success" : "badge-danger"'>
                                        <i class="fa" :class="item.status ? 'fa-check-circle-o' : 'fa-times-circle-o'" aria-hidden="true"></i>
                                        {{ item.status ? "Activa" : "Inactiva"}}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-opacity-warning rounded-pill waves-effect" v-on:click="category = item" data-toggle="modal" data-target="#modelCreateEdit">Editar</button>
                                    <button type="button" class="btn rounded-pill waves-effect" :class='item.status ? "btn-opacity-danger" : "btn-opacity-success"' data-toggle="modal" data-target="#modelStatus" v-on:click="category = item">
                                        {{ item.status ? "Inactivar" : "Activar"}}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <editsert-category :category="category" :getCategories="getCategories" />
                <status-category :category="category" :getCategories="getCategories" />
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
                categories: [],
                categoriesAll: [],
                query: '',
                category: {
                    id: 0,
                    category: '',
                }
            }
        },
        mounted() {
            this.getCategories();
        },
        methods: {
            searchCategory(){
                this.categories = this.categoriesAll;
                this.categories = this.categories.filter((category) => {
                    if(this.query != ""){
                        return category.category.toLocaleLowerCase().indexOf(this.query.toLocaleLowerCase()) >= 0;
                    } else {
                        return category;
                    }
                });
            },
            async getCategories(){
                this.loading(true);
                try {
                    let response = await myFetch().get('admin/categories');
                    this.categories = response.res.categories;
                    this.categoriesAll = response.res.categories;
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
