@extends('layout.app')
@section('title', 'Vídeos')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Vídeos</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/videos/pesquisar">Vídeos</a></li>
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
                            	<h5 class="card-title">{{$videos->titulo}}</h5>
                            	<br><br>
	            				<?php echo $videos->video; ?>
	                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scrpts')
    
@stop