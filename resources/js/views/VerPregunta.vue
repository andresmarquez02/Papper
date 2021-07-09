<template>
    <div class="pt-3 pb-3 px-md-5">
        <div>
            <a href="#/inicio" v-on:click="atras()" class="btn btn-outline-light rounded-circle">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="shadow bg-light my-3 px-4 pt-4 pb-2">
            <span>{{ $store.state.pregunta.nombre_apellido }}</span>
            <h1>{{ $store.state.pregunta.titulo }}</h1>
            <p> {{$store.state.pregunta.descripcion}}
            </p>
            <div>
                <span v-if="mi_like($store.state.pregunta.id)">
                    <i class="fa fa-heart-o h5 cursor-pointer" :id="'comentarios'+$store.state.pregunta.id"
                    v-on:click="like($store.state.pregunta.id,$store.state.pregunta.likes)"
                     aria-hidden="true" like="No"></i>
                    <span class="mr-2" :id="'likes'+$store.state.pregunta.id">{{$store.state.pregunta.likes}}</span>
                </span>
            </div>
        </div>
        <div class="shadow border my-3 px-4 pt-4 pb-2 bg-white"
        v-for="comentario in $store.state.commentarios" :key="comentario.id">
            <div class="row m-0">
                <div class="col-6 p-0">
                    <span>{{ comentario.nombre_apellido }}</span>
                </div>
                <div class="col-6 p-0 d-flex justify-content-end">
                    <div class="dropdown dropleft">
                        <span class="cursor-pointer" id="triggerIdss" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">...</span>
                        <div class="dropdown-menu dropleft" style="right:0" v-if="comentario.id_usuario == $store.state.usuario.id" aria-labelledby="triggerIdss">
                            <h6 class="dropdown-item cursor-pointer" v-on:click="denunciar()">Denunciar</h6>
                            <h6 class="dropdown-item cursor-pointer" v-on:click="modal_elimiar(comentario.id)"
                             data-toggle="modal" data-target="#modelEliminarc">Eliminar</h6>
                        </div>
                        <div class="dropdown-menu" v-else aria-labelledby="triggerIdss">
                            <h6 class="dropdown-item cursor-pointer" v-on:click="denunciar()">Denunciar</h6>
                        </div>
                    </div>
                </div>
            </div>
            <p class="comment"> {{comentario.comentario}}
            </p>
            <div>
                <span v-if="mi_like_comentario(comentario.id)">
                    <i class="fa fa-heart-o h5 cursor-pointer" :id="'comentarios_c'+comentario.id"
                    v-on:click="like_comentario(comentario.id,comentario.likes)"
                     aria-hidden="true" like="No"></i>
                    <span class="mr-2" :id="'likes_c'+comentario.id">{{comentario.likes}}</span>
                </span>
            </div>
        </div>
        <div class="my-3 px-4 pt-4 pb-2"
        v-if="$store.state.commentarios == ''">
            <h2 class="text-center">Sin comentarios</h2>
        </div>
        <div class="my-3 px-lg-4 pt-4 pb-2">
            <div class="col-12 btn-group p-0 btn-group-toggle">
                <input type="text" class="form-control col-md-11 col-sm-10 col-10" placeholder="comentario..."
                v-model="$store.state.comentario" v-on:keyup.enter="comentar()" maxlength="255" minlength="1">
                <button type="button" v-on:click="comentar()" class="col-md-1 col-sm-2 col-2 btn btn-outline-primary">
                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                </button>
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
                        <h2>Esta seguro de eliminar esta publicacion?</h2>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" v-on:click="eliminar()">Si</button>
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
        return{
            comentario_editar: '',
            validador: /^[a-zA-ZÁ-ÿ\s]{1,255}$/,
            numeros: /^\d{1,255}$/,
            id_comentario: '',
        }
    },
    methods: {
        async like(value,likes){
            let confirma = document.getElementById(value).getAttribute('like');
            if(confirma === "Si"){
                let ids = document.getElementById('comentarios'+value);
                const consulta = await fetch('like/'+value+'/'+0);
                const respuesta = await consulta.text();
                if(respuesta != "Error"){
                    for(var i = 0; i < this.$store.state.preguntas.length; i++){
                        if(this.$store.state.preguntas[i].id == value){
                            this.$store.state.preguntas[i].likes = respuesta;
                        }
                    }
                    ids.classList.remove('fa-heart');
                    ids.classList.add('fa-heart-o');
                    ids.classList.remove('text-danger');
                    document.getElementById(value).setAttribute('like','No');
                }
                else{
                    alerify.error("Haga click nuevamente");
                }
            }
            else if(confirma === "No"){
                let ids = document.getElementById('comentarios'+value);
                const consulta = await fetch('like/'+value+'/'+1);
                const respuesta = await consulta.text();
                if(respuesta != "Error"){
                    for(var i = 0; i < this.$store.state.preguntas.length; i++){
                        if(this.$store.state.preguntas[i].id == value){
                            this.$store.state.preguntas[i].likes = respuesta;
                        }
                    }
                    ids.classList.remove('fa-heart-o');
                    ids.classList.add('fa-heart');
                    ids.classList.add('text-danger');
                    document.getElementById(value).setAttribute('like','Si');
                }
                else{
                    alerify.error("Haga click nuevamente");
                }
            }
            else{
                alertify.error("Error inesperado. Recargue el sitio web");
            }
        },
        async like_comentario(value,likes){
            let confirma = document.getElementById('comentarios_c'+value).getAttribute('like');
            if(confirma === "Si"){
                let ids = document.getElementById('comentarios_c'+value);
                const consulta = await fetch('like/comentarios/'+value+'/'+0);
                const respuesta = await consulta.text();
                if(respuesta != "Error"){
                    for(var i = 0; i < this.$store.state.commentarios.length; i++){
                        if(this.$store.state.commentarios[i].id == value){
                            this.$store.state.commentarios[i].likes = respuesta;
                        }
                    }
                    ids.classList.remove('fa-heart');
                    ids.classList.add('fa-heart-o');
                    ids.classList.remove('text-danger');
                    document.getElementById('comentarios_c'+value).setAttribute('like','No');
                }
                else{
                    alerify.error("Haga click nuevamente");
                }

            }
            else if(confirma === "No"){
                let token = document.querySelector('meta#token').getAttribute('content');
                let ids = document.getElementById('comentarios_c'+value);
                const consulta = await fetch('like/comentarios/'+value+'/'+1,{
                     method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const respuesta = await consulta.text();
                if(respuesta != "Error"){
                    for(var i = 0; i < this.$store.state.commentarios.length; i++){
                        if(this.$store.state.commentarios[i].id == value){
                            this.$store.state.commentarios[i].likes = respuesta;
                        }
                    }
                    ids.classList.remove('fa-heart-o');
                    ids.classList.add('fa-heart');
                    ids.classList.add('text-danger');
                    document.getElementById('comentarios_c'+value).setAttribute('like','Si');
                }
                else{
                    alerify.error("Haga click nuevamente");
                }
            }
            else{
                alertify.error("Error inesperado. Recargue el sitio web");
            }
        },
        async mi_like(value){
            let token = document.querySelector('meta#token').getAttribute('content');
            try{
                const consulta = await fetch('milike/'+value,{
                     method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const respuesta = await consulta.text();
                if(respuesta != 0){
                    let ids = document.getElementById("comentarios"+value);
                    ids.classList.remove('fa-heart-o');
                    ids.classList.add('fa-heart');
                    ids.classList.add('text-danger');
                    ids.setAttribute('like','Si');
                }
            }
            catch(error){}
        },
        async mi_like_comentario(value){
            let token = document.querySelector('meta#token').getAttribute('content');
            try{
                const consulta = await fetch('milike/comentario/'+value,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const respuesta = await consulta.text();
                if(respuesta != 0){
                    let ids = document.getElementById("comentarios_c"+value);
                    ids.classList.remove('fa-heart-o');
                    ids.classList.add('fa-heart');
                    ids.classList.add('text-danger');
                    ids.setAttribute('like','Si');
                }
            }
            catch(error){}
        },
        atras(value){
            this.$store.state.normal = "";
            this.$store.state.no_normal = "d-none";
        },
        comentar(){
            const regular =  /^.{1,240}$/ ;
            let pre = document.getElementById('carga')
            if(regular.test(this.$store.state.comentario)){
                // $store.state.pregunta.id;
                pre.classList.remove('d-none');
                pre.classList.add('d-flex');
                this.$store.dispatch('enviar_comentario');
            }
            else{
                alertify.error("No puede escribir mas de 240 caracteres por comentario :)");
            }
        },
        modal_cambiar(comentario,id_comentario){
            this.comentario_editar = comentario;
            this.id_comentario = id_comentario;
        },
        async cambiar(){
            let token = document.querySelector('meta#token').getAttribute('content');
            if(this.comentario_editar !== ""){
                let formulario = new FormData();
                formulario.append('comentario',this.comentario_editar);
                alertify.success('Editando y guardando');
                const consulta = await fetch('editar_comentario/'+this.id_comentario,{
                    method: 'POST',
                    body: formulario,
                    headers: {
                        'X-CSRF-TOKEN':token
                    }
                });
                const respuesta = await consulta.text();
                if(respuesta == "Exito"){
                    for(var i = 0; i < this.$store.state.commentarios.length; i++){
                        if(this.$store.state.commentarios[i].id == this.id_comentario){
                            this.$store.state.commentarios[i].comentario = this.comentario_editar;
                        }
                    }
                    let obj =document.getElementById('cerrarEditarc');
                    obj.click();
                    alertify.success('Publicación editada con exíto.');
                }
                else{
                     alertify.error('Error. reintente de nuevo.');
                }
            }
            else{
                alertify.error("El comentario no puede estar vacio.");
            }
        },
        modal_elimiar(id){
            this.id_comentario = id;
        },
        async eliminar(){
            let pre = document.getElementById('carga');
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            let token = document.querySelector('meta#token').getAttribute('content');
            try{
                const consulta = await fetch('eliminar_comentario/'+this.id_comentario,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const resultado = await consulta.text();
                alertify.success("Procesando...");
                if(resultado == "Exito"){
                    for(var i = 0; i < this.$store.state.commentarios.length; i++){
                        if(this.$store.state.commentarios[i].id == this.id_comentario){
                            this.$store.state.commentarios.splice(i,1);
                        }
                    }
                    pre.classList.add('d-none');
                    alertify.success("Comentario eliminado con exito.");
                }
                else{
                    alertify.error("Error. Intente de nuevo.");
                }
            }
            catch(error){}
        },
        denunciar(){
            setTimeout(()=>{
                alertify.success("Comentario denunciado");
            },2000);
        },
        atras(){
            let anterior = localStorage.getItem('atras');
            localStorage.setItem('grupo',anterior);
            this.$store.dispatch('preguntas_get');
        }
    },
}
</script>
