<template>
    <div class="pt-3 pb-3 px-md-5">
        <div v-if="$store.state.usuario !== null">
            <router-link class="btn btn-outline-dark waves-effect rounded-circle" to="/inicio">
                <i class="fas fa-arrow-left"></i>
            </router-link>
        </div>
        <div v-else>
            <router-link class="btn btn-outline-dark waves-effect rounded-circle" to="/">
                <i class="fas fa-arrow-left"></i>
            </router-link>
        </div>
        <div class="px-4 pt-4 pb-2 my-3 bg-light card-preg">
            <div>
                <img src="img/wave_publicacion.svg" class="position-absolute waves-card">
            </div>
            <div class="p-0">
                <span>{{  $store.state.pregunta.nombre_apellido }}</span>
                <small class="d-block small-hora text-muted">{{$store.state.pregunta.created_at}}</small>
            </div>
            <div>
                <h2 class="font-weight-bold">{{ $store.state.pregunta.titulo }}</h2>
                <p class="mb-1">
                    <i class="fa fa-quote-left ss-small" aria-hidden="true"></i>
                    {{$store.state.pregunta.descripcion}}
                    <i class="fa fa-quote-right ss-small" aria-hidden="true"></i>
                </p>
                <div class="mb-3">
                    <small class="mr-3">#Grupo</small>
                    <small>#{{$store.state.pregunta.grupo}}</small>
                </div>
            </div>
            <div>
                <span>
                    <i class="cursor-pointer fa h5" :class="$store.state.esLike > 0 ? 'fa-heart text-danger' : 'fa-regular fa-heart'" :id="'corazon_'+$store.state.pregunta.id" v-on:click="like($store.state.pregunta.id)"
                     aria-hidden="true" :like="$store.state.esLike > 0 ? 'Si' : 'No'"></i>
                    <span class="mr-2" :id="'likes'+$store.state.pregunta.id">{{$store.state.pregunta.likes}}</span>
                </span>
            </div>
        </div>
        <comentario/>
        <div class="px-4 pt-4 pb-2 my-3"
        v-if="$store.state.commentarios == ''">
            <h2 class="text-center font-weight-bold">Sin comentarios...</h2>
        </div>
        <div class="pt-4 pb-2 my-3 px-lg-4" v-if="$store.state.usuario !== null">
            <div class="mb-3 input-group">
                <input type="text" class="form-control rounded-pill-left" v-model="$store.state.comentario" v-on:keyup.enter="comentar()" placeholder="comentario..." aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="px-3 btn btn-primary btn-sm waves-effect" v-on:click="comentar()" type="button" id="button-addon2">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </button>
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
                confirma.classList = "fa fa-regular fa-heart h5 cursor-pointer";
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
        comentar(){

            if(this.$store.state.usuario == null) return location.hash = "/login";
            const regular =  /^.{1,400000000}$/ ;
            let pre = document.getElementById('carga')
            if(regular.test(this.$store.state.comentario)){
                pre.classList.remove('d-none');
                pre.classList.add('d-flex');
                this.$store.dispatch('enviar_comentario');
            }
            else{
                if(this.$store.state.comentario != "" && !regular.test(this.$store.state.comentario)){
                    alertify.error("Comentario muy extenso por favor envielo en dos partes");
                }
            }
        }
    },
}
</script>
