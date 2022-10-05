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
            url: "/financeiros/pagamentos"
        },
        "columns": [
            { data: 'name' },
            { data: 'valor_saque' },
			{ data: 'created_at' },
            { data: 'data_pagamento' },
        ]
    });

	$('.window .close').click(function (e) {
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			
	$("#status_pagamento").change(function() {
		var status = $(this).val();
		if (status == '2') {
			$('#descricao').text('');
			$('.descricao_reprovacao').css('display', 'block');
		} else {
			$('.descricao_reprovacao').css('display', 'none');
		}
	});
	
	$('#salvar_dados').click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            type: "POST",
            url: "/financeiros/salvar-pagamento",
            data: {
                idSolicitacao: $('#id_solicitacao').val(),
				idStatus: $('#status_pagamento').val(),
                descricao: $('#descricao').val()
            },
            cache: false,
            success: function(data){
                $('#descricao').text('');
                $('#id_solicitacao').val('0');
				$('#mensagem_sucesso').show();
					
				$( ".close" ).trigger( "click" );
                $('#zero_config').DataTable().ajax.reload();
				setTimeout(function() { 
			        $('#mensagem_sucesso').hide();
			    }, 2000);
            }
        });
	});
});

function abrirModal(idSolicitacao){
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
	var nomeSolicitante = $('#nome_solicitante_'+idSolicitacao).val();
    $('#id_solicitacao').val(idSolicitacao);
	$('#valor_pagamento').val($('#solicitacao_id_'+idSolicitacao).val());
	$('#nome_solicitante').val(nomeSolicitante);
	$('#status_pagamento').val(1);
	$('#chave_pix').val($('#chave_pix_'+idSolicitacao).val());
	$('#descricao').text('Olá '+nomeSolicitante+' pagamento foi efetuado.');
}