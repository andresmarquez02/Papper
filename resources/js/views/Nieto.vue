<template>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Nuevo Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" id="cerrar" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group text-dark col-6">
                        <label for="">Nombre</label>
                        <input type="text" name="nombre" required class="form-control"  v-model="nombre">
                        <small id="helpIds1" class="text-danger d-none">El campo no puede estar  vacio o ser contener numeros</small>
                    </div>
                    <div class="form-group text-dark col-6">
                        <label for="">Apellido</label>
                        <input type="text" name="apellido" required class="form-control" v-model="apellido">
                        <small id="helpIds2" class="text-danger d-none">El campo no puede estar  vacio o ser contener numeros</small>
                    </div>
                    <div class="form-group text-dark col-6">
                        <label for="">Correo</label>
                        <input type="email" name="correo" required class="form-control" v-model="correo">
                        <small id="helpIds3" class="text-danger d-none">El campo no puede estar  vacio o no ser un correo</small>
                    </div>
                    <div class="form-group text-dark col-6">
                        <label for="">Cargo</label>
                        <select class="form-control" name="cargo" v-model="cargo">
                            <option value="0" selected>Selecciona</option>
                            <option  v-for="cargo in $store.state.cargos" :value="cargo.cargo">
                            {{ cargo.cargo }}</option>
                        </select>
                        <small id="helpIds4" class="text-danger d-none">El campo no puede estar  vacio</small>
                    </div>
                    <div class="form-group text-dark col-12">
                        <label for="">Dirección</label>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control" name="direc" v-model="pais"  v-on:change="region_get()">
                                    <option value="0" selected>Selecciona</option>
                                    <option v-for="pais in $store.state.paises" :value="pais.pais">
                                    {{ pais.pais }}</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control" name="region" v-model="region" placeholder="Selecciona">
                                  <option value="0" selected>Selecciona</option>
                                    <option v-for="region in $store.state.regiones" :value="region.region">
                                    {{ region.region }}</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <small id="helpIds6" class="text-danger d-none">Rellene el campo</small>
                    </div>
                    <div class="form-group text-dark col-6">
                        <label for="">Telefono</label>
                        <input type="number" name="telefono" required class="form-control"  v-model="celular">
                        <small id="helpIds5" class="text-danger d-none">El campo no puede estar  vacio o ser contener letras</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerar</button>
                <button type="button" class="btn btn-primary" v-on:click="guardar()">Guardar</button>
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
            celular: '',
            pais: '',
            region: '',
            regiones: '',
        }
    },
    methods:{
        async region_get(){
            const consulta = await fetch('get_region/'+this.pais);
            const respuesta = await consulta.json();
            this.$store.state.regiones = respuesta;
        },
        errores (value){
            if(value < 7){
                for(var i = 1; i <=6; i++){
                    var ing = document.querySelector("#helpIds"+i);
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
                    var ing = document.querySelector("#helpIds"+i);
                    ing.classList.add("d-block");
                    ing.classList.remove("d-none");
                }
            }
            else{
                for(var i = 1; i <=6; i++){
                    var ing = document.querySelector("#helpIds"+i);
                    ing.classList.add("d-none");
                    ing.classList.remove("d-block");
                }
            }
        },
        guardar(){
            const regular = {
                letras: /^[a-zA-ZÁ-ÿ]{1,20}$/,
                numeros: /^\d{9,15}$/,
                correos: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/,
            };
            if(regular.letras.test(this.nombre) && regular.letras.test(this.apellido)
            && regular.correos.test(this.correo) && regular.letras.test(this.cargo)
            && regular.numeros.test(this.celular) && regular.letras.test(this.pais)
            && regular.letras.test(this.region)
             ){
                    Array.prototype.ultimate = function(n){
                        return this.slice(-n);
                    };
                    let id = this.$store.state.personas.ultimate(1);
                    let idFin = 0;
                    let value = true;
                    if(id == ""){
                        id = 0;
                        idFin = id + 1;
                    }
                    else{
                        idFin = id[0].id + 1;
                    }
                    this.$store.state.personas.push({
                        id: idFin, nombre: this.nombre,apellido: this.apellido,
                        'email': this.correo, 'cargo': this.cargo, 'telefono': this.celular,
                        'pais': this.pais, region: this.region
                    })
                    alertify.success("Usuario Guardado exítosamente");
                    let obj = document.getElementById('cerrar');
                    obj.click();
                    this.nombre = null;
                    this.apellido = "";
                    this.celular = "";
                    this.pais = "";
                    this.region = "";
                    this.cargo = "";
                    this.correo = "";
                    this.errores(8);
            }
            else{
                if(!regular.letras.test(this.nombre)){
                    this.errores(1);
                }
                else if(!regular.letras.test(this.apellido)){
                    this.errores(2);
                }
                else if(!regular.correos.test(this.correo)){
                    this.errores(3);
                }
                else if(!regular.letras.test(this.cargo)){
                    this.errores(4);

                }
                else if(!regular.numeros.test(this.celular)){
                    this.errores(5);
                }
                else if(!regular.letras.test(this.pais) || !regular.letras.test(this.region)){
                    this.errores(6);
                }
                else{
                    this.errores(7);
                }
            }
        }
    }
}
</script>
