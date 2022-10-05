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
            url: "/faqs/pesquisar"
        },
        "columns": [
            { data: 'titulo' },
            {
                data: 'options',
                name: 'options',
                orderable: false,
                searchable: true
            }
        ]
    });
});