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

<fieldset>
    <form method="POST">
        <textarea name="mensagem" placeholder="Digite sua mensagem..."></textarea><br><br>
        <input type="submit" value="Enviar mensagem" />
    </form>
</fieldset><br>

<?php

$sql = "SELECT * FROM mensagens ORDER BY data_msg";
$sql = $pdo->query($sql);
if($sql->rowCount() > 0){
    foreach($sql->fetchAll() as $mensagem):
?>
    <?= $mensagem['nome']; ?><br><br>
    <?= $mensagem['msg']; ?><br><br>
    <?php
        if($mensagem['nome'] == $_SESSION['nome']):
    ?>
    <a href="deletar.php?id=<?= $mensagem['id']?>">Deletar</a> - <a href="editar.php?id=<?= $mensagem['id']?>">Editar</a> <br>
    <?php
        endif;
    ?>
    <hr>

<?php
    endforeach;
}else{
    echo "Nenhuma mensagem!";
}
?>
<a href="sair.php">Sair</a>