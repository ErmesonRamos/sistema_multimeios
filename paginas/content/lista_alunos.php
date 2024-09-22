<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link rel="stylesheet" href="../estilos/listagem.css">
</head>
<body>
<div>
    <table>
    <h2>Alunos Cadastrados:</h2>
    <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Turma</th>
                <th>Foto</th>
            </tr>
    </thead>
    <tbody>
    <?php
    include_once('../conf/conexao.php');

        $select = "SELECT * FROM tb_student ORDER BY id_student DESC LIMIT 10";
        
        try{
            $result = $conect->prepare($select);
            $cont = 1;
            $result->execute();
            
            $contar = $result->rowCount();
            if($contar > 0){
                while($show = $result->FETCH(PDO::FETCH_OBJ)){

    ?>
    <tr id="task-list" class="task-box template hide">
    <td data-label="ID"><?php echo $cont++; ?></td>
    <td data-label="Nome"><?php echo $show->name_student; ?></td>
    <td data-label="Email"><?php echo $show->email_student; ?></td>
    <td data-label="Turma"><?php echo $show->class; ?></td>
    <td data-label="Foto">
        <img src="../img/fotos_alunos/<?php echo $show->photo; ?>" alt="Foto">
    </td>
    <td data-label="Ações">
        <a href="home.php?acao=editarAlunos&idUpdate=<?php echo $show->id_student; ?>" class="done-btn" title="Editar dados do Aluno">Editar</a>
        <a href="home.php?acao=deletarAlunos&idDel=<?php echo $show->id_student; ?>" class="remove-btn" onclick="return confirm('Deseja remover o aluno?')">Deletar</a>
    </td>
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
</body>
</html>