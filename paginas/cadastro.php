<?php
include('../config/conexao.php'); // Inclui o arquivo de conexão com o banco de dados

// Verifica se o formulário foi enviado
if (isset($_POST['Registrar'])) {
    // Recebe os dados do formulário
    $name_user = $_POST['nome'];
    $email_user = $_POST['email'];
    $password_user = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Usando hash seguro para a senha
    $matricula = $_POST['matricula'];
    $classe = $_POST['classe'];

    // Verifica se foi enviado algum arquivo de foto
    if (!empty($_FILES['foto']['name'])) {
        $formatosPermitidos = array("png", "jpg", "jpeg", "gif"); // Formatos permitidos
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION); // Obtém a extensão do arquivo

        // Verifica se a extensão do arquivo está nos formatos permitidos
        if (in_array(strtolower($extensao), $formatosPermitidos)) {
            $pasta = "img/avatares/"; // Define o diretório para upload
            $temporario = $_FILES['foto']['tmp_name']; // Caminho temporário do arquivo
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
    $cadastro = "INSERT INTO tb_user (registron_user, name_user, email_user, password_user, class, picture) VALUES (:matricula, :nome, :email, :senha, :classe, :foto)";

    try {
        $result = $conect->prepare($cadastro);
        $result->bindParam(':matricula', $matricula, PDO::PARAM_STR);
        $result->bindParam(':nome', $nome, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':senha', $senha, PDO::PARAM_STR);
        $result->bindParam(':classe', $classe, PDO::PARAM_STR);
        $result->bindParam(':foto', $novoNomeAvatar, PDO::PARAM_STR);
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
            <input type="text" name="matricula" placeholder="Matricula" required>
            <input type="text" name="classe" placeholder="Turma" required>
            <a href="login.html">Voltar para pagína de entrada</a>
            <br>
            <input type="submit" value="Registrar">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>