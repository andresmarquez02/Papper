<template>
    <div class="pt-3 pb-3 px-md-5">
        <div v-if="$store.state.usuario !== null">
            <router-link class="btn btn-outline-light rounded-circle" to="/inicio">
                <i class="fas fa-arrow-left"></i>
            </router-link>
        </div>
        <div v-else>
            <router-link class="btn btn-outline-light rounded-circle" to="/">
                <i class="fas fa-arrow-left"></i>
            </router-link>
        </div>
        <div class="shadow bg-light my-3 px-4 pt-4 pb-2">
            <span>{{ $store.state.pregunta.nombre_apellido }}</span>
            <h1>{{ $store.state.pregunta.titulo }}</h1>
            <p> {{$store.state.pregunta.descripcion}}
            </p>
            <div>
                <span>
                    <i class="fa h5 cursor-pointer" :class="$store.state.esLike > 0 ? 'fa-heart text-danger' : 'fa-heart-o'" :id="'corazon_'+$store.state.pregunta.id" v-on:click="like($store.state.pregunta.id)"
                     aria-hidden="true" :like="$store.state.esLike > 0 ? 'Si' : 'No'"></i>
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
                <div class="col-6 p-0 d-flex justify-content-end" v-if="$store.state.usuario !== null">
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
                <span>
                    <i class="fa fa-heart-o h5 cursor-pointer" :id="'comentarios_c'+comentario.id"
                    v-on:click="like_comentario(comentario.id)"
                     aria-hidden="true" like="No"></i>
                    <span class="mr-2" :id="'likes_c'+comentario.id">{{comentario.likes}}</span>
                </span>
            </div>
        </div>
        <div class="my-3 px-4 pt-4 pb-2"
        v-if="$store.state.commentarios == ''">
            <h2 class="text-center text-white font-weight-bold">Sin comentarios...</h2>
        </div>
        <div class="my-3 px-lg-4 pt-4 pb-2" v-if="$store.state.usuario !== null">
            <div class="col-12 btn-group p-0 btn-group-toggle">
                <input type="text" class="form-control rounded-0 rounded-left col-md-11 col-sm-10 col-10" placeholder="comentario..."
                v-model="$store.state.comentario" v-on:keyup.enter="comentar()" maxlength="255" minlength="1">
                <button type="button" v-on:click="comentar()" class="col-md-1 col-sm-2 col-2 btn btn-outline-light">
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
                        <h2>Esta seguro de eliminar este comentario?</h2>
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
    mounted() {
        let intervalo = setInterval(()=> {
            if(this.$store.state.commentarios !== null){
                this.mi_like();
                window.clearInterval(intervalo);
            }
        },3000);
    },
    data(){
        return{
            comentario_editar: '',
            validador: /^[a-zA-ZÁ-ÿ\s]{1,255}$/,
            numeros: /^\d{1,255}$/,
            id_comentario: '',
        }
    },
    methods: {
        async like(value){
            if(this.$store.state.usuario === null) return location.hash = "/login";

            let token = document.querySelector('meta#token').getAttribute('content');
            let confirma = document.getElementById('corazon_'+value);
            let likex = confirma.getAttribute('like');
            if(likex == "No"){
                this.$store.state.pregunta.likes +=1;
                confirma.classList = "fa fa-heart h5 cursor-pointer text-danger";
                confirma.setAttribute('like','Si');
            }
            else {
                confirma.classList = "fa fa-heart-o h5 cursor-pointer";
                this.$store.state.pregunta.likes -=1;
                confirma.setAttribute('like','No');
            }
            try {
                const consulta = await fetch('like/'+value,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                if(consulta.status != 200) throw(consulta);
            } catch (error) {
                alertify.error("Intenta de nuevo");
            }
        },
        async mi_like(){
            let i = null;
            let likes = null;
            for(i of this.$store.state.commentarios){
                for( likes of this.$store.state.likes_comentarios){
                    if(likes.id_user == this.$store.state.usuario.id && likes.id_comentario == i.id){
                        let ids = document.getElementById('comentarios_c'+i.id);
                        ids.classList = "fa fa-heart h5 cursor-pointer text-danger";
                        ids.setAttribute('like','Si');
                    }
                }
            }
        },
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
        comentar(){

            if(this.$store.state.usuario == null) return location.hash = "/login";
            const regular =  /^.{1,400000000}$/ ;
            let pre = document.getElementById('carga')
            if(regular.test(this.$store.state.comentario)){
                // $store.state.pregunta.id;
                pre.classList.remove('d-none');
                pre.classList.add('d-flex');
                this.$store.dispatch('enviar_comentario');
            }
            else{
                alertify.error("Comentario muy extenso por favor envielo en dos partes");
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
            alertify.success("Procesando...");
            try{
                const consulta = await fetch('eliminar_comentario/'+this.id_comentario,{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                const resultado = await consulta.text();
                if(consulta.status == 200){
                    for(var i = 0; i < this.$store.state.commentarios.length; i++){
                        if(this.$store.state.commentarios[i].id == this.id_comentario){
                            this.$store.state.commentarios.splice(i,1);
                        }
                    }
                    pre.classList.remove('d-flex');
                    pre.classList.add('d-none');
                    alertify.success("Comentario eliminado con exito.");
                }
                else{
                    throw(consulta);
                }
            }
            catch(error){
                pre.classList.remove('d-flex');
                pre.classList.add('d-none');
                alertify.error("Error. Intente de nuevo.");
            }
        },
        denunciar(){
            setTimeout(()=>{
                alertify.success("Comentario denunciado");
            },1200);
        }
    },
}
</script>
