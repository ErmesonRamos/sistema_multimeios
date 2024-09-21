<?php
include_once('../conf/conexao.php');
?>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Livros</title>
  <link rel="stylesheet" href="../estilos/cadastro-livro.css"> <!-- Referência ao CSS externo -->
</head>
<body>

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
              <option value="Outro">Outro</option>
            </select>
            <br>
            <label for="icapa">Capa ou Ilustração</label>
            <input type="file" name="icapa" id="icapa">
            <input type="submit" name="cadastrar" value="Cadastrar">
          </form>
          <?php
            if(isset($_POST['cadastrar'])){
                $ititulo_livro = $_POST['ititulo_livro'];
                $iautor = $_POST['iautor'];
                $igenero = $_POST['igenero'];
                
                if(isset($_FILES['icapa'])){
        

                  if (!empty($_FILES['icapa']['name'])) {
                      $formatosP = array("png", "jpg", "jpeg", "JPG");
                      $extensao = pathinfo($_FILES['icapa']['name'], PATHINFO_EXTENSION);
          
                      if (in_array(strtolower($extensao), $formatosP)) {
                          $pastaDestino = "../img/capas_livros";
                          $pastaTemp = $_FILES['icapa']['tmp_name'];
                          $newnameCapa = uniqid() . ".$extensao";
          
                          if (move_uploaded_file($pastaTemp, $pastaDestino . $newnameCapa)) {
                          } else {
                              echo '<strong>Não foi possível fazer o upload do arquivo.</strong>';
                              exit();
                          }
                      } else {
                          echo '<strong>Formato de arquivo não permitido.</strong>';
                          exit();
                      }
                  } else {
                      $newnameCapa = 'capa_padrao.png';
                  }
              }else{
                  echo '<strong>foto nao enviada!!!!!</strong>';
              }
                
                $cadastro = "INSERT INTO tb_book (title, author_book, gender_book, book_cover) VALUES (:ititulo_livro, :iautor, :igenero, :icapa)";

                try{
                  $result = $conect->prepare($cadastro);
                  $result -> bindParam(':ititulo_livro', $ititulo_livro, PDO::PARAM_STR);
                  $result -> bindParam(':iautor', $iautor, PDO::PARAM_STR);
                  $result -> bindParam(':igenero', $igenero, PDO::PARAM_STR);
                  $result -> bindParam(':icapa', $newnameCapa, PDO::PARAM_STR);
                  $result -> execute();

                  $contar = $result->rowCount();

                  if($contar > 0){
                      echo "Livro cadastrado com sucesso !  :)";
                      echo "<script>setTimeout(function(){
                      window.location.href = '../home.php?acao=cadastrarLivros';
                      }, 3000); // Redireciona após 3 segundos (3000 milissegundos)</script>";
                      flush();
                  }else{
                      echo "Ocorreu um erro ao tentar cadastrar o livro !  ;(";
                  }
              }catch(PDOException $e){
                  echo '<strong> ERRO DE PDO </strong>'.$e->getMessage();
              }
            }
          ?>
        </div>
      </aside>
    </div>
  </main>
  <!-- Scripts do Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
