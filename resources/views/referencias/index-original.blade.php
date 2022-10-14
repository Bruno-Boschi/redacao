@extends('layout.app')
@section('title', 'Referencia')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Referencia</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/referencia">Referencia</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="btn-group mt-2 mb-2" role="group">
                                <a href="/referencias-materias/create-edit"
                                    class="btn btn-success  text-white">Cadastrar</a>
                            </div>
                        </div>
                        @if (Session::has('mensagem'))
                            <br>
                            <div class="alert alert-success" role="alert" id="mensagem_sucesso">
                                {{ Session::get('mensagem') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Tema</th>
                                        <th>Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referencias as $referencia)
                                        <tr>
                                            <td> {{ $referencia['titulo'] }}</td>
                                            <td> {{ $referencia['tema_descricao'] }}</td>
                                            <td> {{ $referencia['link'] }}</td>
                                            <td>

                                                <button id="click" class="btn  mdi mdi-delete "
                                                    onclick="openModal({{ $referencia->id }})"></button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
<script>
    function openModal(id) {
        swal("Deletar este pedido de materia?", {
                icon: "warning",
                buttons: ["Sair", "Apagar"]
            })
            .then(async (value) => {
                if (value) {
                    let res = await fetch('/referencias-materias/delete/' + id, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-Token": '{{ csrf_token() }}'
                        },
                        method: 'DELETE'
                    });
                    let data = await res.json();

                    if (data.response) {
                        swal({
                            icon: "success",
                            text: "Pedido feito com sucesso"
                        });
                        location.reload();
                    } else {
                        swal({
                            icon: "error",
                            text: "Ocorreu um erro"
                        });
                    }
                }
            });
    }
</script>
@section('scrpts')
    <script src="{{ URL('/assets/painel/') }}/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/DataTables/datatables.min.js"></script>

    {{-- <script src="{{ URL('/assets/painel/js/referencias/') }}/index.js"></script> --}}
@stop
