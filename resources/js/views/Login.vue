<template>
    <div style="padding-top:4.5rem">
        <div>
            <img src="img/wave_paper.svg" class="position-absolute" style="height:80vh;top:0;z-index:-1;">
        </div>
        <div class="d-flex height-md">
            <div class="p-4 mx-auto my-auto card-login rounded-xl w-md-40 w-sm-75 w-85">
                <div class="mt-3 form-group">
                    <h2 class="font-weight-bold text-dark">
                        Login
                    </h2>
                </div>
                <form v-on:submit.prevent="ingress()">
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="emil" class="form-control rounded-pill" placeholder="Ej:andres03marquez@gmail.com" v-model="correo">
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control rounded-pill" placeholder="***********" v-model="contrasena">
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn btn-text-primary waves-effect waves-light rounded-pill">
                            Ingresar
                        </button>
                    </div>
                </form>
                <div class="d-flex justify-content-end">
                    <router-link class="text-muted small" role="button"
                   :to="{name: 'papper_register'}">
                        ¿Aun no tienes una cuenta?
                   </router-link>
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
                            'X-CSRF-TOKEN': this.$store.state.token,
                            'Accept': 'application/json'
                        }
                    });
                    const respuesta = await consulta.json();
                    if(consulta.status !== 200)
                        throw([respuesta,consulta.status]);
                    if(consulta.status === 200){
                        localStorage.setItem("logueado","Si");
                        alertify.success("Entrando...");
                        location.href = "./home";
                    }
                } catch (errors) {
                    carga.classList.remove("d-flex");
                    carga.classList.add("d-none");
                    if(errors[1] == 422){
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
                alertify.error("Rellena los campos con datos validos");
            }
        }
    },
}
</script>
