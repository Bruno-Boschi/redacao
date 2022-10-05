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
            url: "/departamentos"
        },
        "columns": [
            { data: 'departamento' },
            {
                data: 'options',
                name: 'options',
                orderable: false,
                searchable: true
            }
        ]
    });

	$('.close').click(function (e) {
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			

    $('#nav-tab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

	$("#departamento").focus(function(){
		$( ".error" ).remove();
	});

	$('#salvar_dados').click(function () {
		var departamento = $('#departamento').val();
		if (departamento.trim() == '') {
			$(".dados_departamento").append('<small class="text-muted error" style="color:red !important;">Campo Obrigátorio.</small>');
			return;
		}
		
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            type: "POST",
            url: "/departamentos/salvar-tema",
            data: {
                idDepartamento: $('#id_departamento').val(),
                departamento: $('#departamento').val()
            },
            cache: false,
            success: function(data){
				var alterado = $('#id_departamento').val();
                $('#departamento').val('');
                $('#id_departamento').val('');
				(alterado == '0') ? $('#mensagem_sucesso').css('display','block') : 
					$('#mensagem_sucesso_alterado').css('display','block');
				$( ".close" ).trigger( "click" );
                $('#zero_config').DataTable().ajax.reload();
				setTimeout(function() { 
					(alterado == '0') ? $('#mensagem_sucesso').css('display','block') : 
						$('#mensagem_sucesso_alterado').css('display','block');
			    }, 2000);
            }
        });
    });	
});

function abrirModal(idDepartamento){
    var id = "#dialog1";

    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    $('#mask').css({'width':maskWidth,'height':maskHeight});

    $('#mask').fadeIn(1000);	
    $('#mask').fadeTo("slow",0.8);	

    //Get the window height and width
    var winH = $('.window').height();
    var winW = $('.window').width();
          
    $(id).css('top',  '90px');
    $(id).css('left', '145px');

    $(id).fadeIn(2000); 
    $('#id_departamento').val(idDepartamento);
	$('#departamento').val($('#departamento_tema_'+idDepartamento).val());
}