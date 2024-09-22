<?php
include_once('../conf/conexao.php');
?>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Alunos</title>
  <link rel="stylesheet" href="../../estilos/cadastro-alunos.css"> 
</head>
<body>
  <main>
    <div class="main-content">
      <aside>
        <div class="container-form">
        <a href="home.php?acao=listaAlunos">Lista de Alunos</a>
          <h2>Cadastrar Alunos</h2>
          <form role="form" action="" method="post" enctype="multipart/form-data">
            <label for="inome">Nome:</label>
            <input type="text" name="inome" id="inome">
            <br>
            <label for="iemail">Email:</label>
            <input type="email" name="iemail" id="iemail">
            <br>
            <label for="iturma">Turma</label>
            <select name="iturma" id="iturma" required>
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
            <br>
            <label for="ifoto">Foto do Aluno</label>
            <input type="file" name="ifoto" id="ifoto">
            <br>
            <input type="submit" name="cadastrar" value="Cadastrar">
          </form>
          <?php
            if(isset($_POST['cadastrar'])){
                $inome = filter_input(INPUT_POST, 'inome', FILTER_SANITIZE_STRING);
                $iemail = filter_input(INPUT_POST, 'iemail', FILTER_SANITIZE_STRING);
                $iturma = filter_input(INPUT_POST, 'iturma', FILTER_SANITIZE_STRING);

                if(isset($_FILES['ifoto'])){
                  if (!empty($_FILES['ifoto']['name'])) {
                      $formatosP = array("png", "jpg", "jpeg", "JPG");
                      $extensao = pathinfo($_FILES['ifoto']['name'], PATHINFO_EXTENSION);
          
                      if (in_array(strtolower($extensao), $formatosP)) {
                          $pastaDestino = "../img/fotos_alunos/";
                          $pastaTemp = $_FILES['ifoto']['tmp_name'];
                          $newnameFoto = uniqid() . ".$extensao";
          
                          if (move_uploaded_file($pastaTemp, $pastaDestino . $newnameFoto)) {
                          } else {
                              echo '<strong>Não foi possível fazer o upload do arquivo.</strong>';
                              exit();
                          }
                      } else {
                          echo '<strong>Formato de arquivo não permitido.</strong>';
                          exit();
                      }
                  } else {
                      $newnameFoto = 'foto_padrao.jpg';
                  }
              }else{
                  echo '<strong>foto nao enviada!!!!!</strong>';
              }

                $cadastro = "INSERT INTO tb_student (name_student, email_student, class, photo) VALUES (:inome, :iemail, :iturma, :ifoto)";

                try{
                    $result = $conect->prepare($cadastro);
                    $result -> bindParam(':inome', $inome, PDO::PARAM_STR);
                    $result -> bindParam(':iemail', $iemail, PDO::PARAM_STR);
                    $result -> bindParam(':iturma', $iturma, PDO::PARAM_STR);
                    $result -> bindParam(':ifoto', $newnameFoto, PDO::PARAM_STR);
                    $result -> execute();

                    $contar = $result->rowCount();

                    if($contar > 0){
                        echo "Cadastrado com sucesso !  :)";
                        header("Refresh: 3; url=home.php?acao=cadastrarAlunos");
                        exit();
                    }else{
                        echo "Ocorreu um erro ao tentar cadastrar !  ;(";
                        header("Refresh: 3; url=home.php?acao=cadastrarAlunos");
                        exit();
                    }
                }catch(PDOException $e){
                    echo '<strong> ERRO DE PDO </strong>'.$e->getMessage();
                }
            }
          ?>
        </div>
      </aside>
    </div>
  </main>

  <!-- Scripts do Ionicons -->
  <script src="../JS/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>