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
      url: "/usuarios/administradores",
    },
    columns: [
      { data: "name" },
      { data: "email" },
      { data: "celular", orderable: false },
      { data: "departamento_id", orderable: false },
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
