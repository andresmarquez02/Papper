<template>
    <div>
        <div class="position-relative">
            <div class="bg-home vh-100-home overflow-hidden">
                <div class="w-100 h-100 bg-image-50">
                </div>
            </div>
            <div class="row m-0 pt-xl-2 px-xl-5 pb-xl-5 p-md-2 position-absolute w-100 h-100 d-flex align-items-center top-10">
                <div class="col-12">
                    <nav class="navbar navbar-expand-sm navbar-dark text-dark">
                <router-link class="navbar-brand text-white pt-2" :to="{name: 'home'}" id="nav">Roulex</router-link>
                <button class="navbar-toggler d-lg-none" type="button" v-on:click="show_hide()" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse pt-2" id="collapsibleNavId">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <router-link
                            class="nav-link text-white"
                            :to="{name: 'home'}">
                                Empresas fundadas
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                            class="nav-link text-white"
                            :to="{name: 'home'}">
                                Trabajadores ejemplares
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                            class="nav-link text-white"
                            :to="{name: 'home'}">
                                Proyectos
                            </router-link>
                        </li>
                        <li class="nav-item active">
                            <router-link class="btn btn-dark shadow mr-2 animate__animated s2 animate__delay-5s animate__jello animate__repeat-2"
                            :to="{name: 'login'}" >Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="btn btn-light shadow animate__animated s2 animate__delay-5s animate__jello animate__repeat-2"
                            :to="{name: 'registro'}">Registro</router-link>
                        </li>
                    </ul>
                </div>
            </nav>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-12 pt-xl-1 pt-5">
                    <div class="text-white">
                        <span class="h4">Bienvenido a Roulex</span>
                        <h1 class="mb-4 display-4 font-weight-bolder">La web de Trabajadores y Empresas</h1>
                        <p class="caps">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque     laboriosam cumque eveniet repudiandae</p>
                        <p class="mb-0"><a href="#" class="btn btn-primary">Registrarme</a>
                         <a href="#" class="btn btn-light">Leer más</a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 py-5 pb-2 mt-3 d-flex-none justify-content-center form-home-color
                animate__animated s3 animate__zoomIn  mt-xl-5">
                    <div class="w-75 text-white">
                        <h1 class="text-center font-weight-bolder mb-4">Unete</h1>
                        <div class="form-group position-relative text-white mb-4 mt-2">
                            <label class="position-absolute text-dark px-3 rounded-pill bg-light label-form">Nombre</label>
                            <input type="text" class="form-control form-contact p-4"  placeholder="Ej. John Doe" aria-describedby="helpId">
                        </div>
                        <div class="form-group position-relative text-white mb-4">
                            <label class="position-absolute text-dark px-3 rounded-pill bg-light label-form">Usuario</label>
                            <input type="text" class="form-control form-contact p-4"  placeholder="Ej. John Doe" aria-describedby="helpId">
                        </div>
                        <div class="form-group position-relative text-white mb-4">
                            <label class="position-absolute text-dark px-3 rounded-pill bg-light label-form">Correo</label>
                            <input type="text" class="form-control form-contact p-4"  placeholder="Ej. John Doe" aria-describedby="helpId">
                        </div>
                        <div class="form-group position-relative text-white mb-4">
                            <label class="position-absolute text-dark px-3 rounded-pill bg-light label-form">Contraseña</label>
                            <input type="password" class="form-control form-contact p-4"  placeholder="Ej. John Doe" aria-describedby="helpId">
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="button" class="btn btn-light btn-lg shadow rounded-pill">Ingresar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="row m-0 pt-3 mb-5 px-md-4">
            <div class="col-12 mb-3 d-flex justify-content-center">
                <h1 class="font-weight-bold display-4 text-dark">
                    Miembresias
                </h1>
            </div>
            <div class="col-md-3 col-sm-6 mb-3 px-md-4 px-2 text-center text-white d-flex">
                <div class="plan-1 p-3 rounded font-weight-bolder shadow d-grid w-100">
                    <div>
                        <h1 class="mb-4 font-weight-bolder">Premium <br> 4$</h1>
                        <p>10 propuestas de empresas - trimestral</p>
                        <p>20 envios de Curriculo - trimestral</p>
                        <p>Chat con empresas</p>
                        <p>Validacion de cuenta</p>
                    </div>
                    <div class="align-self-end">
                        <button type="button" class="btn btn-light btn-block">Comprar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6  mb-3 px-md-4 px-2 text-center text-white d-flex">
                <div class="p-3 plan-2 rounded font-weight-bolder shadow d-grid w-100">
                    <div>
                        <h1 class="mb-4 font-weight-bolder">Pro <br> 7$</h1>
                        <p>30 propuestas de empresas - trimestral</p>
                        <p>40 envios de Curriculo - trimestral</p>
                        <p>Chat con empresas</p>
                        <p>Validacion de cuenta</p>
                        <p>Contraciones siendo novato</p>
                    </div>
                    <div class="align-self-end">
                        <button type="button" class="btn btn-light btn-block">Comprar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6  mb-3 px-md-4 px-2 text-center text-white d-flex">
                <div class="p-3 plan-3 rounded font-weight-bolder shadow d-grid w-100">
                    <div>
                        <h1 class="mb-4 font-weight-bolder">Pro-max <br> 15$</h1>
                        <p>80 propuestas de empresas - trimestral</p>
                        <p>100 envios de Curriculo - trimestral</p>
                        <p>Chat con empresas</p>
                        <p>Validacion de cuenta</p>
                        <p>Contraciones siendo novato</p>
                        <p>Pagina web</p>
                    </div>
                    <div class="align-self-end">
                        <button type="button" class="btn btn-light btn-block">Comprar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6  mb-3 px-md-4 px-2 text-center text-white d-flex">
                <div class="p-3 plan-4 rounded font-weight-bolder shadow w-100">
                    <div>
                        <h1 class="mb-4 font-weight-bolder">Golden <br> 19$</h1>
                        <p>80 propuestas de empresas - trimestral</p>
                        <p>100 envios de Curriculo - trimestral</p>
                        <p>Chat con empresas</p>
                        <p>Validacion de cuenta</p>
                        <p>Contraciones siendo novato</p>
                        <p>Pagina web</p>
                        <p>Roulex patrocina tu empresa</p>
                        <p>Roulex te envia propuestas</p>
                    </div>
                    <div class="align-self-end">
                        <button type="button" class="btn btn-light btn-block">Comprar</button>
                    </div>
                </div>
            </div>
        </div>-->
         <br>
        <br>
        <div class="row m-0 row-padding pt-3 pb-7">
            <div class="col-12 text-center mb-3">
                <h2 class="font-weight-bolder text-dark">Categorias Populares</h2>
            </div>
            <div class="d-flex justify-content-center col-md-2 col-4 col-sm-3" v-for="vacante in vacantes">
               <div class="circle-categorye" style="background: url(img/carousel-1.jpg);">
                   <div class="bg-black-50 w-100 h-100 d-flex justify-content-center
                   align-items-center">
                        <div>
                            <div class="text-center text-white">{{vacante.categoria}}</div>
                            <div class="text-white text-small">{{vacante.cantidad}} vacantes</div>
                        </div>
                   </div>
               </div>
            </div>
            <div class="d-flex justify-content-center col-12 mt-5">
                <button type="button" class="btn btn-danger btn-sm col-2">Ver más</button>
            </div>
        </div>
        <div class="fletch">
            <div class="px-4 py-3 bg-primary rounded-circle text-white">
                <div>
                    <i class="fa fa-arrow-down  animation_deslice" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="row m-0 py-5 row-padding bg-light">
            <div class="col-md-4 col-sm-4 px-lg-4 px-md-4 pb-5 pt-md-5 mb-md-3" v-for="ll in info">
                <div class="rounded bg-white shadow mx-3-edit">
                    <div class="px-0 position-relative">
                        <img :src="'img/'+ll.img" class="w-100 rounded-top" alt="">
                    </div>
                    <div class="p-3 py-2">
                        <div class="text-small text-primary">Paso. {{ll.info}}</div>
                        <h5 class="font-weight-bolder text-dark">{{ll.titulo}}</h5>
                        <div class="font-weight-light py-2 text-muted">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                            Quam nulla, voluptas eligendi aperiam odio.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-relative bg-img-miles w-100 mb-3">
            <div class="row m-0 py-5 row-padding w-100 bg-roulex">
                <div class="col-sm-4 row m-0 my-md-4">
                    <div class="d-flex justify-content-center align-items-center col-3 pt-3">
                        <i class="fa fa-users text-white h2" aria-hidden="true"></i>
                    </div>
                    <div class="col-9">
                        <h5 class="font-weight-bold text-white">
                            60,000
                        </h5>
                        <h6 class="font-weight-bold text-white">
                            Trabajadores Activos
                        </h6>
                    </div>
                </div>
                <div class="col-sm-4 row m-0 my-md-4">
                    <div class="d-flex justify-content-center col-3 pt-3">
                        <i class="fa fa-hospital-o text-white h2" aria-hidden="true"></i>
                    </div>
                    <div class="col-9">
                        <h5 class="font-weight-bold text-white">
                            4,000
                        </h5>
                        <h6 class="font-weight-bold text-white">
                            Empresas en producción
                        </h6>
                    </div>
                </div>
                <div class="col-sm-4 row m-0 my-md-4">
                    <div class="d-flex justify-content-center col-3 pt-3">
                        <i class="fas fa-project-diagram text-white h2"></i>
                    </div>
                    <div class="col-9">
                        <h5 class="font-weight-bold text-white">
                            5,000
                        </h5>
                        <h6 class="font-weight-bold text-white">
                            Proyectos Realizados
                        </h6>
                    </div>
                </div>
            </div>
        </div>
       <div class="row m-0 mb-5 mt-5 px-2">
            <div class="col-12 p-0 text-dark py-5 px-5">
                <div class="row m-0 row-padding">
                    <div class="col-md-6 col-sm-12 d-flex ">
                        <div clas="position-relative w-100 d-flex" style="min-height:12rem">
                            <div class="img-empresa img-top">
                            </div>
                            <div  class="img-empresa img-bottom">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 d-flex align-items-center pl-5">
                        <div style="text-align:initial !important" class="py-5 my-3">
                            <div class="text-small text-primary">Tu Empresa</div>
                            <h2 class="font-weight-bolder">¿Como puedes crear tu empresa?</h2>
                            <div class="font-weight-light text-muted">
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque laboriosam cumque eveniet repudiandae
                                quam nulla, voluptas deleniti impedit eligendi aperiam odio! Doloremque dolores, veritatis iust
                            </div>
                            <br>
                            <div class="font-weight-light text-muted">
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque laboriosam cumque eveniet repudiandae
                                nulla delectus itaque quisquam repellat.
                            </div>
                            <div class="mt-3 font-weight-light">
                                <button type="button" class="btn btn-sm col-5 btn-danger">Empezar</button>
                                <br>
                                <br>
                                <i class="fa fa-facebook mr-2" aria-hidden="true"></i>
                                <i class="fa fa-twitter mr-2" aria-hidden="true"></i>
                                <i class="fa fa-instagram mr-2" aria-hidden="true"></i>
                                <i class="fa fa-dribbble mr-2" aria-hidden="true"></i>
                                <i class="fa fa-pinterest mr-2" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-fort">
            <div class="row m-0 p-5 shadow-lg row-padding bg-roulex">
                <div class="col-md-4 col-sm-12 my-4" v-for="users in trabajadores">
                    <div class="bg-light rounded p-3">
                        <div>
                            <div class="d-inline-block">
                                <img src="img/Penguins.jpg" class="img-fluid rounded-circle d-inline-block img-user-fort">
                            </div>
                            <div class="d-inline-block">
                                <h5 class="d-inline-block">
                                    {{users.name}}
                                    <br>
                                    <span class="text-primary text-small">{{users.type}}</span>
                                </h5>
                            </div>
                        </div>
                        <div>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsnobi ipsum
                            est reiciendis dolorem minus quasi in rem vel quibusdacorporis  distinctio
                        </div>
                        <div class="text-warning">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h2 class="font-weight-bolder text-center text-light">
                        Usuarios top trabajadores
                    </h2>
                </div>
            </div>
        </div>
        <div class="pt-5">
            <div class="d-flex justify-content-center row-padding my-5">
                <div class="px-5 mx-5 py-5 text-center bg-light shadow-sm text-dark">
                    <h3 class="font-weight-bolder">WE ARE STUDYLAB AN ONLINE LEARNING CENTER</h3>
                    <h6>We can manage your dream building A small river named Duden flows by their place. We can manage your dream building A small river named Duden</h6>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="button" class="btn btn-primary">Empieza Ahora</button>
                    </div>
                </div>
            </div>
            <div class="row m-0 py-5 row-padding">
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <div>
                        <h2 class="font-weight-bolder">Bienvenido a <span class="text-danger">Roulex</span></h2>
                        <h4 class="font-weight-bolder">We can manage your dream building A</h4>
                        <div class="text-primary text-small">
                            Acerca de Empleados
                        </div>
                       <p class="font-weight-light text-muted mt-3">We can manage your dream building A small
                        river named Duden flows by their place. We can manage your dream building A small 
                        river named Duden. We can manage your.
                        </p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-light py-2 px-4 shadow-sm">Ver más</button>
                        </div>
                    </div>
                </div>
                <div class="col-6 row m-0 lh-md text-dark">
                    <div class="col-6">
                        <div class="bg-light mb-3 rounded p-3">
                            <img src="img/service_1.svg" class="img-fluid d-block mb-2" alt="">
                            We can manage your dream building A small river named Duden flows.
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light mb-3 rounded p-3">
                            <img src="img/service_2.svg" class="img-fluid d-block mb-2" alt="">
                            We can manage your dream building A small river named Duden flows.
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light mb-3 rounded p-3">
                            <img src="img/service_3.svg" class="img-fluid d-block mb-2" alt="">
                            We can manage your dream building A small river named Duden flows.
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light mb-3 rounded p-3">
                            <img src="img/service_4.svg" class="img-fluid d-block mb-2" alt="">
                            We can manage your dream building A small river named Duden flows. 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 row rounded row-padding">
                <div class="col-12 pt-5 pl-5">
                    <h4 class="font-weight-bold text-dark">
                        <span class="text-danger">Proyectos</span> Roulex
                    </h4>
                </div>
            </div>
            <div class="row m-0 text-dark mt-3">
                <div class="col-md-6 col-sm-6 col-12 row m-0 p-0">
                    <div class="col-12 p-0 position-relative item-jobs">
                        <div class="position-absolute w-100 h-100 bg-black-70 d-flex justify-content-center align-items-center text-white information-jobs">
                            <div class="container-info">
                                <div class="text-danger-marron">Constructora. Bloquets</div>
                                <h4 class="font-weight-bold"> 
                                    <span class="border-bottom border-light pb-2">Edificio "The Engines"</span>
                                </h4>
                                <div class="text-small">
                                    <span class="mr-4">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        400.
                                    </span>
                                    <span class="mr-3">
                                        <i class="fas fa-dollar-sign    "></i>
                                        20.000,00
                                    </span>
                                    <span>
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        200.
                                    </span>
                                    <br>
                                    <span class="text-small">
                                        Lorem ipsum dolor, sit amet consectetur elit.
                                    </span>
                                </div>
                            </div>
                        </div>
                        <img src="img/carousel-2.jpg" class="w-100" alt="" style="height:31.5vh;">
                    </div>
                    <div class="col-6 p-0 position-relative item-jobs">
                        <div class="position-absolute w-100 h-100 bg-black-70 d-flex justify-content-center align-items-center text-white information-jobs">
                            <div class="container-info">
                                <div class="text-danger-marron">Constructora. Bloquets</div>
                                <h4 class="font-weight-bold"> 
                                    <span class="border-bottom border-light pb-2">Edificio "The Engines"</span>
                                </h4>
                                <div class="text-small">
                                    <span class="mr-4">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        400.
                                    </span>
                                    <span class="mr-3">
                                        <i class="fas fa-dollar-sign    "></i>
                                        20.000,00
                                    </span>
                                    <span>
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        200.
                                    </span>
                                    <br>
                                    <span class="text-small">
                                        Lorem ipsum dolor, sit amet consectetur elit.
                                    </span>
                                </div>
                            </div>
                        </div>
                        <img src="img/service-4.jpg" class="w-100" alt="" style="height:31.5vh;">
                    </div>
                    <div class="col-6 p-0 position-relative item-jobs">
                        <div class="position-absolute w-100 h-100 bg-black-70 d-flex justify-content-center align-items-center text-white information-jobs">
                            <div class="container-info">
                                <div class="text-danger-marron">Constructora. Bloquets</div>
                                <h4 class="font-weight-bold"> 
                                    <span class="border-bottom border-light pb-2">Edificio "The Engines"</span>
                                </h4>
                                <div class="text-small">
                                    <span class="mr-4">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        400.
                                    </span>
                                    <span class="mr-3">
                                        <i class="fas fa-dollar-sign    "></i>
                                        20.000,00
                                    </span>
                                    <span>
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        200.
                                    </span>
                                    <br>
                                    <span class="text-small">
                                        Lorem ipsum dolor, sit amet consectetur elit.
                                    </span>
                                </div>
                            </div>
                        </div>
                        <img src="img/galery7.PNG" class="w-100" alt="" style="height:31.5vh;">
                    </div>
                </div>
                <div class="col-6 p-0 position-relative item-jobs">
                    <div class="position-absolute w-100 h-100 bg-black-70 d-flex justify-content-center align-items-center text-white information-jobs">
                        <div class="container-info">
                            <div class="text-danger-marron">Constructora. Bloquets</div>
                            <h4 class="font-weight-bold"> 
                                <span class="border-bottom border-light pb-2">Edificio "The Engines"</span>
                            </h4>
                            <div class="text-small">
                                <span class="mr-4">
                                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                                    400.
                                </span>
                                <span class="mr-3">
                                    <i class="fas fa-dollar-sign    "></i>
                                    20.000,00
                                </span>
                                <span>
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                    200.
                                </span>
                                <br>
                                <span class="text-small">
                                    Lorem ipsum dolor, sit amet consectetur elit.
                                </span>
                            </div>
                        </div>
                    </div>
                    <img src="img/carousel-1.jpg" class="w-100 img-h" alt="">
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row m-0 py-5 mt-4 row-padding bg-light">
                <div class="col-12 text-center pb-3">
                    <h6 class="font-weight-bolder text-danger">Redes Sociales</h6>
                    <h3 class="font-weight-bolder">Opiniones Recientes</h3>
                </div>
                <div class="col-md-3 col-sm-6 pb-5" v-for="count in contt">
                    <div class="rounded text-dark p-4 bg-white">
                        <div class="text-primary text-small">
                            May. 22, 2021. <span>johndoe13</span>
                        </div>
                        <div class="p-1">
                            <span class="text-info">@Roulex</span> Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque     laboriosam cumque eveniet repudiandae
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary shadow">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                Twitter
                            </button>
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
        let barr = document.getElementById('nav_bar');
        // barr.classList.remove('fixed-top');
        // barr.classList.add('sticky-top');
        barr.classList.remove('bg-home-options-login');
        // barr.classList.add('bg-oran');
        let foo = document.getElementById('footer');
        foo.classList.remove('d-none');
    },
    data(){
        return {
            contador: [1,2,3,4,5,6],
            contt: [1,2,3,4],
            users_count: [1,2,3,4,5,6,7,8,9],
            images: ['service-1.jpg','service-2.jpg','service-3.jpg','service-4.jpg','service-5.jpg',
            'service-6.jpg'],
            trabajadores: [{'name':'John Doe','type':'Ing en Sistemas'},{'name':'Marck Hoe','type':'Veterinario'},{'name':'Maria Paz','type':'Costurera'}],
            info: [
                {info: 1,titulo: 'Registrate',img:'repartidor.PNG'},
                {info: 2,titulo: 'Recibe y acepta',img:'galery7.PNG'},
                {info: 3,titulo: 'Pagos',img:'asoc.PNG'},
            ],
            vacantes: [
                {info: 1,categoria: 'Tecnologia',cantidad:80},
                {info: 2,categoria: 'Artes',cantidad:60},
                {info: 3,categoria: 'Construcción',cantidad:50},
                {info: 4,categoria: 'Medicina',cantidad:70},
                {info: 5,categoria: 'Agricultura',cantidad:90},
                {info: 6,categoria: 'Educación',cantidad:30},
            ],
        }
    }
}
</script>
