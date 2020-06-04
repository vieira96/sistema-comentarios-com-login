<?php
session_start();
require 'config.php';

if(isset($_POST['email']) && !empty($_POST['email'])){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();
    if($sql->rowCount() > 0){
        echo "O usuario ja existe";
    }else{
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
        $senha = md5(filter_var($_POST['senha'], FILTER_SANITIZE_STRING));
        $sql = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
        $sql->bindValue(':email', $email);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':senha', $senha);
        $sql->execute();
        unset($_SESSION['logado']);
        var_dump($email, $nome, $senha);
        header("Location: login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <style type="text/css">
        .form-control {
            max-width: 250px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <h3>Criar conta</h3>
            <div class="form-group">
                <input class="form-control" type="text" name="nome" placeholder="Nome..." />
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email..." />
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="senha" placeholder="Senha..." />
            </div>
            <div class="form-group">
                <input class="btn btn-success" type="submit" value="Criar"/> <a href="login.php" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script> 
</body>
</html>

