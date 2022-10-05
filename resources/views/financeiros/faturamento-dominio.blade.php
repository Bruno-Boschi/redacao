@extends('layout.app')
@section('title', 'Faturamento Domínio')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Faturamento Domínio</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/financeiros/faturamento-dominio">Faturamento Domínio</a></li>
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
            	<form id="dados_cadastro" action="/financeiros/faturamento-dominio" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-4">
                            <label>Dominio:</label>
                            <select required class="form-control" id="dominio_id" name="dominio_id">
                                <option value=""></option>
                                @foreach ($dominios as $dominio) 
                                	<option value="{{$dominio->id}}" {{($idDominio == $dominio->id) ? 'selected' : ''}}>{{$dominio->dominio}}</option>
                            	@endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label>Data Inicial:</label>
                            <input required type="text" class="form-control date-inputmask" placeholder="Data Inicial" name="data_inicial" value="{{'01'.date('/m/Y')}}">
                        </div>
                        <div class="col-4">
                            <label>Data Final:</label>
                            <input required type="text" class="form-control date-inputmask" placeholder="Data Final" name="data_final"value="{{date('d/m/Y')}}">
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary my-4" value="Buscar">
                </form>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>ID Post</th>
                                    <th style="text-align: center;">Impressões</th>
                                    <th style="text-align: center;">Cliques</th>
                                    <th style="text-align: center;">Data Faturamento</th>
									<th style="text-align: right;">CPM</th>
                                    <th style="text-align: right;">Valor Pagamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dados as $dado) 
									<?php 
									$resultado = 0;
									if ($dado->valor_impressao > 0) {
										$valorImpressao = $dado->impressoes / 1000;
										$resultado = $valorImpressao / $dado->valor_impressao;
									}
									?>
                                	<tr>
                                        <th scope="row"><a href="{{$dado->dominio.'?p='.$dado->id_wordpress}}" target="_blank">{{$dado->id_wordpress}}</a></th>
                                        <td style="text-align: center;">{{$dado->impressoes}}</td>
                                        <td style="text-align: center;">{{$dado->cliques}}</td>
                                        <td style="text-align: center;">{{$dado->data_busca}}</td>
										<td style="text-align: center;">{{number_format($resultado,2,",",".")}}</td>
                                        <td style="text-align: right;">{{number_format($dado->valor_impressao,2,",",".")}}</td>
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
	<script src="{{URL('/assets/bibliotecas/inputmask/dist/min/')}}/jquery.inputmask.bundle.min.js"></script>
	<script src="{{URL('/assets/js/')}}/masks.js"></script>
@stop