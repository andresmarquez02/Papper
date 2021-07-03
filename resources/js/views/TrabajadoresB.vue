<template>
    <div>
    <div class="d-flex justify-content-center mt-5">
        <div class="form-group d-flex w-50">
            <input type="text" name=""  class="form-control rounded-pill mr-4" placeholder="Buscar Trabajador" aria-describedby="helpId">
            <button class="btn btn-orang rounded-pill">Buscar</button>
        </div>
    </div>
    <div class="d-flex px-2">
        <div class="form-inline mr-3">
            <select name="" class="form-control rounded-pill" >
                <option value="">Categorias</option>
                <option value="">Administradores</option>
                <option value="">Conductor</option>
                <option value="">Maestros de Obras</option>
                <option value="">Delivery</option>
                <option value="">Musico</option>
                <option value="">Programador</option>
                <option value="">Costurera(o)</option>
                <option value="">Inormatico</option>
            </select>
        </div>
        <div class="form-inline mr-3">
            <select name="" class="form-control rounded-pill" >
                <option value="">Experiencia</option>
                <option value="">Novato</option>
                <option value="">2 Años</option>
                <option value="">4 años</option>
                <option value="">5 años</option>
                <option value="">más experiencia</option>
            </select>
        </div>
        <div class="form-inline">
            <select name="" class="form-control rounded-pill" >
                <option value="">Edad</option>
                <option value="">18-25</option>
                <option value="">25-35</option>
                <option value="">35-40</option>
                <option value="">40-50</option>
                <option value="">51 o mas</option>
            </select>
        </div>
    </div>
    <div class="row m-0 row-padding">
        <div class="col-4 my-4 text-white" v-for="i in contador">
            <div class="user-fort rounded p-3">
                <div>
                    <img src="img/Penguins.jpg" class="img-fluid rounded-circle d-inline-block img-user-fort">
                    <div class="d-inline-block">
                        <h5>
                            Marcos Barrientos
                            <br>
                            <span class="text-light h6">Ing en Sistemas</span>
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
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-lg justify-content-center my-4">
          <li class="page-item disabled">
            <a class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Previous</span>
            </a>
          </li>
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">4</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
              <span class="sr-only">Next</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</template>
<script>
export default {
    mounted() {
        let barr = document.getElementById('nav_bar');
        barr.classList.remove('fixed-top');
        barr.classList.add('sticky-top');
        barr.classList.remove('bg-home-options-login');
        barr.classList.add('bg-oran');
        let foo = document.getElementById('footer');
        foo.classList.remove('d-none');
    },
    data() {
        return {
            contador: [1,2,3,4,5,6,7,8,9,10,11,12]
        }
    },
}
</script>
