<?php
include_once("config/conexao.php");

if (isset($_POST['cadastrar'])) {
    $name_user = $_POST['name_user'];
    $email_user = $_POST['email_user'];
    $password_user = password_hash($_POST['password_user'], PASSWORD_DEFAULT);
    $class = $_POST['class'];
    $booking_day = $_POST['booking_day'];
    $return_day = $_POST['return_day'];

    if (!empty($_FILES['foto_user']['name'])) {
        $formatosPermitidos = array("png", "jpg", "jpeg", "gif");
        $extensao = pathinfo($_FILES['foto_user']['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($extensao), $formatosPermitidos)) {
            $pasta = realpath(__DIR__ . "img/avatares/");
            $temporario = $_FILES['foto_user']['tmp_name'];
            $novoNomeAvatar = uniqid() . ".$extensao";
            $destino = $pasta . DIRECTORY_SEPARATOR . $novoNomeAvatar;

            // Verifique se o diretório existe e é gravável
            if (!is_dir($pasta) || !is_writable($pasta)) {
                echo "Diretório de upload não encontrado ou não é gravável.";
                exit();
            }

            // Verifique se o arquivo pode ser movido
            if (move_uploaded_file($temporario, $destino)) {
                echo "Imagem enviada com sucesso!";
            } else {
                $error = error_get_last();
                echo 'Não foi possível fazer o upload do arquivo. Erro: ' . $error['message'];
                exit();
            }
        } else {
            echo 'Formato de arquivo não permitido.';
            exit();
        }
    } else {
        $novoNomeAvatar = 'avatar_padrao.png';
    }

    $new_user = "INSERT INTO tb_user (name_user, email_user, password_user, class, booking_day, return_day, picture) VALUES (:name_user, :email_user, :password_user, :class, :booking_day, :return_day, :foto_user)";

    try {
        $result = $conect->prepare($new_user);
        $result->bindParam(':name_user', $name_user, PDO::PARAM_STR);
        $result->bindParam(':email_user', $email_user, PDO::PARAM_STR);
        $result->bindParam(':password_user', $password_user, PDO::PARAM_STR);
        $result->bindParam(':class', $class, PDO::PARAM_STR);
        $result->bindParam(':booking_day', $booking_day, PDO::PARAM_STR);
        $result->bindParam(':return_day', $return_day, PDO::PARAM_STR);
        $result->bindParam(':foto_user', $novoNomeAvatar, PDO::PARAM_STR);
        $result->execute();
        $contar = $result->rowCount();
    
        if ($contar > 0) {
            echo "Livro adicionado com sucesso!";
        } else {
            echo "Nenhum livro foi inserido. Verifique se os dados foram corretamente enviados.";
        }
    } catch (PDOException $e) {
        error_log("Erro de PDO: " . $e->getMessage());
        echo "Ocorreu um erro ao tentar inserir os dados: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet">
  <title>Cadastro de Usuário</title>
</head>
<body>
  <form action="cadastro_usuario.php" method="post" enctype="multipart/form-data">
        <label for="name_user">Username:</label>
        <input type="text" name="name_user" id="name_user"><br>
        <label for="email_user">Email:</label>
        <input type="email" name="email_user" id="email_user"><br>
        <label for="password_user">Senha:</label>
        <input type="password" name="password_user" id="password_user"><br>
        <label for="class">Classe:</label>
        <input type="text" name="class" id="class"><br>
        <label for="booking_day">Booking_day:</label>
        <input type="date" name="booking_day" id="booking_day"><br>
        <label for="return_day">Return_day:</label>
        <input type="date" name="return_day" id="return_day"><br>
        <label for="foto_user">Adicionar foto:</label><br>
        <input type="file" name="foto_user" id="foto_user"><br>
        <input type="submit" name="cadastrar" value="Cadastrar-se">
    </form>
</body>
</html>
  