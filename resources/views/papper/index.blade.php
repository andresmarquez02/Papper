@extends('layout.app')
@section('content')
<body class="bg-white" onload="atras()">
    <div id="app">
        <papper />
    </div>
    <div id="carga" class="modal-backdrop d-none bg-black-30 justify-content-center align-items-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
    </div>
    {{-- <h6 class="dropdown-item cursor-pointer" v-on:click="modal_cambiar(comentario.comentario,comentario.id)"
                             data-toggle="modal" data-target="#modelEditarc">Editar</h6>
                             <div class="modal" id="modelEditarc" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tu comentario</h5>
                                            <button type="button" id="cerrarEditarc" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Comentario</label>
                                                <input type="text" class="form-control" v-on:keyup.Enter="cambiar()" v-model="comentario_editar">
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary"
                                            v-on:click="cambiar()">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
    <script>
        let pre = document.getElementById('carga')
        pre.classList.remove('d-none');
        pre.classList.add('d-flex');
        function atras(){
            window.location.hash="not-hash-back";
            window.location.hash="not-hash-again-back"
            window.onhashchange=function(){window.location.hash="no-back-button";}
            pre.classList.remove('d-flex');
            pre.classList.add('d-none');
        }
    </script>
    <script src="{{asset('alertify/lib/alertify.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
</body>
@endsection
