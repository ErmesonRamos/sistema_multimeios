<?php
include_once('../conf/conexao.php');

// Obtém o ID da reserva a ser editada
$id_reserve = $_GET['idUpdate'];
$select = "
    SELECT 
        r.id_reserve,
        r.id_book,
        r.id_student,
        r.booking_day,
        r.return_day,
        b.title,
        s.name_student
    FROM 
        tb_reserve r
    JOIN 
        tb_book b ON r.id_book = b.id_book
    JOIN 
        tb_student s ON r.id_student = s.id_student
    WHERE 
        r.id_reserve = :id_reserve";

$resultado = $conect->prepare($select);
$resultado->bindParam(':id_reserve', $id_reserve, PDO::PARAM_INT);
$resultado->execute();

if ($resultado->rowCount() > 0) {
    $fetch = $resultado->fetch(PDO::FETCH_OBJ);
    $oldBookId = $fetch->id_book;
    $oldStudentId = $fetch->id_student;
    $oldBookingDay = $fetch->booking_day;
    $oldReturnDay = $fetch->return_day;
} else {
    header("Location: ../home.php");
    exit();
}

// Busca todos os livros e alunos para os selects
$livros_query = "SELECT id_book, title FROM tb_book";
$alunos_query = "SELECT id_student, name_student FROM tb_student";
$livros_result = $conect->query($livros_query);
$alunos_result = $conect->query($alunos_query);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva</title>
    <link rel="stylesheet" href="../estilos/updates.css">
</head>
<body>
    <form role="form" action="" method="post">
        <h2>Editar Dados da Reserva</h2>
        <input type="hidden" name="id_reserve" value="<?php echo $id_reserve; ?>" required>
        
        <label for="id_book">Livro</label>
        <select name="id_book" required>
            <option value="" disabled>Selecione um Livro</option>
            <?php while ($livro = $livros_result->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo $livro['id_book']; ?>" <?php echo ($livro['id_book'] == $oldBookId) ? 'selected' : ''; ?>>
                    <?php echo $livro['title']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="id_student">Aluno</label>
        <select name="id_student" required>
            <option value="" disabled>Selecione um Aluno</option>
            <?php while ($aluno = $alunos_result->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo $aluno['id_student']; ?>" <?php echo ($aluno['id_student'] == $oldStudentId) ? 'selected' : ''; ?>>
                    <?php echo $aluno['name_student']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="booking_day">Data de Reserva</label>
        <input type="date" name="booking_day" value="<?php echo $oldBookingDay; ?>" required>

        <label for="return_day">Data de Devolução</label>
        <input type="date" name="return_day" value="<?php echo $oldReturnDay; ?>" required>

        <input type="submit" name="update_reserve" value="Salvar Alterações">
    </form>

    <?php
    if (isset($_POST["update_reserve"])) {
        $newBookId = $_POST["id_book"];
        $newStudentId = $_POST["id_student"];
        $newBookingDay = $_POST["booking_day"];
        $newReturnDay = $_POST["return_day"];

        // Atualiza os dados da reserva
        try {
            $update = "UPDATE tb_reserve SET id_book = :id_book, id_student = :id_student, booking_day = :booking_day, return_day = :return_day WHERE id_reserve = :id_reserve";

            $resultado = $conect->prepare($update);
            $resultado->bindParam(':id_reserve', $id_reserve, PDO::PARAM_INT);
            $resultado->bindParam(':id_book', $newBookId, PDO::PARAM_INT);
            $resultado->bindParam(':id_student', $newStudentId, PDO::PARAM_INT);
            $resultado->bindParam(':booking_day', $newBookingDay);
            $resultado->bindParam(':return_day', $newReturnDay);
            $resultado->execute();

            if ($resultado->rowCount() > 0) {
                echo "<div>Dados da reserva atualizados com sucesso!</div>";
                header("Refresh: 3; url=home.php?acao=reservaLista");
                exit();
            } else {
                echo "<div>Não foi possível atualizar</div>";
            }
        } catch (PDOException $e) {
            echo "ERRO DE PDO: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
