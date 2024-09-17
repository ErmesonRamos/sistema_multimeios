<?php
session_start();
include('../config/conexao.php');

// Verifica se já está logado
if (isset($_SESSION['loginUser'])) {
    header("Location: paginas/home.php?acao=bemvindo");
    exit();
}

// Exibir mensagens com base na ação
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == 'negado') {
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Erro ao Acessar o sistema!</strong> Efetue o login ;(</div>';
    } elseif ($acao == 'sair') {
        echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Você acabou de sair da Agenda Eletrônica!</strong> :(</div>';
    }
}

// Processar o formulário de login
if (isset($_POST['login'])) {
    $login = filter_input(INPUT_POST, 'email_user', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha_user', FILTER_DEFAULT);

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
                if (password_verify($senha, $user['password_user'])) {
                    // Criar sessão
                    $_SESSION['loginUser'] = $login;
                    $_SESSION['senhaUser'] = $user['registron_user'];

                    header("Location: paginas/home.php?acao=bemvindo");
                    exit();
                } else {
                    $error = 'Senha incorreta, tente novamente.';
                }
            } else {
                $error = 'E-mail não encontrado, verifique seu login ou faça o cadastro.';
            }
        } catch (PDOException $e) {
            error_log("ERRO DE LOGIN DO PDO: " . $e->getMessage());
            $error = 'Ocorreu um erro ao tentar fazer login. Por favor, tente novamente mais tarde.';
        }
    } else {
        $error = 'Todos os campos são obrigatórios.';
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
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Erro!</strong> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <h2>Acesse sua conta:</h2>
                        <input type="email" name="email_user" placeholder="E-mail" required>
                        <input type="password" name="senha_user" placeholder="Senha" required>
                        <div class="opcoes">
                            <input type="checkbox" name="" id="">
                            <p>lembre-se de mim</p>
                            <a href="cadastro.php">Registrar um novo acesso</a>
                        </div>
                        <br>
                        <input type="submit" name="login" value="Entrar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
