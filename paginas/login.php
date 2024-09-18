<?php
if (isset($_POST['login'])) {
    $login = filter_input(INPUT_POST, 'emailLogin', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senhaLogin', FILTER_DEFAULT);

    if ($login && $senha) {
        $select = "SELECT * FROM tb_user WHERE email_user = :emailLogin";

        try {
            $resultLogin = $conect->prepare($select);
            $resultLogin->bindParam(':emailLogin', $login, PDO::PARAM_STR);
            $resultLogin->execute();

            $verificar = $resultLogin->rowCount();
            if ($verificar > 0) {
                $user = $resultLogin->fetch(PDO::FETCH_ASSOC);

                // Verifica a senha
                if (password_verify($senha, $user['senha_user'])) { // Ajuste aqui se necessário
                    $_SESSION['login'] = $login;
                    $_SESSION['senhaLogin'] = $user['registron_user'];

                    echo '<div class="alert alert-success">Logado com sucesso!</div>';
                    header("Location: paginas/home.php?acao=bemvindo");
                    exit();
                } else {
                    echo '<div class="alert alert-danger">Senha incorreta, tente novamente.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">E-mail não encontrado, verifique seu login ou faça o cadastro.</div>';
            }
        } catch (PDOException $e) {
            error_log("ERRO DE LOGIN DO PDO: " . $e->getMessage());
            echo '<div class="alert alert-danger">Ocorreu um erro ao tentar fazer login.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Todos os campos são obrigatórios.</div>';
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
              if (isset($_SESSION['login'])) {
                header("Location: home.php");
                exit();
              }
          ?>
          <form action="" method="post">
            <h2>Acesse sua conta:</h2>
            <input type="email" name="emailLogin" placeholder="E-mail" required>
            <input type="password" name="senhaLogin" placeholder="Senha" required>
            <div class="opcoes">
              <input type="checkbox" name="" id="">
              <p>lembre-se de mim</p>
              <a href="cadastro.php">Registrar um novo acesso</a>
            </div>
            <br>
            <input type="submit" value="login">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>