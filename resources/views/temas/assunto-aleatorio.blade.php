@extends('layout.app')
@section('title', 'Temas')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Tema</h4>
                <div class="ms-auto text-end">

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="alert alert-warning" role="alert" style="display:none" id="mensagem_erro">
                            <p id="mensagem_erro_descricao"></p>
                        </div>
                        @if ($limiteRejeicoes > 0)
                            @if (!$habilitaBotaoRejeitar)
                                <div class="alert alert-warning" role="alert">
                                    <p>Usuário já excedeu o número de rejeições de assunto diária.</p>
                                </div>
                            @endif
                        @endif
                        <div class="col-12">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <input type="hidden" id="id_assunto" value="{{ $assunto[0]['id'] }}">
                                            <input type="hidden" id="id_tema" value="{{ $assunto[0]['tema_id'] }}">
                                            <h5 class="card-title">Assunto: &nbsp;&nbsp;{{ $assunto[0]['assunto'] }}</h5>
                                            <h5 class="card-title">Categoria: &nbsp;&nbsp;{{ $assunto[0]['tema'] }}</h5>
                                            <h5 class="card-title">Idioma: &nbsp;&nbsp;{{ $assunto[0]['idioma'] }}</h5>
                                            <h5 class="card-title">Palavras: &nbsp;&nbsp;{{ $assunto[0]['qtd_palavras'] }}
                                                <h5 class="card-title">Preço:
                                                    &nbsp;&nbsp;R$&nbsp;{{ $assunto[0]['preco_materia'] }}
                                                </h5>
                                            </h5>
                                            <p>
                                                Descrição:<br>
                                                <?php echo $assunto[0]['descricao']; ?>
                                            </p>
                                        </div>
                                        @if ($assunto[0]['status'] == 3)
                                            <?php $assuntoId = $assunto[0]['id']; ?>
                                            <div class="mr-10 justify-content-between">
                                                <a href="/materias/create-edit/0/{{ $assuntoId }}"
                                                    class="btn btn-success text-white">Criar
                                                    Matéria</a>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div>
                        <br><br>
                        <h4 class="page-title">Referência Tema</h4>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table mb-0" id="all-member-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="40%" scope="col">Título</th>
                                        <th width="40%" scope="col">Referência</th>
                                        {{-- <th width="10%" scope="col">Link</th> --}}
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referencias as $referencia)
                                        <?php
                                        $link = empty($referencia['link_wordpress']) ? '' : '<a href="' . $referencia['link_wordpress'] . '" target="_blank">Abrir</a>';
                                        ?>
                                        <?php
                                        $linkRef = empty($referencia['descricao']) ? '' : '<a href="' . $referencia['descricao'] . '" target="_blank">Url Link</a>';
                                        ?>
                                        <tr>
                                            <td width="40%" scope="col">{{ $referencia['titulo'] }}</td>
                                            <td width="40%" scope="col"><?php echo $linkRef; ?></td>
                                            {{-- <td width="40%" scope="col">{{ $referencia['descricao'] }}</td> --}}
                                            <td width="10%" scope="col"><?php echo $link; ?></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    @if ($assunto[0]['status'] == 1)
                        <div class="row">
                            @if ($limiteRejeicoes > 0)
                                @if ($habilitaBotaoRejeitar)
                                    <div class="col-1">
                                        <button type="button" id="rejeitar_assunto"
                                            class="btn btn-danger text-white">Rejeitar</button>
                                    </div>
                                @endif
                            @elseif ($assunto[0]['usuario_id'] != 0)
                                <div class="col-1">
                                    <button type="button" id="rejeitar_assunto"
                                        class="btn btn-danger text-white">Rejeitar</button>
                                </div>
                            @endif
                            <div class="col-1">
                                <button type="button" id="aceitar_assunto"
                                    class="btn btn-success text-white">Aceitar</button>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop
@section('scrpts')
    <script src="{{ URL('/assets/painel/js/temas/') }}/alteracao_status.js"></script>
@stop
