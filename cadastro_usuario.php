<?php
include('config/conexao.php'); // Inclui o arquivo de conexão com o banco de dados

// Verifica se o formulário foi enviado
if (isset($_POST['botao'])) {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Usando hash seguro para a senha
    $class = $_POST['class'];
    $booking_day = $_POST['booking_day'];
    $return_day = $_POST['return_day'];

    // Prepara a consulta SQL para inserção dos dados do usuário
    $cadastro = "INSERT INTO tb_user (name_user, email_user, password_user, class, booking_day, return_day) VALUES (:nome, :email, :senha, :class, :booking_day, :return_day)";

    try {
        $result = $conect->prepare($cadastro);
        $result->bindParam(':nome', $nome, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':senha', $senha, PDO::PARAM_STR);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
<form action="cadastro_usuario.php" method="post">
      <div>
        <div class="input-group mb-3">
          <input type="text" name="nome" class="form-control" placeholder="Digite seu Nome..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Digite seu E-mail..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="senha" class="form-control" placeholder="Digite sua Senha..." required>
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
            <button type="submit" name="botao" class="btn btn-primary btn-block">Finalizar Cadastro</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
</body>
</html>