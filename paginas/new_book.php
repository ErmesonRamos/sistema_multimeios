<?php
include_once("../config/conexao.php");

if(isset($_POST['new_book'])){
    $titulo_livro = $_POST['titulo_livro'];
    $autor = $_POST['autor'];
    $genero_livro = $_POST['genero_livro'];

    if(!empty($_FILES['capa_livro'])){
        $formatosPermitidos = array("png", "jpg", "jpeg", "webp");
        $extensao = pathinfo($_FILES['capa_livro'], PATHINFO_EXTENSION);

        if(in_array(strtolower($extensao), $formatosPermitidos)){
            echo "Capa adicionada";
        }else{
            echo "Erro ao adicionar capa";
            exit();
        }
    }else{
        echo "Formato de imagem não permitido";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar novo livro</title>
</head>
<body>
    <form action="new_book.php" method="post">
        <label for="titulo_livro">Título:</label>
        <input type="text" name="titulo_livro" id="titulo_livro">
        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor">
        <label for="genero_livro">Gênero:</label>
        <input type="text" name="genero_livro" id="genero_livro">
        <label for="capa_livro">Capa:</label>
        <input type="file" name="capa_livro" id="capa_livro">
        <input type="submit" name="new_book" value="Adicionar novo">
    </form>
</body>
</html>l