<?php
include_once("../config/conexao.php");

if(isset($_POST['new_book'])){
    $titulo_livro = $_POST['titulo_livro'];
    $autor = $_POST['autor'];
    $genero_livro = $_POST['genero_livro'];

    // if (!empty($_FILES['capa_livro']['name'])) {
    //     $formatosPermitidos = array("png", "jpg", "jpeg", "gif"); // Formatos permitidos
    //     $extensao = pathinfo($_FILES['capa_livro']['name'], PATHINFO_EXTENSION); // Obtém a extensão do arquivo

    //     // Verifica se a extensão do arquivo está nos formatos permitidos
    //     if (in_array(strtolower($extensao), $formatosPermitidos)) {
    //         $pasta = "../img/"; // Define o diretório para upload
    //         $temporario = $_FILES['capa_livro']['tmp_name']; // Caminho temporário do arquivo
    //         $novoNome = uniqid() . ".$extensao"; // Gera um nome único para o arquivo

    //         // Move o arquivo para o diretório de imagens
    //         if (move_uploaded_file($temporario, $pasta . $novoNome)) {
    //             // Sucesso no upload da imagem
    //         } else {
    //             echo 'Não foi possível fazer o upload do arquivo.';
    //             exit();
    //         }
    //     } else {
    //         echo 'Formato de arquivo não permitido.';
    //         exit();
    //     }
    // } else {
    //     // Define um avatar padrão caso não seja enviado nenhum arquivo de foto
    //     $novoNome = 'capa_padrao.jpeg'; // Nome do arquivo de avatar padrão
    // }

    $new_book = "INSERT INTO tb_book (title, gender_book) VALUES (:titulo_livro, :genero_livro)";

    try{
        $result = $conect->prepare($new_book);
        $result->bindParam(':titulo_livro', $titulo_livro, PDO::PARAM_STR);
        $result->bindParam(':genero_livro', $genero_livro, PDO::PARAM_STR);
        //$result->bindParam(':capa_livro', $capa_livro, PDO::PARAM_STR);
        $result->execute();
        $contar = $result->rowCount();

        if($contar > 0){
            echo "Livro adicionado";
        }else{
            echo "Livro não foi inserido";
        }
    }
    catch(PDOException $e){
        error_log("Erro de PDO: " . $e->getMessage());
        echo "Ocorreu um erro ao tentar inserir os dados";
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
    <form action="new_book.php" method="post" enctype="multipart/form-data">
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
</html>