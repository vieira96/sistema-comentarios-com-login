<?php

require 'config.php';

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = addslashes($_GET['id']);
    if(filter_var($id, FILTER_VALIDATE_INT)){

        $sql = "DELETE FROM mensagens WHERE id = '$id'";
        $sql = $pdo->query($sql);

        header("Location: index.php");
    }else{
        header("Location: index.php");
    }
}