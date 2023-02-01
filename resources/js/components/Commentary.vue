<template>
    <div class="px-4 pt-4 pb-2 my-3 bg-white card-preg">
        <div class="m-0 row">
            <div class="p-0 col-6 d-flex align-items-end">
                <router-link class="text-dark" :to="{name: 'profile', params: {username: commentary.username}}" style="color: #484e53 !important;text-decoration:none;height: 31px;">
                    {{ commentary.username }}
                </router-link>
                <small class="small-hora text-muted">&nbsp; - {{commentary.created_at}}</small>
            </div>
            <div class="p-0 col-6 d-flex justify-content-end" v-if="user !== null">
                <div class="dropdown dropleft" v-if="commentary.user_id == user.id">
                    <span class="cursor-pointer" id="triggerIdss" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="fa fa-ellipsis-v" style="color: #9c9898;" aria-hidden="true"></i>
                    </span>
                    <div class="dropdown-menu dropleft" style="right:0" v-if="commentary.user_id == user.id" aria-labelledby="triggerIdss">
                        <h6 class="cursor-pointer dropdown-item" v-on:click="modelDelete(commentary.id)"
                            data-toggle="modal" data-target="#modelEliminarc">Eliminar</h6>
                    </div>
                </div>
            </div>
        </div>
        <p class="comment" v-html="commentary.commentary"></p>
        <div>
            <span v-on:click="reactionCommentary(commentary,keyCommentary)" class="cursor-pointer">
                <i
                    :class="[commentary.my_like ? 'text-danger fa-heart' : 'text-dark fa-heart-o']"
                    class="cursor-pointer fa fa-regular h5"
                    aria-hidden="true"
                >
                </i>
                <span class="mr-2" :class="[commentary.my_like ? 'text-danger' : 'text-dark']">{{commentary.reactions}}</span>
            </span>
        </div>
    </div>
</template>
<script>
    import Vuex from "vuex";
    import { myFetch } from '../helper/myFetch';

    export default {
        props: ['commentary','keyCommentary','modelDelete','commentaries'],
        methods: {
            async reactionCommentary(commentary, keyCommentary){
                // Si el user no esta logueado lo redirige al login
                if(this.user === null) {
                    return this.$router.push({name : 'login'});
                }

                if(commentary.my_like > 0){
                    commentary.reactions = commentary.reactions - 1;
                } else {
                    commentary.reactions = commentary.reactions + 1;
                }
                commentary.my_like = !commentary.my_like;

                await myFetch().post('reacted/commentary/'+commentary.id,{});
            }
        },
        computed: {
            ...Vuex.mapState(['user']),
        },
    }
</script>
