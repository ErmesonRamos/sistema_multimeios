<?php
try{
    DEFINE('HOST', 'localhost');
    DEFINE('DB', 'new_sistema_multimeios');
    DEFINE('USER', 'root');
    DEFINE('PASS', 'bdjmf');

    $conect = new PDO('mysql:host='.HOST.';dbname='.DB,USER,PASS);
    $conect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo "<strong> ERRO DE PDO </strong>".$e->getMessage();
}