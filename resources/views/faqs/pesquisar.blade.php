@extends('layout.app')
@section('title', 'Pequisar FAQ')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Pesquisar</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/faqs/pesquisar">Pesquisar</a></li>
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
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scrpts')
    <script src="{{URL('/assets/painel/')}}/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="{{URL('/assets/painel/')}}/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="{{URL('/assets/painel/')}}/extra-libs/DataTables/datatables.min.js"></script>
    <script src="{{URL('/assets/painel/js/faqs/')}}/pesquisar.js"></script>
@stop