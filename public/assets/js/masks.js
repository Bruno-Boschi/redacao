$(function (e) {
  "use strict";
  $(".date-inputmask").inputmask("dd/mm/yyyy", { placeholder: "dd/mm/aaaa" }),
    $(".time-inputmask").inputmask("hh:mm", { placeholder: "hh:mm" }),
    $(".phone-inputmask").inputmask("(99) 99999-9999", {
      placeholder: "(  )      -     ",
    }),
    $(".international-inputmask").inputmask("+9(999)999-9999"),
    $(".xphone-inputmask").inputmask("(999) 999-9999 / x999999"),
    $(".purchase-inputmask").inputmask("aaaa 9999-****"),
    $(".cc-inputmask").inputmask("9999 9999 9999 9999"),
    $(".cpf-inputmask").inputmask("999.999.999-99", {
      placeholder: "   .   .   -  ",
    }),
    $(".isbn-inputmask").inputmask("999-99-999-9999-9"),
    $(".currency-inputmask").inputmask("$9999"),
    $(".percentage-inputmask").inputmask("99%"),
    $(".decimal-inputmask").inputmask({
      alias: "currency",
      radixPoint: ".",
      precision: 2,
      prefix: "R$ ",
    }),
    $(".inputmask").inputmask({
      alias: "currency",
      radixPoint: ".",
      precision: 2,
      prefix: "R$ ",
    }),
    $(".email-inputmask").inputmask({
      mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[*{2,6}][*{1,2}].*{1,}[.*{2,6}][.*{1,2}]",
      greedy: !1,
      onBeforePaste: function (n, a) {
        return (e = e.toLowerCase()).replace("mailto:", "");
      },
      definitions: {
        "*": {
          validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~/-]",
          cardinality: 1,
          casing: "lower",
        },
      },
    });
});
