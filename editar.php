<?php

require 'config.php';

if(isset($_GET['id']) && !empty($_GET['id'])){

    $id = addslashes($_GET['id']);
    if(filter_var($id, FILTER_VALIDATE_INT)){
        $sql = "SELECT * FROM mensagens WHERE id = '$id'";
        $sql = $pdo->query($sql);
        if($sql->rowCount() > 0){
            $mensagem = $sql->fetch();
        }  
    }else{
        header("Location: index.php");
    }
}
?>

<?php
    if(isset($_POST['mensagem']) && !empty($_POST['mensagem'])){
        $mensagem = filter_var($_POST['mensagem'], FILTER_SANITIZE_STRING);
        $sql = $pdo->prepare("UPDATE mensagens SET msg = :msg");
        $sql->bindValue(':msg', $mensagem);
        $sql->execute();

        header("Location: index.php");
    }
?>

<form method="POST">
    <textarea name="mensagem"><?= $mensagem['msg']?></textarea><br><br>
    <input type="submit" value="confirmar"/>
</form>
