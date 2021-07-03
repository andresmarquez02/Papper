<template>
    <div>
        <div class="row m-0" style="min-height:100vh">
            <div class="col-md-6 col-sm-12 px-0 d-sm-none-block">
                <div class="bg-home position-relative pt-5-sm-7 w-100 vh-100-h">
                </div>
                <div class="d-flex justify-content-center align-items-center position-absolute w-100 h-100"
                style="top:0;left:0">
                    <h1 class="display-5 font-weight-bold text-center text-white">
                        <span class="display-3 font-weight-bolder">Login</span>
                        <br>
                        <span class="display-4 font-weight-bold">Que tengas <br> un dia muy <br> productivo</span>
                    </h1>
                </div>
                <div class="d-flex justify-content-end align-items-end  position-absolute w-100 pr-5"
                 style="bottom:0;">
                    <i class="fa fa-facebook text-primary h2 mr-4" aria-hidden="true"></i>
                    <i class="fa fa-twitter text-info h2 mr-4" aria-hidden="true"></i>
                    <i class="fa fa-whatsapp text-success h2" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 px-0">
                <div class="bg-home position-relative pt-5-sm-7 w-100 vh-100-h pt-5 pb-2 rounded-bottom">
                </div>
                <div class="d-flex justify-content-center align-items-center position-absolute w-100 h-100"
                style="top:0;left:0">
                    <div class="w-75 text-white rounded p-4 shadow-lg bg-form animate__animated s3 animate__zoomIn">
                        <h1 class="text-center font-weight-bolder">Login</h1>
                        <div class="form-group">
                            <label for="">Usuario</label>
                            <input type="text" class="form-control form">
                        </div>
                        <div class="form-group">
                            <label for="">Contraseña</label>
                            <input type="text" class="form-control form">
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="button" class="btn btn-light rounded-pill shadow">Ingresar
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
        barr.classList.add('fixed-top');
        barr.classList.remove('sticky-top');
        // barr.classList.add('bg-home-options-login');
        barr.classList.remove('bg-oran');
        let foo = document.getElementById('footer');
        foo.classList.add('d-none');
    },
}
</script>
