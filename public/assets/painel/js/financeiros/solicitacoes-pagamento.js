$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#zero_config').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "/financeiros/solicitacoes-pagamento"
        },
        "columns": [
            { data: 'name' },
            { data: 'valor_saque' },
			{ data: 'created_at' },
			{ data: 'data_pagamento' },
			{ data: 'status' },
            {
                data: 'options',
                name: 'options',
                orderable: false,
                searchable: true
            }
        ]
    });
});