<template>
    <dashboard>
        <div class="mt-2">
            <div class="m-0 row">
                <div class="p-4 bg-white rounded shadow-sm col-12">
                    <div class="px-3 mb-3 d-flex">
                        <div class="h4 font-weight-bold text-primary">Notificaciones</div>
                        <div class="ml-auto">
                            <span class="border border-dark rounded-circle d-flex justify-content-center align-items-center" style="height:2rem;width:2rem" role="button">
                                <i class="fa fa-retweet" v-on:click="getNotifications()"
                                aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <template v-for="notification in notifications">
                        <span class="py-3 dropdown-item" :key="notification.id">
                            <router-link :to="{name: 'profile', params: {username: notification.username}}" class="text-primary">
                                @{{ notification.username }}
                            </router-link>
                            <router-link :to="'/commentaries/'+notification.post_id">
                                {{ notification.description }}
                            </router-link>
                        </span>
                    </template>
                    <span class="dropdown-item" v-if="notifications === ''">
                    No tienes notificaciones</span>
                </div>
            </div>
        </div>
    </dashboard>
</template>
<script lang="js">
    import Vuex from 'vuex';
    export default {
        mounted(){
            this.getNotifications();
        },
        methods:{
            ...Vuex.mapActions(['getNotifications']),
        },
        computed: {
            ...Vuex.mapState(['notifications'])
        },
    }
</script>
