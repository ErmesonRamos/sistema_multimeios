<?php include '../../includes/header.php' ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="estilos/cadastrador_alunos.css">
  <title>Cadastrador de Alunos</title>
</head>
<body>
  <main>
    <div class="conteiner">
      <h1>Cadastrar alunos</h1>
      <div class="book-register">
        <form action="">
          <label for="inome">Nome do aluno:</label>
          <br>
          <input type="text" name="inome" id="inome">
          <br>
          <label for="iemail">Email</label>
          <br>
          <input type="email" name="iemail" id="iemail">
          <br>
          <label for="iautor">Autor</label>
          <br>
          <input type="text" name="iautor" id="iautor">
          <br>
          <label for="ibook-day">Dia da reserva</label>
          <br>
          <input type="date" name="ibook-day" id="ibook-day">
          <br>
          <label for="ireturn_day">Dia do retorno da reserva</label>
          <br>
          <input type="date" name="ireturn_day" id="ireturn_day">
          <br>
          <label for="iregistron_studant">Matrícula do aluno</label>
          <br>
          <input type="number" name="iregistron_studant" id="iregistron_studant">
          <br>
          <input type="submit" value="reservar">
        </form>
      </div>
    </div>
  </main>
</body>
</html>

