<?php
use App\Helpers\FormataData;
use App\Models\Suportes\Chamados;
?>
@extends('layout.app')
@section('title', 'Dashboard')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                        <h6 class="text-white">Total de {{ count($ultimosChamados) }} Chamados</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-warning text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                        <h6 class="text-white"> Total de {{ $totalAberto }} Chamados Aberto</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                        <h6 class="text-white">Total de {{ $totalChamados }} Chamados Fechados</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Últimas Chamados</h5>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Título</th>
                                        <th scope="col">Data/Hora</th>
                                        <th scope="col">Data Fechamento</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ultimosChamados as $chamados)
                                        <tr>
                                            <th scope="row">{{ $chamados->titulo }}</th>
                                            <td>{{ FormataData::dataHoraDbParaBr($chamados->created_at) }}</td>
                                            <td>{{ FormataData::dataDbParaBr($chamados->data_fechamento) }}</td>
                                            <td>{{ Chamados::STATUS_CHAMADO[$chamados->status] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-5">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Ranking de Redatores</h5>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Redator</th>
                                        <th scope="col">Total Matérias</th>
                                        <th scope="col">Total Rejeitado</th>
                                        <th scope="col">Total Aceitado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rankingRedatores as $rankingRedator)
                                        <tr>
                                            <td>{{ $rankingRedator->name }}</td>
                                            <th scope="row">{{ $rankingRedator->total_materias }}</th>
                                            <th scope="row">{{ $rankingRedator->rejetado }}</th>
                                            <th scope="row">{{ $rankingRedator->aceite }}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body d-flex" style="justify-content: space-between;">

                                <div>
                                    <h5 class="card-title mb-0">Solicitações</h5>
                                </div>
                                <div>
                                    <a href="/temas/create-edit-redator" class="btn btn-info
 text-white">Solicitar
                                        Matéria</a>
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Assunto</th>
                                        <th scope="col">Redator</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Idioma</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitacoes as $solicitacao)
                                        <tr>
                                            <th scope="row">{{ $solicitacao->assunto }}</th>
                                            @if (isset($solicitacao->usuario_nome))
                                                <th>{{ $solicitacao->usuario_nome }}</th>
                                            @else
                                                <th>Todos</th>
                                            @endif
                                            @if (isset($solicitacao->tema_descricao))
                                                <th>{{ $solicitacao->tema_descricao }}</th>
                                            @else
                                                <th>Não informado</th>
                                            @endif
                                            <th>{{ $solicitacao->idioma }}</th>
                                            <th>
                                                @if ($solicitacao->status == 0)
                                                    Enviado
                                                @elseif ($solicitacao->status == 1)
                                                    Aguardando
                                                @elseif ($solicitacao->status == 2)
                                                    Rejeitado
                                                @elseif ($solicitacao->status == 3)
                                                    Aceito
                                                @elseif ($solicitacao->status == 4)
                                                    Finalizado
                                                @endif

                                            </th>
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
@stop
