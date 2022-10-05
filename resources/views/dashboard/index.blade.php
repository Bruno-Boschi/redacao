<?php
use App\Helpers\FormataData;
use App\Models\Materias\Materias;
use App\Models\Materias\Temas;
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
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                        <h6 class="text-white">Total de {{ count($materias) }} Materias</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                        <h6 class="text-white"> Total de {{ $totalMateriasAprovado }} Aprovados</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-warning text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                        <h6 class="text-white">Total de {{ $totalMateriasRevisao }} Aguardando Avaliação</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                        <h6 class="text-white">Total de {{ $totalMateriasReprovado }} Reprovado</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h1>
                        <h6 class="text-white">R$ {{ number_format($valorTotalReceber, 2, ',', '.') }} a receber</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class=" d-flex justify-content-between  card-body">


                                <h5 class="card-title  mb-0">Últimas Matérias</h5>

                                <div class="d-flex justify-content-between" role="group">
                                    <a href="/materias/create-edit" class="btn btn-success text-white">Nova Matéria</a>
                                </div>

                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Título</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Data/Hora</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materias as $materia)
                                        <tr>
                                            <th scope="row">{{ $materia->assunto }}</th>
                                            <td>{{ $materia->tema }}</td>
                                            <td>{{ FormataData::dataHoraDbParaBr($materia->created_at) }}</td>
                                            <td>{{ Materias::STATUS_MATERIAS[$materia->status] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Ranking de Redatores</h5>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Redator</th>
                                        <th scope="col">Total Matérias</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rankingRedatores as $rankingRedator)
                                        <tr>
                                            <td>{{ $rankingRedator->name }}</td>
                                            <th scope="row">{{ $rankingRedator->total_materias }}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Últimas Solicitações Matérias</h5>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Título</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Data/Hora</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assuntoRedator as $assunto)
                                        <tr>
                                            <th scope="row">{{ $assunto->assunto }}</th>
                                            <td>{{ $assunto->tema }}</td>
                                            <td>{{ FormataData::dataHoraDbParaBr($assunto->created_at) }}</td>
                                            <td><a href='/temas/assunto-aleatorio/<?= $assunto->id ?>'
                                                    class="link border-top"><i class="mdi mdi-search-web"></i></a></td>
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
