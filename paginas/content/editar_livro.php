<?php
include('../../conf/conexao.php');

// Verifica se o ID foi passado
if (isset($_GET['idEdit'])) {
    $id = $_GET['idEdit'];

    // Busca os dados do livro a ser editado
    $select = "SELECT * FROM tb_book WHERE id_book=:id";
    try {
        $result = $conect->prepare($select);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        $contar = $result->rowCount();
        if ($contar > 0) {
            $show = $result->FETCH(PDO::FETCH_OBJ);
        } else {
            echo "Livro não encontrado!";
            exit();
        }
    } catch (PDOException $e) {
        echo '<strong> ERRO DE PDO </strong>' . $e->getMessage();
    }
} else {
    echo "ID do livro não informado!";
    exit();
}

// Atualiza os dados do livro
if (isset($_POST['editar'])) {
    $ititulo_livro = $_POST['ititulo_livro'];
    $iautor = $_POST['iautor'];
    $genero = $_POST['genero'];

    $update = "UPDATE tb_book SET title=:ititulo_livro, author_book=:iautor, gender_book=:genero WHERE id_book=:id";

    try {
        $result = $conect->prepare($update);
        $result->bindParam(':ititulo_livro', $ititulo_livro, PDO::PARAM_STR);
        $result->bindParam(':iautor', $iautor, PDO::PARAM_STR);
        $result->bindParam(':genero', $genero, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        echo "Livro atualizado com sucesso!";
        header("Location: home.php");
        exit();
    } catch (PDOException $e) {
        echo '<strong> ERRO DE PDO </strong>' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link rel="stylesheet" href="../../estilos/cadastro-livro.css">
</head>
<body>
    <header>
        <img src="../../img/logo-multimeios.png" alt="Logo">
        <nav>
            <li><a href="#">Home</a></li>
            <li><a href="../../cadastro_alunos.php">Cadastrar Alunos</a></li>
            <li><a href="../../layout/alocacao-livros.html">Reservar Livros</a></li>
        </nav>
    </header>

    <main>
        <div class="container-form">
            <h2>Editar Livro</h2>
            <form action="" method="post">
                <label for="ititulo_livro">Título do Livro:</label>
                <input type="text" name="ititulo_livro" id="ititulo_livro" value="<?php echo $show->title; ?>" required>
                <br>
                <label for="iautor">Autor:</label>
                <input type="text" name="iautor" id="iautor" value="<?php echo $show->author_book; ?>" required>
                <br>
                <label for="igenero">Gênero:</label>
                <select id="igenero" name="genero" required>
                    <option value="">Selecione um gênero</option>
                    <option value="ficcao" <?php if ($show->gender_book == 'ficcao') echo 'selected'; ?>>Ficção</option>
                    <option value="fantasia" <?php if ($show->gender_book == 'fantasia') echo 'selected'; ?>>Fantasia</option>
                    <option value="sci-fi" <?php if ($show->gender_book == 'sci-fi') echo 'selected'; ?>>Sci-Fi</option>
                    <option value="romance" <?php if ($show->gender_book == 'romance') echo 'selected'; ?>>Romance</option>
                    <option value="aventura" <?php if ($show->gender_book == 'aventura') echo 'selected'; ?>>Aventura</option>
                    <option value="misterio" <?php if ($show->gender_book == 'misterio') echo 'selected'; ?>>Mistério</option>
                    <option value="biografia" <?php if ($show->gender_book == 'biografia') echo 'selected'; ?>>Biografia</option>
                    <option value="autoajuda" <?php if ($show->gender_book == 'autoajuda') echo 'selected'; ?>>Autoajuda</option>
                    <option value="historia" <?php if ($show->gender_book == 'historia') echo 'selected'; ?>>História</option>
                    <option value="poesia" <?php if ($show->gender_book == 'poesia') echo 'selected'; ?>>Poesia</option>
                    <option value="literatura-infantojuvenil" <?php if ($show->gender_book == 'literatura-infantojuvenil') echo 'selected'; ?>>Literatura Infantojuvenil</option>
                    <option value="ensaios" <?php if ($show->gender_book == 'ensaios') echo 'selected'; ?>>Ensaios</option>
                    <option value="religiao" <?php if ($show->gender_book == 'religiao') echo 'selected'; ?>>Religião</option>
                    <option value="filosofia" <?php if ($show->gender_book == 'filosofia') echo 'selected'; ?>>Filosofia</option>
                    <option value="educacao" <?php if ($show->gender_book == 'educacao') echo 'selected'; ?>>Educação</option>
                </select>
                <br>
                <input type="submit" name="editar" value="Salvar Alterações">
            </form>
        </div>
    </main>

    <footer>
        <p>© 2024 EEEP José Maria Falcão. Todos os direitos reservados</p>
        <ul>
            <li><a href="#">Sobre nós</a></li>
            <li><a href="#">Termos de Uso</a></li>
            <li><a href="#">Políticas de Privicidade</a></li>
        </ul>
    </footer>
</body>
</html>
