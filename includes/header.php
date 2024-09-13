<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multimeios JMF</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;400i;700&display=swap" rel="stylesheet">
    <!-- Ícone da página -->
    <link rel="icon" href="../../dist/img/logo.png" type="image/x-icon">
    <!-- Estilos personalizados -->
    <style>
        /* Estilos Gerais */
        body {
            font-family: 'Source Sans Pro', sans-serif;
            color: #4F4F4F;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .main-header {
            background-color: #3C8C8C;
            border-bottom: 1px solid #2D6B6B;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link {
            color: #FFFFFF;
            margin-right: 1rem;
            text-decoration: none;
        }

        .navbar-nav .nav-link:hover {
            color: #cce0ff;
        }

        .form-inline .form-control-navbar {
            border-radius: 0.25rem;
            border: 1px solid #2D6B6B;
            background-color: #3C8C8C;
            color: #FFFFFF;
        }

        .btn-navbar {
            background-color: #2D6B6B;
            border: none;
            color: #FFFFFF;
        }

        .btn-navbar:hover {
            background-color: #3C8C8C;
        }

        /* Sidebar */
        .main-sidebar {
            width: 250px;
            background-color: #4CAF50;
            color: #FFFFFF;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            transition: width 0.3s ease;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            z-index: 1000; /* Ensure sidebar is on top */
        }

        /* Brand Logo */
          .brand-link {
              background-color: #388E3C;
              color: #FFFFFF;
              padding: 1rem;
              display: flex;
              align-items: center;
              justify-content: center;
              margin-bottom: 1rem;
              white-space: nowrap; /* Prevent text wrapping */
              overflow: hidden; /* Prevent text overflow */
          }

          /* When sidebar is expanded */
          .sidebar-expanded .brand-link .brand-text {
              display: block; /* Show the brand text */
          }

          /* When sidebar is collapsed */
          .sidebar-collapsed .brand-link .brand-text {
              display: none; /* Hide the brand text */
          }

          .brand-image {
              width: 30px;
              height: 30px;
              margin-right: 10px;
          }

          /* Adjust the brand image for collapsed state */
          .sidebar-collapsed .brand-image {
              width: 24px;
              height: 24px;
          }

        .nav-link {
            display: flex;
            align-items: center;
            color: #FFFFFF;
            padding: 1rem;
            text-align: left;
            text-decoration: none;
            border-radius: 4px;
            margin: 0.5rem 0;
            transition: background-color 0.3s ease;
            cursor: pointer;
            font-size: 1rem;
            white-space: nowrap; /* Prevent text wrapping */
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.25rem;
        }

        .nav-link span {
            transition: opacity 0.3s ease;
            overflow: hidden; /* Prevent text overflow */
        }

        .nav-link.active,
        .nav-link:hover {
            background-color: #388E3C;
        }

        .nav-item.has-treeview {
            position: relative;
        }

        .nav-treeview {
            display: none;
            background-color: #2C6B41;
            transition: max-height 0.3s ease;
            overflow: hidden;
        }

        .nav-treeview .nav-link {
            padding-left: 2rem;
            text-align: left;
        }

        .nav-item.has-treeview > a .fa-caret-down {
            font-size: 0.8rem;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            transition: opacity 0.3s ease;
        }

        /* Estilos gerais do painel do usuário */
        .user-panel {
            border-bottom: 1px solid #388E3C;
            margin-bottom: 1rem;
            text-align: center;
            transition: height 0.3s ease; /* Transição suave para altura */
        }

        .user-panel .image img {
            border-radius: 50%;
            object-fit: cover;
            transition: width 0.3s ease, height 0.3s ease; /* Transição suave para tamanho */
        }

        .user-panel .info {
            transition: opacity 0.3s ease;
        }

        /* Estilos para o estado expandido da sidebar */
        .sidebar-expanded .user-panel .image img {
            width: 80px; /* Tamanho da imagem no estado expandido */
            height: 80px; /* Tamanho da imagem no estado expandido */
        }

        .sidebar-expanded .user-panel .info {
            opacity: 1; /* Nome do usuário visível no estado expandido */
            white-space: nowrap; /* Impede a quebra de linha no nome */
        }

        /* Estilos para o estado contraído da sidebar */
        .sidebar-collapsed .user-panel .image img {
            width: 90px; /* Tamanho da imagem no estado contraído */
            height: 90px; /* Tamanho da imagem no estado contraído */
        }

        .sidebar-collapsed .user-panel .info {
            opacity: 0; /* Nome do usuário oculto no estado contraído */
            font-size: 0;
            margin-top: 13px;
        }

        /* Content Wrapper */
        .content-wrapper {
            margin-left: 250px;
            padding: 1rem;
            transition: margin-left 0.3s ease;
        }

        .sidebar-collapsed .content-wrapper {
            margin-left: 80px;
        }

        .sidebar-collapsed {
            width: 80px;
        }

        .sidebar-collapsed .nav-link {
            font-size: 0.75rem;
            text-align: center;
            white-space: nowrap; /* Impede a quebra de linha */
            padding: 0.75rem 0; /* Ajuste do padding para alinhamento melhor */
        }

        .sidebar-collapsed .nav-link span {
            display: none;
        }

        .sidebar-collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.5rem;
        }

        .sidebar-collapsed .brand-text {
            font-size: 0.875rem;
        }

        .sidebar-collapsed .brand-image {
            width: 24px;
            height: 24px;
        }

        .sidebar-collapsed .nav-treeview {
            display: none;
        }

        .sidebar-collapsed .user-panel .image img {
            width: 24px;
            height: 24px;
        }

        /* Centralizar ícones ao estar contraído */
        .sidebar-collapsed .nav-link i {
            display: block;
            margin: 0 auto; /* Centraliza os ícones */
        }

        /* Ajustes no ícone do submenu */
        .nav-item.has-treeview > a {
            display: flex;
            align-items: center;
            position: relative;
        }

        .nav-item.has-treeview > a .fa-caret-down {
            display: inline-block;
            opacity: 1;
        }

        .sidebar-collapsed .nav-item.has-treeview > a .fa-caret-down {
            display: none;
        }

        /* Alinhar o submenu com o ícone do submenu */
        .nav-treeview {
            display: none;
            background-color: #2C6B41;
            transition: max-height 0.3s ease;
            overflow: hidden;
            padding-left: 1rem;
        }

        .nav-treeview .nav-link {
            padding-left: 1rem; /* Add padding to align submenu items */
            text-align: left;
        }
    </style>
