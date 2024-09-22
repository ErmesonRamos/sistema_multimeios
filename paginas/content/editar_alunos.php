<?php
include_once('../conf/conexao.php');
$id_student = $_GET['idUpdate'];
$select = "SELECT * FROM tb_student WHERE id_student=:id_student";
$resultado = $conect -> prepare($select);
$resultado -> bindParam(':id_student', $id_student, PDO::PARAM_INT);
$resultado -> execute();

if($resultado -> rowCount() > 0){
    $fetch = $resultado -> fetch(PDO::FETCH_OBJ);
    $oldNome = $fetch -> name_student;
    $oldEmail = $fetch -> email_student;
    $oldTurma = $fetch -> class;
    $oldFoto = $fetch -> photo;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="../estilos/updates.css">
</head>
<body>
    <form role="form" action="" method="post" enctype="multipart/form-data">
    <h2>Editar Dados do Aluno</h2>
        <input type="text" value=<?php echo "$id_student" ?> name="id_student" hidden required>
        
        <label for="name_student">Nome</label>
        <input type="text" id="_student" value=<?php echo $oldNome ?> name="name_student" placeholder="Nome">

        <label for="email_student">Email</label>
        <input type="email" id="email_student" value=<?php echo $oldEmail ?> name="email_student" placeholder="Email">

        <label for="class">Turma</label>
            <select name="class" id="class">
              <option value="" disabled selected>Selecione uma turma</option>
              <option value="1º Ano Informatica">1º Ano Informatica</option>
              <option value="1º Ano Administração">1º Ano Administração</option>
              <option value="1º Ano Logística">1º Ano Logística</option>
              <option value="1º Ano Enfermagem">1º Ano Enfermagem</option>
              <option value="2º Ano Informatica">2º Ano Informatica</option>
              <option value="2º Ano Comercio">2º Ano Comercio</option>
              <option value="2º Ano Enfermagem">2º Ano Enfermagem</option>
              <option value="2º Ano Secretaria">2º Ano Secretaria</option>
              <option value="3º Ano Informatica">3º Ano Informatica</option>
              <option value="3º Ano Enfermagem">3º Ano Enfermagem</option>
              <option value="3º Ano Administração">3º Ano Administração</option>
              <option value="3º Ano Contabilidade">3º Ano Contabilidade</option>
        </select>
        
        <label for="photo">Foto</label>
        <input type="file" name="photo" id="photo">
        <label for="photo">Escolher arquivo</label>
        
        <input type="submit" name="update_student" value="Salvar Alterações">
    </form>
    <?php
    if(isset($_GET['idUpdate'])){
    $id_student = $_GET['idUpdate'];

    if(isset($_POST["update_student"])){
        $newNome = $_POST["name_student"];
        $newEmail = $_POST["email_student"];
        
        if(isset($_POST["class"]) && !empty($_POST["class"])){
            $newTurma = $_POST["class"];
        } else {
            $newTurma = $oldTurma;
        }
    
            if(isset($_FILES['photo'])){

              if(!empty($_FILES['photo']['name'])){
                  $formatosP = array("png", "jpeg", "jpg");
                  $extensao = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

                  if(in_array(strtolower($extensao), $formatosP)){
                      $pastaTemp = $_FILES['photo']['tmp_name'];
                      $pasta = "../img/fotos_alunos/";
                      $newFoto = uniqid() . ".$extensao";

                      if(file_exists($pasta . $pastaTemp)){
                          unlink($pasta . $oldFoto);
                      }
                      if(move_uploaded_file($pastaTemp, $pasta . $newFoto)){

                      }else{
                          echo"Falha no upload de arquivo!";
                          exit();
                      }
                  }else{
                      echo"Formato nao permitido!";
                      exit();
                  }
              }else{$newFoto = $oldFoto;}
                
            }

            if(empty($_POST['name_student'])){
              $newNome = $oldNome;
            }
            if(empty($_POST['email_student'])){
              $newEmail = $oldEmail;
            }

            try{
                $update = "UPDATE tb_student SET name_student=:name_student, email_student=:email_student, class=:class, photo=:photo WHERE id_student = :id_student";
        
                $resultado = $conect->prepare($update);
                $resultado->bindParam(':id_student', $id_student, PDO::PARAM_INT);
                $resultado->bindParam(':name_student', $newNome, PDO::PARAM_STR);
                $resultado->bindParam(':email_student', $newEmail, PDO::PARAM_STR);
                $resultado->bindParam(':class', $newTurma, PDO::PARAM_STR);
                $resultado->bindParam(':photo', $newFoto, PDO::PARAM_STR);
                $resultado->execute();
        
                if($resultado->rowCount() > 0){
                    echo "<div>Dados do aluno atualizados com sucesso!</div>";
                    header("Refresh: 3; url=home.php?acao=listaAlunos");
                    exit();
                }else{
                    echo "<div>Não foi possivel atualizar</div>";
                }
                if ($newNome !== $newNome || $newEmail !== $newEmail) {
                    header("Refresh: 3; url=home.php?acao=listaAlunos"); 
                    exit(); 
                } else {
                    header("Refresh: 3; url=home.php?acao=listaAlunos");
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