<template>
    <div style="padding-top:4.5rem;">
        <div class="d-flex justify-content-center align-items-center height-sm height-md">
            <div class="bg-light-50 w-50-75 card-login rounded-xl">
                <div class="py-2 mt-3">
                    <h2 class="text-center font-weight-bold text-dark">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                        <br>
                        Registro
                    </h2>
                </div>
                <form v-on:submit.prevent="register()" autocomplete="false">
                    <div class="my-3 form-group">
                        <div class="d-flex justify-content-center">
                            <input type="text" maxlength="254" minlength="5" class="form-control rounded-pill w-75-90" placeholder="Usuario" v-model="nombreApellido">
                        </div>
                    </div>
                    <div class="my-3 form-group">
                        <div class="d-flex justify-content-center">
                            <input type="email" maxlength="254" minlength="5" class="form-control rounded-pill w-75-90" placeholder="Correo" v-model="correo">
                        </div>
                    </div>
                    <div class="my-3 form-group">
                        <div class="d-flex justify-content-center">
                            <div class="input-group w-75-90">
                              <input :type="password" maxlength="254" minlength="5" class="form-control rounded-pill-left w-75-90" placeholder="Contraseña" v-model="contrasena" aria-label="" aria-describedby="button-addon2">
                              <div class="input-group-append">
                                <button class="btn btn-dark waves-effect btn-sm rounded-pill-right" v-on:click="ver_contrasena()" type="button" id="button-addon2"><i class="fa" :class="eye" aria-hidden="true"></i></button>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-3 form-group">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary waves-effect rounded-pill">
                                 Registrarme
                            </button>
                        </div>
                    </div>
                </form>
                <div class="m-0 mb-2 row">
                    <div class="pb-3 pl-4 col-11 d-flex justify-content-end">
                        <div>
                            <router-link  class="text-muted small" role="button"
                                :to="{name: 'papper_login'}">¿Ya tienes una cuenta?
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted(){
        localStorage.setItem("grupo",0);
    },
    data(){
        return {
            nombreApellido: '',
            correo: '',
            contrasena: '',
            password: 'password',
            eye: "fa-eye"
        }
    },
    methods: {
        ver_contrasena(){
            if(this.password == 'password'){
                this.eye = "fa-eye-slash";
                this.password = 'text';
            }
            else{
                this.eye = "fa-eye";
                this.password = 'password';
            }
        },
        async register(){
            const regular = {
                correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/,
                nombres: /^[a-zA-ZA0-9\_\-]{5,20}$/
            };
            if(regular.correo.test(this.correo) && this.contrasena != "" &&
            regular.nombres.test(this.nombreApellido)){
                let carga = document.querySelector("#carga");
                carga.classList.remove("d-none");
                carga.classList.add("d-flex");
                let formulario = new FormData();
                formulario.append('correo',this.correo);
                formulario.append('usuario',this.nombreApellido);
                formulario.append('contrasena',this.contrasena);
                try {
                    const consulta = await fetch('register',{
                        method: 'POST',
                        body: formulario,
                        headers: {
                            'X-CSRF-TOKEN': this.$store.state.token,
                            'Accept': 'application/json'
                        }
                    });
                    const respuesta = await consulta.json();
                    if(consulta.status !== 200)
                        throw([respuesta,consulta.status]);
                    if(consulta.status === 200){
                        alertify.success(respuesta.exito);
                        this.$router.push("../../login");
                    }
                } catch (errors) {
                    carga.classList.remove("d-flex");
                    carga.classList.add("d-none");
                    if(errors[1] == 422){
                        if(errors[0].errors.usuario)
                            return alertify.error(errors[0].errors.usuario);
                        if(errors[0].errors.correo)
                            return alertify.error(errors[0].errors.correo);
                        if(errors[0].errors.contrasena)
                            return alertify.error(errors[0].errors.contrasena);
                    }
                    else if(errors[1] == 500){
                        if(errors[0].error)
                            alertify.error(errors[0].error);
                    }
                }
            }
            else{
                alertify.error("Debe rellenar todos los campos");
            }
        }
    },
}
</script>
