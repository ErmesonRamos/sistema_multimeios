<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>New Agenda 2.0 | Cadastro de Usuário</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="cad_user.php" style="font-size: 25px"><b>Cadastre-se para ter acesso</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Cadastre todos os dados para ter acesso a agenda</p>

      <form action="cad_user.php" method="post" enctype="multipart/form-data">
     
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
          <input type="text" name="classe" class="form-control" placeholder="Digite sua Classe..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <label>Booking day: </label>
          <input type="date" name="booking_day" class="form-control" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <label>Return day: </label>
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
      <?php
      include('config/conexao.php'); // Inclui o arquivo de conexão com o banco de dados

      // Verifica se o formulário foi enviado
      if (isset($_POST['botao'])) {
          // Recebe os dados do formulário
          $nome = $_POST['nome'];
          $email = $_POST['email'];
          $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Usando hash seguro para a senha
          $classe = $_POST['classe'];
          $booking_day = $_POST['booking_day'];
          $return_day = $_POST['return_day'];

          $cadastro = "INSERT INTO tb_user (name_user, email_user, password_user, class, booking_day, return_day) VALUES (:nome, :email, :senha, :classe, :booking_day, :return_day)";

          try {
              $result = $conect->prepare($cadastro);
              $result->bindParam(':nome', $nome, PDO::PARAM_STR);
              $result->bindParam(':email', $email, PDO::PARAM_STR);
              $result->bindParam(':senha', $senha, PDO::PARAM_STR);
              $result->bindParam(':classe', $classe, PDO::PARAM_STR);
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
     
      <!-- /.social-auth-links -->

      
      <p style="text-align: center;">
        <a href="index.php" class="text-center">Voltar para o Login!</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>