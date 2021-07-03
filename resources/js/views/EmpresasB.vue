<template>
    <div class="pt-5">
    <div class="d-flex justify-content-center">
        <div class="form-group d-flex w-50">
          <input type="text" name=""  class="form-control rounded-pill mr-4" placeholder="Buscar Empresa" aria-describedby="helpId">
          <button class="btn btn-orang rounded-pill">Buscar</button>
        </div>
    </div>
    <div class="d-flex px-2">
        <div class="form-inline mr-3">
            <select name="" class="form-control rounded-pill" >
                <option value="">Categorias</option>
                <option value="">Administrativas</option>
                <option value="">Automovilismo</option>
                <option value="">Contructoras</option>
                <option value="">Delivery</option>
                <option value="">Musical</option>
                <option value="">Programación</option>
                <option value="">Textiles</option>
                <option value="">Tecnologia</option>
            </select>
        </div>
        <div class="form-inline mr-3">
            <select name="" class="form-control rounded-pill" >
                <option value="">Tipo Empresas</option>
                <option value="">Mas Recientes</option>
                <option value="">En Crecimiento</option>
                <option value="">Medianas</option>
                <option value="">Grandes</option>
                <option value="">Remotas</option>
            </select>
        </div>
        <div class="form-inline">
            <select name="" class="form-control rounded-pill" >
                <option value="">Vacantes</option>
                <option value="">2</option>
                <option value="">4</option>
                <option value="">8</option>
                <option value="">10</option>
                <option value="">mas</option>
            </select>
        </div>
    </div>
     <div class="row m-0 mt-5 row-padding">
                <div class="col-4 my-3" v-for="i in contador">
                    <div class="bg-white shadow rounded-top">
                        <div class="row">
                            <img src="img/Penguins.jpg" class="img-fluid col-6">
                            <div class="col-6">
                                PencilNote
                                <br>
                                tipo: Electronica
                                <br>
                                bacantes: 5
                                <br>
                                <a href="#">Postularme</a>
                                <br>
                                <div class="text-warning">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="social-empress rounded-bottom text-white text-center">
                        <i class="fa fa-facebook mr-2" aria-hidden="true"></i>
                        <i class="fa fa-instagram mr-2" aria-hidden="true"></i>
                        <i class="fa fa-linkedin mr-2" aria-hidden="true"></i>
                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
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
    data(){
        return {
            contador: [1,2,3,4,
                        5,6,7,8,
                        9,10,11,12],
            color: '',
            text: '',
        }
    },
    methods: {
        clases(value){
            if(value == 1 || value == 6 || value == 11){
                this.color = 'bg-light';
                this.text = 'text-dark';
            }
            else if(value == 2 || value == 7 || value == 12){
                this.color = 'bg-dark';
                this.text = 'text-white';


            }
            else if(value == 3 || value == 8 || value == 9){
                this.color = 'bg-info-50';
                this.text = 'text-white';


            }
            else{
                this.color = 'bg-danger-50';
                this.text = 'text-white';
            }
        }
    },
}
</script>
