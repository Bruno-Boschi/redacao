<?php
use App\Helpers\FormataData;
use App\Models\Suportes\Chamados;
?>
@extends('layout.app')
@section('title', 'Chamado Nº '.$chamado[0]['id'])
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Chamado Nº {{$chamado[0]['id']}}</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/suportes">Suporte</a></li>
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
                	<div class="col-12">
                        <div class="card">
                            <h4 class="card-title">{{$chamado[0]['titulo']}}</h4>
                            <hr>
                            <div class="chat-box scrollable" style="height:475px;">
                                <ul class="chat-list">
                                    <!--chat Row -->
                                    @foreach($detalhamentos as $detalhamento)
                                    	@if($detalhamento['tipo_mensagem'] == 'C')
                                        <li class="chat-item">
                                            <div class="chat-content">
                                                <h6 class="font-medium">{{$chamado[0]['name']}}</h6>
                                                <div class="box bg-light-info"><?php echo $detalhamento['mensagem']; ?></div>
                                            </div>
                                            <div class="chat-time">{{FormataData::dataHoraDbParaBr($detalhamento['created_at'])}}</div>
                                        </li>
                                        @endif
                                        @if($detalhamento['tipo_mensagem'] == 'A')
                                        <li class="odd chat-item">
                                            <div class="chat-content">
                                            	<h6 class="font-medium">{{$atendente->name}}</h6>
                                                <div class="box bg-light-inverse"><?php echo $detalhamento['mensagem']; ?></div>
                                            	<div class="chat-time">{{FormataData::dataHoraDbParaBr($detalhamento['created_at'])}}</div>
                                            </div>
                                        </li>
                                         @endif
                                    @endforeach
                                </ul>
                            </div>
                            <hr>
                            @if($chamado[0]['status'] != Chamados::CODIGO_CHAMADO_FECHADO)
                            <form id="dados_cadastro" action="/suportes/editar" method="post">
    			                {!! csrf_field() !!}
    			                <input type="hidden" name="id" value="{{$chamado[0]['id']}}">
    			                <input type="hidden" name="tipo_mensagem" value="{{(Auth::user()->tipo_usuario == 'R') ? 'C' : 'A'}}">
                            	<div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label> Descrição: </label>
                                            <div id="editor"></div>
                                            <textarea name="descricao" id="descricao" class="textarea_editor form-control" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user()->tipo_usuario == 'A')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select required class="form-control" id="status" name="status">
                                                @foreach($statusChamado as $statusChamado => $name)
                                                    <option value="{{$statusChamado}}" {{($chamado[0]['status'] == $statusChamado) ? 'selected' : ''}}>{{$name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            	<input type="hidden" name="usuario_id" value="{{$chamado[0]['usuario_suporte_id']}}">
                                <input type="submit" class="btn btn-primary my-4" value="Salvar">
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scrpts')
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/ckeditor.js"></script>
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/sample.js"></script>
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/jquery.js"></script>
    <script src="{{URL('/assets/painel/js/faqs/')}}/form.js"></script>
@stop