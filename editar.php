<?php
session_start();
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
        $sql = $pdo->prepare("UPDATE mensagens SET msg = :msg WHERE id = '$id'");
        $sql->bindValue(':msg', $mensagem);
        $sql->execute();

        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <style type="text/css">
        .form-control {
            margin-top: 10px;
        }
    </style>
</head>
<body>
        <div class="container">
            <form method="POST">
                <div class="form-group">
                    <textarea class="form-control" name="mensagem"><?= $mensagem['msg']?></textarea>
                </div> 
                <div class="form-group">
                    <input class="btn btn-success" type="submit" value="confirmar"/> <a class="btn btn-warning" href="index.php">Cencelar</a>
                </form>
            </form>
        </div>
       
    <script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>  
</body>
</html>

