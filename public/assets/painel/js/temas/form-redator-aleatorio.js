CKEDITOR.editorConfig = function (config) {
  config.language = "es";
  config.uiColor = "#F7B42C";
  config.height = 300;
  config.toolbarCanCollapse = true;
};
CKEDITOR.replace("descricao_assunto");

$(document).ready(function () {
  // $(".postName").select2({
  //   placeholder: "Selecione Redator",
  //   minimumInputLength: 3,
  //   ajax: {
  //     url: "/temas/redator",
  //     dataType: "json",
  //     delay: 250,
  //     data: function (data) {
  //       return {
  //         searchTerm: data.term, // search term
  //       };
  //     },
  //     processResults: function (response) {
  //       return {
  //         results: response,
  //       };
  //     },
  //     cache: true,
  //   },
  // });

  $(".postName").select2({
    placeholder: "Selecione a Redator",
  });

  $(".postPalavras").select2({
    placeholder: "Selecione a Quantidade de palavras",
  });

  $(".postDominio").select2({
    placeholder: "Selecione Matéria",
    minimumInputLength: 3,
    ajax: {
      url: "/temas/materias-cadastrada",
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

  // $(".postTema").select2({
  //   placeholder: "Selecione a Categoria",
  //   minimumInputLength: 3,
  //   ajax: {
  //     url: "/temas/temas-cadastrado",
  //     dataType: "json",
  //     delay: 250,
  //     data: function (data) {
  //       return {
  //         searchTerm: data.term, // search term
  //       };
  //     },
  //     processResults: function (response) {
  //       return {
  //         results: response,
  //       };
  //     },
  //     cache: true,
  //   },
  // });
  $(".postTema").select2({
    placeholder: "Selecione a Categoria",
  });

  $("#salvar_url").click(function () {
    console.log($("#materia").val());
    if ($("#titulo_referencia").val() == "") {
      alert("Informe Título de Refência.");
      $("#titulo_referencia").val("");
      return;
    }

    if ($("#referencia").val() == "" && $("#materia").val() == null) {
      alert("Informe a Refência ou a Matéria.");
      $("#referencia").val("");
      return;
    }

    var referencia =
      $("#referencia").val() == ""
        ? $("#materia").text()
        : $("#referencia").val();
    var tituloReferencia = $("#titulo_referencia").val();
    var idMateria = $("#materia").val();
    adicionarLinha(referencia, tituloReferencia, idMateria);

    $("#referencia").val("");
    $("#titulo_referencia").val("");
  });
});

function adicionarLinha(descricao, titulo, idMateria, idUrl = 0) {
  var tabela = document.getElementById("all-member-table");
  var numeroLinhas = tabela.rows.length;
  if (numeroLinhas > 0) {
    $("#todas_perguntas").css("display", "block");
  }
  var linha = tabela.insertRow(numeroLinhas);
  var chave = "linha_" + numeroLinhas;
  linha.id = chave;
  var celula1 = linha.insertCell(0);
  var celula2 = linha.insertCell(1);
  var celula3 = linha.insertCell(2);
  celula1.innerHTML = titulo;
  celula2.innerHTML = descricao;
  celula3.innerHTML =
    '<input type="hidden" id="pergunta" name="descricao_referencia[]" class="id_descricao_' +
    numeroLinhas +
    '" value="' +
    descricao +
    '">' +
    '<input type="hidden" id="pergunta" name="titulo[]" class="id_titulo_' +
    numeroLinhas +
    '" value="' +
    titulo +
    '">' +
    '<input type="hidden" id="id_table_url_' +
    numeroLinhas +
    '" name="id_table_url_' +
    numeroLinhas +
    '" class="id_table_url_' +
    numeroLinhas +
    '" value="' +
    idUrl +
    '">' +
    '<a href="#todas_url" onclick="removeLinha(' +
    numeroLinhas +
    ')" class="btn btn-danger">Remover</a>';
}

function removeLinha(linha) {
  var idUrl = $("#id_table_url_" + linha).val();
  if (idUrl != 0) {
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });

    $.ajax({
      type: "POST",
      url: "/temas/deletar-referencia",
      data: {
        idReferencia: idUrl,
      },
      success: function (result) {
        $("#linha_" + linha).remove();
      },
    });
  } else {
    $("#linha_" + linha).remove();
  }
}
