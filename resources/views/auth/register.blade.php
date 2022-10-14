<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Redação CDD - Criar Conta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Redação CDD - Criar Conta">
    <meta name="author" content="Themesberg">
    <meta name="description" content="">
    <meta name="keywords" content="" />
    <link rel="canonical" href="">

    <link rel="apple-touch-icon" sizes="120x120" href="{{ URL('/assets/img/favicon/') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL('/assets/img/favicon/') }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL('/assets/img/favicon/') }}/favicon-16x16.png">
    <link rel="manifest" href="{{ URL('/assets/img/favicon/') }}/site.webmanifest">
    <link rel="mask-icon" href="{{ URL('/assets/img/favicon/') }}/safari-pinned-tab.svg" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link type="text/css" href="{{ URL('/assets/bibliotecas/sweetalert2/dist/') }}/sweetalert2.min.css"
        rel="stylesheet">
    <link type="text/css" href="{{ URL('/assets/bibliotecas/notyf/') }}/notyf.min.css" rel="stylesheet">
    <link type="text/css" href="{{ URL('/assets/css/') }}/volt.css" rel="stylesheet">
</head>

<body>
    <main>
        <section class="mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <p class="text-center">

                </p>
                <div class="row justify-content-center form-bg-image"
                    data-background-lg="../../assets/img/illustrations/signin.svg">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Criar Conta </h1>
                                @if (isset($data))
                                    <p class="text-danger mb-0">{{ $data }}</p>
                                @endif
                            </div>
                            <form action="/usuarios/cadastro" class="mt-4" id="registro" method="post">
                                {!! csrf_field() !!}
                                <!-- Form -->
                                <div class="form-group mb-2">
                                    <label for="nome">Nome</label>
                                    <div class="input-group">
                                        <input type="nome" name="nome" class="form-control"
                                            placeholder="Nome Completo" id="nome" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="email">E-mail</label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control" placeholder="E-mail"
                                            id="email" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="celular">Celular</label>
                                    <div class="input-group">
                                        <input type="celular" name="celular" class="form-control phone-inputmask"
                                            placeholder="Celular" id="celular" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <label for="dt_nascimento">Data Nascimento</label>
                                            <div class="input-group">
                                                <input type="dt_nascimento" name="dt_nascimento"
                                                    class="form-control date-inputmask" placeholder="Data Nascimento"
                                                    id="dt_nascimento" autofocus required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label for="tipo">Tipo</label>
                                            <div class="input-group">
                                                <select required class="form-control" id="tipo" name="tipo">
                                                    <option value="R">Redator</option>
                                                    <option value="P">Publisher</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <label for="cpf">CPF</label>
                                            <div class="input-group">
                                                <input type="cpf" name="cpf"
                                                    class="form-control cpf-inputmask" placeholder="CPF"
                                                    id="cpf" autofocus required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label for="chave_pix">Chave PIX</label>
                                            <div class="input-group">
                                                <input type="chave_pix" name="chave_pix" class="form-control"
                                                    placeholder="Chave PIX" id="chave_pix" autofocus required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <label for="password">Senha</label>
                                            <div class="input-group">
                                                <input type="password" name="password" placeholder="Senha"
                                                    class="form-control" id="password" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label for="confirm_password">Confirme a Senha</label>
                                            <div class="input-group">
                                                <input type="password" name="confirm_password"
                                                    placeholder="Confirme a Senha" class="form-control"
                                                    id="confirm_password" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- End of Form -->
                                    <div class="mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="remember">
                                            <label class="form-check-label fw-normal mb-0" for="remember">
                                                Estou de acordo com <a href="#" class="fw-bold">termos e
                                                    Condições</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-gray-800" value="REGISTRAR">
                                </div>
                            </form>
                            <div class="d-flex justify-content-center align-items-center mt-4">
                                <span class="fw-normal">
                                    já tem uma conta?
                                    <a href="/login" class="fw-bold">Entre aqui</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ URL('/assets/bibliotecas/@popperjs/core/dist/umd/') }}/popper.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/bootstrap/dist/js/') }}/bootstrap.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/onscreen/dist/') }}/on-screen.umd.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/smooth-scroll/dist/') }}/smooth-scroll.polyfills.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/chartist/dist/') }}/chartist.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/chartist-plugin-tooltips/dist/') }}/chartist-plugin-tooltip.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/sweetalert2/dist/') }}/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/notyf/') }}/notyf.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/simplebar/dist/') }}/simplebar.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ URL('/assets/bibliotecas/jquery/dist/') }}/jquery.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/inputmask/dist/min/') }}/jquery.inputmask.bundle.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/jquery-validate/') }}/jquery.validate.min.js"></script>
    <script src="{{ URL('/assets/bibliotecas/jquery-validate/') }}/additional-methods.min.js"></script>
    <script src="{{ URL('/assets/js/') }}/volt.js"></script>
    <script src="{{ URL('/assets/js/') }}/masks.js"></script>
    <script src="{{ URL('/assets/js/register') }}/validacao.js"></script>
</body>

</html>
