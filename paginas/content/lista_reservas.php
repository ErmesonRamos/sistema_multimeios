<?php
include_once('../conf/conexao.php');

// Consulta para obter as reservas
$reservas_query = "
    SELECT 
        r.id_reserve, 
        b.title AS book_title, 
        s.name_student, 
        r.booking_day, 
        r.return_day 
    FROM 
        tb_reserve r
    JOIN 
        tb_book b ON r.id_book = b.id_book
    JOIN 
        tb_student s ON r.id_student = s.id_student
    ORDER BY 
        r.booking_day DESC";
$reservas_result = $conect->query($reservas_query);
?>

<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
    
    <style>
        .conteiner {
            margin-top: 50px;
            margin-bottom: 800px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="conteiner">
        <h2 style="text-align:center;">Lista de Reservas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Reserva</th>
                    <th>Título do Livro</th>
                    <th>Nome do Aluno</th>
                    <th>Data de Reserva</th>
                    <th>Data de Devolução</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($reserva = $reservas_result->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?= $reserva['id_reserve']; ?></td>
                        <td><?= $reserva['book_title']; ?></td>
                        <td><?= $reserva['name_student']; ?></td>
                        <td><?= date('d/m/Y', strtotime($reserva['booking_day'])); ?></td>
                        <td><?= date('d/m/Y', strtotime($reserva['return_day'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
