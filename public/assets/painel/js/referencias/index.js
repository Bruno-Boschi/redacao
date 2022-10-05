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
      url: "/referencias-materias",
    },
    columns: [
      { data: "titulo" },
      { data: "tema_descricao" },
      { data: "link" },
      {
        data: "options",
        name: "options",
        orderable: false,
        searchable: true,
      },
    ],
  });
});
