<?php
require 'config.php';

if(isset($_POST['nome']) && !empty($_POST['nome'])){
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $mensagem = filter_var($_POST['mensagem'], FILTER_SANITIZE_STRING);


    $sql = $pdo->prepare("INSERT INTO mensagens (nome, msg, data_msg) VALUES (:nome, :msg, NOW())");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':msg', $mensagem);
    $sql->execute();

}

?>

<fieldset>
    <form method="POST">
        <input type="text" name="nome" placeholder="Digite seu nome..." /><br><br>
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
    <a href="deletar.php?id=<?= $mensagem['id']?>">Deletar</a> - <a href="editar.php?id=<?= $mensagem['id']?>">Editar</a> <br>
    <hr>

<?php
    endforeach;
}else{
    echo "Nenhuma mensagem!";
}

?>