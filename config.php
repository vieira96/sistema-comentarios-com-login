<?php

$dsn = "mysql:dbname=projeto_comentarios;host=localhost";
$dbuser = "root";
$dbpass = "newpassword";

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
} catch(PDOException $e){
    echo "Erro: " . $e->getMessage();
}