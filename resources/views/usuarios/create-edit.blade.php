<?php
use App\Helpers\FormataData;
?>
@extends('layout.app')
@section('title', 'Cadastro Usuário')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">

                @if ($tipoUsuario == 'A')
                    <h4 class="page-title">Usuários</h4>
                @elseif ($tipoUsuario == 'R')
                    <h4 class="page-title">Redator</h4>
                @endif

                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @if ($tipoUsuario == 'A')
                                <li class="breadcrumb-item"><a href="/usuarios/administradores">Usuário</a></li>
                            @elseif ($tipoUsuario == 'R')
                                <li class="breadcrumb-item"><a href="/usuarios/redatores">Redator</a></li>
                            @endif
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
                <form id="dados_cadastro" action="/usuarios/salvar" method="get">
                    {!! csrf_field() !!}
                    <input type="hidden" name="tipo_usuario"
                        value="{{ isset($usuario->tipo_usuario) ? $usuario->tipo_usuario : $tipoUsuario }}">
                    @if (isset($usuario->id))
                        <input type="hidden" name="id" value="{{ $usuario->id }}">
                    @endif
                    <?php
                    $dataNascimento = '';
                    if (isset($usuario->data_nascimento)) {
                        $dataNascimento = FormataData::dataDbParaBr($usuario->data_nascimento);
                    }
                    $departamentoSelecionado = isset($usuario->departamento_id) ? $usuario->departamento_id : '';
                    ?>

                    @if ($tipoUsuario == 'R')
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input required type="text" class="form-control" placeholder="Nome" name="name"
                                        value="{{ isset($usuario->name) ? $usuario->name : '' }}">
                                </div>
                            </div>
                            @if (Auth::user()->tipo_usuario == 'A')
                                <div class="col-md-6">
                                    <label>Tipo:</label>
                                    <select required class="form-control" onchange="ocultar()" id="tipo_redator"
                                        name="tipo_redator">
                                        <option value="{{ isset($usuario->tipo_redator) ? $usuario->tipo_redator : '' }}">
                                            {{ isset($usuario->tipo_redator) ? $usuario->tipo_redator : '' }}
                                        </option>
                                        <option value="CLT">CLT</option>
                                        <option value="PJ">PJ</option>
                                    </select>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <label>Tipo:</label>
                                    <select required class="form-control" onchange="ocultar()" id="tipo_redator"
                                        name="tipo_redator" readonly>
                                        <option value="{{ isset($usuario->tipo_redator) ? $usuario->tipo_redator : '' }}">
                                            {{ isset($usuario->tipo_redator) ? $usuario->tipo_redator : '' }}
                                        </option>
                                    </select>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input required type="text" class="form-control" placeholder="Nome" name="name"
                                        value="{{ isset($usuario->name) ? $usuario->name : '' }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-12" id="email">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input required type="text" class="form-control" placeholder="Usuário" name="email"
                                value="{{ isset($usuario->email) ? $usuario->email : '' }}">
                        </div>
                    </div>

                    {{-- @if ($tipoUsuario == 'R')
                        <div class="row">
                            <div class="col-6" id="email">
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input required type="text" class="form-control" placeholder="Usuário" name="email"
                                        value="{{ isset($usuario->email) ? $usuario->email : '' }}">
                                </div>
                            </div>
                            <div class="col-6" id="Valor">
                                <div class="form-group">
                                    <label>Valor Por Materia</label>
                                    <input required type="text" class="form-control decimal-inputmask"
                                        placeholder="Valor" name="preco_materia"
                                        value="{{ isset($usuario->preco_materia) ? $usuario->preco_materia : '' }}">
                                </div>
                            </div>
                        </div>
                    @endif --}}


                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Celular</label>
                                <input required type="text" class="form-control phone-inputmask" placeholder="Celular"
                                    name="celular" value="{{ isset($usuario->celular) ? $usuario->celular : '' }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Data Nascimento</label>
                                <input required type="text" class="form-control date-inputmask"
                                    placeholder="Data Nascimento" name="data_nascimento" value="{{ $dataNascimento }}">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>CPF</label>
                                <input required type="text" class="form-control cpf-inputmask" placeholder="CPF"
                                    name="cpf" value="{{ isset($usuario->cpf) ? $usuario->cpf : '' }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chave PIX</label>
                                <input required type="text" class="form-control" placeholder="Chave PIX" name="chave_pix"
                                    value="{{ isset($usuario->chave_pix) ? $usuario->chave_pix : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" class="form-control" placeholder="Senha" name="password"
                                    {{ isset($usuario->password) ? '' : 'required' }}>
                            </div>
                        </div>
                    </div>
                    @if ($tipoUsuario == 'A')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Departamento</label>
                                    <select required class="form-control" id="departamento" name="departamento">
                                        @foreach ($departamentos as $departamento => $name)
                                            <option value="{{ $departamento }}"
                                                {{ $departamentoSelecionado == $departamento ? 'selected' : '' }}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                    <input type="submit" class="btn btn-primary my-4" value="Salvar">
                </form>
            </div>
        </div>
    </div>
@stop
@section('scrpts')
    <script>
        function ocultar() {
            var tipo_redator = document.getElementById("tipo_redator").value;
            if (tipo_redator == "PJ") {
                document.getElementById("Valor").style.display = "block";
                document.getElementById("email").classList.remove("col-12");
                document.getElementById("email").classList.add("col-6");
            } else {
                document.getElementById("Valor").style.display = "none";
                document.getElementById("email").classList.add("col-12");

            }
        }
    </script>
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
    <script src="{{ URL('/assets/painel/js/usuarios/') }}/form.js"></script>
@stop
