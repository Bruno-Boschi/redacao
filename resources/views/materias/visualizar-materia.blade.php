<?php
use App\Models\Materias\Materias;
?>
@extends('layout.app')
@section('title', 'Matéria')
@section('content')
    <?php
    
    $caminho = '';
    if (!empty($materia[0]['imagem_principal'])) {
        $Caracterimagem = substr($materia[0]['imagem_principal'], 0, 5);
        $caminho = $Caracterimagem == 'https' ? $materia[0]['imagem_principal'] : '/assets/materias/imagem_materias/' . $materia[0]['imagem_principal'];
    }
    ?>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Matéria</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/materias">Matéria</a></li>
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Redator: {{ $materia[0]['name'] }}</h5>
                                    <h5 class="card-title">Tipo Redator: {{ $materia[0]['tipo_redator'] }}</h5>
                                    <h5 class="card-title">Titulo: {{ $materia[0]['assunto'] }}</h5>
                                    @if (isset($materia[0]['tema']))
                                        <h5 class="card-title">Categoria: {{ $materia[0]['tema'] }}</h5>
                                    @endif

                                    @if ($materia[0]['tipo_redator'] != 'CLT')
                                        <h5 class="card-title">Preço:
                                            &nbsp;&nbsp;R$&nbsp;{{ $materia[0]['valor_post'] }}
                                        </h5>
                                    @endif

                                    <h5 class="card-title">Idioma: {{ $materia[0]['idioma'] }}</h5>
                                    <h5 class="card-title">Palavras: {{ $materia[0]['qtd_palavras'] }}</h5>
                                    @if (!empty($caminho))
                                        <img id="icone_img" style="width:30%;" src="{{ $caminho }}">
                                    @endif
                                    <br><br>
                                    <!DOCTYPE html>
                                    <html dir="ltr">

                                    <body>
                                        <?php echo $materia[0]['descricao']; ?>
                                    </body>

                                    </html>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div>
                            <br><br>
                            <h4 class="page-title">Referencia</h4>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <table class="table mb-0" id="all-member-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50%" scope="col">Título</th>
                                        <th width="50%" scope="col">Referência - Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referencias as $referencia)
                                        <?php
                                        $linkRef = empty($referencia['link']) ? '' : '<a href="' . $referencia['link'] . '" target="_blank">Url Link</a>';
                                        ?>
                                        <tr>
                                            <td width="50%" scope="col">{{ $referencia['titulo'] }}</td>
                                            {{-- <td width="50%" scope="col">{{ $referencia['link'] }}</td> --}}
                                            <td width="50%" scope="col"><?php echo $linkRef; ?></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php $temaSelecionado = isset($materia[0]['tema_id']) ? $materia[0]['tema_id'] : ''; ?>

                    <br><br>
                    @if ($materia[0]['status'] == Materias::CODIGO_STATUS_AGUARDANDO_AVALIACAO)
                        <form id="dados_cadastro" action="/materias/salvar-revisao" method="get">
                            {!! csrf_field() !!}
                            @if (isset($materia[0]['id']))
                                <input type="hidden" name="id" value="{{ $materia[0]['id'] }}">
                            @endif
                            <div class="row">
                                <div class="col-4">
                                    <label>Status:</label>
                                    <select required class="form-control" id="status_id" name="status_id">
                                        <option value=""></option>
                                        <option value="3">Publicar</option>
                                        <option value="2">Reprovado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row retorno_reprovacao2" id="categoria">
                                <div class="col-4">
                                    <label>Categoria:</label>
                                    <select required class="form-control  postTema" onchange="ocultar()" id="tema_id"
                                        name="tema_id">
                                        @foreach ($temas as $tema)
                                            <option value="{{ $tema->id }}"
                                                {{ $temaSelecionado == $tema->id ? 'selected' : '' }}>
                                                {{ $tema->descricao }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row retorno_reprovacao2">
                                <div class="col-4">
                                    <label>Dominio:</label>
                                    <select required class="form-control" id="dominio_id" name="dominio_id">
                                        <option value=""></option>
                                        @foreach ($dominios as $dominio)
                                            <option value="{{ $dominio->id }}">{{ $dominio->dominio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row retorno_reprovacao">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label> Descrição: </label>
                                        <div id="editor"></div>
                                        <textarea name="descricao" id="descricao" class="textarea_editor form-control" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary my-4" value="Salvar">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
@section('scrpts')
    <script src="{{ URL('/assets/painel/extra-libs/ck-editor/') }}/ckeditor.js"></script>
    <script src="{{ URL('/assets/painel/extra-libs/ck-editor/') }}/sample.js"></script>
    <script src="{{ URL('/assets/painel/extra-libs/ck-editor/') }}/jquery.js"></script>
    <script src="{{ URL('/assets/painel/js/materias/') }}/revisao.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/select2/dist/js/') }}/select2.min.js"></script>
    <link href="{{ URL('/assets/painel/js/libs/select2/dist/css/') }}/select2.min.css" rel="stylesheet">
    <script>
        function ocultar() {
            var status_id = document.getElementById("status_id").value;
            if (status_id == 3) {
                document.getElementById("categoria").style.display = "block";

            } else {
                document.getElementById("categoria").style.display = "none";

            }
        }
    </script>
@stop
