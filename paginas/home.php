<?php

include_once('../includes/header.php');

// Sanitização de entrada -- substituido 'filter_var() e FILTER_SANITIZE_STRING por htmlspecialchars() :: chat disse estar depreciado no php 8.1
$acao = isset($_GET['acao']) ? htmlspecialchars($_GET['acao']) : 'bemvindo';

// Definir caminhos em variáveis
$paginas = [
    'bemvindo' => 'content/home_principal.php',
    'cadastrarAdmin' => '../cadastro_adm.php',
    'cadastrarLivros' => 'content/cadastrar_livros.php',
    'editarLivros' => 'content/editar_livros.php',
    'deletarLivros' => 'content/deletar_livros.php',
    'listaLivros' => 'content/lista_livros.php',
    'reservarLivros' => 'content/reservar_livros.php',
    'reservaLista' => 'content/lista_reservas.php',
    'cadastrarAlunos' => 'content/cadastrar_alunos.php',
    'listaAlunos' => 'content/lista_alunos.php',
    'editarAlunos' => 'content/editar_alunos.php',
    'deletarAlunos' => 'content/deletar_alunos.php'

];

// Verificar se a ação existe no array, caso contrário, usar a página padrão
$pagina_incluir = isset($paginas[$acao]) ? $paginas[$acao] : $paginas['bemvindo'];

// Incluir a página correspondente
include_once($pagina_incluir);

include_once('../includes/footer.php');