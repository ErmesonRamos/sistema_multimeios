<?php
  
  session_start(); 

  // Verifica se o usuário está autenticado (verifica se a sessão está ativa e se o usuário está logado)
  if (isset($_SESSION['loginUser']) && $_SESSION['senhaUser'] === true) {
      // Redireciona para a página home
      header("Location: paginas/home.php");
  }
  
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="estilos/login.css">
  <title>Login da Multimeios</title>
</head>
<body>
  <div class="container">
    <div class="container-conteudo">
      <div class="container-img">
        <div class="conteiner-conteudo-img">
          <img src="img/logotipo-multimeios.png" alt="">
          <h2>MULTIMEIOS JMF</h2>
          <p>Acesse livros e gerencie seus materiais com facilidade. Apoio ao seu aprendizado!</p>
        </div>
      </div>
    <div class="container-form">
      <div class="container-conteudo-form">
        <form role="form" action="" method="post" enctype="multipart/form-data">
          <h2>Acesse sua conta:</h2>
          <input type="email" name="email" placeholder="E-mail" required>
          <input type="password" name="senha" placeholder="Senha" required>
          <div class="opcoes">
            <input type="checkbox" name="lembrar" id="lembrar">
            <p>lembre-se de mim</p>
            <a href="cadastro_adm.php">Registrar um novo acesso</a>
          </div>
          <br>
          <input type="submit" name="login" value="Entrar">
        </form>
        <?php

        if (isset($_GET['acao'])) {
          $acao = $_GET['acao'];
          if ($acao == 'negado') {
              echo '<strong>Erro ao Acessar o sistema!</strong> Efetue o login ;(';
            
          } elseif ($acao == 'sair') {
              echo '<strong>Você fez logout do sistema.</strong>';
            
          }
        }

        if(isset($_POST['login'])){
          $login = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
          $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
      
          // Modifique a consulta para buscar apenas pelo e-mail
          $select = "SELECT * FROM tb_admin WHERE email_admin=:emailLogin";
      
          try {
              $resultLogin = $conect->prepare($select);
              $resultLogin->bindParam(':emailLogin', $login, PDO::PARAM_STR);
              $resultLogin->execute();
      
              if ($resultLogin->rowCount() > 0) {
                  $user = $resultLogin->fetch(PDO::FETCH_ASSOC);
                  // Verifique a senha usando password_verify
                  if (password_verify($senha, $user['password_admin'])) {
                      // A senha está correta
                      $_SESSION['loginUser'] = $login;
                      echo '<strong>Login realizado com sucesso! Aguarde...</strong>';
                      echo "<script>setTimeout(function(){
                        window.location.href = 'paginas/home.php';
                        }, 3000); // Redireciona após 3 segundos (3000 milissegundos)</script>";
                        flush();
                      exit();
                  } else {
                      // A senha está incorreta
                      echo '<strong> Não foi possível realizar o login !  ;( <br> Email ou Senha incorretos / Usuário não encontrado</strong>';
                  }
              } else {
                  // Nenhum usuário encontrado com esse e-mail
                  echo '<strong> Não foi possível realizar o login !  ;( <br> Email ou Senha incorretos / Usuário não encontrado</strong>';
              }
          } catch(PDOException $e) {
              echo '<strong> ERRO DE PDO </strong>' . $e->getMessage();
          }
      }        
        ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>