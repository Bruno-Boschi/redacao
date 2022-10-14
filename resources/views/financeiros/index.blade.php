@extends('layout.app')
@section('title', 'Solicitação Pagamento')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Solicitação Pagamento</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/financeiros">Solicitação Pagamento</a></li>
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
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Regras de Pagamento</h4>
                        <p>{{$configuracoes->regras_pagamento}}</p>
                    </div>
                	@if(Session::has('mensagem'))
                	<div class="alert alert-success" role="alert" id="mensagem_sucesso">
                        {{Session::get('mensagem')}}
                    </div>
                    @endif
                	@if(Session::has('erro'))
                	<div class="alert alert-danger" role="alert">
                        {{Session::get('erro')}}
                    </div>
                    @endif
                    <div class="table-responsive">
						<form id="dados_cadastro" action="/financeiros/salvar" method="get">
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="{{$configuracoes->id}}">
                            <div class="tab-content ">		
                                <!-- style="display: none" --> 
                                <div class="tab-pane active" id="dados" data-role="tabpanel">						
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label> Nome: </label>
                                            <h5 class="card-title">{{Auth::user()->name}}</h5> 
                                        </div>
                                        <div class="col-lg-6">
                                            <label> Valor Total: </label>
                                            <h5 class="card-title">{{number_format($valorTotalReceber,2,",",".")}}</h5> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label> CPF: </label>
                                            <h5 class="card-title">{{Auth::user()->cpf}}</h5> 
                                        </div>
                                        <div class="col-lg-6">
                                            <label> Valor do Saque: </label>
                                            <input required name="valor_saque" type="text" class="form-control decimal-inputmask" id="valor_saque" value=""> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label> Chave PIX: </label>
                                            <h5 class="card-title">{{Auth::user()->chave_pix}}</h5> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                        					<a class="btn btn-primary my-4" href="/usuarios/create-edit/{{Auth::user()->tipo_usuario}}/{{Auth::user()->id}}">
                                            	Editar Dados
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                            					<input type="submit" class="btn btn-primary my-4" value="Salvar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scrpts')
	<script src="{{URL('/assets/painel/extra-libs/mask-money/')}}/jquery.maskMoney.js"></script>
    <script type="text/javascript">$(".decimal-inputmask").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});</script>
@stop