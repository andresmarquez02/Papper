@extends('layout.app')
@section('content')
<body class="bg-white">
    <div id="app">
        <papper-home />
    </div>
    <div id="carga" class="modal-backdrop d-none bg-black-30 justify-content-center align-items-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
    </div>
    <script src="{{asset('alertify/lib/alertify.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        let pre = document.getElementById('carga')
        document.addEventListener('Load', function(){
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
        });
        pre.classList.remove('d-flex');
        pre.classList.add('d-none');
    </script>
</body>
@endsection
