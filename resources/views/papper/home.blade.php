@extends('layout.app')
@section('content')
    <div id="app">
        <papper-home />
    </div>
@endsection
@section('script')
    <script>
        let pre = document.getElementById('carga')
        document.addEventListener('Load', function(){
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
        });
        pre.classList.remove('d-flex');
        pre.classList.add('d-none');
    </script>
@endsection
