<template>
    <div>
        <div class="px-4 pt-4 pb-2 my-3 bg-purble-90 card-comentari"
        v-for="comentario in $store.state.commentarios" :key="comentario.id">
            <div class="m-0 row">
                <div class="p-0 col-6">
                    <span>{{  comentario.nombre_apellido }}</span>
                    <small class="d-block small-hora text-muted">{{comentario.created_at}}</small>
                </div>
                <div class="p-0 col-6 d-flex justify-content-end" v-if="$store.state.usuario !== null">
                    <div class="dropdown dropleft">
                        <span class="cursor-pointer" id="triggerIdss" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">...</span>
                        <div class="dropdown-menu dropleft" style="right:0" v-if="comentario.id_usuario == $store.state.usuario.id" aria-labelledby="triggerIdss">
                            <h6 class="cursor-pointer dropdown-item" v-on:click="denunciar()">Denunciar</h6>
                            <h6 class="cursor-pointer dropdown-item" v-on:click="modal_elimiar(comentario.id)"
                             data-toggle="modal" data-target="#modelEliminarc">Eliminar</h6>
                        </div>
                        <div class="dropdown-menu" v-else aria-labelledby="triggerIdss">
                            <h6 class="cursor-pointer dropdown-item" v-on:click="denunciar()">Denunciar</h6>
                        </div>
                    </div>
                </div>
            </div>
            <p class="comment"> {{comentario.comentario}}
            </p>
            <div>
                <span>
                    <i class="cursor-pointer fa fa-heart-o h5" :id="'comentarios_c'+comentario.id"
                    v-on:click="like_comentario(comentario.id)"
                     aria-hidden="true" like="No"></i>
                    <span class="mr-2" :id="'likes_c'+comentario.id">{{comentario.likes}}</span>
                </span>
            </div>
        </div>
        <div class="modal" id="modelEliminarc" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <h2>Esta seguro de eliminar este comentario?</h2>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div>
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> No</button>
                            <button type="button" class="btn btn-dange waves-effectr" data-dismiss="modal" v-on:click="eliminar()"><i class="fa fa-trash" aria-hidden="true"></i> Si</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        async like_comentario(value){
            if(this.$store.state.usuario == null) return location.hash = "/login";

            let token = document.querySelector('meta#token').getAttribute('content');
            let ids = document.getElementById('comentarios_c'+value);
            let confirma = document.getElementById('comentarios_c'+value).getAttribute('like');
            if(confirma === "Si"){
                for(var i = 0; i < this.$store.state.commentarios.length; i++){
                    if(this.$store.state.commentarios[i].id == value){
                        this.$store.state.commentarios[i].likes -= 1;
                    }
                }
                ids.classList.remove('fa-heart');
                ids.classList.add('fa-heart-o');
                ids.classList.remove('text-danger');
                document.getElementById('comentarios_c'+value).setAttribute('like','No');
            }
            else {
                for(var i = 0; i < this.$store.state.commentarios.length; i++){
                    if(this.$store.state.commentarios[i].id == value){
                        this.$store.state.commentarios[i].likes += 1;
                    }
                }
                ids.classList.remove('fa-heart-o');
                ids.classList.add('fa-heart');
                ids.classList.add('text-danger');
                document.getElementById('comentarios_c'+value).setAttribute('like','Si');
            }
            await fetch('like/comentarios/'+value,{
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
        },
        modal_elimiar(id){
            this.id_comentario = id;
        },
        async eliminar(){
            let pre = document.getElementById('carga');
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            let token = document.querySelector('meta#token').getAttribute('content');
            alertify.success("Procesando...");
            try{
                const consulta = await fetch('eliminar_comentario/'+this.id_comentario,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const resultado = await consulta.json();
                pre.classList.remove('d-flex');
                pre.classList.add('d-none');
                if(consulta.status == 200){
                    for(var i = 0; i < this.$store.state.commentarios.length; i++){
                        if(this.$store.state.commentarios[i].id == this.id_comentario){
                            this.$store.state.commentarios.splice(i,1);
                        }
                    }
                    alertify.success(resultado.exito);
                }
                else{
                    throw([resultado,consulta]);
                }
            }
            catch(error){
                alertify.error(resultado[0].error);
            }
        },
        denunciar(){
            setTimeout(()=>{
                alertify.success("Comentario denunciado");
            },1200);
        }
    }
}
</script>
