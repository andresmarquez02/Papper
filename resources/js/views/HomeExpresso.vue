<template>
    <div>
        <div class="mb-5 bg-home-left position-relative vh-100 w-100 px-md-5 pt-md-3">
            <nav-expresso class="position-absolute w-calc"></nav-expresso>
            <div class="d-flex justify-content-center align-items-center vh-100">
               <div class="text-center text-white w-md-50-sm-95 pt-sm-3">
                    <h5>
                        LA MAGIA Y EL SABOR EN UN SOLO LUGAR.
                    </h5>
                    <div class="display-4 title">
                        Descubre los mejores platillos en <span class="text_info">Expresso.</span>
                    </div>
               </div>
            </div>
        </div>
        <div class="row m-0 px-12 my-4">
            <div class="col-md-6 col-sm-12">
                <img src="img/welcome.png " class="img-fluid" alt="">
            </div>
            <div class="col-md-6 col-sm-12 d-flex align-items-center">
                <div>
                    <h1 class="title font-weight-bold">
                        Bienvenido a Expresso.
                    </h1>
                    <div class="mt-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, ipsum delectus! Facilis 
                        nihil velit nesciunt pariatur id dicta natus reprehenderit est corporis! Voluptatibus provident
                        beatae quidem error officiis officia? Soluta.
                    </div>
                    <div class="mt-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, ipsum delectus! Facilis 
                        nihil velit nesciunt pariatur id dicta natus reprehenderit est corporis! Voluptatibus.
                    </div>
                    <div class="mt-5 pt-3">
                        <button type="button" class="btn btn-info rounded-0 btn-lg">Leer más</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0 px-12">
            <div class="col-12 mb-4 text-dark">
                <h1 class="font-weight-bold title">
                    Tienda.
                </h1>
                <div class="col-md-4 col-sm-10">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                    laboriosam!
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-6 mb-3" v-if="value.favorito == 'Si'" v-for="value in tienda">
                <div class="rounded-0 img_tienda bg-light mb-2" role="button" data-toggle="modal"
                data-target="#modelId" v-on:click="shop(value)">
                    <div class="overflow-hidden">
                        <img src="img/Penguins.jpg" class="w-100" alt="">
                    </div>
                    <div class="text-dark bg-info-hover p-2 row m-0">
                        <div class="h4 col-6 font-weight-bold title">
                            {{value.producto}}
                        </div>
                        <div class="col-6 h4 d-flex justify-content-end font-weight-bold text_info">
                            <span>
                                ${{value.precio}}
                            </span>
                        </div>
                        <div class="col-12">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            laboriosam.
                        </div>
                        <div class="col-12 d-flex justify-content-end text_info">
                            <i class="fas fa-shopping-cart "></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center mb-4">
                <router-link :to="{name:'tienda'}"class="btn btn-info btn-lg rounded-0">Ver más..</router-link>
            </div>
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                              <label for="">Cantidad del producto</label>
                              <input type="number" class="form-control" v-on:keyup.Enter="add()" placeholder="Cantidad" v-model="cantidad" min="1" required>
                              <small id="helpId" :class="text">Obligatorio*</small>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-info text-white rounded-0" data-dismiss="modal" v-on:click="add()">Agregar al Carrito</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row m-0 mb-5">
            <div class="col-12 px-0">
                <img src="img/patrocinio.PNG" class="img-fluid w-100" alt="">
            </div>
        </div>
        <div class="row m-0 p-0 text-dark mb-3 pb-3">
            <div class="col-12 d-flex justify-content-center mt-3 py-4">
                <h1 class="font-weight-bold text-center title">Promociones Expressas</h1>
            </div>
            <div class="col-sm-6 px-md-3 py-3 pb-2 mb-4" v-if="value.especialidad == 'Si'" v-for="value in tienda">
                <div class="row px-0 m-0 promocion" role="button" data-toggle="modal"
                data-target="#modelId" v-on:click="shop(value)">
                    <div class="col-md-6 col-sm-12 col-xs-12 px-0">
                         <img src="img/Penguins.jpg" class="w-100" alt="">
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <h2 class="font-weight-bolder title">{{value.producto}}</h2>
                        <div>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            laboriosam.
                        </div>
                        <div class="d-flex justify-content-end mt-lg-5 mt-md-3 pr-4">
                            <h4 class="font-weight-bold">
                                {{value.precio}}$
                            </h4>
                        </div>
                        <div>
                            <small class="text_info">Fin de promocion el 20/04/2021</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0 p-0 text-dark my-2 py-md-5 px-lg-4 px-md-2 px-1">
            <div class="col-md-5 pl-md-1 pl-3 d-flex align-items-center">
                <div>
                    <h5 class="text_info">Importante</h5>
                    <h1 class="title"><span class="text_info">Expresso</span> te facilita la vida</h1>
                    <div class="w-75">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                        laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                        dicta.
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row m-0">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 px-3 mb-5">
                        <div class="p-2 bg-light shadow-sm">
                            <div class="svg bike py-2">
                            </div>
                            <h4 class="text-center title">Delivery a tu medida</h4>
                            <small class="px-xl-3">
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            </small>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 px-3 mb-5">
                        <div class="p-2 bg-light shadow-sm">
                            <div class="svg money py-2">
                            </div>
                            <h4 class="text-center title">Sin ningun cobro extra</h4>
                            <small class="px-xl-3">
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            </small>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 px-3 mb-5">
                        <div class="p-2 bg-light shadow-sm">
                            <div class="svg earth py-2">
                            </div>
                            <h4 class="text-center title">Envios Internacionales</h4>
                            <small class="px-xl-3">
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0 text-dark my-5 pb-5 px-12">
            <div class="col-12 py-3">
                <h1 class="title text-center">En <span class="text_info">Expresso</span> puedes hacer</h1>
            </div>
            <div class="col-md-6 d-sm_none px-0">
                <div class="img_options">
                </div>
            </div>
            <div class="col-md-6 px-0">
                <div class="row m-0 pl-md-4">
                    <div class="col-12 pt-3">
                        <h3 class="title">Entregas super expresas</h3>
                        <div class="w-85">
                            Lorem, ipsum dolor adipisicing elit. Excepturi, deleniti
                            <br><br>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                        </div>
                    </div>
                    <div class="col-12 pt-3">
                        <h3 class="title">Programacion de entregas</h3>
                        <div class="w-85">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            <br><br>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            Lorem, ipsum dolor sit amet consectetur
                        </div>
                    </div>
                    <div class="col-12 pt-3">
                        <h3 class="title">Pedidos para dias especificos</h3>
                        <div class="w-85">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            <br><br>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-12 pt-4 px-0">
                <div class="row m-0 shadow bg-white carrusel">
                    <div class="col-12 mb-4">
                        <h1 class="text-center font-weight-bolder title text-white">Sigue estos pasos y haz un pedido</h1>
                    </div>
                    <div class="col-md-6 col-sm-12 py-3 w-item h-item position-relative" style="overflow:hidden">
                        <div class="position-absolute veinticinco_bottom d-flex justify-content-center align-items-center w-100 h-100" id="item-carousel-img">
                            <img src="img/carrito.svg" class="h-item">
                        </div>
                        <div class="position-absolute dosientos_bottom d-flex justify-content-center align-items-center w-100 h-100" id="item-carousel-img">
                            <img src="img/ubicacion.svg" class="h-item">
                        </div>
                        <div class="position-absolute dosientos_bottom d-flex justify-content-center align-items-center w-100 h-100" id="item-carousel-img">
                            <img src="img/paga.svg" class="h-item">
                        </div>
                        <div class="position-absolute dosientos_bottom d-flex justify-content-center align-items-center w-100 h-100" id="item-carousel-img">
                            <img src="img/casa.svg" class="h-item">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 py-4 h-item text-white position-relative d-flex justify-content-center align-items-center"
                    style="overflow:hidden">
                        <div>
                            <div class="position-absolute veinticinco pr-md-5" id="item-carousel">
                                <div class="px-lg-5 px-md-3 w-md-100-sm-75 px-1">
                                    <h2 class="font-weight-bolder pl-1 title">Carrito</h2>
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                                    laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                                    dicta.
                                    <br>
                                    laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                                    dicta.
                                </div>
                            </div>
                            <div class="position-absolute dosientos pr-md-5" id="item-carousel">
                                <div class="px-lg-5 px-md-3 w-md-100-sm-75 px-1">
                                    <h2 class="font-weight-bolder pl-1 title">Marcar Ubicación</h2>
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                                    laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                                    dicta.
                                     <br>
                                    laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                                    dicta.
                                </div>
                            </div>
                           <div class="position-absolute dosientos pr-md-5" id="item-carousel">
                                <div class="px-lg-5 px-md-3 w-md-100-sm-75 px-1">
                                    <h2 class="font-weight-bolder pl-1 title">Paga</h2>
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                                    laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                                    dicta.
                                     <br>
                                    laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                                    dicta.
                                </div>
                            </div>
                            <div class="position-absolute dosientos pr-md-5" id="item-carousel">
                                <div class="px-lg-5 px-md-3 w-md-100-sm-75 px-1">
                                    <h2 class="font-weight-bolder pl-1 title">Recibelo en tu casa</h2>
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, deleniti
                                    laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                                    dicta.
                                     <br>
                                    laboriosam! Illum hic accusantium error neque atque maxime nobis modi       iure
                                    dicta.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center pt-5">
                        <span class="bg-light mr-3 py-1 px-2 rounded-pill" v-on:click="move(0)" id="next-item"></span>
                        <span class="bg-info mr-3 py-1 px-2 rounded-pill pulse" v-on:click="move(1)" id="next-item"></span>
                        <span class="bg-info mr-3 py-1 px-2 rounded-pill" v-on:click="move(2)" id="next-item"></span>
                        <span class="bg-info mr-3 py-1 px-2 rounded-pill" v-on:click="move(3)" id="next-item"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0 ">
            <div class="col-12">
                
            </div>
        </div>
        <div class="row m-0 pt-4 px-12">
            <div class="col-12 text-center text-dark py-3">
                <small class="text_info title font-weight-light">¿Acerca?</small>
                <h1 class="title">
                    Acerca de <span class="text_info">Nosotros</span>
                </h1>
            </div>
            <div class="col-md-4 col-sm-12 px-md-3 px-4 pb-5" v-for="ll in info">
                <div class="px-md-3">
                    <div class="px-0 position-relative">
                        <img :src="'img/'+ll.img" class="w-100 rounded vh-40" alt="">
                    </div>
                    <div class="d-block position-relative w-100">
                        <div class="p-3 rounded shadow-sm bg-white ubic_information">
                            <h4 class="title">{{ll.titulo}}</h4>
                            <small class="text_info">
                                Expresso tu mejor opcion
                            </small>
                            <div>
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Illum hic accusantium 
                                error neque atque maxime nobis modi iure dicta.
                            </div>
                            <br>
                            <br>
                            <div class="text-center pb-3">
                                <span class="bg-info text-white rounded-0 px-3 py-2">
                                Más información
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="enCarrito != ''">
            <ul class="list-group fixed-bottom list-fixed hidexs" id="list_list">
                <li class="list-group-item pb-1 px-1 text-center">
                    <div class="row m-0">
                        <div class="col-9">
                            Carrito
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-light btn-sm rounded-circle"
                            v-on:click="cerrar_abrir(1)">&times;</button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item pb-1">
                    <div class="row m-0">
                        <div class="col-4">
                            Producto
                        </div>
                        <div class="col-4">
                            Precio
                        </div>
                        <div class="col-4">
                            Cantidad
                        </div>
                    </div>
                </li>
                <li class="list-group-item no-hover-list py-1 px-1">
                    <div class="row m-0" v-for="carrito in enCarrito">
                        <div class="col-4">
                            {{carrito.producto}}
                        </div>
                        <div class="col-4">
                            {{carrito.precio}}
                        </div>
                        <div class="col-4">
                            {{carrito.cantidad}}
                        </div>
                    </div>
                </li>
                <li class="list-group-item py-1 px-1 d-flex justify-content-center">
                    <div>
                        <button type="button" id="map_comprar" class="btn btn-light rounded-pill"
                        data-toggle="modal" data-target="#modelComprar" v-on:click="mapa()">Comprar</button>
                        <button type="button" id="map_comprar" class="btn btn-light rounded-pill"
                        v-on:click="cerrar_abrir(1)">Minimizar</button>
                    </div>
                </li>
            </ul>
            <button type="button" class="btn btn-danger rounded-pill shows fixed-bottom list-fixed button-car" id="button_list"
            v-on:click="cerrar_abrir(2)"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Carrito</button>
        </div>
        <div class="modal fade" id="modelComprar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title">{{title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" id="cerrar_comprar" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <div :class="item_1">
                            <div class="row m-0">
                            <div class="col-4">
                                Producto
                            </div>
                            <div class="col-2">
                                Precio
                            </div>
                            <div class="col-2">
                                Cantidad
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                        <div class="row m-0" v-for="carrito in enCarrito">
                            <div class="col-4 py-2">
                                {{carrito.producto}}
                            </div>
                            <div class="col-2 py-2">
                                {{carrito.precio}}
                            </div>
                            <div class="col-2 py-2">
                                {{carrito.cantidad}}
                            </div>
                            <div class="col-4 py-2">
                                <button type="button" class="btn btn-danger rounded-pill" v-on:click="eliminar(carrito.id)">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light rounded-pill shadow"
                            v-on:click="items(2)">Siguiente</button>
                        </div>
                        </div>
                        <div :class="item_2">
                            <div>Ubique el <i class="fa fa-location-arrow" aria-hidden="true"></i>
                            para saber donde quiere que se le entregue su pedido</div>
                            <div id="mapid"></div>
                            <div class="modal-footer d-flex justify-content-center">
                               <div>
                                    <button type="button" class="btn btn btn-light rounded-pill shadow"
                                    v-on:click="items(1)">Atras</button>
                                    <button type="button" class="btn btn-info text-white rounded-pill shadow"
                                    v-on:click="items(3)">Ver y pagar</button>
                               </div>
                            </div>
                        </div>
                        <div :class="item_3">
                            <div class="form-group">
                              <label for="">Tipo de entrega</label>
                              <select class="form-control" v-model="tipo_entrega" v-on:change="type()">
                                <option value="1">Expresa</option>
                                <option value="2">Planificar hora </option>
                                <option value="3">Planificar día</option>
                              </select>
                              <div v-if="tipo_entrega == 2">
                                    <div class="form-group">
                                        <label for="">Ingresa la hora</label>
                                        <input type="time" class="form-control" placeholder="00:00" 
                                        v-on:change="acceso()" v-model="planificado">
                                    </div>
                              </div>
                              <div v-if="tipo_entrega == 3">
                                    <div class="form-group">
                                        <label for="">Ingresa la hora</label>
                                        <input type="datetime-local" class="form-control" placeholder="00:00" 
                                        v-on:change="acceso()" v-model="planificado">
                                    </div>
                              </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <div>
                                    <button type="button" class="btn btn-info text-white rounded-pill shadow"
                                    v-on:click="items(2)">Atras</button>
                                    <form action="./pagar" method="post" class="d-inline">
                                        <input type="hidden" name="_token" :value="token">
                                        <button type="button" class="btn btn-light rounded-pill shadow" :class="button_access"
                                        v-on:click="items(4)">Pagar</button>
                                        <button type="submit" id="submit" class="btn btn-primary d-none"></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div :class="item_4">

                            <div v-if="recibo != 0">
                                <div class="row my-2">
                                    <div class="col-6 d-flex justify-content-end">
                                        Total=
                                    </div>
                                    <div class="col-6">
                                        {{recibo}}
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        Delivery=
                                    </div>
                                    <div class="col-6">
                                        {{recibo}}
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                         Total a pagar=
                                    </div>
                                    <div class="col-6">
                                         {{recibo + recibo}}
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <div>
                                        <button type="button" class="btn btn-info text-white rounded-pill shadow"
                                        v-on:click="items(3)">Atras</button>
                                        <form action="./pagar" method="post" class="d-inline">
                                            <input type="hidden" name="_token" :value="token">
                                            <button type="button" class="btn btn-light rounded-pill shadow"
                                            v-on:click="flujo()">Pagar</button>
                                            <button type="submit" id="submit" class="btn btn-primary d-none"></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <h2 class="text-center">
                                    No tienes ningun producto en tu carrito
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState,mapMutations } from 'vuex'
export default {
    mounted() {
        setInterval(()=>{
            if(this.permiItem === true){
                if(this.contador < 4){
                    this.contador++;
                }
                else{
                    this.contador = 0;
                }
                this.move(this.contador);
            }
        },8000);
        this.products();        
        this.token = document.getElementById('token').getAttribute('content');
        this.fede();
    },
    data() {
        return {
            contador: 0,
            permiItem: true,
            info: [
                {info: 1,titulo: 'Repartidores',img:'repartidor.PNG'},
                {info: 2,titulo: 'Marketing',img:'galery7.PNG'},
                {info: 3,titulo: 'Comercios asociados',img:'asoc.PNG'},
            ],
            tienda: '',
            cantidad: '',
            producto: '',
            text: 'text-muted',
            enCarrito: [],
            token: '',
            item_1: 'd-block',
            item_2: 'd-none',
            item_3: 'd-none',
            item_4: 'd-none',
            recibo: 0,
            title: '',
            tipo_entrega: [],
            item_seleccionado: 0,
            tu_entrega: 0,
            button_access: 'd-none',
            planificado: '',
        }
    },
    methods: {
        async products(){
            const consulta = await fetch('./js/tienda.json');
            const respuesta = await consulta.json();
            this.tienda = respuesta;
            this.$store.state.tienda = respuesta;
            this.enCarrito = JSON.parse(localStorage.getItem('producto'));
            this.$store.state.enCarrito = JSON.parse(localStorage.getItem('producto'));
            if(this.enCarrito == null){
                this.enCarrito = [];
                this.$store.state.enCarrito = [];
            }
        },
        shop(value){
            this.producto = value;
        },
        add(){
            let cantidad = parseInt(this.cantidad);
            if(this.cantidad != "" && cantidad > 0){
                let producto = JSON.parse(localStorage.getItem('producto'));
                console.log(producto);
                if(producto == null || producto == '' || producto.length == 0){
                    producto = [{
                        id: this.producto.id,
                        producto: this.producto.producto,
                        precio: this.producto.precio,
                        cantidad: parseInt(this.cantidad),
                    }];
                }
                else{
                    let vall = false;
                    for(var i = 0; i < producto.length;i++){
                        if(this.producto.id == producto[i].id){
                            producto[i].cantidad += parseInt(this.cantidad);
                            vall = true;
                            break;
                        }
                    }
                    if(vall == false){
                        producto.push( {
                            id: this.producto.id,
                            producto: this.producto.producto,
                            precio: this.producto.precio,
                            cantidad: parseInt(this.cantidad),
                        });
                    }
                }
                this.text = "text-muted";
                this.cantidad = "";
                localStorage.setItem('producto',JSON.stringify(producto));
                this.enCarrito = JSON.parse(localStorage.getItem('producto'));
                this.$store.state.enCarrito = JSON.parse(localStorage.getItem('producto'));
            }
            else{
                this.text = "text-danger";
                alertify.error("Cantidad incorrecta");
            }
        },
        eliminar(value){
            let producto = JSON.parse(localStorage.getItem('producto'));
            for(var i = 0; i < producto.length; i++){
                if(producto[i].id == value){
                    producto.splice(i,1);
                    alertify.success("Eliminado con exito");
                    break;
                }
            }
            localStorage.setItem('producto',JSON.stringify(producto));
            this.enCarrito = JSON.parse(localStorage.getItem('producto'));
            this.$store.state.enCarrito = JSON.parse(localStorage.getItem('producto'));
        },
        async flujo(){
            let total = 0;
            for(var i = 0; i < this.enCarrito.length;i++){
                total += this.enCarrito[i].precio * this.enCarrito[i].cantidad;
            }
            try{
                let formulario = new FormData();
                formulario.append('total',total);
                const consulta = await fetch('carrito',{
                    method: 'POST',
                    body: formulario,
                    headers: {
                        'X-CSRF-TOKEN': this.token
                    }
                });
                const respuesta = await consulta.text();
                if(respuesta == ""){
                    this.flujo();
                }
                else{
                    
                    let obj = document.getElementById('submit');
                    obj.click();
                }
            }
            catch(error){
                this.flujo();
            }
            return false;
        },
        mapa(){
            navigator.geolocation.getCurrentPosition(showPosition,errores);
            function showPosition(position){
                console.log("Latitude: " + position.coords.latitude +
                "Longitude: " + position.coords.longitude);
                const providers = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                const providers2 = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                const providers3 = 'http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png';
                var mymap = L.map('mapid').setView([position.coords.latitude, position.coords.longitude], 13);
                L.tileLayer(providers3, {
                    maxZoom: 18,
                }).addTo(mymap);
            }
            function errores(error){
                let obj = document.getElementById('cerrar_comprar');
                obj.click();
                if(error.code == 1){
                    alertify.confirm("Por favor activa la localizacion y recarga el sitio");
                }
                else{
                    alertify.confirm("A ocurrido un error al obtener su ubicacion recargue el sitio. por favor");
 
                }
            }
            this.items(1);
        },
        items(value){
            let modal = document.getElementById('cerrar_comprar');
            if(value == 1){
                this.item_1 = 'd-block';
                this.item_2 = 'd-none';
                this.item_3 = 'd-none';
                this.item_4 = 'd-none';
                this.title = "Su carrito";
            }
            else if(value == 2){
                this.item_1 = 'd-none';
                this.item_2 = 'd-block';
                this.item_3 = 'd-none';
                this.item_4 = 'd-none';
                let total = 0;
                for(var i = 0; i < this.enCarrito.length;i++){
                    total += this.enCarrito[i].precio * this.enCarrito[i].cantidad;
                }
                this.recibo = total;
                this.title = "Su ubicación";
                if(this.recibo < 1){
                    alertify.error("Total incorrecto. No hay productos en el carrito");
                    modal.click();
                }
            }
            else if(value == 3){
                this.item_1 = 'd-none';
                this.item_2 = 'd-none';
                this.item_3 = 'd-block';
                this.item_4 = 'd-none';
                this.title = "Tipo de entrega";
            }
            else if(value == 4){
                if(this.$store.state.enCarrito != "" && this.recibo > 0){
                    this.item_1 = 'd-none';
                    this.item_2 = 'd-none';
                    this.item_3 = 'd-none';
                    this.item_4 = 'd-block';
                    this.title = "Recibo de Pago";
                }
                else{
                    alertify.error("No tiene productos en el carrito");
                    modal.click();
                }
            }
            else{
                alertify.error("Error inesperado");
            }
        },
        cerrar_abrir(value){
            let lista = document.getElementById('list_list');
            let boton = document.getElementById('button_list');
            if(value == 1){
                lista.classList.add('hidexs');
                boton.classList.add('shows');
                lista.classList.remove('shows');
                boton.classList.remove('hidexs');
            }else{
                boton.classList.add('hidexs');
                lista.classList.add('shows');
                boton.classList.remove('shows');
                lista.classList.remove('hidexs');
            }
        },
        type(){
            this.tipo_entrega == 1  ? this.button_access = "d-inline-block" : this.button_access = "d-none";
        },
        acceso(){
            this.planificado != "" ? this.button_access = "d-inline-block" : this.button_access = "d-none";
        },
        move(value){
            if(value == 4){ this.contador = 0;value=0;}
            let items = document.querySelectorAll("#item-carousel");
            let imgs = document.querySelectorAll("#item-carousel-img");
            let ii= null,aa = null;
            let next_items = document.querySelectorAll("#next-item");
            value != '' && next_items[1].getAttribute('class','pulse') ? next_items[1].classList.remove("pulse") :
            '';
            if(value != this.item_seleccionado){
                for(aa in next_items){
                    if(aa == value){
                        next_items[aa].classList.add("bg-light");
                        next_items[aa].classList.remove("bg-info");
                    }
                    else{
                        if(aa < 4){
                            next_items[aa].classList = "bg-info mr-3 py-1 px-2 rounded-pill";
                        }
                    }
                }
                for(ii in items){
                    if(ii == value){
                        items[ii].classList.add("veinticinco");
                        items[ii].classList.remove("dosientos");
                        imgs[ii].classList.add("veinticinco_bottom");
                        imgs[ii].classList.remove("dosientos_bottom");
                        items[this.item_seleccionado].classList.add("dosientos");
                        imgs[this.item_seleccionado].classList.remove("veinticinco_bottom");
                        imgs[this.item_seleccionado].classList.add("dosientos_bottom");
                        this.item_seleccionado = ii;
                        this.permiItem = false;
                        this.contador = value;
                    }
                }
                setTimeout(()=>{
                    this.permiItem = true;
                },3000);
            }
        },
        ...mapMutations('expresso',['deleteSub','fede'])
    },
    computed:{
        ...mapState('expresso',['usuario']),
    }
}
</script>
