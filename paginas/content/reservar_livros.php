<?php
include_once('../conf/conexao.php');

// Consulta para obter livros disponíveis
$livros_query = "SELECT id_book, title FROM tb_book";
$livros_result = $conect->query($livros_query);

// Consulta para obter alunos
$alunos_query = "SELECT id_student, name_student FROM tb_student";
$alunos_result = $conect->query($alunos_query);

$today = date('Y-m-d'); // Data atual

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Processa a reserva
    $id_book = $_POST['id_book'];
    $id_student = $_POST['id_student'];
    $booking_day = $_POST['booking_day']; // Data de reserva fornecida pelo usuário
    $return_day = $_POST['return_day']; // Data de devolução fornecida pelo usuário

    // Valida a data de devolução
    if (strtotime($return_day) < strtotime($booking_day)) {
        echo "<script>alert('A data de devolução deve ser igual ou posterior à data de reserva.');</script>";
    } else {
        $insert_query = "INSERT INTO tb_reserve (id_book, id_student, booking_day, return_day) VALUES (:id_book, :id_student, :booking_day, :return_day)";
        $stmt = $conect->prepare($insert_query);
        $stmt->bindParam(':id_book', $id_book, PDO::PARAM_INT);
        $stmt->bindParam(':id_student', $id_student, PDO::PARAM_INT);
        $stmt->bindParam(':booking_day', $booking_day);
        $stmt->bindParam(':return_day', $return_day);

        if ($stmt->execute()) {
            echo "<script>alert('Reserva feita com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao fazer a reserva.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Livro</title>
    <link rel="stylesheet" href="../estilos/reserva.css">
</head>
<body>
    <div class="container">
        <div class="conteiner-infor">
            <a href="home.php?acao=reservaLista" class="link">Lista de Reservas</a>
            <h2>Reservar Livro</h2>
        </div>
        <div class="conteiner-form">
            <form method="POST">
                <div class="form-group">
                    <label for="id_book">Livro:</label>
                    <select name="id_book" required>
                        <?php while ($livro = $livros_result->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?= $livro['id_book']; ?>"><?= $livro['title']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="id_student">Aluno:</label>
                    <select name="id_student" required>
                        <?php while ($aluno = $alunos_result->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?= $aluno['id_student']; ?>"><?= $aluno['name_student']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="booking_day">Data de Reserva:</label>
                    <input type="date" name="booking_day" value="<?= $today; ?>" required>
                </div>
                <div class="form-group">
                    <label for="return_day">Data de Devolução:</label>
                    <input type="date" name="return_day" required>
                </div>
                <button type="submit" class="btn">Reservar</button>
            </form>
        </div>
    </div>
</body>
</html>
