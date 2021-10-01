<template>
    <div class="pt-3 pb-3 px-md-5">
        <div v-if="$store.state.referencia_grupo.grupo !== null">
            <h2 class="text-white px-4 cursor-pointer text-decoration"
            v-on:click="per_grupo($store.state.referencia_grupo.id)">
            {{ $store.state.referencia_grupo.grupo !== null ? $store.state.referencia_grupo.grupo : "" }}</h2>
        </div>
        <div class="shadow bg-light-50 my-3 px-4 pt-4 pb-2"  v-for="(preguntas, key) in $store.state.preguntas" v-bind:key="key">
            <div class="row m-0">
                <div class="col-6 p-0">
                    <span>{{ preguntas.nombre_apellido }}</span>
                </div>
                <div class="col-6 p-0 d-flex justify-content-end" v-if="$store.state.usuario !== null">
                    <div class="dropdown dropleft">
                        <span class="cursor-pointer" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">...</span>
                        <div class="dropdown-menu" v-if="preguntas.id_usuario == $store.state.usuario.id" aria-labelledby="triggerId">
                            <h6 class="dropdown-item cursor-pointer" v-on:click="denunciar()">Denunciar</h6>
                            <h6 class="dropdown-item cursor-pointer" v-on:click="modal_cambiar(preguntas.titulo,preguntas.descripcion,preguntas.id_grupo,preguntas.id)"
                             data-toggle="modal" data-target="#modelEditar">Editar</h6>
                            <h6 class="dropdown-item cursor-pointer" v-on:click="modal_elimiar(preguntas.id)"
                             data-toggle="modal" data-target="#modelEliminar">Eliminar</h6>
                        </div>
                        <div class="dropdown-menu" v-else aria-labelledby="triggerId">
                            <h6 class="dropdown-item cursor-pointer" v-on:click="denunciar()">Denunciar</h6>
                        </div>
                    </div>
                </div>
            </div>
            <h2>{{ preguntas.titulo }}</h2>
            <p> {{preguntas.descripcion}}
            </p>
            <div>
                <span>
                    <i class="fa fa-heart-o h5 cursor-pointer" :id="'corazon_'+preguntas.id" v-on:click="like(preguntas.id,key)"
                     aria-hidden="true" like="No"></i>
                    <span class="mr-2" :id="'likes'+preguntas.id">{{preguntas.likes}}</span>
                </span>
                <span>
                    <router-link class="text-dark" :to="'/comentarios/'+preguntas.id">
                        <span>
                            <i class="fa fa-comment h5 cursor-pointer" aria-hidden="true"></i>
                            {{ preguntas.comentarios }}
                        </span>
                    </router-link>
                </span>
            </div>
        </div>
        <div class="modal" id="modelEditar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tu publicación</h5>
                        <button type="button" id="cerrarEditar" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Titulo</label>
                            <input type="text" class="form-control" v-on:keyup.Enter="cambiar()" v-model="titulo_editar">
                        </div>
                        <div class="form-group">
                            <label for="">Grupo</label>
                            <select class="form-control" v-on:keyup.Enter="cambiar()" id="grupos" v-model="id_grupo_editar">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Descripción</label>
                            <textarea class="form-control" v-on:keyup.Enter="cambiar()" v-model="descripcion_editar" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-dark rounded-pill"
                        v-on:click="cambiar()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modelEliminar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
        <div>
            <h1 class="text-center text-white font-weight-bold px-4">{{ $store.state.no_encontro_nada }}</h1>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        let interval = setInterval(()=> {
            if(this.$store.state.preguntas.length > 0){
                this.mi_like();
                window.clearInterval(interval);
            }
        },3000);
    },
    data(){
        return{
            titulo_editar: '',
            descripcion_editar:'',
            id_grupo_editar: '',
            validador: /^[a-zA-ZÁ-ÿ\s]{1,255}$/,
            numeros: /^\d{1,255}$/,
            id_pregunta: '',
        }
    },
    methods: {
        filtrado(value){
            if(value.toLocaleLowerCase().indexOf(this.$store.state.buscador.toLocaleLowerCase()) >= 0){
                return value.toLocaleLowerCase().indexOf(this.$store.state.buscador.toLocaleLowerCase()) >= 0;
            }
            else{
                alertify.error("No se encontraron resultados");
                return value;
            }
        },
        async like(value,key){
            if(this.$store.state.usuario == null) return location.hash = "/login";
            let token = document.querySelector('meta#token').getAttribute('content');
            let confirma = document.getElementById('corazon_'+value);
            let likex = confirma.getAttribute('like');
            if(likex == "No"){
                this.$store.state.preguntas[key].likes +=1;
                confirma.classList = "fa fa-heart h5 cursor-pointer text-danger";
                confirma.setAttribute('like','Si');
            }
            else {
                confirma.classList = "fa fa-heart-o h5 cursor-pointer";
                this.$store.state.preguntas[key].likes -=1;
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
            for(i of this.$store.state.preguntas){
                for( likes of this.$store.state.likes_generales){
                    if(likes.id_pregunta == i.id && likes.id_usuario == this.$store.state.usuario.id){
                        let ids = document.getElementById('corazon_'+i.id);
                        ids.classList = "fa fa-heart h5 cursor-pointer text-danger";
                        ids.setAttribute('like','Si');
                    }
                }
            }
        },
        per_grupo(value){
            localStorage.setItem('grupo',value)
            this.$store.dispatch('preguntas_get');
        },
        modal_cambiar(titulo,descripcion,id_grupo,id_pregunta){
            this.titulo_editar = titulo;
            this.descripcion_editar = descripcion;
            this.id_grupo_editar = id_grupo;
            this.id_pregunta = id_pregunta;
            let grupos = document.getElementById('grupos');
            for(var i = 0; i <  this.$store.state.grupos.length;i++){
                if(this.$store.state.grupos[i].id == id_grupo){
                    grupos.innerHTML += "<option selected value="+this.$store.state.grupos[i].id+">"+this.$store.state.grupos[i].grupo+"</option>";
                }
                else{
                    grupos.innerHTML += "<option value="+this.$store.state.grupos[i].id+">"+this.$store.state.grupos[i].grupo+"</option>";
                }
            }
        },
        async cambiar(){
            const regular =  /^[a-zA-ZÁ-ÿ\s\,\.]{1,250}$/,
            regularNumber =  /^\d{1,15}$/;
            const regularDesc = /^.{1,400000000}$/;
            let token = document.querySelector('meta#token').getAttribute('content');
            if(regular.test(this.titulo_editar) && regularDesc.test(this.descripcion_editar)
            && regularNumber.test(this.id_grupo_editar)){
                let formulario = new FormData();
                formulario.append('titulo',this.titulo_editar);
                formulario.append('descripcion',this.descripcion_editar);
                formulario.append('id_grupo',this.id_grupo_editar);
                alertify.success('Editando y guardando');
                const consulta = await fetch('editar_pregunta/'+this.id_pregunta,{
                    method: 'POST',
                    body: formulario,
                    headers: {
                        'X-CSRF-TOKEN':token
                    }
                });
                const respuesta = await consulta.text();
                if(respuesta == "Exito"){
                    for(var i = 0; i < this.$store.state.preguntas.length; i++){
                        if(this.$store.state.preguntas[i].id == this.id_pregunta){
                            this.$store.state.preguntas[i].titulo = this.titulo_editar;
                            this.$store.state.preguntas[i].descripcion = this.descripcion_editar;
                            this.$store.state.preguntas[i].id_grupo = this.id_grupo_editar;
                        }
                    }
                    let obj =document.getElementById('cerrarEditar');
                    obj.click();
                    alertify.success('Editado con exito.');
                }
                else{
                     alertify.error('Error. reintente de nuevo.');
                }
            }
            else{
                if(!regular.test(this.titulo_editar)) alertify.error("El titulo no puede estar vacio");
                else if(!regularDesc.test(this.descripcion_editar)) alertify.error("La descripcion no puede estar vacia");
                else if(!regularNumber.test(this.id_grupo_editar)) alertify.error("Selecciona un grupo");
                else alertify.error("Todos los campos deben estar llenos");
            }
        },
        modal_elimiar(id){
            this.id_pregunta = id;
        },
        async eliminar(){
            let pre = document.getElementById('carga');
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            let token = document.querySelector('meta#token').getAttribute('content');
            const consulta = await fetch('eliminar_pregunta/'+this.id_pregunta,{
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            const resultado = await consulta.text();
            if(resultado == "Exito"){
                for(var i = 0; i < this.$store.state.preguntas.length; i++){
                    if(this.$store.state.preguntas[i].id == this.id_pregunta){
                        this.$store.state.preguntas.splice(i,1);
                    }
                }
                alertify.success("Publicacion eliminada con exito.");
            }
            else{
                alertify.error("Error. Intente de nuevo.");
            }
            pre.classList.remove('d-flex');
            pre.classList.add('d-none');
        },
        denunciar(){
            let pre = document.getElementById('carga');
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
            setTimeout(()=>{
                alertify.success("Publicacion denunciada");
                pre.classList.remove('d-flex');
                pre.classList.add('d-none');
            },2000);
        }
    }
}
</script>
