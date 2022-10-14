@extends('layout.app')
@section('title', 'Domínios')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Domínios</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dominios">Domínios</a></li>
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
                            <a href="#dialog1" onclick="abrirModal(0)" title="Cadastrar Domínio" name="modal" class="btn btn-success text-white">Cadastrar</a>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
                <br>
                <div class="row">
                	<div class="alert alert-success" role="alert" id="mensagem_sucesso" style="display: none;">
                        Domínio cadastrado com sucesso.
                    </div>

                	<div class="alert alert-success" role="alert" id="mensagem_sucesso_alterado" style="display: none;">
                        Domínio Alterado com sucesso.
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
                                    <th>Domínio</th>
                                    <th>Usuário</th>
                                    <th>Senha</th>
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
    <div id="dialog1" class="window" style="height: 400px;">
        <div class="d-header">
            <h4 class="page-title">Cadastro de Domínio</h4>
        </div>
        <div class="card">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 dados_dominio">
                        <small class="text-muted">Domínio:</small>
                        <input required name="dominio" type="text" class="form-control" id="dominio" value="">
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-12 dados_usuario">
                        <small class="text-muted">Usuario:</small>
                        <input required name="usuario_dominio" type="text" class="form-control" id="usuario_dominio" value="">
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-12 dados_senha">
                        <small class="text-muted">Senha:</small>
                        <input required name="senha_dominio" type="text" class="form-control" id="senha_dominio" value="">
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
                            <input type="hidden" id="id_dominio" value="">
                            <button type="button" class="btn btn-info" id="salvar_dados">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="mask"></div>
</div>
<div id="boxes">
    <div id="dialog2" class="window" style="height: 270px;width: 520px;">
        <div class="d-header">
            <h4 class="page-title">Importar dados</h4>
        </div>
        <div class="card">
            <div class="modal-body">
                <h4 class="card-title inicializacao_importacao" style="display:none;">Começando a importação</h4>
                <div class="mt-3 inicializacao_importacao" style="display:none;">
                    <div class="d-flex no-block align-items-center">
                        <span id="descricao_dados">81% Clicks</span>
                        <div class="ms-auto">
                            <span id="tipo_importacao">125</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" id="progressao_dados"
                            style="width: 81%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="d-header">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                        	<input type="hidden" id="id_dominio_sincronismo" value="">
                            <button type="button" class="btn btn-secondary close" id="btn_fechar_sincronismo">Fechar</button>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" id="id_dominio" value="">
                            <button type="button" class="btn btn-info" id="importar_dados">Importar Dados</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="mask_2"></div>
</div>
<link href="{{URL('/assets/painel/')}}/css/modal.css" rel="stylesheet">
@stop
@section('scrpts')
    <script src="{{URL('/assets/painel/')}}/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="{{URL('/assets/painel/')}}/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="{{URL('/assets/painel/')}}/extra-libs/DataTables/datatables.min.js"></script>
    <script src="{{URL('/assets/painel/js/dominios/')}}/index.js"></script>
@stop