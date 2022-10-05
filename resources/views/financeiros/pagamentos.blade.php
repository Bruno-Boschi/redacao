@extends('layout.app')
@section('title', 'Solicitações Pagamentos')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Solicitações Pagamentos</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/materias/lista-solicitacoes-pagamento">Solicitações Pagamentos</a></li>
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
                   	<div class="alert alert-success" role="alert" id="mensagem_sucesso" style="display: none;">
                        Confirmação Salva com sucesso.
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Solicitante</th>
                                    <th>Valor Solicitado</th>
                                    <th>Data Solicitação</th>
                                    <th>Data Pagamento</th>
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
    <div id="dialog1" class="window" style="height: 410px;">
        <div class="d-header">
            <h4 class="page-title">Confirmação do Pagamento</h4>
        </div>
        <div class="card">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">Nome Solicitante:</small><br>
                        <input id="nome_solicitante" type="text" value="" readonly="readonly">
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Chave PIX Solicitante:</small><br>
                        <input id="chave_pix" type="text" value="" readonly="readonly">
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">Valor Solicitado:</small><br>
                        <input id="valor_pagamento" type="text" value="" readonly="readonly">
                    </div>  
                    <div class="col-md-6">
                        <small class="text-muted">Status Pagamento:</small>
                        <select required class="form-control" id="status_pagamento" name="status_pagamento">
                            <option value="1" >Pago</option>
                            <option value="2" >Problema no Pagamento</option>
                        </select>
                    </div>  
                </div>
                <div class="row descricao_reprovacao" style="display:none;">
                    <div class="col-md-12">
                        <small class="text-muted">Descrição:</small>
                        <textarea name="descricao" id="descricao" class="textarea_editor form-control" rows="3"></textarea>
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
                            <input type="hidden" id="id_solicitacao" value="">
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
    <script src="{{URL('/assets/painel/js/financeiros/')}}/pagamentos.js"></script>
@stop