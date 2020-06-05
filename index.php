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
    <script src="https://kit.fontawesome.com/6cb3d6337d.js" crossorigin="anonymous"></script>

</head>

<body style="background-color: #1c1e21;">
    <div class="container">

        <fieldset>
            <form method="POST" style="margin-top: 5px;">
                <div class="form-group shadow-textarea">
                    <textarea class="form-control z-depth-1" name="mensagem" rows="2" placeholder="Seu comentário..."></textarea>
                </div>

                
                <input class="btn btn-success" type="submit" value="Comentar" />
            </form>
        </fieldset><br>

        <?php

        $sql = "SELECT * FROM mensagens ORDER BY data_msg";
        $sql = $pdo->query($sql);
        if($sql->rowCount() > 0){
            
            foreach($sql->fetchAll() as $mensagem):
        ?>
            <div class="list-group" style="margin-bottom: 5px; border-radius: 20px;">
                <div class="list-group-item" style="background-color: #262729; color: white; height: auto;">
                    <div class="d-flex">
                        <?= $mensagem['nome']; ?><br><br>
                    </div>
                    <span style="word-wrap: break-word;">
                        <?= $mensagem['msg']; ?><br><br>
                    </span>

                    <?php
                    if($mensagem['nome'] == $_SESSION['nome']):
                ?>
                <div>
                    <a class="btn btn-primary" href="editar.php?id=<?= $mensagem['id']?>"><i class="far fa-edit"></i></a> <a class="btn btn-danger" href="deletar.php?id=<?= $mensagem['id']?>"><i class="far fa-trash-alt"></i></a>
                </div>
                <?php
                    endif;
                ?>
                </div>
            </div>
               

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
