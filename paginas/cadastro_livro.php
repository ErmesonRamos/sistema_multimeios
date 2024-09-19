<?php
include_once('../conf/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Livros</title>
  <link rel="stylesheet" href="../estilos/cadastro-livro.css"> <!-- Referência ao CSS externo -->
</head>
<body>

  <header>
    <img src="../img/logo-multimeios.png" alt="Logo">
    <nav>
        <li><a href="#">Home</a></li>
        <li><a href="../cadastro_alunos.php">Cadastrar Alunos</a></li>
        <li><a href="../layout/alocacao-livros.html">Reservar Livros</a></li>
    </nav>
  </header>

  <div class="conteiner-background">
    <h1>Explore Conhecimento Ilimitado</h1>
    <p>Acesse Milhares de Livros, Artigos e Recursos Educacionais de Nossa Biblioteca.</p>
  </div>

  <main>
    <div class="main-content">
      <aside>
        <div class="container-form">
          <h2>Cadastre Livros aqui</h2>
          <form role="form" action="" method="post" enctype="multipart/form-data">
            <label for="ititulo-livro">Título do Livro:</label>
            <input type="text" name="ititulo_livro" id="ititulo_livro" required>
            <br>
            <label for="iautor">Autor:</label>
            <input type="text" name="iautor" id="iautor" required>
            <br>
            <label for="igenero">Gênero:</label>
            <select id="igenero" name="igenero" required>
              <option value="">Selecione um gênero</option>
              <option value="Ficcao">Ficção</option>
              <option value="Fantasia">Fantasia</option>
              <option value="Sci-fi">Sci-Fi</option>
              <option value="Romance">Romance</option>
              <option value="Aventura">Aventura</option>
              <option value="Misterio">Mistério</option>
              <option value="Biografia">Biografia</option>
              <option value="Autoajuda">Autoajuda</option>
              <option value="Historia">História</option>
              <option value="Poesia">Poesia</option>
              <option value="Literatura-infantojuvenil">Literatura Infantojuvenil</option>
              <option value="Ensaios">Ensaios</option>
              <option value="Religiao">Religião</option>
              <option value="Filosofia">Filosofia</option>
              <option value="Educacao">Educação</option>
            </select>
            <br>
            <input type="submit" name="cadastrar" value="Cadastrar">
          </form>
          <?php
            if(isset($_POST['cadastrar'])){
                $ititulo_livro = $_POST['ititulo_livro'];
                $iautor = $_POST['iautor'];
                $igenero = $_POST['igenero'];

                //echo $ititulo_livro."<br>";
                //echo $iautor."<br>";
                //echo $genero."<br>";

                $cadastro = "INSERT INTO tb_book (title, author_book, gender_book) VALUES (:ititulo_livro, :iautor, :igenero)";

                try{
                    $result = $conect->prepare($cadastro);
                    $result -> bindParam(':ititulo_livro', $ititulo_livro, PDO::PARAM_STR);
                    $result -> bindParam(':iautor', $iautor, PDO::PARAM_STR);
                    $result -> bindParam(':igenero', $igenero, PDO::PARAM_STR);
                    $result -> execute();

                    $contar = $result->rowCount();

                    if($contar > 0){
                        echo "Livro cadastrado com sucesso !  :)";
                    }else{
                        echo "Ocorreu um erro ao tentar cadastrar o livro !  ;(";
                    }
                }catch(PDOException $e){
                    echo '<strong> ERRO DE PDO </strong>'.$e->getMessage();
                }
            }
          ?>
        </div>
        <div id="tasks-list-container" class="container-form">
          <h2>Livros Cadastrados:</h2>
          <table>
            <tbody>
            <?php
                $select = "SELECT * FROM tb_book ORDER BY id_book DESC LIMIT 5";
                
                try{
                    $result2 = $conect->prepare($select);
                    $cont = 1;
                    $result2->execute();
                    
                    $contar2 = $result2->rowCount();
                    if($contar2 > 0){
                        while($show = $result2->FETCH(PDO::FETCH_OBJ)){

            ?>
            <tr id="task-list" class="task-box template hide">
                <td class="task-title"><?php echo $cont++; ?></td>
                <td><?php echo $show->title; ?></td>
                <td><?php echo $show->author_book; ?></td>
                <td><?php echo $show->gender_book; ?></td>
                <div>
                <a href="editar_livro.php?idEdit=<?php echo $show->id_book; ?>" title="Editar Livro"><ion-icon class="done-btn" name="checkmark-outline"></ion-icon></a>
                <a href="deletar_livro.php?idDel=<?php echo $show->id_book; ?>" onclick="return confirm('Deseja remover o livro?')"><ion-icon class="remove-btn" name="close-outline"></ion-icon></a>
                </div>
            </tr>
            <?php
                        }
                    }else{

                    }
                }catch(PDOException $e){
                    echo '<strong> ERRO DE PDO </strong>'.$e->getMessage();
                }
            ?>
            </tbody>
          </table>
      </aside>
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

  <!-- Scripts do Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
