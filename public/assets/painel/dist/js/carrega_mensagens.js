$(document).ready(function () {
  carregaTemaAleatorio();
  carregaCentralNotificacao();
});

function carregaTemaAleatorio() {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $.ajax({
    type: "POST",
    url: "/temas/temas-aleatorio-usuario",
    cache: false,
    success: function (data) {
      var html = "";
      var ativarAlerta = false;
      var obj = JSON.parse(data);
      var contagem = 0;
      $.each(obj.temas_aleatorio, function (index, value) {
        var descricao = value.descricao == null ? "" : value.descricao;
        var novaDescricao =
          value.status == "0"
            ? "<strong>" + descricao + "</strong>"
            : descricao;
        var titulo =
          value.status == "0"
            ? "<strong>" + value.assunto + "</strong>"
            : value.assunto;
        html +=
          '<a href="/temas/assunto-aleatorio/' +
          value.id +
          '" class="link border-top">' +
          '<div class="d-flex no-block align-items-center p-10">' +
          '<span class="btn btn-success btn-circle">' +
          '<i class="mdi mdi-receipt"></i></span>' +
          '<div class="ms-2">' +
          "<label>Nova Solicitação &nbsp; </label>" +
          '<span class="mail-desc">' +
          titulo +
          "</span>" +
          "</div></div></a>";
        if (value.status == 0) {
          ativarAlerta = true;
          contagem = contagem + 1;
        }
      });
      if (ativarAlerta) {
        $("#ativar_redator").addClass("warning");
        $(".notificacao_nova_redator").html(contagem);
      } else {
        $(".notificacao_nova_redator").css("display", "none");
      }
      $(".temas_pendentes").html(html);
      setTimeout(() => {
        carregaTemaAleatorio();
      }, 900000);
    },
  });
}

function carregaCentralNotificacao() {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $.ajax({
    type: "POST",
    url: "/dashboard/central-notificacao",
    cache: false,
    success: function (data) {
      var html = "";
      var ativarAlerta = false;
      var obj = JSON.parse(data);
      var contagem = 0;
      $.each(obj.temas_aleatorio, function (index, value) {
        var descricao = value.mensagem == null ? "" : value.mensagem;
        var novaDescricao =
          value.status == "0"
            ? "<strong>" + descricao + "</strong>"
            : descricao;
        html +=
          '<a href="/dashboard/redirecionar-url/' +
          value.id +
          '" class="link border-top">' +
          '<div class="d-flex no-block align-items-center p-6">' +
          '<div class="ms-2">' +
          '<span class="mail-desc">' +
          novaDescricao +
          "</span>" +
          "</div></div></a>";
        if (value.status == 0) {
          ativarAlerta = true;
          contagem = contagem + 1;
        }
      });
      if (ativarAlerta) {
        $("#central_notificacao_mensagem").addClass("warning");
        $(".notificacao_mensagem").html(contagem);
      } else {
        $(".notificacao_mensagem").css("display", "none");
      }
      $(".central_notificacao_pendencia").html(html);
      setTimeout(() => {
        carregaCentralNotificacao();
      }, 900000);
    },
  });
}
