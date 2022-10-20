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

function adicionarLinha(descricao, titulo, idUrl = 0) {
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
  celula2.innerHTML =
    '<a href="' + descricao + '" target="_blank">Url Link</a>';
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
    '">';
  // +
  // '<a href="#todas_url" onclick="removeLinha(' +
  // numeroLinhas +
  // ')" class="btn btn-danger">Remover</a>'
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
      url: "/materias/deletar-referencia",
      data: {
        idUrl: idUrl,
      },
      success: function (result) {
        $("#linha_" + linha).remove();
      },
    });
  } else {
    $("#linha_" + linha).remove();
  }
}

function ajaxUpload(id, csrfToken) {
  $(id).change(function (e) {
    if ($("#imagem_principal").val() == "") {
      alert("Selecione o dominio para enviar a notificação");
      $(id).val("");
      return;
    }
    e.preventDefault();

    // Cria FormData
    var formData = new FormData();
    formData.append("file", this.files[0], this.files[0].name);
    formData.append("_token", csrfToken);

    var campo = "#" + $(this).attr("data-name");
    var img = $(this).attr("data-name") + "_img";
    var recebe = "#" + $(this).attr("data-name") + "_recebe";

    var aviso =
      '<div id="flashMessage" class="ls-alert-success" role="alert" >Efetuando upload aguarde</div>';

    $("#recebeaviso").html(aviso);

    $.ajax({
      type: "POST",
      url: "/materias/upload",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        data = JSON.parse(data);
        $("#" + img).remove();
        $(campo).attr("value", data.msg);

        $(recebe).append(
          '<p><img id="' +
            img +
            '" style="max-width:40%" src="/assets/materias/imagem_materias/' +
            data.msg +
            '"></p>'
        );

        $("#recebeaviso").html(" ");
      },
      error: function (data) {
        alert("Erro ao enviar o arquivo");
      },
    });
  });
}
