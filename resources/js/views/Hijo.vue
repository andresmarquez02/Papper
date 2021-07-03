<template>
    <div>
        <h2 class="text-center text-dark font-weight-bold">Tabla común</h2>
        <div class="overflow-x-auto ">
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Codígo</th>
                        <th>Nombre y Apellído</th>
                        <th>Corréo</th>
                        <th>Cargo</th>
                        <th>Telefono</th>
                        <th>Dirección</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="filtra(usuarios.nombre,usuarios.apellido)"
                    v-for="usuarios in $store.state.personas" class="text-center">
                        <td>{{usuarios.id}}</td>
                        <td>{{usuarios.nombre}} {{usuarios.apellido}}</td>
                        <td>{{usuarios.email}}</td>
                        <td>{{usuarios.cargo}}</td>
                        <td>{{usuarios.telefono}}</td>
                        <td>{{usuarios.pais}},{{usuarios.region}}</td>
                        <td>
                            <button class="btn btn-danger mr-2" v-on:click="eliminar(usuarios.id)">
                            <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-dark"  data-toggle="modal" data-target="#actualizar"
                            v-on:click="datos(usuarios)">
                            <i class="fas fa-edit    "></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <h2 class="text-center text-dark font-weight-bold">Arrastra y suelta (Para organizarlos a tu gusto)</h2>
                <Draggable class="list-group text-dark pl-0" id="list" :list="$store.state.personas" v-bind="personitas" tag="ul" chosen-class="moving-card" drag-class="dragg"
                :animation="200" @change="cambiar()">
                    <li :key="usuarios.id" v-if="filtra(usuarios.nombre,usuarios.apellido)"
                    v-for="usuarios in $store.state.personas" class="list-group-item my-2 p-3 rounded cursor-move"
                    :data-id="usuarios.id">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="row m-0">
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <h5 class="font-weight-bold text-darking">Nombre</h5>
                                        {{usuarios.nombre}} {{usuarios.apellido}}
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <h5 class="font-weight-bold text-darking">Correo</h5>
                                        {{usuarios.email}}
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <h5 class="font-weight-bold text-darking">Dirección</h5>
                                        {{usuarios.pais}}, {{usuarios.region}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 d-flex justify-content-end">
                                <button class="btn btn-danger mr-2" v-on:click="eliminar(usuarios.id)">
                                <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-dark mr-2"  data-toggle="modal" data-target="#actualizar"
                                v-on:click="datos(usuarios)">
                                <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-primary"  data-toggle="modal" data-target="#ver_mas"
                                v-on:click="ver_mas(usuarios)">
                                <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                </Draggable>
        <h4 class="text-dark text-center">
            Si borra alguno de los datos o todos solo sufrira cambios en su ordenador, ya que esto no esta conectado a una base de datos.
        </h4>
        <div class="d-flex justify-content-center">
            <button type="button" @click="reestablecer()" class="btn btn-primary rounded-pill">Reestablecer datos</button>
        </div>
         <!-- Modal -->
        <div class="modal" id="actualizar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <nieta></nieta>
        </div>
        <div class="modal" id="ver_mas" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <hija></hija>
        </div>
    </div>
</template>
<script>
import Draggable from 'vuedraggable';
export default {
    mounted() {
        let lista = document.querySelector('#list');
        Sortable.create(lista,{
            store:{
                set: (sortable) => {
                    console.log(sortable.toArray());
                    const orden = sortable.toArray();
                    localStorage.setItem('orden', orden.join(','));
                },
                get: (sortable) => {

                },
            }
        });
    },
    components: {
        Draggable,
    },
    methods: {
        cambiar(){
            alertify.success("Movido");
        },
        reestablecer(){
            localStorage.removeItem('orden')
            this.$store.dispatch('get_usuarios');
        },
        filtra(value, value2){
            if(value.toLocaleLowerCase().indexOf(this.$store.state.nombre.toLocaleLowerCase()) >= 0){
                return value.toLocaleLowerCase().indexOf(this.$store.state.nombre.toLocaleLowerCase()) >= 0;
            }
            else if(value2.toLocaleLowerCase().indexOf(this.$store.state.nombre.toLocaleLowerCase()) >= 0){
                return value2.toLocaleLowerCase().indexOf(this.$store.state.nombre.toLocaleLowerCase()) >= 0;
            }
        },
        eliminar(value){
            for(var i = 0; i < this.$store.state.personas.length; i++){
                if(this.$store.state.personas[i].id == value){
                    this.$store.state.personas.splice(i,1);
                    alertify.error("Usuario Eliminado");
                    break;
                }
            }
        },
        ver_mas(value){
            this.$store.state.vermas = value;
        },
        datos(value){
            this.$store.state.act_user = value;
            this.$store.state.id = value.id
            this.$store.state.regiones = [];
        },
    },
    computed: {
        personitas: {
            get(value){
                // console.log(value.$store.state.personas);
            },
            set(value){
                console.log("Hola");
            }
        }
    }
}
</script>
<style >
    .text-darking{
        color: #20212c;
    }
    .cursor-move:hover{
        cursor: move;
    }
</style>
<style lang="css">
    .moving-card {
        background: #f3f2f2;
        cursor: move;
        transform: rotate(-0.8deg) scale(1.02);
        box-shadow: 1px 1px 8px 0px #756e6e7c;
    }
    .dragg{
        opacity: 0;
    }
    .d-table{
        display: table;
    }
    .overflow-x-auto{
        overflow-x: auto;
    }
</style>
