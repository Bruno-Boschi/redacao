$(document).ready(function () {
    $('#dados_horario').css('display', 'none');
	$("#idGrupoUsuario").change(function() {
		var grupo = $(this).val();
		if (grupo == '3') {
			$('#dados_horario').css('display', 'block');
		} else {
			$('#dados_horario').css('display', 'none');
		}
	});
	$( "#idGrupoUsuario" ).trigger( "change" );
});