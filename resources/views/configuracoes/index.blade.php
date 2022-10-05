@extends('layout.app')
@section('title', 'Configurações')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Configurações</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/configuracoes">Configurações</a></li>
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
                        @if (Session::has('mensagem'))
                            <div class="alert alert-success" role="alert" id="mensagem_sucesso">
                                {{ Session::get('mensagem') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <form id="dados_cadastro" action="/configuracoes/salvar" method="get">
                                {!! csrf_field() !!}
                                <input type="hidden" name="id" value="{{ $configuracoes->id }}">
                                <div class="tab-content ">
                                    <!-- style="display: none" -->
                                    <div class="tab-pane active" id="dados" data-role="tabpanel">
                                        <div class="row">
                                            {{-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> Valor por Matéria: </label>
                                                    <input required name="valor_materia" type="text"
                                                        class="form-control maskMoney-inputmask" id="valor_materia"
                                                        value="{{ number_format($configuracoes->valor_materia, 2, ',', '.') }}">
                                                </div>
                                            </div> --}}
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label> Valor Mínimo Saque: </label>
                                                    <input required name="valor_minimo" type="text"
                                                        class="form-control maskMoney-inputmask" id="valor_minimo"
                                                        value="{{ number_format($configuracoes->valor_minimo, 2, ',', '.') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label> Regras Pagamento: </label>
                                                    <textarea name="descricao" class="textarea_editor form-control" rows="6">{{ $configuracoes->regras_pagamento }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row" style="display: none">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> Usuário SMS: </label>
                                                    <input name="usuario_sms" type="text" class="form-control"
                                                        id="usuario_sms" value="{{ $configuracoes->usuario_sms }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> Senha SMS: </label>
                                                    <input name="senha_sms" type="text" class="form-control"
                                                        id="senha_sms" value="{{ $configuracoes->senha_sms }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> Total Matérias para Rejeitar: </label>
                                                    <input name="total_rejeitos_materia" type="text" class="form-control"
                                                        id="total_rejeitos_materia"
                                                        value="{{ $configuracoes->total_rejeitos_materia }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> Tempo para selecionar Próximo Redator: </label>
                                                    <input name="tempo_rejeitar_materia" type="text"
                                                        class="form-control time-inputmask" id="tempo_rejeitar_materia"
                                                        value="{{ $configuracoes->tempo_rejeitar_materia }}">
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
            </div>
        </div>
    </div>
@stop
@section('scrpts')
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
    <script src="{{ URL('/assets/bibliotecas/inputmask/dist/min/') }}/jquery.inputmask.bundle.min.js"></script>
    <script src="{{ URL('/assets/js/') }}/masks.js"></script>
@stop
