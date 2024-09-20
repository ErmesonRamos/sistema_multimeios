<?php
include_once('conf/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Alunos</title>
  <link rel="stylesheet" href="estilos/cadastro-alunos.css"> 
</head>
<body>

  <header>
    <img src="img/logo-multimeios.png" alt="Logo">
    <nav>
        <li><a href="paginas/cadastro_livro.php">Home</a></li>
        <li><a href="#">Cadastrar Alunos</a></li>
        <li><a href="layout/alocacao-livros.html">Reservar Livros</a></li>
    </nav>
  </header>

  <div>
    <a href="index.php">Ir para o Login</a>
  </div>
  <main>
    <div class="main-content">
      <aside>
        <div class="container-form">
          <h2>Cadastro de Administradores</h2>
          <form role="form" action="" method="post" enctype="multipart/form-data">
            <label for="anome">Nome:</label>
            <input type="text" name="anome" id="anome">
            <br>
            <label for="aemail">Email:</label>
            <input type="email" name="aemail" id="aemail">
            <br>
            <label for="asenha">Senha:</label>
            <input type="password" name="asenha" id="asenha">
            <br>
            <input type="submit" name="cadastrar" value="Cadastrar">
          </form>
          <?php
            if(isset($_POST['cadastrar'])){
                $anome = filter_input(INPUT_POST, 'anome', FILTER_SANITIZE_STRING);
                $aemail = filter_input(INPUT_POST, 'aemail', FILTER_SANITIZE_STRING);
                $asenha = password_hash($_POST['asenha'], PASSWORD_DEFAULT);

                // echo $inome."<br>";
                // echo $iemail."<br>";
                // echo $isenha."<br>";
                // echo $iturma."<br>";

                $cadastro = "INSERT INTO tb_admin (name_admin, email_admin, password_admin) VALUES (:anome, :aemail, :asenha)";

                try{
                    $result = $conect->prepare($cadastro);
                    $result -> bindParam(':anome', $anome, PDO::PARAM_STR);
                    $result -> bindParam(':aemail', $aemail, PDO::PARAM_STR);
                    $result -> bindParam(':asenha', $asenha, PDO::PARAM_STR);
                    $result -> execute();

                    $contar = $result->rowCount();

                    if($contar > 0){
                        echo "Cadastrado com sucesso !  :)";
                    }else{
                        echo "Ocorreu um erro ao tentar cadastrar !  ;(";
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