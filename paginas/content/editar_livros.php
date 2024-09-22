<?php
include_once('../conf/conexao.php');
$id_book = $_GET['idUpdate'];
$select = "SELECT * FROM tb_book WHERE id_book=:id_book";
$resultado = $conect -> prepare($select);
$resultado -> bindParam(':id_book', $id_book, PDO::PARAM_INT);
$resultado -> execute();

if($resultado -> rowCount() > 0){
    $fetch = $resultado -> fetch(PDO::FETCH_OBJ);
    $oldTitulo = $fetch -> title;
    $oldAutor = $fetch -> author_book;
    $oldGenero = $fetch -> gender_book;
    $oldCapa = $fetch -> book_cover;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link rel="stylesheet" href="../estilos/updates.css">
</head>
<body>
    <form role="form" action="" method="post" enctype="multipart/form-data">
    <h2>Editar Dados do Livro</h2>
        <input type="text" value=<?php echo "$id_book" ?> name="id_book" hidden required>
        
        <label for="title">Título</label>
        <input type="text" id="title" value=<?php echo $oldTitulo ?> name="title" placeholder="Título">

        <label for="author_book">Autor</label>
        <input type="text" id="author_book" value=<?php echo $oldAutor ?> name="author_book" placeholder="Autor">

        <label for="gender_book">Gênero:</label>
        <select id="gender_book" name="gender_book">
            <option value="" disabled selected>Selecione um gênero</option>
            <option value="Ficcao">Ficção</option>
            <option value="Fantasia">Fantasia</option>
            <option value="Sci-fi">Sci-Fi</option>
            <option value="Romance">Romance</option>
            <option value="Aventura">Aventura</option>
            <option value="Misterio">Mistério</option>
            <option value="Biografia">Biografia</option>
            <option value="Autoajuda">Autoajuda</option>
            <option value="Historia">História</option>
            <option value="Poesia">Poesia</option>
            <option value="Literatura-infantojuvenil">Literatura Infantojuvenil</option>
            <option value="Ensaios">Ensaios</option>
            <option value="Religiao">Religião</option>
            <option value="Filosofia">Filosofia</option>
            <option value="Educacao">Educação</option>
            <option value="Outro">Outro</option>
        </select>
        
        <label for="book_cover">Capa</label>
        <input type="file" name="book_cover" id="book_cover">
        <label for="book_cover">Escolher arquivo</label>
        
        <input type="submit" name="update_book" value="Salvar Alterações">
    </form>
    <?php
    if(isset($_GET['idUpdate'])){
    $id_book = $_GET['idUpdate'];

    if(isset($_POST["update_book"])){
        $newTitulo = $_POST["title"];
        $newAutor = $_POST["author_book"];
        
        if(isset($_POST["gender_book"]) && !empty($_POST["gender_book"])){
            $newGenero = $_POST["gender_book"];
        } else {
            $newGenero = $oldGenero; // Mantém o gênero antigo se não for enviado
        }
    
            if(isset($_FILES['book_cover'])){

              if(!empty($_FILES['book_cover']['name'])){
                  $formatosP = array("png", "jpeg", "jpg");
                  $extensao = pathinfo($_FILES['book_cover']['name'], PATHINFO_EXTENSION);

                  if(in_array(strtolower($extensao), $formatosP)){
                      $pastaTemp = $_FILES['book_cover']['tmp_name'];
                      $pasta = "../img/capas_livros/";
                      $newCapa = uniqid() . ".$extensao";

                      if(file_exists($pasta . $pastaTemp)){
                          unlink($pasta . $oldCapa);
                      }
                      if(move_uploaded_file($pastaTemp, $pasta . $newCapa)){

                      }else{
                          echo"Falha no upload de arquivo!";
                          exit();
                      }
                  }else{
                      echo"Formato nao permitido!";
                      exit();
                  }
              }else{$newCapa = $oldCapa;}
                
            }

            if(empty($_POST['title'])){
              $newTitulo = $oldTitulo;
            }
            if(empty($_POST['author_book'])){
              $newAutor = $oldAutor;
            }

            try{
                $update = "UPDATE tb_book SET title=:title, author_book=:author_book, gender_book=:gender_book, book_cover=:book_cover WHERE id_book = :id_book";
        
                $resultado = $conect->prepare($update);
                $resultado->bindParam(':id_book', $id_book, PDO::PARAM_INT);
                $resultado->bindParam(':title', $newTitulo, PDO::PARAM_STR);
                $resultado->bindParam(':author_book', $newAutor, PDO::PARAM_STR);
                $resultado->bindParam(':gender_book', $newGenero, PDO::PARAM_STR);
                $resultado->bindParam(':book_cover', $newCapa, PDO::PARAM_STR);
                $resultado->execute();
        
                if($resultado->rowCount() > 0){
                    echo "<div>Dados do livro atualizados com sucesso!</div>";
                    header("Refresh: 3; url=home.php?acao=listaLivros");
                    exit();
                }else{
                    echo "<div>Não foi possivel atualizar</div>";
                }
                if ($newTitulo !== $newTitulo || $newAutor !== $newAutor) {
                    header("Refresh: 3; url=home.php?acao=listaLivros"); // Redireciona para sair se titulo ou autor foram alterados
                    exit(); // Garante que o redirecionamento ocorra
                } else {
                    header("Refresh: 3; url=home.php?acao=listaLivros");
                    exit();
                }
            }catch(PDOException $e){
                echo "ERRO DE PDO: ". $e->getMessage();
            }
    }
}else{
    header("Location: ../home.php");
}
?>
</body>
</html>