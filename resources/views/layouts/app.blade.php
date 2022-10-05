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
            @yield('content')
        </section>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
