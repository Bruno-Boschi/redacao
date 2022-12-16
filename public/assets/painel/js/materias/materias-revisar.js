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
      url: "/materias/materias-revisar",
    },
    columns: [
      { data: "id" },
      {
        data: "imagem_principal",
        name: "imagem",
        orderable: false,
        searchable: true,
      },
      { data: "assunto", className: "dt[-head|-body]-left" },
      { data: "name" },
      { data: "tema" },
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
