<template>
    <div class="px-4 py-3 mt-2 mb-3 card-preg">
        <div class="m-0 row position-relative">
            <div class="p-0 col-6 d-flex align-items-end">
                <router-link class="text-dark" :to="{name: 'profile', params: {username: post.username}}" style="color: #484e53 !important;text-decoration:none;height: 31px;">
                    {{ post.username }}
                </router-link>
                <small class="small-hora text-muted">&nbsp; - {{post.created_at}}</small>
            </div>
            <div v-if="posts !== ''" class="p-0 col-6 d-flex justify-content-end">
                <div v-if="user !== null">
                    <div class="dropdown dropleft" >
                        <span class="cursor-pointer" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="fa fa-ellipsis-v" style="color: #9c9898;" aria-hidden="true"></i> </span>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <span class="cursor-pointer dropdown-item" v-if="post.user_id != user.id" v-on:click="modelDenunciation(post)"
                                data-toggle="modal" data-target="#modelDenunciedPost">Denunciar</span>
                            <span class="cursor-pointer dropdown-item" v-if="post.user_id == user.id" v-on:click="modelEdit(post)"
                                data-toggle="modal" data-target="#modelEditPost">Editar</span>
                            <span class="cursor-pointer dropdown-item" v-if="post.user_id == user.id" v-on:click="modelDelete(post.id)"
                                data-toggle="modal" data-target="#modelDeletePost">Eliminar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <h5 class="mb-1 font-weight-bold position-relative">{{ post.title }}</h5>
            <p class="mb-1 text-muted">
                {{post.description.substring(0, 200)}}
                <span v-if="post.description.length >200" class="text-primary">Ver mas...</span>
                <!-- <i class="fa fa-quote-right ss-small" aria-hidden="true"></i> -->
            </p>
            <div class="mb-2">
                <small><i class="fa fa-hashtag" aria-hidden="true"></i> {{post.category}}</small>
            </div>
        </div>
        <div>
            <span v-on:click="reaction(post,keyPost)" class="mr-3 cursor-pointer">
                <i class="cursor-pointer fa fa-regular" aria-hidden="true" :class="[post.my_like ? 'text-danger fa-heart' : 'text-dark fa-heart-o']"></i>
                <span class="ml-1" :id="'reactions'+post.id" :class="[post.my_like ? 'text-danger' : '']">{{post.reactions}}</span>
            </span>
            <span class="mr-3 cursor-pointer">
                <router-link class="text-dark" :to="'/commentaries/'+post.id" style="color: #484e53 !important;text-decoration:none">
                    <span>
                        <i class="cursor-pointer fa fa-comment-o" aria-hidden="true"></i>
                        <span class="ml-1">{{ post.commentaries }}</span>
                    </span>
                </router-link>
            </span>
            <span v-if="user">
                <span v-if="user.role_id == 1" data-toggle="modal" data-target="#modelDenunciation">
                    <span class="cursor-pointer" data-toggle="tooltip" data-placement="top" title="Denuncias Recibidas" v-on:click="getDenunciation(post.id)" v-if="post.denunciations > 0">
                        <i class="cursor-pointer fa fa-fist-raised" aria-hidden="true"></i>
                         {{ post.denunciations }}
                    </span>
                </span>
            </span>
        </div>
    </div>
</template>
<script>
    import { myFetch } from '../helper/myFetch';
    import Vuex from 'vuex';

    export default {
        props: ['post','keyPost','modelEdit','modelDelete', 'denunciations','setDenunciations'],
        methods: {
            async reaction(post,keyPost){
                if(this.user == null)
                    return this.$router.push("/login");

                try {
                    let response = await myFetch().post('reacted/'+post.id);
                    if(response.status !== 200) throw(response.res);
                } catch (error) {
                    alertify.error("Intenta de nuevo");
                    return 0;
                }

                if(post.my_like > 0){
                    this.post.reactions = post.reactions - 1;
                } else {
                    this.post.reactions = post.reactions + 1;
                }
                this.post.my_like = !post.my_like;
            },
            async getDenunciation(id){
                this.loading(true);
                try {
                    let response = await myFetch().get('admin/denunciations/post/'+id);
                    if(response.status !== 200) throw(response.res);
                    this.setDenunciations(response.res.denunciations);
                    this.loading(false);
                } catch (error) {
                    alertify.error("Intenta de nuevo");
                    this.loading(false);
                    return 0;
                }
            },
            async modelDenunciation(post){
                this.loading(true);
                try {
                    let response = await myFetch().get('denunciations');
                    if(response.status !== 200) throw(response.res);
                    this.setDenunciations(response.res.denunciations, post.id);
                    this.loading(false);
                } catch (error) {
                    alertify.error("Intenta de nuevo");
                     this.loading(false);
                }
            },
            ...Vuex.mapMutations(['loading']),
        },
        computed: {
            ...Vuex.mapState(['posts','user']),
        },
    }
</script>
<style lang="css">
    a{
        color: #484e53 !important;
        text-decoration: none;
    }
</style>
