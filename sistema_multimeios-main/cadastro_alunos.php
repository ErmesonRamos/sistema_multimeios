<?php
include_once('conf/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Alunos</title>
  <link rel="stylesheet" href="estilos/cadastro-alunos.css"> 
</head>
<body>

  <header>
    <img src="img/logo-multimeios.png" alt="Logo">
    <nav>
        <li><a href="paginas/cadastro_livro.php">Home</a></li>
        <li><a href="#">Cadastrar Alunos</a></li>
        <li><a href="layout/alocacao-livros.html">Reservar Livros</a></li>
    </nav>
  </header>

  <main>
    <div class="main-content">
      <aside>
        <div class="container-form">
          <h2>Cadastre Alunos aqui</h2>
          <form action="">
            <label for="inome">Nome:</label>
            <input type="text" name="inome" id="inome">
            <br>
            <label for="iemail">Email:</label>
            <input type="email" name="iemail" id="iemail">
            <br>
            <label for="isenha">Senha:</label>
            <input type="password" name="isenha" id="isenha">
            <br>
            <label for="iturma">Turma</label>
            <select name="iturma" id="iturma">
              <option value="">Selecione uma turma</option>
              <option value="1">1º Ano Informatica</option>
              <option value="2">1º Ano Administração</option>
              <option value="3">1º Ano Logística</option>
              <option value="4">1º Ano Enfermagem</option>
              <option value="5">2º Ano Informatica</option>
              <option value="6">2º Ano Comercio</option>
              <option value="7">2º Ano Enfermagem</option>
              <option value="8">2º Ano Secretaria</option>
              <option value="9">3º Ano Informatica</option>
              <option value="10">3º Ano Enfermagem</option>
              <option value="11">3º Ano Administração</option>
              <option value="12">3º Ano Contabilidade</option>
            </select>
            <br>
            <input type="submit" name="cadastrar" value="Cadastrar">
          </form>
          <?php
            if(isset($_POST['cadastrar'])){
                $inome = $_POST['inome'];
                $iemail = $_POST['iemail'];
                $isenha = password_hash($_POST['isenha'], PASSWORD_DEFAULT);
                $iturma = $_POST['iturma'];

                //echo $inome."<br>";
                //echo $iemail."<br>";
                //echo $isenha."<br>";
                //echo $iturma."<br>";

                $cadastro = "INSERT INTO tb_user (name_user, email_user, password_user, class) VALUES (:inome, :iemail, :isenha, :iturma)";

                try{
                    $result = $conect->prepare($cadastro);
                    $result -> bindParam(':inome', $inome, PDO::PARAM_STR);
                    $result -> bindParam(':iemail', $iemail, PDO::PARAM_STR);
                    $result -> bindParam(':isenha', $isenha, PDO::PARAM_STR);
                    $result -> bindParam(':iturma', $iturma, PDO::PARAM_STR);
                    $result -> execute();

                    $contar = $result->rowCount();

                    if($contar > 0){
                        echo "Cadastrado com sucesso !  :)";
                    }else{
                        echo "Ocorreu um erro ao tentar cadastrar !  ;(";
                    }
                }catch(PDOException $e){
                    echo '<strong> ERRO DE PDO </strong>'.$e->getMessage();
                }
            }
          ?>
        </div>
        <div id="tasks-list-container" class="container-form">
          <h2>Alunos cadastrados:</h2>
          <table>
            <tbody>
            <?php
                $select = "SELECT * FROM tb_user ORDER BY registron_user DESC LIMIT 5";
                
                try{
                    $result2 = $conect->prepare($select);
                    $cont = 1;
                    $result2->execute();
                    
                    $contar2 = $result2->rowCount();
                    if($contar2 > 0){
                        while($show = $result2->FETCH(PDO::FETCH_OBJ)){

            ?>
            <tr id="task-list" class="task-box template hide">
                <td class="task-title"><?php echo $cont++; ?></td>
                <td><?php echo $show->name_user; ?></td>
                <td><?php echo $show->email_user; ?></td>
                <td><?php echo $show->class; ?></td>
                <div>
                <a href="paginas/editar_aluno.php?acao=editar" title="Editar Livro"><ion-icon class="done-btn" name="checkmark-outline"></ion-icon></a>
                <a href="paginas/deletar_aluno.php?idDel=<?php echo $show->registron_user; ?>" onclick="return confirm('Deseja remover o aluno?')"><ion-icon class="remove-btn" name="close-outline"></ion-icon></a>
                </div>
            </tr>
            <?php
                        }
                    }else{

                    }
                }catch(PDOException $e){
                    echo '<strong> ERRO DE PDO </strong>'.$e->getMessage();
                }
            ?>
            </tbody>
          </table>
        </div>
      </aside>
    </div>
  </main>

  <footer>
    <p>© 2024 EEEP José Maria Falcão. Todos os direitos reservados</p>
    <ul>
      <li><a href="#">Sobre nós</a></li>
      <li><a href="#">Termos de Uso</a></li>
      <li><a href="#">Políticas de Privicidade</a></li>
    </ul>
  </footer>

  <!-- Scripts do Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>