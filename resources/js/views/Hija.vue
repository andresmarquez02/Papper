<template>
    <div>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-dark">
                    <h5 class="modal-title">Detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body text-dark">
                    <div class="row h6">
                        <div class="col-md-6 my-1">
                            <div class="h5 font-weight-bold">Nombre y Apellido</div>
                            {{ $store.state.vermas.nombre}} {{ $store.state.vermas.apellido}}

                        </div>
                        <div class="col-md-6 my-1">
                            <div class="h5 font-weight-bold">Correo</div>
                            {{ $store.state.vermas.email}}
                        </div>
                        <div class="col-md-6 my-1">
                            <div class="h5 font-weight-bold">Cargo</div>
                             {{ $store.state.vermas.cargo}}
                        </div>
                        <div class="col-md-6 my-1">
                            <div class="h5 font-weight-bold">Telefono</div>
                             {{ $store.state.vermas.telefono}}
                        </div>
                        <div class="col-md-6 my-1">
                            <div class="h5 font-weight-bold">País y Región</div>
                             {{ $store.state.vermas.pais}},
                             {{ $store.state.vermas.region}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark rounded-pill" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>
