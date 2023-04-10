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
            url: "/dominios"
        },
        "columns": [
            { data: 'dominio' },
			{ data: 'usuario_dominio' },
			{ data: 'senha_dominio' },
            {
                data: 'options',
                name: 'options',
                orderable: false,
                searchable: true
            }
        ]
    });

	$( "#dominio" ).blur(function() {
	  var site = $(this).val();
	  var urlSite = site.indexOf('https://');
	  if (urlSite < 0) {
	    $("#dominio").val('https://'+site);
	  }
	});

	$('.close').click(function (e) {
		e.preventDefault();
		
		$('#mask').hide();
		$('#mask_2').hide();
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

	$("#dominio").focus(function(){
		$( ".error" ).remove();
	});

	$('#salvar_dados').click(function () {
		var dominio = $('#dominio').val();
		if (dominio.trim() == '') {
			$( ".error" ).remove();
			$(".dados_dominio").append('<small class="text-muted error" style="color:red !important;">Campo Obrigátorio.</small>');
			return;
		}
		
		var usuarioDominio = $('#usuario_dominio').val();
		if (usuarioDominio.trim() == '') {
			$( ".error" ).remove();
			$(".dados_usuario").append('<small class="text-muted error" style="color:red !important;">Campo Obrigátorio.</small>');
			return;
		}
		
		var senhaDominio = $('#senha_dominio').val();
		if (senhaDominio.trim() == '') {
			$( ".error" ).remove();
			$(".dados_senha").append('<small class="text-muted error" style="color:red !important;">Campo Obrigátorio.</small>');
			return;
		}
		
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            type: "POST",
            url: "/dominios/salvar-dominio",
            data: {
                idDominio: $('#id_dominio').val(),
                dominio: $('#dominio').val(),
				dominioUsuario: $('#usuario_dominio').val(),
				dominioSenha: $('#senha_dominio').val()
            },
            cache: false,
            success: function(data){
				var alterado = $('#id_dominio').val();
                $('#dominio').val('');
				$('#usuario_dominio').val('');
				$('#senha_dominio').val('');
                $('#id_dominio').val('0');
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
	$('#importar_dados').click(function () {
		$('#progressao_dados').css('width', '0%');
		$('#descricao_dados').html('0%');
		$('#tipo_importacao').html('');
		$('.inicializacao_importacao').show();
		$('#btn_fechar_sincronismo').prop('disabled', true);
		$('#importar_dados').prop('disabled', true);
		importandoCategorias();
	});
});

function abrirModal(idDominio){
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
    $('#id_dominio').val(idDominio);
	$('#dominio').val($('#dominio_'+idDominio).val());
	$('#usuario_dominio').val($('#usuario_dominio_'+idDominio).val());
	$('#senha_dominio').val($('#senha_dominio_'+idDominio).val());
}

function abrirModalSincronizacao(idDominio){
    var id = "#dialog2";

    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    $('#mask_2').css({'width':maskWidth,'height':maskHeight});

    $('#mask_2').fadeIn(1000);	
    $('#mask_2').fadeTo("slow",0.8);	

    //Get the window height and width
    var winH = $('.window').height();
    var winW = $('.window').width();
          
    $(id).css('top',  '90px');
    $(id).css('left', '246px');

    $(id).fadeIn(2000); 
    $('#id_dominio_sincronismo').val(idDominio);
	$('#progressao_dados').css('width', '0%');
	$('#descricao_dados').html('0%');
	$('#tipo_importacao').html('');
	$('.inicializacao_importacao').hide();
}

function importandoCategorias(){
	$('#progressao_dados').css('width', '10%');
	$('#descricao_dados').html('10%');
	$('#tipo_importacao').html('Carregando Categorias...');
	
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "/dominios/importar-temas",
        data: {
            idDominio: $('#id_dominio_sincronismo').val()
        },
        cache: false,
        success: function(data){
			data = JSON.parse(data);
			if (data.status == 1){
				$('#progressao_dados').css('width', '25%');
				$('#descricao_dados').html('25%');
				setTimeout(function() { 
					importandoPost(); 
			    }, 2000);
			}
        }
    });	
}

function importandoPost(){
	$('#progressao_dados').css('width', '50%');
	$('#descricao_dados').html('50%');
	$('#tipo_importacao').html('Carregando Matérias...');
	
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "/dominios/importar-materias",
        data: {
            idDominio: $('#id_dominio_sincronismo').val()
        },
        cache: false,
        success: function(data){
			data = JSON.parse(data);
			if (data.status == 1){
				$('#progressao_dados').css('width', '95%');
				$('#descricao_dados').html('95%');
				setTimeout(function() { 
					$('#progressao_dados').css('width', '100%');
					$('#descricao_dados').html('100%');
					$('#tipo_importacao').html('Finalizado...');
					$('#btn_fechar_sincronismo').prop('disabled', false);
					$('#importar_dados').prop('disabled', false);
					$( "#btn_fechar_sincronismo" ).trigger( "click" );
			    }, 2000);
			}
        }
    });	
}