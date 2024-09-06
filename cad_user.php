<?php
include('config/conexao.php'); // Inclui o arquivo de conexão com o banco de dados

// Verifica se o formulário foi enviado
if (isset($_POST['cadastrar'])) {
    // Recebe os dados do formulário
    $name_user = $_POST['name_user'];
    $email_user = $_POST['email_user'];
    $password_user = password_hash($_POST['password_user'], PASSWORD_DEFAULT); // Usando hash seguro para a senha
    $class = $_POST['class'];
    $booking_day = $_POST['booking_day'];
    $return_day = $_POST['return_day'];

    // Verifica se foi enviado algum arquivo de foto
    if (!empty($_FILES['picture']['name'])) {
        $formatosPermitidos = array("png", "jpg", "jpeg", "gif"); // Formatos permitidos
        $extensao = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION); // Obtém a extensão do arquivo

        // Verifica se a extensão do arquivo está nos formatos permitidos
        if (in_array(strtolower($extensao), $formatosPermitidos)) {
            $pasta = "img/avatares"; // Define o diretório para upload
            $temporario = $_FILES['picture']['tmp_name']; // Caminho temporário do arquivo
            $novoNomeAvatar = uniqid() . ".$extensao"; // Gera um nome único para o arquivo

            // Move o arquivo para o diretório de imagens
            if (move_uploaded_file($temporario, $pasta . $novoNomeAvatar)) {
                // Sucesso no upload da imagem
            } else {
                echo '<div class="container">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Erro!</h5>
                            Não foi possível fazer o upload do arquivo.
                        </div>
                    </div>';
                exit(); // Termina a execução do script após o erro
            }
        } else {
            echo '<div class="container">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Formato Inválido!</h5>
                        Formato de arquivo não permitido.
                    </div>
                </div>';
            exit(); // Termina a execução do script após o erro
        }
    } else {
        // Define um avatar padrão caso não seja enviado nenhum arquivo de foto
        $novoNomeAvatar = 'avatar_padrao.png'; // Nome do arquivo de avatar padrão
    }

    // Prepara a consulta SQL para inserção dos dados do usuário
    $cadastro = "INSERT INTO tb_user (name_user, email_user, password_user, picture, class, booking_day, return_day) VALUES (:name_user, :email_user, :password_user, :picture, :class, :booking_day, :return_day)";

    try {
        $result = $conect->prepare($cadastro);
        $result->bindParam(':name_user', $name_user, PDO::PARAM_STR);
        $result->bindParam(':email_user', $email_user, PDO::PARAM_STR);
        $result->bindParam(':password_user', $password_user, PDO::PARAM_STR);
        $result->bindParam(':picture', $novoNomeAvatar, PDO::PARAM_STR);
        $result->bindParam(':class', $class, PDO::PARAM_STR);
        $result->bindParam(':booking_day', $booking_day, PDO::PARAM_STR);
        $result->bindParam(':return_day', $return_day, PDO::PARAM_STR);
        $result->execute();
        $contar = $result->rowCount();

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
        // Loga a mensagem de erro em vez de exibi-la para o usuário
        error_log("ERRO DE PDO: " . $e->getMessage());
        echo '<div class="container">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Erro!</h5>
                    Ocorreu um erro ao tentar inserir os dados.
                </div>
            </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt_br">
<head>
  <title>Sistema Multimeios | Cadastro de Usuário</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div>
  <div>
    <div>
      <p>Cadastre todos os dados para ter acesso ao sistema</p>

      <form action="" method="post">
      <div>
        <label>Foto do usuário</label>
        <div>
            <div>
            <input type="file" name="picture" id="picture">
            <label>Arquivo de imagem</label>
            </div>
            
        </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="name_user" class="form-control" placeholder="Digite seu Nome..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email_user" class="form-control" placeholder="Digite seu E-mail..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" name="password_user" class="form-control" placeholder="Digite sua Senha..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="text" name="class" class="form-control" placeholder="Digite sua Classe/Turma..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <label>Booking Day...</label>
          <input type="date" name="booking_day" class="form-control" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <label>Return Day...</label>
          <input type="date" name="return_day" class="form-control" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-12" style="margin-bottom: 25px">
            <button type="submit" name="cadastrar" class="btn btn-primary btn-block">Finalizar Cadastro</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
        <a href="index.php" class="text-center">Voltar para o Login!</a>
      </p>
    </div>
  </div>
</div>

</body>
</html>