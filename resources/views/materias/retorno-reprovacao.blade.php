@extends('layout.app')
@section('title', 'Matéria')
@section('content')
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
                            	<h5 class="card-title">Assunto: {{$materias[0]['assunto']}}</h5>
                            	<h5 class="card-title">Tema: {{$materias[0]['tema']}}</h5>
                            	<br>
                            	<label>Motivo Reprovação:</label>
                            	@foreach($materias as $materia)
                            	<!DOCTYPE html>
								<html dir="ltr">
                        			<body>
                        				<?php echo $materia['historico']; ?>
                    				</body>
								</html>
								<hr>
								@endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="btn-group mt-12" role="group">
                            <a href="/materias/create-edit/{{$materias[0]['id']}}" class="btn btn-success text-white" title="Editar">Editar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scrpts')
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/ckeditor.js"></script>
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/sample.js"></script>
    <script src="{{URL('/assets/painel/extra-libs/ck-editor/')}}/jquery.js"></script>
    <script src="{{URL('/assets/painel/js/materias/')}}/revisao.js"></script>
@stop