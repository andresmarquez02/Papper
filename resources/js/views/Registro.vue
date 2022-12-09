<template>
    <div>
        <div class="d-flex min-vh-100 bg-font">
            <div class="p-4 mx-auto my-auto card-login rounded-xl w-lg-50 w-md-60 w-sm-75 w-95">
                <div class="mt-3 form-group">
                    <h2 class="mb-1 text-center font-weight-bold text-dark">
                        Registro
                    </h2>
                    <div class="mb-3 text-center text-muted h4">Bienvenido a Papper</div>
                </div>
                <form v-on:submit.prevent="register()" autocomplete="false">
                    <!-- Grupo de html para el usuario -->
                    <div class="mb-2 form-group">
                        <label class="mb-0 ml-2 small">Usuario</label>
                        <input type="text"
                            maxlength="254"
                            minlength="5"
                            class="form-control rounded-pill"
                            :class="{
                                'is-invalid': submitted && $v.usuario.usuario.$error
                            }"
                            placeholder="papper_admin"
                            name="usuario"
                            v-model="usuario.usuario"
                        >
                        <div
                            v-if="submitted && !$v.usuario.usuario.required"
                            class="invalid-feedback"
                        >
                            El usuario es requerido
                        </div>
                    </div>
                    <!-- Grupo de html para el correo -->
                    <div class="mb-2 form-group">
                        <label class="mb-0 ml-2 small">Correo</label>
                        <input type="email"
                            maxlength="254"
                            minlength="5"
                            class="form-control rounded-pill "
                            :class="{
                                'is-invalid': submitted && $v.usuario.correo.$error
                            }"
                            placeholder="Ej:andres03marquez@gmail.com"
                            name="correo"
                            v-model="usuario.correo"
                        >
                        <div
                            v-if="submitted && !$v.usuario.correo.required"
                            class="invalid-feedback"
                        >
                            El correo es requerido
                        </div>
                    </div>
                    <!-- Grupo de html para la contraseña -->
                    <div class="mb-2 form-group">
                        <label class="mb-0 ml-2 small">Contraseña</label>
                        <div class="input-group">
                            <input :type="password"
                                maxlength="254"
                                minlength="5"
                                class="form-control rounded-pill-left"
                                :class="{
                                    'is-invalid': submitted && $v.usuario.contrasena.$error
                                }"
                                placeholder="******"
                                name="contrasena"
                                aria-label=""
                                aria-describedby="button-addon2"
                                v-model="usuario.contrasena"
                            >
                            <div class="input-group-append">
                            <button class="btn btn-text-dark waves-effect btn-sm rounded-pill-right" v-on:click="verContrasena()" type="button" id="button-addon2"><i class="fa" :class="eye" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div
                            v-if="submitted && !$v.usuario.contrasena.required"
                            class="invalid-feedback"
                        >
                            La contraseña es requerida
                        </div>
                    </div>
                    <div class="mb-2 form-group">
                        <label class="mb-0 ml-2 small">Confirmar Contraseña</label>
                        <input :type="password"
                            maxlength="254"
                            minlength="5"
                            class="form-control rounded-pill"
                            :class="{
                                'is-invalid': submitted && $v.usuario.confirmContrasena.$error
                            }"
                            placeholder="******"
                            name="contrasena"
                            v-model="usuario.confirmContrasena"
                        >
                        <div
                            v-if="submitted && !$v.usuario.confirmContrasena.required"
                            class="invalid-feedback"
                        >
                            La confirmacion de la contraseña es requerida
                        </div>
                    </div>
                    <!-- Boton de registrarme -->
                    <div class="mb-2 form-group">
                        <div class="d-flex justify-content-center mt-2">
                            <button type="submit" class="btn btn-text-primary waves-effect waves-light rounded-pill w-100">
                                Registrarme
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Link para ir a login  -->
                <div class="pb-3 pr-3 d-flex justify-content-end">
                    <router-link  class="text-muted small" role="button"
                        :to="{name: 'papper_login'}">¿Ya tienes una cuenta?
                    </router-link>
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
            usuario: {
                usuario: "",
                correo: "",
                contrasena: "",
                confirmContrasena: ""
            },
        }
    },
    validations: {
        usuario: {
            usuario: { required },
            correo: { required, email },
            contrasena: { required, minLength: minLength(6) },
            confirmContrasena: { required, sameAsPassword: sameAs("contrasena") }
        }
    },
    methods: {
        // Mapeo de la mutacion loading para el preload
        ...Vuex.mapMutations(["loading"]),

        // Funcion para ver la contraseña del input
        verContrasena(){
            if(this.password == 'password'){
                this.eye = "fa-eye-slash";
                this.password = 'text';
            }
            else{
                this.eye = "fa-eye";
                this.password = 'password';
            }
        },

        // Registro de usuario
        async register(){
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) {
                alertify.error("Debe llenar todos los campos correctamente");
                return;
            }
            try {
                // Activacion del loading (Funcion que se encuentra en el store)
                this.loading(true);
                //Hacemos un envio de datos mediante la libreria que se creo.
                const response = await myFetch().post("register",{body:this.usuario});
                // validacion de respuesta
                if(response.status !== 200){
                    // Paso a catch para mostrar el error
                    throw(response.res);
                } else {
                    // Paso del loadign a false
                    this.loading(false);
                    this.usuario = {
                        usuario: "",
                        correo: "",
                        contrasena: "",
                        confirmContrasena: ""
                    }
                    // Respuesta exitosa
                    alertify.success(response.res.exito);
                    this.$router.push("../../login");
                }
            } catch (errors) {
                // Paso del loadign a false
                this.loading(false);

                // Muestra del error
                let { usuario, correo, contrasena, err } = errors.errors;

                if(usuario !== undefined && usuario.length > 0) return alertify.error(usuario[0]);
                if(correo !== undefined && correo.length > 0) return alertify.error(correo[0]);
                if(contrasena !== undefined && contrasena.length > 0) return alertify.error(contrasena[0]);
                if(err !== undefined && err.length > 0) return alertify.error(err[0]);
            }
        }
    },
}
</script>
