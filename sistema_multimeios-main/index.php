<?php
ob_start(); //armazena dados em cache
session_start();
if(isset($_SESSION['loginUser']) && (isset($_SESSION['senhaUser']))){
    header("Location: cadastro_livro.php");
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
          <form action="" method="post">
            <h2>Acesse sua conta:</h2>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <div class="opcoes">
              <input type="checkbox" name="" id="">
              <p>lembre-se de mim</p>
              <a href="cadastro_alunos.php">Registrar um novo acesso</a>
            </div>
            <br>
            <input type="submit" name="login" value="Entrar">
          </form>
          <?php
          include_once('conf/conexao.php');
          if(isset($_POST['login'])){
            $login = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
            $senha = password_hash(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT));
            $select = "SELECT * FROM tb_user WHERE email_user=:emailLogin AND password_user=:senhaLogin";
            
            try{
                $resultLogin = $conect->prepare($select);
                $resultLogin->bindParam(':emailLogin', $login, PDO::PARAM_STR);
                $resultLogin->bindParam(':senhaLogin', $senha, PDO::PARAM_STR);
                $resultLogin->execute();

                $verificar = $resultLogin->rowCount();
                if($verificar > 0){
                    $login = $_POST['email'];
                    $senha = $_POST['senha'];
                    $_SESSION['loginUser'] = $login;
                    $_SESSION['senhaUser'] = $senha;

                    echo '<strong>Login realizado com sucesso! Aguarde...</strong>';
                    header("Location: cadastro_alunos.php");
                    //header("Location: paginas/home.php?acao=bemvindo");

                }else{
                    echo '<strong> Não foi possível realizar o login !  ;( <br> Email ou Senha incorretos / Usuário não encontrado</strong>';
                }
            }catch(PDOException $e){
                echo '<strong> ERRO DE PDO </strong>'.$e->getMessage();
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>