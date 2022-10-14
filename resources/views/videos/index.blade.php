@extends('layout.app')
@section('title', 'Vídeos')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Vídeos</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/videos">Vídeos</a></li>
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
                        <div class="btn-group mt-2" role="group">
                            <a href="#dialog1" onclick="abrirModal(0)" title="Cadastrar Vídeo" name="modal" class="btn btn-success text-white">Cadastrar</a>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
                <br>
                <div class="row">
                	<div class="alert alert-success" role="alert" id="mensagem_sucesso" style="display: none;">
                        Vídeos cadastrado com sucesso.
                    </div>

                	<div class="alert alert-success" role="alert" id="mensagem_sucesso_alterado" style="display: none;">
                        Vídeos Alterado com sucesso.
                    </div>
                    
                    @if(Session::has('mensagem'))
                	<div class="alert alert-success" role="alert" id="mensagem_sucesso">
                        {{Session::get('mensagem')}}
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Título</th>
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

<div id="boxes">
    <div id="dialog1" class="window" style="height: 370px;">
        <div class="d-header">
            <h4 class="page-title">Cadastro de Vídeo</h4>
        </div>
        <div class="card">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 dados_titulo">
                        <small class="text-muted">Título:</small>
                        <input required name="titulo" type="text" class="form-control" id="titulo" value="">
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-12 dados_video">
                        <small class="text-muted">Vídeo:</small>
                        <textarea name="video" id="video" class="textarea_editor form-control" rows="3"></textarea>
                    </div>  
                </div>
            </div>  
        </div>
        <div class="d-header">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary close">Fechar</button>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" id="id_video" value="">
                            <button type="button" class="btn btn-info" id="salvar_dados">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="mask"></div>

</div>
<link href="{{URL('/assets/painel/')}}/css/modal.css" rel="stylesheet">
@stop
@section('scrpts')
    <script src="{{URL('/assets/painel/')}}/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="{{URL('/assets/painel/')}}/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="{{URL('/assets/painel/')}}/extra-libs/DataTables/datatables.min.js"></script>
    <script src="{{URL('/assets/painel/js/videos/')}}/index.js"></script>
@stop