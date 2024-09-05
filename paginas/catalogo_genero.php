<?php
include_once("../includes/header.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gêneros de Livros na Escola</title>
    <style>
       html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f4f4f4;
        }
        .main-content {
            flex: 1; /* Faz com que o conteúdo principal ocupe o espaço disponível */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Adiciona algum espaço ao redor do conteúdo */
            background-color: #f4f4f4;
            overflow: hidden; /* Garante que não haja barras de rolagem indesejadas */
        }
        .core-wrapper {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .title-heading {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .items-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Espaço entre os botões */
            justify-content: center; /* Centraliza os itens horizontalmente */
        }
        .item-entry {
            flex: 1 1 calc(50% - 10px); /* Calcula largura de cada item para duas colunas com espaçamento */
            margin: 0;
        }
        .link-button {
            display: block;
            width: 100%;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #6b756e;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        .link-button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .link-button:active {
            background-color: #004494;
            transform: translateY(0);
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="main-content">
    <div class="core-wrapper">
        <h1 class="title-heading">Gêneros de Livros Presentes</h1>
        <ul class="items-list">
            <li class="item-entry"><a class="link-button" href="genre.html?genre=ficcao_cientifica">Ficção Científica</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=biografia">Biografia</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=romance">Romance</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=historia">História</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=aventura">Aventura</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=autoajuda">Autoajuda e Desenvolvimento Pessoal</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=literatura_infantojuvenil">Literatura Infantojuvenil</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=tecnico_profissional">Técnico e Profissional</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=poesia">Poesia</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=ensaios">Ensaios e Crônicas</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=literatura_brasileira">Literatura Brasileira</a></li>
            <li class="item-entry"><a class="link-button" href="genre.html?genre=literatura_mundial">Literatura Mundial</a></li>
        </ul>
    </div>
</div>
<footer>
    <?php
        include_once("../includes/footer.php");
    ?>
</footer>
</body>
</html>
