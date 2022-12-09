<template>
    <div>
        <div class="d-flex min-vh-100 bg-font">
            <div class="p-4 mx-auto my-auto card-login rounded-xl w-lg-50 w-md-60 w-sm-75 w-95">
                <div class="mt-3 form-group">
                    <h2 class="mb-1 text-center font-weight-bold text-dark">
                        Login
                    </h2>
                    <div class="mb-3 text-center text-muted h4">Ingresa a Papper</div>
                </div>
                <form v-on:submit.prevent="login($event)">
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
                    <div class="form-group d-flex justify-content-center mt-2">
                        <button type="submit" class="btn btn-text-primary w-100 waves-effect waves-light rounded-pill">
                            Ingresar
                        </button>
                    </div>
                </form>
                 <!-- Link para ir a registro  -->
                <div class="pb-3 pr-3 d-flex justify-content-end">
                    <router-link  class="text-muted small" role="button"
                        :to="{name: 'papper_register'}">¿Aun no tienes una cuenta?
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vuex from 'vuex'
    import { myFetch } from '../helper/myFetch';
    import { required, email, minLength } from "vuelidate/lib/validators";

    export default {
        data() {
            return {
                usuario: {
                    correo: 'andresprueba@gmail.com',
                    contrasena: '123123'
                },
                password: 'password',
                eye: "fa-eye",
                submitted: false,
            }
        },
        validations: {
            usuario: {
                correo: { required, email },
                contrasena: { required, minLength: minLength(6) },
            }
        },
        methods: {
            // Mapeo de la mutacion loading para el preload
            ...Vuex.mapMutations(["loading"]),
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
            async login(event){
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
                    const response = await myFetch().post("login",{body:this.usuario});

                    // validacion de respuesta
                    if(response.status !== 200){
                        // Paso a catch para mostrar el error
                        throw(response.res);
                    } else {
                        // Paso del loadign a false
                        this.loading(false);
                        // Respuesta exitosa
                        this.usuario = {
                            correo: "",
                            contrasena: "",
                        }
                        localStorage.setItem("logueado","Si");
                        this.$router.push({ name: 'principal' });
                        alertify.success(response.res.exito);
                    }
                } catch (errors) {
                    // Paso del loadign a false
                    this.loading(false);

                    // Muestra del error
                    let { correo, contrasena, err } = errors.errors;

                    if(correo !== undefined) return alertify.error(correo[0]);
                    if(contrasena !== undefined) return alertify.error(contrasena[0]);
                    if(err !== undefined) return alertify.error(err[0]);
                }
            }
        },
    }
</script>
