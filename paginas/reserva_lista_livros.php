<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserva de Livros</title>
  <link rel="stylesheet" href="../estilos/alocacao-livros.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

  <header>
    <img src="../img/logo-multimeios.png" alt="Logo">
    <nav>
        <li><a href="cadastro_livro.php">Home</a></li>
        <li><a href="../cadastro_alunos.php">Cadastrar Alunos</a></li>
        <li><a href="#">Reservar Livros</a></li>
    </nav>
  </header>

  <div class="search-container">
    <input type="text" placeholder="Pesquise pelo título de seu livro, genêro e autor">
    <button type="submit"><i class="fas fa-search"></i></button>
  </div>

  <main>
    <aside>
      <div class="conteiner-card">
        <?php
            include_once('../conf/conexao.php');

        ?>
        <div class="conteiner-thumbnail"></div>
        <div class="conteiner-informacao">
          <h4>Título 1</h4>
          <p>Autor livro</p>
        </div>
        <div class="conteiner-btn">
          <a href="#">Ver Detalhes</a>
        </div>
      </div>

      <div class="conteiner-card">
        <div class="conteiner-thumbnail"></div>
        <div class="conteiner-informacao">
          <h4>Título 2</h4>
          <p>Autor livro</p>
        </div>
        <div class="conteiner-btn">
          <a href="#">Ver Detalhes</a>
        </div>
      </div>

      <div class="conteiner-card">
        <div class="conteiner-thumbnail"></div>
        <div class="conteiner-informacao">
          <h4>Título 3</h4>
          <p>Autor livro</p>
        </div>
        <div class="conteiner-btn">
          <a href="#">Ver Detalhes</a>
        </div>
      </div>
    </aside>
  </main>

  <div class="container-proxima-pagina">
    <a href="#">Anterior</a>
    <h4>Pagína 01</h4>
    <a href="#">Proxima</a>
  </div>
  
  <footer>
    <p>© 2024 EEEP José Maria Falcão. Todos os direitos reservados</p>
    <ul>
      <li><a href="#">Sobre nós</a></li>
      <li><a href="#">Termos de Uso</a></li>
      <li><a href="#">Políticas de Privicidade</a></li>
    </ul>
  </footer>

</body>
</html>
