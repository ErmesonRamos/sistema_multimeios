<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <link rel="stylesheet" href="../estilos/listagem.css">
</head>
<body>
<div>
    <h2>Livros Cadastrados:</h2>
    <table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Gênero</th>
            <th>Capa</th>
        </tr>
    </thead>
    <tbody>
    <?php
    include_once('../conf/conexao.php');

        $select = "SELECT * FROM tb_book ORDER BY id_book DESC LIMIT 6";
        
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
    <td data-label="Título"><?php echo $show->title; ?></td>
    <td data-label="Autor"><?php echo $show->author_book; ?></td>
    <td data-label="Gênero"><?php echo $show->gender_book; ?></td>
    <td data-label="Capa">
        <img src="../img/capas_livros/<?php echo $show->book_cover; ?>" alt="Capa do Livro">
    </td>
    <td data-label="Ações">
        <a href="home.php?acao=editarLivros&idUpdate=<?php echo $show->id_book; ?>" class="done-btn" title="Editar Livro">Editar</a>
        <a href="home.php?acao=deletarLivros&idDel=<?php echo $show->id_book; ?>" class="remove-btn" onclick="return confirm('Deseja remover o livro?')">Deletar</a>
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