CKEDITOR.editorConfig = function( config ) {
	config.language = 'es';
	config.uiColor = '#F7B42C';
	config.height = 300;
	config.toolbarCanCollapse = true;
};
CKEDITOR.replace('descricao');

$(document).ready(function () {
	$('.retorno_reprovacao').hide();
	$( "#status_id" ).on('change', function() {
		if ($(this).val() == '3') {
			$('.retorno_reprovacao').hide();
		} else {
			$('.retorno_reprovacao').show();
			CKEDITOR.instances['descricao'].setData('');
		}
	});
});