</head>
<body class="hold-transition layout-fixed">
<div class="wrapper">

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="../../dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text">Biblioteca</span>
        </a>


        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Nome do Usuário</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="index.html" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Livros -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <span>Livros</span>
                            <i class="fa fa-caret-down nav-icon"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pages/UI/general.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Gêneros</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/icons.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Editora</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/buttons.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Autor</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/sliders.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Exemplar</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Sobre -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-info-circle"></i>
                            <span>Sobre</span>
                            <i class="fa fa-caret-down nav-icon"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pages/UI/general.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Nossa História</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/icons.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Equipe</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/buttons.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Parcerias</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/sliders.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Políticas da Biblioteca</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/modals.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span>Contato</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Relatório -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <span>Relatório</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Your content goes here -->
    </div>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Sidebar expand/collapse on hover
        $('.main-sidebar').hover(
            function() {
                $(this).stop(true, true).animate({ width: '250px' }, 300);
                $('.content-wrapper').stop(true, true).animate({ marginLeft: '250px' }, 300);
                $(this).addClass('sidebar-expanded'); // Adiciona a classe para o estado expandido
                $(this).removeClass('sidebar-collapsed'); // Remove a classe para o estado contraído
            },
            function() {
                $(this).stop(true, true).animate({ width: '80px' }, 300);
                $('.content-wrapper').stop(true, true).animate({ marginLeft: '80px' }, 300);
                $(this).addClass('sidebar-collapsed'); // Adiciona a classe para o estado contraído
                $(this).removeClass('sidebar-expanded'); // Remove a classe para o estado expandido
            }
        );

        // Toggle submenu visibility on click
        $('.nav-item.has-treeview > a').on('click', function(e) {
            e.preventDefault();
            var $submenu = $(this).siblings('.nav-treeview');

            if ($submenu.is(':visible')) {
                $submenu.slideUp(300);
                $(this).removeClass('active');
            } else {
                $submenu.slideDown(300);
                $(this).addClass('active');
                $('.nav-treeview').not($submenu).slideUp(300);
                $('.nav-item.has-treeview > a').not(this).removeClass('active');
            }
        });
    });
</script>
</body>
</html>
