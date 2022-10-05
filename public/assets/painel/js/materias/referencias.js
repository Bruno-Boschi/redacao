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
            url: "/materias/referencias"
        },
        "columns": [
            { data: 'assunto' },
			{ data: 'dominio' },
			{ data: 'name' },
			{ data: 'tema' },
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