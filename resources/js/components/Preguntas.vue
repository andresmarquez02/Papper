<template>
    <div class="pt-3 pb-3 px-md-5">
        <div v-if="$store.state.referencia_grupo.grupo != undefined && $store.state.referencia_grupo.grupo != ''
        && $store.state.referencia_grupo.grupo != null">
            <div style="padding-top: 1.5rem;">
                <span class="px-4 cursor-pointer text-decoration h2 font-weight-bold"
                v-on:click="per_grupo($store.state.referencia_grupo.id)">
                    <i class="fa fa-hashtag" aria-hidden="true"></i>
                    {{ $store.state.referencia_grupo.grupo !== null ? $store.state.referencia_grupo.grupo : "" }}
                </span>
            </div>
        </div>
        <div class="px-4 pt-4 pb-2 my-4 bg-light-50 card-preg"  v-for="(preguntas, key) in $store.state.preguntas" v-bind:key="key">
            <div class="m-0 row">
                <div class="p-0 col-6">
                    <span>{{ preguntas.nombre_apellido }}</span>
                    <small class="d-block small-hora text-muted">{{preguntas.created_at}}</small>
                </div>
                <div class="p-0 col-6 d-flex justify-content-end" v-if="$store.state.usuario !== null">
                    <div class="dropdown dropleft">
                        <span class="cursor-pointer" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">...</span>
                        <div class="dropdown-menu" v-if="preguntas.id_usuario == $store.state.usuario.id" aria-labelledby="triggerId">
                            <h6 class="cursor-pointer dropdown-item" v-on:click="denunciar()">Denunciar</h6>
                            <h6 class="cursor-pointer dropdown-item" v-on:click="modal_cambiar(preguntas)"
                             data-toggle="modal" data-target="#modelEditar">Editar</h6>
                            <h6 class="cursor-pointer dropdown-item" v-on:click="modal_elimiar(preguntas.id)"
                             data-toggle="modal" data-target="#modelEliminar">Eliminar</h6>
                        </div>
                        <div class="dropdown-menu" v-else aria-labelledby="triggerId">
                            <h6 class="cursor-pointer dropdown-item" v-on:click="denunciar()">Denunciar</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="font-weight-bold">{{ preguntas.titulo }}</h2>
                <p class="mb-1">
                    <i class="fa fa-quote-left ss-small" aria-hidden="true"></i>
                    {{preguntas.descripcion}}
                    <i class="fa fa-quote-right ss-small" aria-hidden="true"></i>
                </p>
                <div class="mb-3">
                    <small class="mr-3"><i class="fa fa-hashtag" aria-hidden="true"></i> Grupo</small>
                    <small><i class="fa fa-hashtag" aria-hidden="true"></i> {{preguntas.grupo}}</small>
                </div>
            </div>
            <div>
                <span>
                    <i class="cursor-pointer fa fa-heart-o h5 waves-effect" :id="'corazon_'+preguntas.id" v-on:click="like(preguntas.id,key)"
                     aria-hidden="true" like="No"></i>
                    <span class="mr-2" :id="'likes'+preguntas.id">{{preguntas.likes}}</span>
                </span>
                <span>
                    <router-link class="text-dark" :to="'/comentarios/'+preguntas.id">
                        <span>
                            <i class="cursor-pointer fa fa-comment h5" aria-hidden="true"></i>
                            {{ preguntas.comentarios }}
                        </span>
                    </router-link>
                </span>
            </div>
        </div>
        <div v-if="$store.state.preguntas.length == 0">
            <h2 class="py-5 text-center font-weight-bold">
                <i class="fas fa-grin-beam-sweat "></i> <br>
                No hay publicaciones para mostrar
            </h2>
        </div>
        <div class="modal" id="modelEditar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Publicación</h5>
                        <button type="button" id="cerrarEditar" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form v-on:submit.prevent="cambiar()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Titulo</label>
                                <input type="text" class="form-control" v-model="titulo_editar">
                            </div>
                            <div class="form-group">
                                <label for="">Grupo</label>
                                <select class="form-control" v-model="id_grupo_editar">
                                    <option v-for="grupo in $store.state.grupos" :value="grupo.id" v-bind:key="grupo.id">{{ grupo.grupo }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Descripción</label>
                                <textarea class="form-control" v-model="descripcion_editar" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning rounded-pill waves-effect"
                            ><i class="fa fa-check-circle" aria-hidden="true"></i> Actualizar</button>
                        </div>
                    </form>
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
                        <h2 class="text-center">Esta seguro de eliminar esta publicacion?</h2>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button type="button" class="px-4 btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> No</button>
                            <button type="button" class="px-4 btn btn-danger waves-effect" data-dismiss="modal" v-on:click="eliminar()"><i class="fa fa-trash" aria-hidden="true"></i> Si</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h1 class="px-4 text-center text-white font-weight-bold">{{ $store.state.no_encontro_nada }}</h1>
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
        modal_cambiar(pregunta){
            this.titulo_editar = pregunta.titulo;
            this.descripcion_editar = pregunta.descripcion;
            this.id_grupo_editar = pregunta.id_grupo;
            this.id_pregunta = pregunta.id;
        },
        async cambiar(){
            const regular =  /^.{1,250}$/,
            regularNumber =  /^\d{1,15}$/;
            const regularDesc = /^.{1,400000000}$/;
            let token = document.querySelector('meta#token').getAttribute('content');
            if(regular.test(this.titulo_editar) && regularDesc.test(this.descripcion_editar)
            && regularNumber.test(this.id_grupo_editar)){
                try {
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
                    const respuesta = await consulta.json();
                    if(consulta.status === 200){
                        this.$store.dispatch('preguntas_get');
                        let obj =document.getElementById('cerrarEditar');
                        obj.click();
                        alertify.success(respuesta.exito);
                    }
                    else throw([respuesta,consulta.status]);
                } catch (errors) {
                    carga.classList.remove("d-flex");
                    carga.classList.add("d-none");
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
