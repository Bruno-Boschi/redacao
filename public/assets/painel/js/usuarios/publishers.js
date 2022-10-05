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
      url: "/usuarios/publishers",
    },
    columns: [
      { data: "name" },
      { data: "email" },
      { data: "celular", orderable: false },
      { data: "data_nascimento", orderable: false },
      { data: "ativo" },
      {
        data: "options",
        name: "options",
        orderable: false,
        searchable: true,
      },
    ],
  });
});
