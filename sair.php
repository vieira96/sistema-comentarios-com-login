<?php
session_start();
require 'config.php';
if(isset($_SESSION['logado'])){
    unset($_SESSION['logado']);
    header("Location: login.php");
    exit;
}else{
    header("Location: login.php");
    exit;
}