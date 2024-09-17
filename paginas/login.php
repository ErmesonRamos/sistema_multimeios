<?php
session_start();
include('config/conexao.php');

if (isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

    if ($email && $password) {
        $sql = "SELECT * FROM tb_user WHERE email_user = :email";
        $stmt = $conect->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password_user'])) {
                $_SESSION['user_id'] = $user['registron_user'];
                $_SESSION['user_name'] = $user['name_user'];
                echo '<div class="alert alert-success">Login bem-sucedido! Redirecionando...</div>';
                header("Refresh: 2; url=home.php");
                exit();
            } else {
                echo '<div class="alert alert-danger">Senha incorreta.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">E-mail não encontrado.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Todos os campos são obrigatórios!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../estilos/login.css">
  <title>Login da Multimeios</title>
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
          <?php
              if (isset($_SESSION['loginUser'])) {
                header("Location: paginas/home.php");
                exit();
              }
          ?>
          <form action="" method="post">
            <h2>Acesse sua conta:</h2>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <div class="opcoes">
              <input type="checkbox" name="" id="">
              <p>lembre-se de mim</p>
              <a href="cadastro.php">Registrar um novo acesso</a>
            </div>
            <br>
            <input type="submit" name="login" value="Entrar">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
