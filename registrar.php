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

<h3>Criar conta</h3>
<form method="POST">
    <input type="text" name="nome" placeholder="Nome..." /><br><br>
    <input type="email" name="email" placeholder="Email..." /><br><br>
    <input type="password" name="senha" placeholder="Senha..." /><br><br>
    <input type="submit" value="Criar" />
</form>