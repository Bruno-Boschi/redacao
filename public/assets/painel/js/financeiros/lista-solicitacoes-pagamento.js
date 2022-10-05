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
            url: "/financeiros/lista-solicitacoes-pagamento"
        },
        "columns": [
            { data: 'name' },
            { data: 'valor_saque' },
			{ data: 'created_at' },
            {
                data: 'options',
                name: 'options',
                orderable: false,
                searchable: true
            }
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
                descricao: $('#descricao').val(),
				comprovante: $('#comprovante').val()
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

function ajaxUpload(id, csrfToken){
	$(id).change(function(e){
		if ($('#comprovante_pagamento').val() == '') {
			alert('Selecione o dominio para enviar a notificação');
			$(id).val('');
			return;
		}
		e.preventDefault();

		// Cria FormData
		var formData = new FormData();
		formData.append('file',this.files[0],this.files[0].name);
		formData.append('_token', csrfToken);
		
		var campo = '#'+$(this).attr('data-name');
		var img   = $(this).attr('data-name')+'_img';
		var recebe= '#'+$(this).attr('data-name')+'_recebe';
		
		var aviso = '<div id="flashMessage" class="ls-alert-success" role="alert" >Efetuando upload aguarde</div>';
		
		$('#recebeaviso').html(aviso);

		$.ajax({
			type:'POST',
		    url: '/financeiros/upload/'+$('#id_solicitacao').val(),
		    data:formData,
		    cache:false,
		    contentType: false,
		    processData: false,
		    success:function(data){
		    	data = JSON.parse(data);
		        $('#'+img).remove();
		        $(campo).attr('value',data.msg)
		
		        //$(recebe).append('<p><img id="'+img+'" style="max-width:100%" src="/assets/painel/uploads/documentos/'+$('#id_solicitacao').val()+'/'+data.msg+'"></p>')
		
		        //$('#recebeaviso').html(" ");
		      },
		      error: function(data){
		          alert("Erro ao enviar o arquivo");
		      }
		})
	})

}
