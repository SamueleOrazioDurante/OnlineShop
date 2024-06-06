<?php session_start();
    include "src.php";
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }

    saveCartToDB();

    $SESSION[] = array();
    session_unset();
    session_destroy();
    echo "Disconnessione eseguita, arrivederci";
    header("Location: login.php");