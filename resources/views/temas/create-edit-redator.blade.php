@extends('layout.app')
@section('title', 'Cadastrar Tema')
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Cadastrar Tema</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/temas">Cadastrar Tema</a></li>
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
                <form id="dados_cadastro" action="/temas/salvar-redator-aleatorio" method="post">
                    {!! csrf_field() !!}
                    @if (isset($redatorAleatorio->id))
                        <input type="hidden" name="id" value="{{ $redatorAleatorio->id }}">
                    @endif
                    <div class="tab-content ">
                        <!-- style="display: none" -->
                        <div class="tab-pane active" id="dados" data-role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 dados_assunto">
                                    <label class="text-muted">Assunto:</label>
                                    <input required name="assunto" type="text" class="form-control" id="assunto"
                                        value="">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="text-muted">Idioma:</label><br>
                                    <input required class="form-control" id="idioma" name="idioma" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-muted">Redator:</label><br>
                                    <select class="form-control postName" id="redator" name="redator"></select>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="text-muted">Categoria:</label><br>
                                    <select required class="form-control postTema" id="tema" name="tema">
                                        {{-- <option value=""></option>
                                        @foreach ($temas as $tema)
                                            <option value="{{ $tema['id'] }}">{{ $tema['descricao'] }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="text-muted">Descrição Assunto:</label>
                                    <textarea name="descricao_assunto" id="descricao_assunto" class="textarea_editor form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div>
                                <br><br>
                                <h4 class="page-title">Referência Tema</h4>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Título</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Referência - Link</label>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Matéria</label>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-lg-2">
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="titulo_referencia"
                                            id="titulo_referencia" value="">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <input type="text" class="form-control" name="referencia" id="referencia"
                                            value="">
                                    </div>
                                </div>
                                {{-- <div class="col-md-3 dados_redator">
                                    <select class="form-control postDominio" id="materia" name="materia"></select>
                                </div>
                                --}}
                                <div class="col-lg-2">
                                    <a href="#salvar_url" class="btn btn-primary" id="salvar_url">Adicionar</a>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table mb-0" id="all-member-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="45%" scope="col">Título</th>
                                                <th width="45%" scope="col">Referência</th>
                                                <th width="10%" scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                 <input type="submit" class="btn btn-primary my-4" value="Salvar"> -->
                    <button class="btn btn-primary my-4" type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </div>
@stop
@section('scrpts')
    <link href="{{ URL('/assets/painel/js/libs/select2/dist/css/') }}/select2.min.css" rel="stylesheet">
    <script src="{{ URL('/assets/painel/extra-libs/ck-editor/') }}/ckeditor.js"></script>
    <script src="{{ URL('/assets/painel/extra-libs/ck-editor/') }}/sample.js"></script>
    <script src="{{ URL('/assets/painel/extra-libs/ck-editor/') }}/jquery.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/DataTables/datatables.min.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/select2/dist/js/') }}/select2.min.js"></script>
    <script src="{{ URL('/assets/painel/js/temas/') }}/form-redator-aleatorio.js"></script>
    @foreach ($temaReferencias as $temaReferencia)
        <script>
            adicionarLinha("{{ $temaReferencia->descricao }}", "{{ $temaReferencia->titulo }}", {{ $temaReferencia->id }});
        </script>
    @endforeach
@stop
