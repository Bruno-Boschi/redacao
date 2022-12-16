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
      url: "/temas/redator-aleatorio",
    },
    columns: [
      { data: "id" },
      { data: "assunto" },
      { data: "redator" },
      { data: "descricao" },
      { data: "idioma" },
      { data: "created_at" },
      { data: "status" },
      {
        data: "options",
        name: "options",
        orderable: false,
        searchable: true,
      },
    ],
  });
});
