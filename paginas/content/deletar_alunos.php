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
    <h2 style="text-align:center; padding-top:100px;">Apagando dados do aluno...</h2>
    <img src="../img/banido.gif" alt="aluno banido" style="display: block; margin: 0 auto; width: 300px; height: auto;">
</body>
</html>

<?php
if (isset($_GET['idDel'])) {
    $id_student = $_GET['idDel'];

    try {
        // Excluir reservas relacionadas
        $delete_reserve = "DELETE FROM tb_reserve WHERE id_student = :id_student";
        $stmt_reserve = $conect->prepare($delete_reserve);
        $stmt_reserve->bindParam(':id_student', $id_student, PDO::PARAM_INT);
        $stmt_reserve->execute();

        // Consulta para obter a foto do aluno
        $photo_query = "SELECT photo FROM tb_student WHERE id_student = :id_student";
        $resultado = $conect->prepare($photo_query);
        $resultado->bindParam(':id_student', $id_student, PDO::PARAM_INT);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {
            $row = $resultado->fetch(PDO::FETCH_ASSOC);
            $photo = $row['photo'];

            if ($photo != 'foto_padrao.jpg') {
                $path = "../img/fotos_alunos/" . $photo; 
                if (file_exists($path)) { 
                    unlink($path);
                }
            }

            // Exclui o aluno
            $delete = "DELETE FROM tb_student WHERE id_student = :id_student";
            $resultado = $conect->prepare($delete);
            $resultado->bindParam(':id_student', $id_student, PDO::PARAM_INT);
            $resultado->execute();

            if ($resultado->rowCount() > 0) {
                header("Refresh: 5; url=home.php?acao=listaAlunos");
                exit();
            } else {
                echo "ERRO AO DELETAR";
            }
        }
    } catch (PDOException $e) {
        echo "ERRO DE PDO: " . $e->getMessage();
    }
} else {
    header("Refresh: 5; url=home.php?acao=listaAlunos");
}
?>