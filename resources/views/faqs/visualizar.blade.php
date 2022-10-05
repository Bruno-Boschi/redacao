@extends('layout.app')
@section('title', 'Faq')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">FAQ</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/faqs/pesquisar">FAQ</a></li>
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
                            	<h5 class="card-title">{{$faq->titulo}}</h5>
                            	<br><br>
                            	<!DOCTYPE html>
								<html dir="ltr">
                        			<body>
                        				<?php echo $faq->descricao; ?>
                    				</body>

								</html>
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