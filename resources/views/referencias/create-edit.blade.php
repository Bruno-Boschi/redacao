@extends('layout.app')
@section('title', 'Cadastro Referencia')
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Cadastro Referencia</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/referencia">Referencia</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
                        </ol><br>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="dados_cadastro" action="{{ route('createEdit') }}" method="post">
                    {!! csrf_field() !!}
                    @if (isset($referencia->id))
                        <input type="hidden" name="id" value="{{ $referencia->id }}">
                    @endif
                    <?php $temaSelecionado = isset($referencia->tema_id) ? $referencia->tema_id : ''; ?>
                    <div class="tab-content ">
                        <!-- style="display: none" -->
                        <div class="tab-pane active" id="dados" data-role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label> Titulo: </label>
                                        <input required name="titulo" type="text" class="form-control validate"
                                            id="titulo" value="{{ $referencia->titulo ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="text-muted">Temas:</label><br>
                                    <select required class="form-control validate" id="tema_id" name="tema_id">
                                        <option value=""></option>
                                        @foreach ($temas as $tema)
                                            <option value="{{ $tema['id'] }}"
                                                {{ $temaSelecionado == $tema->id ? 'selected' : '' }}>
                                                {{ $tema['descricao'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="text-muted">Link</label><br>
                                    <input required name="link" type="text" class="form-control validate"
                                        id="link" value="{{ $referencia->link ?? '' }}">

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

@section('scrpts')


@stop
