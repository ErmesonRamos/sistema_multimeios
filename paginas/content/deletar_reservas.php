
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Reserva</title>
</head>
<body>
    <h2 style="text-align:center; padding-top:100px;">Deletando Reserva...</h2>
    <img src="../img/alanzoka.gif" alt="reserva apagada" style="display: block; margin: 0 auto; width: 300px; height: auto;">

<?php 
include_once('../conf/conexao.php');

if (isset($_GET['idDel'])) {
    $id_reserve = $_GET['idDel'];

    try {
        // Excluir a reserva
        $delete_reserve = "DELETE FROM tb_reserve WHERE id_reserve = :id_reserve";
        $stmt_reserve = $conect->prepare($delete_reserve);
        $stmt_reserve->bindParam(':id_reserve', $id_reserve, PDO::PARAM_INT);
        $stmt_reserve->execute();

        // Verifica se a reserva foi deletada
        if ($stmt_reserve->rowCount() > 0) {
            header("Refresh: 3; url=home.php?acao=reservaLista");
            exit();
        } else {
            echo "<h2 style='text-align:center; padding-top:100px;'>Erro ao deletar a reserva.</h2>";
        }
    } catch (PDOException $e) {
        echo "ERRO DE PDO: " . $e->getMessage();
    }
} else {
    header("Location: home.php?acao=reservaLista");
    exit();
}
?>
</body>
</html>