<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link rel="stylesheet" href="../estilos/listagem.css">
 
</head>
<body>

<div class="conteiner">
    <table>
    <h2>Livros Reservados</h2>
    <thead>
            <tr>
                <th>Livro</th>
                <th>Aluno</th>
                <th>D.Reserva</th>
                <th>Retorno</th>
            </tr>
    </thead>
    <tbody>

<?php
include_once('../conf/conexao.php');

$select = "
    SELECT 
        r.id_reserve,
        b.title,
        s.name_student,
        r.booking_day,
        r.return_day,
        b.book_cover
    FROM 
        tb_reserve r
    JOIN 
        tb_book b ON r.id_book = b.id_book
    JOIN 
        tb_student s ON r.id_student = s.id_student
    ORDER BY 
        r.id_reserve DESC 
    LIMIT 10";
        
try {
    $result = $conect->prepare($select);
    $cont = 1;
    $result->execute();
    
    $contar = $result->rowCount();
    if ($contar > 0) {
        while ($show = $result->FETCH(PDO::FETCH_OBJ)) {
?>
    <tr id="task-list" class="task-box template hide">
        <td data-label="ID"><?php echo $cont++; ?></td>
        <td data-label="Livro"><?php echo $show->title; ?></td>
        <td data-label="Aluno"><?php echo $show->name_student; ?></td>
        <td data-label="D.Reserva"><?php echo $show->booking_day; ?></td>
        <td data-label="Retorno"><?php echo $show->return_day; ?></td>
        <td data-label="Foto">
            <img src="../img/capas_livros/<?php echo $show->book_cover; ?>" alt="Foto">
        </td>
        <td data-label="Ações">
            <a href="home.php?acao=editarReservas&idUpdate=<?php echo $show->id_reserve; ?>" class="done-btn" title="Editar reserva">Editar</a>
            <a href="home.php?acao=deletarReservas&idDel=<?php echo $show->id_reserve; ?>" class="remove-btn" onclick="return confirm('Deseja apagar a reserva?')">Deletar</a>
        </td>
    </tr>
<?php
        }
    } else {
        echo '<tr><td colspan="6">Nenhuma reserva encontrada.</td></tr>';
    }
} catch (PDOException $e) {
    echo '<strong>ERRO DE PDO:</strong> ' . $e->getMessage();
}

?>
</div>   
</body>
