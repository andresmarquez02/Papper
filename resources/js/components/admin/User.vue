<template>
    <tr>
        <td>{{ user.id }}</td>
        <td>
            <div class="line-user">
                <router-link :to="'/profile/'+user.username" style="color: #484e53 !important;text-decoration:none">
                    {{ user.username }}
                </router-link>
            </div>
            <small class="text-muted">{{ user.email }}</small>
        </td>
        <td>
            <span class="px-2 py-1 badge badge-danger rounded-pill" v-if="!user.status">
                <i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Bloqueado
            </span>
            <span class="px-2 py-1 badge badge-success rounded-pill" v-else>
                <i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Activo
            </span>
        </td>
        <td>{{ user.created_at }}</td>
        <td>
            <button type="button" class="btn rounded-pill waves-effect" :class='user.status ? "btn-opacity-warning" : "btn-opacity-success"' data-toggle="modal" data-target="#modelBlockUser" v-on:click="setUserId(user.id)">{{user.status ? "Bloquear" : "Desbloquear"}}</button>
        </td>
    </tr>
</template>
<script>
export default {
    props: ['user','setUserId'],
}
</script>
<style scoped>
    .line-user{
        line-height: 1rem
    }
</style>
