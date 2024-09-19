<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="tasks-list-container" class="container-form">
          <h2>Alunos cadastrados:</h2>
          <table>
            <tbody>
            <?php
            include_once('../conf/conexao.php');
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
</body>
</html>        