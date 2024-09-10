<?php
include_once("../../config/conexao.php");

if (isset($_POST['new_book'])) {
    $titulo_livro = $_POST['titulo_livro'];
    $autor = $_POST['autor'];
    $genero_livro = $_POST['genero_livro'];

    if (!empty($_FILES['capa_livro']['name'])) {
        $formatosPermitidos = array("png", "jpg", "jpeg", "gif");
        $extensao = pathinfo($_FILES['capa_livro']['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($extensao), $formatosPermitidos)) {
            $pasta = "../../img/capas";
            $temporario = $_FILES['capa_livro']['tmp_name'];
            $novoNomeCapa = uniqid() . ".$extensao";
            $destino = $pasta . $novoNomeCapa;

            // Verifique se o diretório existe
            if (!is_dir($pasta)) {
                echo "Diretório de upload não encontrado.";
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
        $novoNomeCapa = 'capa_padrao.jpeg';
    }

    $new_book = "INSERT INTO tb_book (title, gender_book, author_book, picture) VALUES (:titulo_livro, :genero_livro, :autor, :capa_livro)";

    try {
        $result = $conect->prepare($new_book);
        $result->bindParam(':titulo_livro', $titulo_livro, PDO::PARAM_STR);
        $result->bindParam(':genero_livro', $genero_livro, PDO::PARAM_STR);
        $result->bindParam(':autor', $autor, PDO::PARAM_STR);
        $result->bindParam(':capa_livro', $novoNomeCapa, PDO::PARAM_STR);
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
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/cadastro_livro.css">
  <title>titulo</title>
</head>
<body>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Principais Livros Lidos:</h1>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!--Livros mais lidos-->
    <section>
      <div class="container">
        <div class="book-card">
          <img src="https://via.placeholder.com/250x350?text=Book+1" alt="Book 1">
          <h3>Título do Livro 1</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="book-card">
          <img src="https://via.placeholder.com/250x350?text=Book+2" alt="Book 2">
          <h3>Título do Livro 2</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="book-card">
          <img src="https://via.placeholder.com/250x350?text=Book+3" alt="Book 3">
          <h3>Título do Livro 3</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="book-card">
          <img src="https://via.placeholder.com/250x350?text=Book+4" alt="Book 4">
          <h3>Título do Livro 4</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="book-card">
          <img src="https://via.placeholder.com/250x350?text=Book+5" alt="Book 5">
          <h3>Título do Livro 5</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="book-card">
          <img src="https://via.placeholder.com/250x350?text=Book+6" alt="Book 6">
          <h3>Título do Livro 6</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="book-card">
          <img src="https://via.placeholder.com/250x350?text=Book+7" alt="Book 7">
          <h3>Título do Livro 7</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="book-card">
          <img src="https://via.placeholder.com/250x350?text=Book+7" alt="Book 7">
          <h3>Título do Livro 7</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
      </div>
    </section>

    <h1>Adicionar novo livro</h1>
    <form action="cadastro_livro.php" method="post" enctype="multipart/form-data">
        <label for="titulo_livro">Título:</label>
        <input type="text" name="titulo_livro" id="titulo_livro">
        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor">
        <label for="genero_livro">Gênero:</label>
        <input type="text" name="genero_livro" id="genero_livro">
        <label for="capa_livro">Capa:</label>
        <input type="file" name="capa_livro" id="capa_livro">
        <input type="submit" name="new_book" value="Adicionar novo">
    </form>


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->  
</body>
</html>
  