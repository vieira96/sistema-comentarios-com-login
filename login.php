<?php
session_start();

require 'config.php';

if(isset($_SESSION['logado']) && !empty($_SESSION['logado'])){
    header("Location: index.php");
    exit;
}

if(isset($_POST['email']) && !empty($_POST['email'])){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = md5(filter_var($_POST['senha'], FILTER_SANITIZE_STRING));
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
    $sql->bindValue(':email', $email);
    $sql->bindValue(':senha', $senha);
    $sql->execute();
    if($sql->rowCount() > 0){
        $user = $sql->fetch();
        $_SESSION['logado'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        header("Location: index.php");
        exit;
    }else{
        ?>  
            <div class="container">
            <div class="alert alert-dismissible alert-danger" role="alert" style="max-width: 290px;">
                Email e/ou senha incorretos
                <a class="close" data-dismiss="alert" aria-label="Fechar">
                    <span style="cursor: pointer;" aria-hidden="true">&times;</span>
                </a>
            </div>
            </div>
        <?php
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <style type="text/css">
        .form-control {
            max-width: 250px;
        }
    </style>
</head>
<body style="background-color: #1c1e21;">
    <div class="container">
        <form method="POST">
            <div class="form-group">
                <h3 style="color: white;">Logar</h3>
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email..." />
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="senha" placeholder="Senha..." />
            </div>
            <div class="form-group">
                <input class="btn btn-success" type="submit" value="Entrar" /> - <a href="registrar.php">Criar conta</a>
            </div>
        </form>
    </div>
<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>  
</body>
</html>

