<template>
    <div>
        <div class="modal" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h4">Nueva Publicación</h5>
                            <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body" v-on:keyup.Enter="publicar()">
                        <div class="form-group">
                            <label for="">Título</label>
                            <input type="text" class="form-control" v-model="titulo" minlength="1" maxlenght="254" placeholder="Alguien me puede ayudar con este codígo?">
                        </div>
                        <div class="form-group">
                            <label for="">Grupo</label>
                            <select class="form-control" v-model="grupo">
                                <option selected>Selecciona</option>
                                <option v-for="grupo in $store.state.grupos" :value="grupo.id">{{ grupo.grupo }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Descripción</label>
                            <textarea class="form-control" v-model="descripcion" minlength="1" maxlenght="254" rows="3" placeholder="<?php echo Hola Mundo;?>"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" v-on:click="publicar()" class="btn btn-outline-dark rounded-pill">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            titulo: '',
            grupo: '',
            descripcion: '',
        }
    },
    methods: {
        async publicar(){
            const regular =  /^[a-zA-ZÁ-ÿ0-9]{1,254}$/,
            regularNumber =  /^\d{1,15}$/;
            const regularDesc = /^.{1,400000000}$/;
            let token = document.querySelector('meta#token').getAttribute('content');
            this.$store.state.token = token;
            if(regular.test(this.titulo) && regularNumber.test(this.grupo) && regularDesc.test(this.descripcion)){
                if(regular.test(this.titulo)){
                    if(regularNumber.test(this.grupo)){
                        try{
                            alertify.success('Publicando...');
                            let formulario = new FormData();
                            formulario.append('titulo',this.titulo);
                            formulario.append('descripcion',this.descripcion);
                            formulario.append('grupo',this.grupo);
                            const consulta = await fetch('preguntas/save/logs',{
                                method: 'POST',
                                body: formulario,
                                headers:{
                                    'X-CSRF-TOKEN':this.$store.state.token
                                }
                            });
                            const respuesta = await consulta.text();
                            if(respuesta == ""){
                                alertify.error("Usted no ha cumplido los parametros de la publicación");
                            }
                            else{
                                alertify.success(respuesta);
                                this.recarga_preguntas();
                                let obj = document.getElementById('close');
                                obj.click();
                                this.titulo = "";
                                this.descripcion = "";
                                this.grupo = "";
                            }
                        }
                        catch(error){}
                    }
                    else{
                        alertify.error("No altere los datos porfavor que no podra hackear el sistema");
                        setTimeout(()=>{
                            location.href = "./papper/home";
                        },5000);

                    }
                }
                else{
                    alertify.error("El título de la publicación deben ser letras")
                }
            }
            else{
                if(!regular.test(this.titulo)){
                    alertify.error('Pon un titulo a tu publicación');
                }
                else if(!regularNumber.test(this.grupo)){
                    alertify.error('Selecciona un grupo');
                }
                else if(!regular.test(this.descripcion)){
                    alertify.error('Crea una descripción para así poder tener más información de lo que quieres');
                }
                else{
                    alertify.error('Debes llenar todos lo campos');
                }
            }
        },
        recarga_preguntas(){
            this.$store.dispatch('preguntas_get');
        }
    },
}
</script>
