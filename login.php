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
        echo "Usuário não encontrado";
    }
}

?>
<h3>Logar</h3>
<form method="POST">
    <input type="email" name="email" placeholder="Email..." /><br><br>
    <input type="password" name="senha" placeholder="Senha..." /><br><br>
    <input type="submit" value="Entrar" /> - <a href="registrar.php">Criar conta</a>
</form>