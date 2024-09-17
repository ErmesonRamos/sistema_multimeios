<?php
include('../config/conexao.php');

if (isset($_POST['register'])) {
    $name = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $class = filter_input(INPUT_POST, 'classe', FILTER_SANITIZE_STRING);

    

    $sql = "INSERT INTO tb_user (name_user, email_user, password_user, class) VALUES (:name_user, :email_user, :password_user, :class_user)";

        try {

        
        $stmt = $conect->prepare($sql);
        $stmt->bindParam(':name_user', $name);
        $stmt->bindParam(':email_user', $email);
        $stmt->bindParam(':password_user', $password);
        $stmt->bindParam(':class_user', $class);
        $stmt->execute();

        $contar = $stmt->rowCount();
        if ($contar > 0) {
          echo '<div class="container">
                  <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h5><i class="icon fas fa-check"></i> OK!</h5>
                      Dados inseridos com sucesso !!!
                  </div>
              </div>';
      } else {
          echo '<div class="container">
                  <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h5><i class="icon fas fa-check"></i> Erro!</h5>
                      Dados não inseridos !!!
                  </div>
              </div>';
      }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Erro ao cadastrar: ' . $e->getMessage() . '</div>';
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../estilos/cadastro.css">
  <title>Cadastro da Multimeios</title>
</head>
<body>
  <div class="container">
    <div class="container-conteudo">
      <div class="container-img">
        <div class="conteiner-conteudo-img">
          <img src="../img/logotipo-multimeios.png" alt="">
          <h2>MULTIMEIOS JMF</h2>
          <p>Acesse livros e gerencie seus materiais com facilidade. Apoio ao seu aprendizado!</p>
        </div>
      </div>
      <div class="container-form">
        <div class="container-conteudo-form">
          <form action="" method="post">
            <h2>Novo por aqui?</h2>
            <input type="text" name="nome" placeholder="Username" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <!-- <input type="text" name="matricula" placeholder="Matricula" required> -->
            <input type="text" name="classe" placeholder="Turma" required>
            <a href="login.php">Voltar para página de entrada</a>
            <br>
            <input type="submit" name="register" value="Registrar">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
