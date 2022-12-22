CKEDITOR.editorConfig = function (config) {
  config.language = "es";
  config.uiColor = "#F7B42C";
  config.height = 300;
  config.toolbarCanCollapse = true;
};
CKEDITOR.replace("descricao");

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

  $(".retorno_reprovacao2").hide();
  $("#status_id").on("change", function () {
    if ($(this).val() == "3") {
      $(".retorno_reprovacao2").show();
      document.getElementById("dominio_id").setAttribute("required");
    } else if ($(this).val() == "2") {
      document.getElementById("dominio_id").removeAttribute("required");
      $(".retorno_reprovacao2").hide();
    }
  });

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

  $(".postTema").select2({
    placeholder: "Selecione a Categoria",
  });
});
