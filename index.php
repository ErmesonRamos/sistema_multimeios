<?php
include('config/conexao.php'); 

if(isset($_POST['email']) || isset($_POST['senha'])) {
  if(strlen($_POST['email']) == 0){
    echo 'Preencha seu email';
  }else if(strlen($_POST['senha']) == 0){
    echo 'Preencha sua senha';
  }else{
    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $mysqli->real_escape_string($_POST['senha']);

    $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' AND permissao = '$permissao'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    $quantidade = $sql_query->num_rows;
    $usuario = $sql_query->fetch_assoc();

    if($quantidade == 1){
      session_start();      
    
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['permissao'] = $usuario['permissao'];
    }else{
      echo "Falha ao logar. Email ou senha incorretos";
    } 
  }
}


//if('permissao' == 'admin'){
//  header("Location: paginas/conteudo/admin_pages/home.php");
//}else if('permissao'== 'prof'){
//  header("Location: paginas/conteudo/prof_pages/home.php");
//}else{
//  header("Location: paginas/conteudo/aluno_pages/home.php");
//}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Multimeios</title>
</head>
<body>
  <form action="" method="POST">
    <label>Email</label>
    <input type="text" name="email">
    <label>Senha</label>
    <input type="text" name="senha">
    <label>Permissão</label>
    <input type="radio" id="admin" name="permissão" value="Admin">
    <label for="admin">Admin</label>
    <input type="radio" id="prof" name="permissão" value="Prof">
    <label for="prof">Prof</label>
    <input type="radio" id="aluno" name="permissão" value="Aluno">
    <label for="aluno">Aluno</label>
    <button type="submit">Entrar</button>
  </form>
</body>
</html>