@extends('layout.app')
@section('title', 'Relatório de Matéria')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Relatório de Matéria</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/materias/relatorios">Relatório de Matéria</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="dados_cadastro" action="/materias/relatorios" method="get">
                    @csrf
                    <div class="tab-content ">
                        <div class="tab-pane active" id="dados" data-role="tabpanel">
                            <div class="row">
                                <div class="col-md-3 dados_assunto">
                                    <label class="text-muted">A partir:</label>
                                    <input required name="data_inicio" type="date" class="form-control" id="data_inicio"
                                        value="">
                                </div>
                                {{-- <div class="col-md-3 dados_assunto">
                                    <label class="text-muted">Data Fim:</label>
                                    <input required name="data_fim" type="date" class="form-control" id="data_fim"
                                        value="">
                                </div> --}}
                                <div class="col-md-3 dados_assunto">
                                    <label class="text-muted">Tipo:</label>
                                    <select required class="form-control" id="tipo" name="tipo">
                                        <option></option>
                                        <option value="0">Não Exportado</option>
                                        <option value="1">Já Exportado</option>
                                        <option value="2">Todos</option>
                                    </select>
                                </div>
                                <div class="col-md-3 dados_assunto">
                                    <input type="submit" class="btn btn-primary my-4" value="Exportar Relatorio">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <input type="submit" class="btn btn-primary my-4" value="Gerar Relatório"> --}}
                </form>
            </div>
        </div>
    </div>
@stop
@section('scrpts')
    <script src="{{ URL('/assets/bibliotecas/inputmask/dist/min/') }}/jquery.inputmask.bundle.min.js"></script>
    <script src="{{ URL('/assets/js/') }}/masks.js"></script>
@stop
