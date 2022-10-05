$(document).ready(function () {
  $("#rejeitar_assunto").click(function () {
    atualizarStatus(2);
  });
  $("#aceitar_assunto").click(function () {
    atualizarStatus(3);
  });
});

function atualizarStatus(status) {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $.ajax({
    type: "POST",
    url: "/temas/atualizar-assunto-redator",
    data: {
      idAssunto: $("#id_assunto").val(),
      idTema: $("#id_tema").val(),
      status: status,
    },
    cache: false,
    success: function (data) {
      var obj = JSON.parse(data);
      if (status == 3) {
        window.location.href = "/materias/create-edit/0/" + obj.id_tema; // redireciona ao aceitar a materia com o ID do Redator_aleatorio
      } else {
        if (obj.status == 2) {
          $("#mensagem_erro").css("display", "block");
          $("#mensagem_erro_descricao").html(
            "Você excedeu o número de rejeição das matérias diária.<br>Foram rejeitadas hoje o total de " +
              obj.totalRejeitada
          );
        } else if (obj.status == 1) {
          window.location.href = "/materias/minhas-materias";
        }
      }
    },
  });
}
