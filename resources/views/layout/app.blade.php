<!DOCTYPE html>
<html dir="ltr" lang="pt">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Redação CDD - @yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL('/assets/painel/imagem/') }}/favicon.png">
    <!-- Custom CSS -->
    <link href="{{ URL('/assets/painel/js/libs/') }}/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ URL('/assets/painel/dist/') }}/css/style.min.css" rel="stylesheet">
    <link href="{{ URL('/assets/painel/dist/') }}/css/animation.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ URL('/assets/painel/extra-libs/') }}/multicheck/multicheck.css">
    <link rel="stylesheet" href="{{ URL('/assets/painel/css/') }}/jquery.dataTables.min.css" type="text/css">
    <link href="{{ URL('/assets/painel/js/libs/') }}/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">


    <!--     <link rel="stylesheet" type="text/css" -->
    <!--         href="{{ URL('/assets/painel/js/libs/') }}/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">

                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="/dashboard">
                        <!-- Logo icon -->
                        <b class="logo-icon ps-2">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ URL('/assets/painel/imagem/') }}/logo.png" alt="homepage" class="light-logo" />

                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{ URL('/assets/painel/imagem/') }}/logo_text.png" alt="homepage"
                                class="light-logo" />

                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item d-none d-lg-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-end">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown possui_notificacao_aleatorio">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark close" href="#"
                                id="central_notificacao_mensagem" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="font-24 mdi mdi-comment-processing"></i>
                                <span class="badge notificacao_mensagem"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mailbox animated bounceInDown"
                                aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="central_notificacao_pendencia"></div>
                                    </li>
                                </ul>
                            </ul>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown possui_notificacao_aleatorio">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark close" href="#"
                                id="ativar_redator" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-bell font-24"></i>
                                <span class="badge notificacao_nova_redator"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mailbox animated bounceInDown"
                                aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="temas_pendentes"></div>
                                    </li>
                                </ul>
                            </ul>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ URL('/assets/painel/imagem/') }}/ico-perfil.png" alt="user"
                                    class="rounded-circle" width="31">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="/usuarios/create-edit/{{ Auth::user()->tipo_usuario }}/{{ Auth::user()->id }}">
                                    <i class="ti-user me-1 ms-1"></i> Meus Dados
                                </a>
                                @if (Auth::user()->tipo_usuario == 'A')
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/configuracoes">
                                        <i class="ti-settings me-1 ms-1"></i> Configurações
                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/usuarios/logout">
                                    <i class="fa fa-power-off me-1 ms-1"></i> Logout
                                </a>
                                <div class="dropdown-divider"></div>
                            </ul>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="pt-4">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/dashboard"
                                aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        @if ((Auth::user()->tipo_usuario == 'A' && Auth::user()->departamento_id == 1) ||
                            (Auth::user()->departamento_id == 0 && Auth::user()->tipo_usuario == 'A') ||
                            Auth::user()->tipo_usuario == 'R')
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="mdi mdi-receipt"></i>
                                    <span class="hide-menu">Matérias</span>
                                </a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    @if (Auth::user()->tipo_usuario == 'A')
                                        <li class="sidebar-item">
                                            <a href="/materias" class="sidebar-link">
                                                <i class="mdi mdi-pencil"></i>
                                                <span class="hide-menu"> Matérias</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/materias/materias-revisar" class="sidebar-link">
                                                <i class="mdi mdi-pencil"></i>
                                                <span class="hide-menu"> Revisar Matérias</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/leilao-materias" class="sidebar-link">
                                                <i class="mdi mdi-pencil"></i>
                                                <span class="hide-menu"> Leilão Matérias</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->tipo_usuario == 'R')
                                        <li class="sidebar-item">
                                            <a href="/materias/minhas-materias" class="sidebar-link">
                                                <i class="mdi mdi-pencil"></i>
                                                <span class="hide-menu"> Minhas Matérias</span>
                                            </a>
                                        </li>
                                        {{-- <li class="sidebar-item">
                                            <a href="/referencias-materias" class="sidebar-link">
                                                <i class="mdi mdi-forum"></i>
                                                <span class="hide-menu"> Referência Matérias</span>
                                            </a>
                                        </li> --}}
                                        {{-- <li class="sidebar-item">
                                        <a href="/referencias-materias" class="sidebar-link">
                                            <i class="mdi mdi-forum"></i>
                                            <span class="hide-menu"> Minhas Solicitacoes</span>
                                        </a>
                                    </li> --}}
                                    @endif
                                    @if (Auth::user()->tipo_usuario == 'A')
                                        {{-- <li class="sidebar-item">
                                            <a href="/referencias-materias" class="sidebar-link">
                                                <i class="mdi mdi-forum"></i>
                                                <span class="hide-menu"> Referência Matérias</span>
                                            </a>
                                        </li> --}}
                                        <li class="sidebar-item">
                                            <a href="/temas" class="sidebar-link">
                                                <i class="mdi mdi-pencil"></i>
                                                <span class="hide-menu">Categorias </span>
                                            </a>
                                        </li>

                                        <li class="sidebar-item">
                                            <a href="/temas/redator-aleatorio" class="sidebar-link">
                                                <i class="mdi mdi-account"></i>
                                                <span class="hide-menu"> Redator Aleatório</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/dominios" class="sidebar-link">
                                                <i class="mdi mdi-domain"></i>
                                                <span class="hide-menu">Domínios </span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/materias/relatorios" class="sidebar-link">
                                                <i class="mdi mdi-format-list-bulleted"></i>
                                                <span class="hide-menu">Relatório de Matérias </span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif


                        @if (Auth::user()->departamento_id == 0 || Auth::user()->departamento_id == 2)

                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="mdi mdi-cash-usd"></i>
                                    <span class="hide-menu">Financeiro</span>
                                </a>

                                <ul aria-expanded="false" class="collapse first-level">
                                    @if (Auth::user()->tipo_usuario == 'R')
                                        <li class="sidebar-item">
                                            <a href="/financeiros" class="sidebar-link">
                                                <i class="mdi mdi-cash-multiple"></i>
                                                <span class="hide-menu">Solicitar Pagamento </span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->tipo_usuario == 'A')
                                        <li class="sidebar-item">
                                            <a href="/financeiros/lista-solicitacoes-pagamento" class="sidebar-link">
                                                <i class="mdi mdi-square-inc-cash"></i>
                                                <span class="hide-menu"> Pagamentos Pendentes</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/financeiros/pagamentos" class="sidebar-link">
                                                <i class="mdi mdi-cash-multiple"></i>
                                                <span class="hide-menu"> Pagamentos</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/financeiros/faturamento-dominio" class="sidebar-link">
                                                <i class="mdi mdi-cash-multiple"></i>
                                                <span class="hide-menu"> Faturamento Domínio</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->tipo_usuario == 'R')
                                        <li class="sidebar-item">
                                            <a href="/financeiros/solicitacoes-pagamento" class="sidebar-link">
                                                <i class="mdi mdi-square-inc-cash"></i>
                                                <span class="hide-menu"> Meus Pagamentos</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-account-box-outline"></i>
                                <span class="hide-menu">Suporte</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="/suportes" class="sidebar-link">
                                        <i class="mdi mdi-comment-account"></i>
                                        <span class="hide-menu">Meus Chamados </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (Auth::user()->tipo_usuario == 'A')
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="mdi mdi-account-multiple-plus"></i>
                                    <span class="hide-menu">Usuários</span>
                                </a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item">
                                        @if (Auth::user()->departamento_id != 2)
                                            <a href="/usuarios/redatores" class="sidebar-link">
                                                <i class="mdi mdi-account-key"></i>
                                                <span class="hide-menu">Redatores </span>
                                            </a>
                                            <a href="/usuarios/publishers" class="sidebar-link">
                                                <i class="mdi mdi-account-key"></i>
                                                <span class="hide-menu">Publishers</span>
                                            </a>
                                        @endif

                                        @if (Auth::user()->departamento_id != 1)
                                            <a href="/usuarios/administradores" class="sidebar-link">
                                                <i class="mdi mdi-account-key"></i>
                                                <span class="hide-menu">Administradores</span>
                                            </a>
                                        @endif

                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-help-circle"></i>
                                <span class="hide-menu">FAQ</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    @if (Auth::user()->tipo_usuario == 'A')
                                        <a href="/faqs" class="sidebar-link">
                                            <i class="mdi mdi-pencil"></i>
                                            <span class="hide-menu">Faq </span>
                                        </a>
                                    @endif
                                    <a href="/faqs/pesquisar" class="sidebar-link">
                                        <i class="mdi mdi-search-web"></i>
                                        <span class="hide-menu">Pesquisar </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-video"></i>
                                <span class="hide-menu">Vídeos</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    @if (Auth::user()->tipo_usuario == 'A')
                                        <a href="/videos" class="sidebar-link">
                                            <i class="mdi mdi-pencil"></i>
                                            <span class="hide-menu"> Aulas em Vídeos</span>
                                        </a>
                                    @endif
                                    <a href="/videos/pesquisar" class="sidebar-link">
                                        <i class="mdi mdi-search-web"></i>
                                        <span class="hide-menu">Pesquisar </span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-note-multiple"></i>
                                <span class="hide-menu">Avisos</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    @if (Auth::user()->tipo_usuario == 'A')
                                        <a href="/avisos" class="sidebar-link">
                                            <i class="mdi mdi-pencil"></i>
                                            <span class="hide-menu">Avisos </span>
                                        </a>
                                    @endif
                                    <a href="/avisos/pesquisar" class="sidebar-link">
                                        <i class="mdi mdi-search-web"></i>
                                        <span class="hide-menu">Últimos Avisos </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- @if (Auth::user()->tipo_usuario == 'R')
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="mdi mdi-help-circle"></i>
                                    <span class="hide-menu">Referência</span>
                                </a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item">
                                        <a href="/materias/referencias" class="sidebar-link">
                                            <i class="mdi mdi-pencil"></i>
                                            <span class="hide-menu">Referência </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif --}}
                        {{-- @if (Auth::user()->tipo_usuario == 'A')
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i class="mdi mdi-account-multiple-plus"></i>
                                    <span class="hide-menu">Relatorios</span>
                                </a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item">
                                        @if (Auth::user()->departamento_id != 2)
                                            <a href="/usuarios/redatores" class="sidebar-link">
                                                <i class="mdi mdi-account-key"></i>
                                                <span class="hide-menu">Redatores </span>
                                            </a>
                                            <a href="/usuarios/publishers" class="sidebar-link">
                                                <i class="mdi mdi-account-key"></i>
                                                <span class="hide-menu">Publishers</span>
                                            </a>
                                        @endif

                                        @if (Auth::user()->departamento_id != 1)
                                            <a href="/usuarios/administradores" class="sidebar-link">
                                                <i class="mdi mdi-account-key"></i>
                                                <span class="hide-menu">Administradores</span>
                                            </a>
                                        @endif

                                    </li>
                                </ul>
                            </li>
                        @endif --}}
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    <footer class="footer text-center">
        All Rights Reserved by Redação CDD.
    </footer>
    </div>
    <script src="{{ URL('/assets/painel/js/libs/') }}/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ URL('/assets/painel/js/libs/') }}/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/') }}/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="{{ URL('/assets/painel/') }}/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="{{ URL('/assets/painel/dist/') }}/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="{{ URL('/assets/painel/dist/') }}/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="{{ URL('/assets/painel/dist/') }}/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!-- <script src="../../dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="{{ URL('/assets/painel/js/libs/') }}/flot/excanvas.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/') }}/flot/jquery.flot.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/') }}/flot/jquery.flot.pie.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/') }}/flot/jquery.flot.time.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/') }}/flot/jquery.flot.stack.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/') }}/flot/jquery.flot.crosshair.js"></script>
    <script src="{{ URL('/assets/painel/js/libs/') }}/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="{{ URL('/assets/painel/dist/js/') }}/carrega_mensagens.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @yield('scrpts')

</body>

</html>
