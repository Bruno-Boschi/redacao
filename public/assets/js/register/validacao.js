$( "#registro" ).validate({
  rules: {
    password: "required",
    nome: "required",
    email: "required",
    celular: "required",
    dt_nascimento: "required",
    cpf: "required",
    chave_pix: "required",
    password: "required",
    confirm_password: {
      equalTo: "#password"
    }
  }
});