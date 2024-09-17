<?php
// config/conexao.php

$host = 'localhost'; // Host do banco de dados
$dbname = 'new_sistema_multimeios'; // Nome do banco de dados
$user = 'root'; // Usuário do banco de dados
$password = 'bdjmf'; // Senha do banco de dados

try {
    $conect = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
