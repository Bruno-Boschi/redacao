@extends('layout.app')
@section('title', 'Publishers')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Publishers</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/usuarios/publishers">Publishers</a></li>
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
                        @if (Session::has('mensagem'))
                            <div class="alert alert-success" role="alert" id="mensagem_sucesso">
                                {{ Session::get('mensagem') }}
                            </div>
                        @endif
                        @if (Session::has('erro'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('erro') }}
                            </div>
                        @endif
                        <div class="col-md-10">
                            <div class="btn-group mt-2" role="group">
                                <a href="/usuarios/create-edit/P" class="btn btn-success text-white">Cadastrar</a>
                            </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Celular</th>
                                        <th>Data Nascimento</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scrpts')
    <script src="{{ URL('/assets/painel/') }}/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/DataTables/datatables.min.js"></script>
    <script src="{{ URL('/assets/painel/js/usuarios/') }}/publishers.js"></script>
@stop
