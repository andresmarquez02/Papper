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
                            <input type="text" class="form-control" v-model="titulo" minlength="1" maxlength="254" placeholder="Alguien me puede ayudar con este codígo?">
                        </div>
                        <div class="form-group">
                            <label for="">Grupo</label>
                            <select class="form-control" v-model="grupo">
                                <option selected>Selecciona</option>
                                <option v-for="grupo in $store.state.grupos" :value="grupo.id" v-bind:key="grupo.id">{{ grupo.grupo }}</option>
                            </select>
                        </div>
                        <div class="mb-0 form-group">
                            <label for="">Descripción</label>
                            <textarea class="form-control" v-model="descripcion" minlength="1" maxlength="254" rows="3" placeholder="<?php echo Hola Mundo;?>"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" v-on:click="publicar()" class="btn btn-primary rounded-pill waves-effect">
                            <i class="fas fa-save "></i>
                            Guardar
                        </button>
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
            const regular =  /^.{1,250}$/,
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
                            const consulta = await fetch('guardar',{
                                method: 'POST',
                                body: formulario,
                                headers:{
                                    'X-CSRF-TOKEN':this.$store.state.token
                                }
                            });
                            const respuesta = await consulta.json();
                            if(consulta.status === 200){
                                alertify.success(respuesta.exito);
                                this.recarga_preguntas();
                                let obj = document.getElementById('close');
                                obj.click();
                                this.titulo = "";
                                this.descripcion = "";
                                this.grupo = "";
                            }
                            else if(consulta.status !== 200){
                                throw([respuesta,consulta.status])
                            }
                        }
                        catch(errors){
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
                        alertify.error("No altere los datos porfavor que no podra hackear el sistema");
                        setTimeout(()=>{
                            location.href = "./papper/home";
                        },2000);

                    }
                }
                else
                    alertify.error("El título de la publicación deben ser letras")

            }
            else{
                if(!regular.test(this.titulo))
                    alertify.error('Pon un titulo a tu publicación');

                else if(!regularNumber.test(this.grupo))
                    alertify.error('Selecciona un grupo');

                else if(!regular.test(this.descripcion))
                    alertify.error('Crea una descripción para así poder tener más información de lo que quieres');

                else
                    alertify.error('Debes llenar todos lo campos');

            }
        },
        recarga_preguntas(){
            this.$store.dispatch('preguntas_get');
        }
    },
}
</script>
