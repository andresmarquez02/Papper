<template>
    <div style="padding-top:4.5rem">
        <div class="d-flex justify-content-center align-items-center" style="min-height:calc(100vh - 4.5rem);" v-on:keyup.enter="ingress()">
            <div class="bg-light-50 shadow-double py-4 rounded-xl w-50-75">
                <div class="form-group mt-3">
                    <div class="d-flex justify-content-center">
                        <h1 class="font-weight-bold">Iniciar sesion</h1>
                    </div>
                </div>

                    <div class="form-group">
                        <div class="d-flex justify-content-center">
                            <label for="" class="text-dark">Correo</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <input type="email" class="form-control bg-light-50 rounded-pill w-75-90" v-model="correo">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-center">
                            <label for="" class="text-dark ">Contraseña</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <input type="password" class="form-control bg-light-50 rounded-pill w-75-90" v-model="contrasena">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-dark rounded-pill btn-lg"
                            v-on:click.prevent="ingress()">Ingresar</button>
                        </div>
                    </div>

                <div class="row m-0 mb-2">
                    <div class="col-12 d-flex justify-content-end">
                        <div class="d-flex justify-content-end">
                        <router-link class="btn btn-link text-dark"
                           :to="{name: 'papper_register'}">¿Aun no tienes una cuenta?</router-link>
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
            correo: '',
            contrasena: ''
        }
    },
    methods: {
        async ingress(){
            const regular = {
                correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/,
                contrasenna: /^.{1,400}$/,
            };
            if(regular.correo.test(this.correo) && this.contrasena !== ""){
                let carga = document.querySelector("#carga");
                carga.classList.remove("d-none");
                carga.classList.add("d-flex");
                let formulario = new FormData();
                formulario.append('correo',this.correo);
                formulario.append('contrasena',this.contrasena);
                try {
                    const consulta = await fetch('login',{
                        method: 'POST',
                        body: formulario,
                        headers: {
                            'X-CSRF-TOKEN': this.$store.state.token
                        }
                    });
                    const respuesta = await consulta.text();
                    if(respuesta == "true"){
                        alertify.success("Entrando...");
                        location.href = "./papper/home";
                    }
                    else{
                        carga.classList.remove("d-flex");
                        carga.classList.add("d-none");
                        alertify.error("Correo o contraseña erronea");
                    }
                } catch (error) {
                    // alertify.error("Correo o contraseña erronea");
                    console.log("hola");
                }
                // location.href="./pappers";
            }
            else{
                alertify.error("Datos incorrectos. El formato del correo no es valido");
                alertify.error("Recuerde escribir su contraseña");
            }
        }
    },
}
</script>
