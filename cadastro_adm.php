<?php
include_once('conf/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Administradores</title>
  <link rel="stylesheet" href="estilos/cadastro.css">
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
            <h2>Crie sua conta:</h2>
            <input type="text" name="anome" placeholder="Nome" required>
            <input type="email" name="aemail" placeholder="E-mail" required>
            <input type="password" name="asenha" placeholder="Senha" required>
        </div>
      
        <input type="submit" name="cadastrar" value="Cadastrar-se">
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
                      echo 'Cadastrado com sucesso !  :)<br>
                      <strong>Faça login para acessar o sistema!</strong><br>
                      Aguarde, você está sendo redirecionado...';
                      echo "<script>setTimeout(function(){
                      window.location.href = 'index.php';
                      }, 3000); // Redireciona após 3 segundos (3000 milissegundos)</script>";
                      // Envia todo o conteúdo para o navegador imediatamente
                      flush(); // Força o envio do conteúdo para o navegador
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

  <!-- Scripts do Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>