<template>
    <div class="align-items-center d-flex">
        <div class="d-none d-md-flex">
            <form action="" method="get" v-on:submit.prevent="search">
                <div class="input-group">
                    <select
                        class="form-control rounded-pill"
                        v-model="category"
                    >
                        <option value="0" selected> Todos </option>
                        <option v-for="category in categories" :value="category.id" v-bind:key="category.id">{{ category.category }}</option>
                    </select>
                    <input
                        class="ml-1 form-control d-inline rounded-pill"
                        type="text" placeholder="🔎 Buscar"
                        v-model="query"
                    >
                </div>
            </form>
        </div>
        <div class="d-md-none">
            <div class="dropdown">
                <span class="cursor-pointer ml-2" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </span>
                <div class="dropdown-menu" style="width:1141% !important" aria-labelledby="triggerId">
                    <div class="px-3 py-2">
                        <form action="" method="get" v-on:submit.prevent="search">
                            <div class="form-group">
                                <select
                                    class="form-control rounded-pill"
                                    v-model="category"
                                >
                                    <option value="0" selected> Todos </option>
                                    <option v-for="category in categories" :value="category.id" v-bind:key="category.id">{{ category.category }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input
                                    class="ml-1 form-control d-inline rounded-pill"
                                    type="text" placeholder="🔎 Buscar"
                                    v-model="query"
                                >
                            </div>
                            <div class="mb-2">
                                <button type="submit" class="btn btn-opacity-primary rounded-pill waves-effect w-100">Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex';
    import { myFetch } from '../helper/myFetch';

export default {
    data() {
        return {
            category: 0,
            query: '',
        }
    },
    methods: {
        ...Vuex.mapMutations(["loading"]),
        async search(){
            this.loading(true);
            try{
                if(this.category === '')  this.category = 0;

                if(this.query !== ""){
                    let response = await myFetch().get('posts/search/'+this.category+'/'+this.query);
                    if(response.status === 200){
                        this.$store.state.posts = response.res.posts;
                    } else {
                        throw(response);
                    }
                }
                this.loading(false);
            }
            catch(error){
                this.loading(false);
                alertify.error("Ha ocurrido un error inesperado");
            }

        }
    },
    computed: {
        ...Vuex.mapState(['categories','posts']),
    },
}
</script>
