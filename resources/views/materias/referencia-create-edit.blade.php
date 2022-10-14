@extends('layout.app')
@section('title', 'Cadastro Tema')
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Tema</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/temas">Tema</a></li>
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
                <form id="dados_cadastro" action="/temas/salvar-tema" method="post">
                    {!! csrf_field() !!}
                    @if (isset($tema->id))
                        <input type="hidden" name="id" value="{{ $tema->id }}">
                    @endif
                    <div class="tab-content ">
                        <!-- style="display: none" -->
                        <div class="tab-pane active" id="dados" data-role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label> Tema: </label>
                                        <input required name="assunto" type="text" class="form-control validate"
                                            id="titulo" value="{{ isset($tema->descricao) ? $tema->descricao : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary my-4" type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
