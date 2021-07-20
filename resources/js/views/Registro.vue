<template>
    <div style="padding-top:4rem">
        <div class="d-flex justify-content-center align-items-center" style="min-height:calc(100vh - 4rem);">
            <div class="bg-light-50 shadow-double w-50-75 rounded-xl">
                <div class="form-group mt-3">
                    <div class="d-flex justify-content-center">
                        <h1 class="font-weight-bold">Registro</h1>
                    </div>
                </div>
                <form v-on:keyup.enter="ingress()">
                    <div class="form-group">
                        <div class="d-flex justify-content-center">
                            <label for="" class="text-dark">Usuario</label>
                        </div>
                        <div class="d-flex justify-content-center">
                        <input type="text" maxlength="254" minlenght="5" class="form-control bg-light-50 rounded-pill w-75-90" v-model="nombreApellido">
                        </div>
                        <div class="d-flex justify-content-center">
                            <small id="helpId" class="text-white text-center w-100">Debe tener minimo 5 caracteres</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-center">
                            <label for="" class="text-dark">Correo</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <input type="email" maxlength="254" minlenght="5" class="form-control bg-light-50 rounded-pill w-75-90" v-model="correo">
                        </div>
                        <div class="d-flex justify-content-center">
                            <small id="helpId" class="text-white">Ej. prueba34@gmail.com</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-center">
                            <label for="" class="text-dark ">Contraseña</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="input-group w-75-90">
                              <input :type="password" maxlength="254" minlenght="5" class="form-control bg-light-50 rounded-pill-left w-75-90" v-model="contrasena" aria-label="" aria-describedby="button-addon2">
                              <div class="input-group-append">
                                <button class="btn btn-primary" v-on:click="ver_contrasena()" type="button" id="button-addon2 rounded-pill-right">ver</button>
                              </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <small id="helpId" class="text-white">La contraseña debe tener minimo 5 caracteres</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-dark rounded-pill btn-lg"
                            v-on:click="register()">Registrarme</button>
                        </div>
                    </div>
                </form>
                <div class="row m-0 mb-2">
                    <div class="col-12 d-flex justify-content-end">
                        <div>
                        <router-link  class="btn btn-link text-dark"
                            :to="{name: 'papper_login'}">¿Ya tengo una cuenta?</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            nombreApellido: '',
            correo: '',
            contrasena: '',
            password: 'password'
        }
    },
    methods: {
        ver_contrasena(){
            if(this.password == 'password')this.password = 'text';
            else this.password = 'password';
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
                formulario.append('an',this.nombreApellido);
                formulario.append('contrasena',this.contrasena);
                try {
                    const consulta = await fetch('register',{
                        method: 'POST',
                        body: formulario,
                        headers: {
                            'X-CSRF-TOKEN': this.$store.state.token
                        }
                    });
                    const respuesta = await consulta.text();
                    if(respuesta == "2"){
                        alertify.success("Entrando...");
                        location.href = "./papper/home";
                    }
                    else if(respuesta == "1"){
                        carga.classList.remove("d-flex");
                        carga.classList.add("d-none");
                        alertify.error("Este correo ya existe");
                    }
                    else if(respuesta == "3"){
                        carga.classList.remove("d-flex");
                        carga.classList.add("d-none");
                        alertify.error("Error de validación");
                    }
                    else if(respuesta == "4"){
                        carga.classList.remove("d-flex");
                        carga.classList.add("d-none");
                        alertify.error("Este usuario ya se esta usando.");
                    }
                    else{
                        carga.classList.remove("d-flex");
                        carga.classList.add("d-none");
                        alertify.error("Datos incorrectos");
                        alertify.error("La contraseña debe ser de minimo 5 caracteres");
                    }
                } catch (error) {
                    // alertify.error("Correo o contraseña erronea");
                }
                // location.href="./pappers";
            }
            else{
                alertify.error("Debe rellenar todos los campos",10000);
                alertify.error("Recuerde que debe ser un formato de correo valido",10000);
            }
        }
    },
}
</script>
