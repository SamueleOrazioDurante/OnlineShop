<?php session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    $_SESSION['carrello'] = null;
    echo "Carrello pulito, arrivederci";
    header("Location: carrello.php");