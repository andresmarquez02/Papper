<template>
    <dashboard>
        <div class="p-4 my-4 bg-white rounded shadow-sm">
            <div class="mb-4 d-fex justify-content-end">
                <form action="" method="get" v-on:submit.prevent="searchUser">
                    <div class="mb-3 input-group">
                        <select class="mr-1 custom-select rounded-pill" name="status" v-model="status" v-on:change="searchUser">
                            <option selected value="">Seleccione un estatus</option>
                            <option value="0">Bloqueado</option>
                            <option value="1">Activo</option>
                        </select>
                        <input type="text" class="mr-1 form-control rounded-pill" placeholder="nombre de usuario o correo" aria-describedby="button-addon2" v-model="emailUsername" v-on:keyup="searchUser">
                        <div class="input-group-append">
                            <button class="btn btn-opacity-primary rounded-pill waves-effect" type="submit" id="button-addon2">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive" v-if="errorSearch">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Estatus</th>
                            <th>F/Registro</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="user in users">
                            <user :user="user" :setUserId="setUserId" :key="user.id" />
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="my-4" v-else>
                <div class="text-center h3">
                    No se han encotrado usuarios <br> con estas especificaciones
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modelBlockUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cabir estatus de la cuenta</h5>
                                <button type="button" class="close" id="closemodalUser" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            ¿Esta seguro que desea cambiar el estatus de esta cuenta?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-opacity-dark rounded-pill waves-effect" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-opacity-primary rounded-pill waves-effect" v-on:click="closeAccount">Si, Cambiar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </dashboard>
</template>
<script>
    import Vuex from 'vuex'
    import { myFetch } from '../../helper/myFetch';

    export default {
        data() {
            return {
                users: [],
                usersAll: [],
                userId: 0,
                status: '',
                emailUsername: '',
                errorSearch: true
            }
        },
        created() {
            this.getUsers();
        },
        methods: {
            async getUsers(){
                this.loading(true);
                try {
                    let response = await myFetch().get("admin/users");
                    if(response.status === 200){
                        this.users = response.res.users;
                        this.usersAll = response.res.users;
                    } else {
                        throw(response);
                    }
                    this.loading(false);
                } catch (error) {
                    this.loading(false);
                    alertify.error("Ha ocurrido un error intenta mas tarde :)");
                }
            },
            searchUser(){
                this.users = this.usersAll;
                this.errorSearch = true;

                if(this.status !== ""){
                    this.users = this.users.filter((user) => {
                        return user.status == this.status;
                    });
                }

                if(this.emailUsername !== ""){
                    this.users = this.users.filter((user) => {
                        if(user.email.toLocaleLowerCase().indexOf(this.emailUsername.toLocaleLowerCase()) >= 0){
                            return user.email.toLocaleLowerCase().indexOf(this.emailUsername.toLocaleLowerCase()) >= 0;
                        } else if(user.username.toLocaleLowerCase().indexOf(this.emailUsername.toLocaleLowerCase()) >= 0) {
                            return user.username.toLocaleLowerCase().indexOf(this.emailUsername.toLocaleLowerCase()) >= 0;
                        }
                    });
                }
                if(this.users.length === 0){
                    this.errorSearch = false;
                }
            },
            setUserId(id){
                this.userId = id;
            },
            async closeAccount(){
                this.loading(true);
                try {
                    let response = await myFetch().get(`admin/change/status/account/${this.userId}`);
                    if(response.status === 200){
                        this.loading(false);
                        this.getUsers();
                        document.getElementById('closemodalUser').click();
                    } else {
                        throw(response);
                    }
                } catch (error) {
                    this.loading(false);
                    alertify.error("Ha ocurrido un error intenta mas tarde :)");
                }
            },
            ...Vuex.mapMutations(['loading']),
        },
    }
</script>
