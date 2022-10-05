<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Redação CDD - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Redação CDD - Login">
    <meta name="author" content="Themesberg">
    <meta name="description" content="">
    <meta name="keywords" content="" />

    <!-- Favicon -->
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
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <p class="text-center"></p>
                <div class="row justify-content-center form-bg-image"
                    data-background-lg="../../assets/img/illustrations/signin.svg">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Login</h1>

                                @if (isset($data))
                                    <p class="text-danger mb-0">{{ $data }}</p>
                                @endif
                            </div>
                            @if (Session::has('mensagem'))
                                <div class="alert alert-warning" Align="center" role="alert" id="mensagem_sucesso">
                                    {{ Session::get('mensagem') }}
                                </div>
                            @endif

                            <form class="mt-4" action="{{ route('login') }}" method="post">
                                {!! csrf_field() !!}
                                <div class="form-group mb-4">
                                    <label for="email">E-mail *</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                                </path>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z">
                                                </path>
                                            </svg>
                                        </span>
                                        <input type="email" name="email" class="form-control" placeholder="E-mail"
                                            id="email" autofocus required>
                                    </div>
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="password">Senha *</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2">
                                                <svg class="icon icon-xs text-gray-600" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                        clip-rule="evenodd">
                                                    </path>
                                                </svg>
                                            </span>
                                            <input type="password" name="password" placeholder="Senha"
                                                class="form-control" id="password" required>
                                        </div>
                                    </div>
                                    <!-- End of Form -->
                                    <div class="d-flex justify-content-between align-items-top mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="remember">
                                            <label class="form-check-label mb-0" for="remember"> Lembrar Login </label>
                                        </div>
                                        <div>
                                            <a href="/password/reset" class="small text-right">Esqueceu a senha?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gray-800">LOGAR</button>
                                </div>
                            </form>
                            <div class="d-flex justify-content-center align-items-center mt-4">
                                <span class="fw-normal"> Ainda não tem conta? <a href="/register"
                                        class="fw-bold">Registrar</a>
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
    <script src="{{ URL('/assets/js/') }}/volt.js"></script>
</body>

</html>
