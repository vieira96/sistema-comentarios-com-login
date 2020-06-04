<?php
session_start();
require 'config.php';


if(empty($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['mensagem']) && !empty($_POST['mensagem'])){
    $nome = $_SESSION['nome'];
    $mensagem = filter_var($_POST['mensagem'], FILTER_SANITIZE_STRING);

    $sql = $pdo->prepare("INSERT INTO mensagens (nome, msg, data_msg) VALUES ('$nome', :msg, NOW())");
    $sql->bindValue(':msg', $mensagem);
    $sql->execute();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Comentarios</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
</head>

<body>
    <div class="container">

        <fieldset>
            <form method="POST" style="margin-top: 5px;">
                <div class="form-group shadow-textarea">
                    <textarea class="form-control z-depth-1" name="mensagem" rows="2" placeholder="Sua mensagem..."></textarea>
                </div>

                
                <input class="btn btn-success" type="submit" value="Enviar mensagem" />
            </form>
        </fieldset><br>

        <?php

        $sql = "SELECT * FROM mensagens ORDER BY data_msg";
        $sql = $pdo->query($sql);
        if($sql->rowCount() > 0){
            
            foreach($sql->fetchAll() as $mensagem):
        ?>
            <div class="row align-items-center">
                <div class="col-sm-10" style="word-wrap: break-word;">
                <?= $mensagem['nome']; ?><br><br>
                <?= $mensagem['msg']; ?><br><br>
                </div>
                <?php
                    if($mensagem['nome'] == $_SESSION['nome']):
                ?>
                <div class="col-sm-2">
                <a class="btn btn-danger" href="deletar.php?id=<?= $mensagem['id']?>">Deletar</a> - <a class="btn btn-dark" href="editar.php?id=<?= $mensagem['id']?>">Editar</a> <br>
                </div>
                <?php
                    endif;
                ?>
            </div>
            <hr>

        <?php
            endforeach;
        }else{
            echo "Nenhuma mensagem!";
        }
        ?>
        <a href="sair.php">Sair</a>
    </div>
<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>    
</body>
</html>
