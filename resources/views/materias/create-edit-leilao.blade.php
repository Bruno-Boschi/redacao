@extends('layout.app')
@section('title', 'Cadastro Matéria')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Matéria </h4>


                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/register">Matéria</a></li>
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
                <form id="dados_cadastro" action="/materias/salvar-leilao" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    @if (isset($materia->id))
                        <input type="hidden" name="id" value="{{ $materia->id }}">
                    @endif
                    <?php $temaSelecionado = isset($solicitacao->tema_id) ? $solicitacao->tema_id : (isset($materia->tema_id) ? $materia->tema_id : 0); ?>
                    <?php $idiomaSelecionado = isset($solicitacao->idioma) ? $solicitacao->idioma : null; ?>
                    <div class="tab-content ">
                        <div class="tab-pane active" id="dados" data-role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label> Titulo: </label>
                                        <input required name="assunto" type="text" class="form-control validate"
                                            id="assunto" value="{{ isset($materia->assunto) ? $materia->assunto : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Idioma:</label>

                                    <input required class="form-control" id="idioma" name="idioma"
                                        value="{{ isset($idiomaSelecionado) ? $idiomaSelecionado : (isset($materia->idioma) ? $materia->idioma : '') }}">

                                </div>
                                <div class="col-md-3">
                                    <label>Valor Desejado:</label>

                                    <input required class="form-control maskMoney-inputmask" id="valor_post"
                                        name="valor_post"
                                        value="{{ isset($materia->valor_post) ? number_format($materia->valor_post, 2, ',', '.') : '' }}">

                                </div>
                            </div>
                            <input type="hidden" name="tema_id" value="{{ $temaSelecionado }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Imagem Principal:</label>
                                    <input type="file" class="form-control" data-name="imagem" name="imagem_principal"
                                        id="imagem_principal" required>

                                    <input type="hidden" id="imagem" name="imagem" class="form-control"
                                        value="{{ isset($materia->imagem_principal) }}">

                                    <div id="imagem_recebe">
                                        @if (isset($materia->imagem_principal))
                                            <img id="icone_img" style="width:30%;"
                                                src="/assets/materias/imagem_materias/{{ $materia->imagem_principal }}">
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label> Descrição: </label>
                                        <div id="editor"></div>
                                        <textarea name="descricao" id="descricao" class="textarea_editor form-control" rows="6" hidden>{{ isset($materia->descricao) ? $materia->descricao : '' }}</textarea>

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
@stop
@section('scrpts')
    <script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>
    <link rel="stylesheet" href="{{ asset('vendor/laraberg/css/laraberg.css') }}">
    <link href="{{ URL('/assets/painel/js/libs/select2/dist/css/') }}/select2.min.css" rel="stylesheet">
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    <script src="{{ URL('/assets/painel/js/materias/') }}/app.js"></script>
    <script src="{{ URL('/assets/painel/js/materias/') }}/form.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/select2/dist/js/') }}/select2.min.js"></script>
    <script src="{{ URL('/assets/painel/extra-libs/mask-money/') }}/jquery.maskMoney.js"></script>

    <script type="text/javascript">
        $(".maskMoney-inputmask").maskMoney({
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: false,
            prefix: "R$ ",
        });
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            Laraberg.init('descricao', {
                height: '300px',
                laravelFilemanager: false,
                sidebar: false
            })
        })
    </script>
    <script>
        ajaxUpload('#imagem_principal', '<?php echo csrf_token(); ?>');
        window.addEventListener('beforeunload', e => {
            window.onbeforeunload = null;
            e.stopImmediatePropagation();
        });
    </script>
@stop
