<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    $id = $_GET['id'];
    $_SESSION['carrello'][$id] = null;
    echo "Prodotto con id: ".$id." eliminato con successo!";
    header("Location: carrello.php");