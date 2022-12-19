$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $("#zero_config").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "/leilao-materias",
    },
    columns: [
      { data: "id" },
      {
        data: "imagem_principal",
        name: "imagem",
        orderable: false,
        searchable: true,
      },
      { data: "assunto" },
      { data: "name" },
      { data: "idioma" },
      { data: "valor_post" },
      { data: "created_at" },
      { data: "status" },
      {
        data: "options",
        name: "options",
        orderable: false,
        searchable: true,
      },
    ],
    order: [[6,'desc'],[7,'desc']]
  });
});
