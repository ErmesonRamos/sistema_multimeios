<?php 
include_once('../conf/conexao.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Livro</title>
</head>
<body>
    <h2 style="text-align:center; padding-top:100px;">Deletando Livro...</h2>
    <img src="../img/alanzoka.gif" alt="livro apagado" style="display: block; margin: 0 auto; width: 300px; height: auto;">
</body>
</html>

<?php 
include_once('../conf/conexao.php');

if (isset($_GET['idDel'])) {
    $id_book = $_GET['idDel'];

    try {
        // Excluir reservas relacionadas
        $delete_reserve = "DELETE FROM tb_reserve WHERE id_book = :id_book";
        $stmt_reserve = $conect->prepare($delete_reserve);
        $stmt_reserve->bindParam(':id_book', $id_book, PDO::PARAM_INT);
        $stmt_reserve->execute();

        // Consulta para obter a capa do livro
        $book_cover_query = "SELECT book_cover FROM tb_book WHERE id_book = :id_book";
        $resultado = $conect->prepare($book_cover_query);
        $resultado->bindParam(':id_book', $id_book, PDO::PARAM_INT);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {
            // Obtém o nome da capa
            $row = $resultado->fetch(PDO::FETCH_ASSOC);
            $book_cover = $row['book_cover'];

            // Verifica se a capa não é a padrão antes de tentar excluir
            if ($book_cover != 'capa_padrao.png') {
                $path = "../img/capas_livros/" . $book_cover; // Concatena corretamente o caminho
                if (file_exists($path)) { // Verifica se o arquivo existe
                    unlink($path);
                }
            }

            // Exclui o livro
            $delete = "DELETE FROM tb_book WHERE id_book = :id_book";
            $resultado = $conect->prepare($delete);
            $resultado->bindParam(':id_book', $id_book, PDO::PARAM_INT);
            $resultado->execute();

            if ($resultado->rowCount() > 0) {
                header("Refresh: 5; url=home.php?acao=listaLivros");
                exit();
            } else {
                echo "ERRO AO DELETAR";
            }
        }
    } catch (PDOException $e) {
        echo "ERRO DE PDO: " . $e->getMessage();
    }
} else {
    header("Refresh: 5; url=home.php?acao=listaLivros");
}
