<template>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Actualizar</h5>
                    <button type="button" class="close" data-dismiss="modal" id="cerrar" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group text-dark col-6">
                        <label for="">Nombre</label>
                        <input type="text" name="nombre" required class="form-control"  v-model="$store.state.act_user.nombre">
                        <small id="helpId1" class="text-danger d-none">El campo no puede estar  vacio o ser contener numeros</small>
                    </div>
                    <div class="form-group text-dark col-6">
                        <label for="">Apellido</label>
                        <input type="text" name="apellido" required class="form-control"    v-model="$store.state.act_user.apellido">
                        <small id="helpId2" class="text-danger d-none">El campo no puede estar  vacio o ser contener numeros</small>
                    </div>
                    <div class="form-group text-dark col-6">
                        <label for="">Correo</label>
                        <input type="email" name="correo" required class="form-control"     v-model="$store.state.act_user.email">
                        <small id="helpId3" class="text-danger d-none">El campo no puede estar  vacio o no ser un correo</small>
                    </div>
                    <div class="form-group text-dark col-6">
                        <label for="">Cargo</label>
                        <select class="form-control" name="cargo" v-model="$store.state.act_user.cargo">
                            <option value="0" selected>Selecciona</option>
                            <option  v-for="cargo in $store.state.cargos" :value="cargo.cargo">
                            {{ cargo.cargo }}</option>
                        </select>
                        <small id="helpId4" class="text-danger d-none">El campo no puede estar  vacio</small>
                    </div>
                    <div class="form-group text-dark col-12">
                        <label for="">Dirección</label>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <p>País: {{$store.state.act_user.pais}}</P>
                                <div class="form-group">
                                  <select class="form-control" name="direc" v-model="$store.state.act_user.pais"  v-on:change="region_get()">
                                    <option value="0" selected>Selecciona</option>
                                    <option v-for="pais in $store.state.paises" :value="pais.   pais">
                                    {{ pais.pais }}</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <p>Region: {{$store.state.act_user.region}}</P>
                                <div class="form-group">
                                  <select class="form-control" name="region" v-model="$store.state.act_user.region" placeholder="Selecciona">
                                  <option value="0" selected>Selecciona</option>
                                    <option v-for="region in $store.state.regiones"     :value="region.region">
                                    {{ region.region }}</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <small id="helpId6" class="text-danger d-none">Rellene el campo</small>
                    </div>
                    <div class="form-group text-dark col-6">
                        <label for="">Telefono</label>
                        <input type="number" name="telefono" required class="form-control"  v-model="$store.state.act_user.telefono">
                        <small id="helpId5" class="text-danger d-none">El campo no puede estar  vacio o ser contener letras</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerar</button>
                <button type="button" class="btn btn-primary" v-on:click="guardar_act()">Guardar</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            nombre: '',
            apellido:'',
            correo: '',
            cargo: '',
            telefono: '',
            pais: '',
            region: '',
            regiones: '',
        }
    },
    methods:{
        async region_get(){
            this.$store.state.act_user.region = "";
            const consulta = await fetch('get_region/'+this.$store.state.act_user.pais);
            const respuesta = await consulta.json();
            this.$store.state.regiones = respuesta;
        },
        errores (value){
            if(value < 7){
                for(var i = 1; i <=6; i++){
                    var ing = document.querySelector("#helpId"+i);
                    if(i == value){
                        ing.classList.add("d-block");
                        ing.classList.remove("d-none");
                    }
                    else{
                        ing.classList.remove("d-block");
                        ing.classList.add("d-none");
                    }
                }
            }
            else if(value == 7){
                for(var i = 1; i <=6; i++){
                    var ing = document.querySelector("#helpId"+i);
                    ing.classList.add("d-block");
                    ing.classList.remove("d-none");
                }
            }
            else{
                for(var i = 1; i <=6; i++){
                    var ing = document.querySelector("#helpId"+i);
                    ing.classList.add("d-none");
                    ing.classList.remove("d-block");
                }
            }
        },
        guardar_act(){
            const regular = {
                letras: /^[a-zA-ZÁ-ÿ]{1,20}$/,
                numeros: /^\d{1,15}$/,
                correos: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/,
            };
            const ertelefono = parseInt(this.$store.state.act_user.telefono);
            console.log(this.$store.state.act_user.pais,this.$store.state.act_user.region);
            if(regular.letras.test(this.$store.state.act_user.nombre) && regular.letras.test(this.$store.state.act_user.apellido) && regular.correos.test(this.$store.state.act_user.email) && regular.letras.test(this.$store.state.act_user.cargo) && regular.numeros.test(ertelefono)){
                if(!regular.letras.test(this.$store.state.act_user.pais) || this.$store.state.act_user.pais === "" && !regular.letras.test(this.$store.state.act_user.region) || this.$store.state.act_user.region === ""){
                    alertify.error("Donde esta ubicado el usuario?");
                    return 0;
                }
                if(this.$store.state.act_user.region == undefined){
                    alertify.error("Elige una regíon");
                    return 0;
                }
                for(var i = 0; i <= this.$store.state.personas.length; i++){
                    if(this.$store.state.personas[i].id === this.$store.state.id){
                        this.$store.state.personas[i].nombre = this.$store.state.act_user.nombre;
                        this.$store.state.personas[i].apellido = this.$store.state.act_user.apellido;
                        this.$store.state.personas[i].email = this.$store.state.act_user.email;
                        this.$store.state.personas[i].cargo = this.$store.state.act_user.cargo;
                        this.$store.state.personas[i].pais = this.$store.state.act_user.pais;
                        this.$store.state.personas[i].region = this.$store.state.act_user.region;
                        this.$store.state.personas[i].telefono = this.$store.state.act_user.telefono;
                        this.errores(8);
                        let obj = document.getElementById('cerrar');
                        obj.click();
                        alertify.success("Actualización exítosa");
                        break
                    }
                }
            }
            else{
                if(!regular.letras.test(this.$store.state.act_user.nombre)){
                    this.errores(1);
                }
                else if(!regular.letras.test(this.$store.state.act_user.apellido)){
                    this.errores(2);
                }
                else if(!regular.correos.test(this.$store.state.act_user.email)){
                    this.errores(3);
                }
                else if(!regular.letras.test(this.$store.state.act_user.cargo)){
                    this.errores(4);

                }
                else if(!regular.numeros.test(ertelefono)){
                    this.errores(5);
                }
                else{
                    this.errores(7);
                }
            }
        }
    }
}
</script>

