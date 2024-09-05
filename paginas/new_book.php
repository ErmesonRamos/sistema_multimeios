<?php
include_once("../config/conexao.php");

if (isset($_POST['new_book'])) {
    $titulo_livro = $_POST['titulo_livro'];
    $autor = $_POST['autor'];
    $genero_livro = $_POST['genero_livro'];
    $booking_day = $_POST['booking_day'];
    $return_day = $_POST['return_day'];

    if (!empty($_FILES['capa_livro']['name'])) {
        $formatosPermitidos = array("png", "jpg", "jpeg", "gif");
        $extensao = pathinfo($_FILES['capa_livro']['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($extensao), $formatosPermitidos)) {
            $pasta = "../img/";
            $temporario = $_FILES['capa_livro']['tmp_name'];
            $novoNomeCapa = uniqid() . ".$extensao";
            $destino = $pasta . $novoNomeCapa;

            // Verifique se o diretório existe
            if (!is_dir($pasta)) {
                echo "Diretório de upload não encontrado.";
                exit();
            }

            // Verifique se o arquivo pode ser movido
            if (move_uploaded_file($temporario, $destino)) {
                echo "Imagem enviada com sucesso!";
            } else {
                $error = error_get_last();
                echo 'Não foi possível fazer o upload do arquivo. Erro: ' . $error['message'];
                exit();
            }
        } else {
            echo 'Formato de arquivo não permitido.';
            exit();
        }
    } else {
        $novoNomeCapa = 'capa_padrao.jpeg';
    }

    $new_book = "INSERT INTO tb_book (title, gender_book, author_book, picture, booking_day, return_day) VALUES (:titulo_livro, :genero_livro, :autor, :capa_livro, :booking_day, :return_day)";

    try {
        $result = $conect->prepare($new_book);
        $result->bindParam(':titulo_livro', $titulo_livro, PDO::PARAM_STR);
        $result->bindParam(':genero_livro', $genero_livro, PDO::PARAM_STR);
        $result->bindParam(':autor', $autor, PDO::PARAM_STR);
        $result->bindParam(':capa_livro', $novoNomeCapa, PDO::PARAM_STR);
        $result->bindParam(':booking_day', $booking_day, PDO::PARAM_STR);
        $result->bindParam(':return_day', $return_day, PDO::PARAM_STR);
        $result->execute();
        $contar = $result->rowCount();
    
        if ($contar > 0) {
            echo "Livro adicionado com sucesso!";
        } else {
            echo "Nenhum livro foi inserido. Verifique se os dados foram corretamente enviados.";
        }
    } catch (PDOException $e) {
        error_log("Erro de PDO: " . $e->getMessage());
        echo "Ocorreu um erro ao tentar inserir os dados: " . $e->getMessage();
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
        <label for="genero_livro">Gênero:</label>
        <input type="text" name="genero_livro" id="genero_livro">
        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor">
        <label for="capa_livro">Capa:</label>
        <input type="file" name="capa_livro" id="capa_livro">
        <label for="booking_day">booking_day:</label>
        <input type="date" name="booking_day" id="booking_day">
        <label for="return_day">return_day:</label>
        <input type="date" name="return_day" id="return_day">
        <input type="submit" name="new_book" value="Adicionar novo">
    </form>
</body>
</html>