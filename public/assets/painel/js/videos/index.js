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
            url: "/videos"
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

	$("#titulo").focus(function(){
		$( ".error" ).remove();
	});
	
	$("#video").focus(function(){
		$( ".error" ).remove();
	});

	$('#salvar_dados').click(function () {
		var titulo = $('#titulo').val();
		if (titulo.trim() == '') {
			$( ".error" ).remove();
			$(".dados_titulo").append('<small class="text-muted error" style="color:red !important;">Campo Obrigátorio.</small>');
			return;
		}
		
		var video = $('#video').val();
		if (video.trim() == '') {
			$( ".error" ).remove();
			$(".dados_video").append('<small class="text-muted error" style="color:red !important;">Campo Obrigátorio.</small>');
			return;
		}

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            type: "POST",
            url: "/videos/salvar-video",
            data: {
                idVideo: $('#id_video').val(),
                titulo: $('#titulo').val(),
				video: $('#video').val()
            },
            cache: false,
            success: function(data){
				var alterado = $('#id_video').val();
                $('#titulo').val('');
				$('#video').val('');
                $('#id_video').val('0');
				(alterado == '0') ? $('#mensagem_sucesso').css('display','block') : 
					$('#mensagem_sucesso_alterado').css('display','block');
				$( ".close" ).trigger( "click" );
                $('#zero_config').DataTable().ajax.reload();
				setTimeout(function() { 
					(alterado == '0') ? $('#mensagem_sucesso').css('display','none') : 
						$('#mensagem_sucesso_alterado').css('display','none');
			    }, 2000);
            }
        });
   });	
});

function abrirModal(idVideo){
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
    $('#id_video').val(idVideo);
	$('#video').val($('#video_'+idVideo).val());
	$('#titulo').val($('#titulo_'+idVideo).val());
}