@extends('layout.app')
@section('title', 'Cadastro Aviso')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Aviso</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/avisos">Aviso</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form id="dados_cadastro" action="/avisos/salvar" method="get">
                {!! csrf_field() !!}
                @if(isset($aviso->id))
                    <input type="hidden" name="id" value="{{$aviso->id}}">
                @endif
                <div class="tab-content ">		
                    <!-- style="display: none" --> 
                    <div class="tab-pane active" id="dados" data-role="tabpanel">						
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Título: </label>
                                    <input required name="titulo" type="text" class="form-control validate" id="nome" value="{{isset($aviso->titulo) ? $aviso->titulo : ''}}"> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Descrição: </label>
                                    <div id="editor"></div>
                                    <textarea name="descricao" id="descricao" class="textarea_editor form-control" rows="6">{{isset($aviso->descricao) ? $aviso->descricao : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary my-4" value="Salvar">
            </form>
        </div>
    </div>
</div>
@stop
@section('scrpts')
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/ckeditor.js"></script>
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/sample.js"></script>
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/jquery.js"></script>
    <script src="{{URL('/assets/painel/js/avisos/')}}/form.js"></script>
@stop