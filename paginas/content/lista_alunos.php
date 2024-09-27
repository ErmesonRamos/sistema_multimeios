<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link rel="stylesheet" href="../estilos/listagem.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

body {
    font-family: "Poppins", sans-serif;
    background-color: #f4f4f4; /* Fundo suave */
    margin: 0;
    padding: 20px;
}
.conteiner {
    margin-top: 100px;
    margin-bottom: 1000px;
}

.conteiner h2 {
    text-align: center; /* Centraliza o título */
    color: #333; /* Cor do título */
    margin-bottom: 70px; /* Espaço abaixo do título */
}

.conteiner table {
    width: 80%; /* Largura total da tabela */
    border-collapse: collapse; /* Junta bordas */
    margin: 0 auto; /* Centraliza a tabela */
    background-color: #fff; /* Fundo branco */
    border-radius: 8px; /* Cantos arredondados */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra leve */
}

.conteiner table th, td {
    padding: 12px; /* Espaçamento interno */
    text-align: center; /* Centraliza o texto horizontalmente */
    vertical-align: middle; /* Alinha verticalmente ao centro */
    border-bottom: 1px solid #ddd; /* Linha entre as linhas */
}

.conteiner table thead th {
    background-color: #4CAF50; /* Fundo verde para cabeçalho */
    color: white; /* Texto branco no cabeçalho */
    font-weight: bold; /* Negrito no cabeçalho */
}

tr:hover {
    background-color: #f1f1f1; /* Fundo leve ao passar o mouse */
}

td img {
    width: 50px; /* Tamanho da imagem */
    height: 50px; /* Altura fixa para manter a proporção */
    border-radius: 50%; /* Faz a imagem ser circular */
    display: block; /* Faz a imagem ocupar um bloco */
    margin: 0 auto; /* Centraliza a imagem na célula */
}

.done-btn, .remove-btn {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    margin: 0 5px; /* Margem entre os botões */
}

.done-btn {
    background-color: #4CAF50; /* Verde */
}

.remove-btn {
    background-color: #f44336; /* Vermelho */
}

.done-btn:hover, .remove-btn:hover {
    opacity: 0.9; /* Leve transparência ao passar o mouse */
}

</style>
<body>
<div class="conteiner">
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
</div>
</body>
</html>