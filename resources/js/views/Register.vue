<template>
    <div>
        <div class="d-flex min-vh-100 bg-font">
            <div class="m-auto w-xl-30rem w-lg-40 w-md-50 w-sm-75 w-95">
                <div class="p-4 my-3 card-login rounded-xl">
                    <div class="mt-3 form-group">
                        <h2 class="mb-1 text-center font-weight-bold text-dark">
                            Registro
                        </h2>
                        <div class="mb-3 text-center text-muted h4">Bienvenido a Papper</div>
                    </div>
                    <form v-on:submit.prevent="register()" autocomplete="false">
                        <!-- Grupo de html para el usuario -->
                        <div class="mb-3 form-group">
                            <label class="mb-0 ml-2 small">Usuario</label>
                            <input type="text"
                                maxlength="254"
                                minlength="5"
                                class="form-control rounded-pill"
                                :class="{
                                    'is-invalid': submitted && $v.user.username.$error
                                }"
                                placeholder="papper_admin"
                                name="user"
                                v-model="user.username"
                            >
                            <div
                                v-if="submitted && !$v.user.username.required"
                                class="invalid-feedback"
                            >
                                El user es requerido
                            </div>
                        </div>
                        <!-- Grupo de html para el Correo -->
                        <div class="mb-3 form-group">
                            <label class="mb-0 ml-2 small">Correo</label>
                            <input type="email"
                                maxlength="254"
                                minlength="5"
                                class="form-control rounded-pill "
                                :class="{
                                    'is-invalid': submitted && $v.user.email.$error
                                }"
                                placeholder="Ej:andres03marquez@gmail.com"
                                name="email"
                                v-model="user.email"
                            >
                            <div
                                v-if="submitted && !$v.user.email.required"
                                class="invalid-feedback"
                            >
                                El correo es requerido
                            </div>
                        </div>
                        <!-- Grupo de html para la contraseña -->
                        <div class="mb-3 form-group">
                            <label class="mb-0 ml-2 small">Contraseña</label>
                            <div class="input-group">
                                <input :type="password"
                                    maxlength="254"
                                    minlength="5"
                                    class="form-control rounded-pill-left"
                                    :class="{
                                        'is-invalid': submitted && $v.user.password.$error
                                    }"
                                    placeholder="******"
                                    name="password"
                                    aria-label=""
                                    aria-describedby="button-addon2"
                                    v-model="user.password"
                                >
                                <div class="input-group-append">
                                <button class="btn btn-text-dark waves-effect btn-sm rounded-pill-right" v-on:click="SeePassword()" type="button" id="button-addon2"><i class="fa" :class="eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div
                                v-if="submitted && !$v.user.password.required"
                                class="invalid-feedback"
                            >
                                La contraseña es requerida
                            </div>
                        </div>
                        <div class="mb-4 form-group">
                            <label class="mb-0 ml-2 small">Confirmar Contraseña</label>
                            <input :type="password"
                                maxlength="254"
                                minlength="5"
                                class="form-control rounded-pill"
                                :class="{
                                    'is-invalid': submitted && $v.user.password_confirmation.$error
                                }"
                                placeholder="******"
                                name="password"
                                v-model="user.password_confirmation"
                            >
                            <div
                                v-if="submitted && !$v.user.password_confirmation.required"
                                class="invalid-feedback"
                            >
                                La confirmacion de la contraseña es requerida
                            </div>
                        </div>
                        <!-- Boton de registrarme -->
                        <div class="pt-2 mb-4 d-flex justify-content-center">
                            <button type="submit" class="btn btn-opacity-primary waves-effect waves-light rounded-pill w-100">
                                Registrarme
                            </button>
                        </div>
                    </form>
                    <!-- Link para ir a login  -->
                    <div class="pb-3 pr-3 d-flex justify-content-end">
                        <router-link  class="small text-muted" role="button"
                            :to="{name: 'login'}">¿Ya tienes una cuenta? Ingresa.
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Vuex from 'vuex'
import { myFetch } from '../helper/myFetch';
import { required, email, minLength, sameAs } from "vuelidate/lib/validators";

export default {
    data(){
        return {
            password: 'password',
            eye: "fa-eye",
            submitted: false,
            user: {
                username: "",
                email: "",
                password: "",
                password_confirmation: ""
            },
        }
    },
    validations: {
        user: {
            username: { required },
            email: { required, email },
            password: { required, minLength: minLength(6) },
            password_confirmation: { required, sameAsPassword: sameAs("password") }
        }
    },
    methods: {
        // Mapeo de la mutacion loading para el preload
        ...Vuex.mapMutations(["loading"]),

        // Funcion para ver la contraseña del input
        SeePassword(){
            if(this.password == 'password'){
                this.eye = "fa-eye-slash";
                this.password = 'text';
            }
            else{
                this.eye = "fa-eye";
                this.password = 'password';
            }
        },

        // Registro de user
        async register(){
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) {
                alertify.error("Debe llenar todos los campos correctamente");
                return;
            }
            // Activacion del loading (Funcion que se encuentra en el store)
            this.loading(true);
            try {

                //Hacemos un envio de datos mediante la libreria que se creo.
                const response = await myFetch().post("register",{body:this.user});
                // validacion de respuesta
                if(response.status !== 200){
                    // Paso a catch para mostrar el error
                    throw(response.res);
                } else {
                    // Paso del loadign a false
                    this.loading(false);
                    // Paso del loadign a false
                    this.loading(false);
                    this.user = {
                        username: "",
                        email: "",
                        password: "",
                        password_confirmation: ""
                    }
                    // Respuesta exitosa
                    alertify.success(response.res.success);
                    this.$router.push("/login");
                }
            } catch (errors) {
                // Paso del loadign a false
                this.loading(false);
                // Muestra del error
                let { user, email, password, err } = errors.errors;

                if(user !== undefined && user.length > 0) return alertify.error(user[0]);
                if(email !== undefined && email.length > 0) return alertify.error(email[0]);
                if(password !== undefined && password.length > 0) return alertify.error(password[0]);
                if(err !== undefined && err.length > 0) return alertify.error(err[0]);
            }
        }
    },
}
</script>
