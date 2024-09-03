<?php
if($_SERVER["REQUEST METHOD"] == "POST"){
    if(isset($_POST["botao_novo"])){
        header("Location:new_book.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <form action="admin_perfil.php" method="POST">
        <button type="submit" nome="botao_novo">Adicionar novo livro ao catalogo</button>
    </form>
</body>
</html>