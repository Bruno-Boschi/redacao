CKEDITOR.editorConfig = function (config) {
  config.language = "es";
  config.uiColor = "#F7B42C";
  config.height = 300;
  config.toolbarCanCollapse = true;
};
CKEDITOR.replace("descricao");

$(document).ready(function () {
  $(".postTema").select2({
    placeholder: "Selecione a Categoria",
    minimumInputLength: 3,
    ajax: {
      url: "/materias/temas-cadastrado",
      dataType: "json",
      delay: 250,
      data: function (data) {
        return {
          searchTerm: data.term, // search term
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  });

  $("#salvar_url").click(function () {
    if ($("#titulo_referencia").val() == "") {
      alert("Informe Título de Referência.");
      $("#titulo_referencia").val("");
      return;
    }

    if ($("#referencia").val() == "") {
      alert("Informe a Referência.");
      $("#referencia").val("");
      return;
    }

    var referencia = $("#referencia").val();
    var tituloReferencia = $("#titulo_referencia").val();
    adicionarLinha(referencia, tituloReferencia);

    $("#referencia").val("");
    $("#titulo_referencia").val("");
  });
});

$(document).ready(function () {
  $(".retorno_reprovacao").hide();
  $("#status_id").on("change", function () {
    if ($(this).val() == "3") {
      $(".retorno_reprovacao").hide();
    } else if ($(this).val() == "2") {
      $(".retorno_reprovacao").show();
      CKEDITOR.instances["descricao"].setData("");
    }
  });
});
