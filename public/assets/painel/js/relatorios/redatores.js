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
      url: "/relatorios/redatores",
    },
    columns: [
      { data: "name" },
      { data: "email" },
      { data: "tipo_redator" },
      { data: "total_materias" },
      { data: "aceito" },
      { data: "rejeitado" },
    ],
  });
});
