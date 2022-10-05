@extends('layout.app')
@section('title', 'Meus Chamados')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Meus Chamados</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/suportes">Meus Chamados</a></li>
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
                    @if(Session::has('mensagem'))
                    <div class="alert alert-success" role="alert" id="mensagem_sucesso">
                        {{Session::get('mensagem')}}
                    </div>
                    @endif
                    @if(Auth::user()->tipo_usuario == 'R')
                    <div class="col-md-10">
                        <div class="btn-group mt-2" role="group">
                            <a href="/suportes/create-edit" class="btn btn-success text-white">Abrir Chamado</a>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Data Abertura</th>
                                    <th>Departamento</th>
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
<script src="{{URL('/assets/painel/')}}/extra-libs/multicheck/datatable-checkbox-init.js"></script>
<script src="{{URL('/assets/painel/')}}/extra-libs/multicheck/jquery.multicheck.js"></script>
<script src="{{URL('/assets/painel/')}}/extra-libs/DataTables/datatables.min.js"></script>
<script src="{{URL('/assets/painel/js/suportes/')}}/index.js"></script>
@stop