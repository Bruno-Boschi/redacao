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
      { data: "id" },
      {
        data: "imagem_principal",
        name: "imagem",
        orderable: false,

      },
      { data: "assunto" , orderable: false, },
      { data: "name" , orderable: false, },
      { data: "url" , orderable: false, },
      { data: "tema" , orderable: false, },
      { data: "idioma" , orderable: false, },
      { data: "created_at" },
      { data: "status" , orderable: false,},
      {
        data: "options",
        name: "options",
        orderable: false,
        searchable: true,
      },
    ],
          order: [[7,'desc']],
  });
});
