<?php
include_once("../config/conexao.php");


if (isset($_POST['Cadastrar'])) {
    $titulo_livro = $_POST['ititulo-livro'];
    $autor = $_POST['iautor'];
    $genero_livro = $_POST['genero'];
    
    $new_book = "INSERT INTO tb_book (title, gender_book, author_book) VALUES (:ititulo-livro, :genero, :iautor)";

    try {
        $result = $conect->prepare($new_book);
        $result->bindParam(':ititulo-livro', $titulo_livro, PDO::PARAM_STR);
        $result->bindParam(':genero', $genero_livro, PDO::PARAM_STR);
        $result->bindParam(':iautor', $autor, PDO::PARAM_STR);
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
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../estilos/cadastrar-livros.css">
  <title>Cadastrar Livros</title>
</head>
<body>
  <header>
    <h1>Explore Conhecimento Ilimitado</h1>
    <p>Acesse Milhares de Livros, Artigos e Recursos Educacionais de Nossa Biblioteca.</p>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Cadastro de Alunos</a></li>
        <li><a href="#">Reserva de Livros</a></li>
        <li><a href="#">Sobre-nós</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <aside>
      <div class="conteiner-form">
        <h2>Adicionar Livros</h2>
        <form action="">
          <label for="ititulo-livro">Título do Livro:</label>
          <input type="text" name="ititulo-livro" id="ititulo-livro">
          <br>
          <label for="iautor">Autor:</label>
          <input type="text" name="iautor" id="iautor">
          <br>
          <label for="igenero">Gênero:</label>
          <select id="genero" name="genero" required>
            <option value="">Selecione um gênero</option>
            <option value="ficcao">Ficção</option>
            <option value="fantasia">Fantasia</option>
            <option value="sci-fi">Sci-Fi</option>
            <option value="romance">Romance</option>
            <option value="aventura">Aventura</option>
            <option value="misterio">Mistério</option>
            <option value="biografia">Biografia</option>
            <option value="autoajuda">Autoajuda</option>
            <option value="historia">História</option>
            <option value="poesia">Poesia</option>
            <option value="literatura-infantojuvenil">Literatura Infantojuvenil</option>
            <option value="ensaios">Ensaios</option>
            <option value="religiao">Religião</option>
            <option value="filosofia">Filosofia</option>
            <option value="educacao">Educação</option>
          </select>
          <br>
          <input type="submit" value="Cadastrar">
        </form>
      </div>
      <div class="conteiner-livros-adicionados">
        <h2>Livros Adicionados</h2>
        <ul>
          <li>Livro 1</li>
          <li>Livro 2</li>
          <li>Livro 3</li>
        </ul>
      </div>
    </aside>
  </main>
</body>
</html>
