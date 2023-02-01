<template>
    <dashboard>
        <div>
            <div class="d-flex justify-content-center" v-if="userProfile !== ''">
                <div class="pt-1 mt-2 mb-2">
                    <h3 class="text-center font-weight-bold">@{{ userProfile.username }}</h3>
                    <div class="text-center text-muted small">Registrado el: {{ userProfile.created_at }}</div>
                    <div class="text-center text-muted small">Publicaciones: {{countPosts}}</div>
                </div>
            </div>
            <posts />
        </div>
    </dashboard>
</template>
<script lang="js">
    import Vuex from 'vuex';
    export default {
        created() {
            // Publicaciones
            this.$store.state.usernameProfile = this.$route.params.username;
            this.getPostsUser();
        },
        methods: {
            ...Vuex.mapActions(['getPostsUser']),
        },
        computed: {
            ...Vuex.mapState(['userProfile', 'posts', 'countPosts']),
        },
    }
</script>
