<?php
session_start();

include_once('../config/conexao.php');
                   
// Exibir mensagens com base na ação
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == 'negado') {
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Erro ao Acessar o sistema!</strong> Efetue o login ;(</div>';
       
    } elseif ($acao == 'sair') {
        echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Você acabou de sair do Sistema Multimeios!</strong> :(</div>';
       
    }
}

// Processar o formulário de login
if (isset($_POST['login'])) {
    $login = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);

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
                if (password_verify($senha, $user['senha'])) {
                    // Criar sessão
                    $_SESSION['loginUser'] = $login;
                    $_SESSION['senhaUser'] = $user['registron_student'];

                    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Logado com sucesso!</strong> Você será redirecionado para a agenda :)</div>';

                    header("Refresh: 5; url=paginas/home.php?acao=bemvindo");
                } else {
                    echo '<div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Erro!</strong> Senha incorreta, tente novamente.</div>';
                    header("Refresh: 7; url=index.php");
                }
            } else {
                echo '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Erro!</strong> E-mail não encontrado, verifique seu login ou faça o cadastro.</div>';
                header("Refresh: 7; url=index.php");
            }
        } catch (PDOException $e) {
            // Log the error instead of displaying it to the user
            error_log("ERRO DE LOGIN DO PDO: " . $e->getMessage());
            echo '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Erro!</strong> Ocorreu um erro ao tentar fazer login. Por favor, tente novamente mais tarde.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Erro!</strong> Todos os campos são obrigatórios.</div>';
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
                header("Location: paginas/cadastro_livro.php"); //AQUI É PRA SER A HOME.PHP QUANDO TIVER !!!
                exit();
              }
          ?>
          <form action="" method="post">
            <h2>Acesse sua conta:</h2>
            <input type="text" name="nome" placeholder="Username" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <div class="opcoes">
              <input type="checkbox" name="" id="">
              <p>lembre-se de mim</p>
              <a href="cadastro.php">Registrar um novo acesso</a>
            </div>
            <br>
            <input type="submit" value="Entrar">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>