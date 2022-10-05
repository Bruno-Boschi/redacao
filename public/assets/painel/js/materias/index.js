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
      url: "/materias",
    },
    columns: [
      {
        data: "imagem_principal",
        name: "imagem",
        orderable: false,
        searchable: true,
      },
      { data: "assunto" },
      { data: "name" },
      { data: "tema" },
      { data: "idioma" },
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
