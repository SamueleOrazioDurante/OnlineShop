<?php
    session_start();
    include "connessione.php";
    include "src.php";

    if(isset($_SESSION['username'])){
      header("Location: index.php");
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrazione</title>
    <link rel="stylesheet" href="src/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

    <div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
        <!-- DA CAMBIARE PLACEHOLDER.PNG ATTUALMENTE -->
        <img src="https://mivatek.global/wp-content/uploads/2021/07/placeholder.png" id="icon" alt="User Icon" />
        </div>

        <!-- Signup Form -->
        <form method="POST" action="#">
          <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username">
          <input type="email" id="email" class="fadeIn second" name="email" placeholder="E-mail@mail.com">
          <input type="text" id="nome" class="fadeIn third" name="nome" placeholder="Nome">
          <input type="text" id="cognome" class="fadeIn third" name="cognome" placeholder="Cognome">
          <input type="date" id="dataNascita" class="fadeIn third" name="dataNascita" value="01/01/2000">
          <input type="text" id="citta" class="fadeIn fourth" name="citta" placeholder="Città">
          <input type="text" id="cap" class="fadeIn fourth" name="cap" placeholder="00000">
          <input type="text" id="provincia" class="fadeIn fourth" name="provincia" placeholder="Provincia">
          <input type="text" id="via" class="fadeIn fourth" name="via" placeholder="Via">
          <input type="text" id="via2" class="fadeIn fourth" name="via2" placeholder="Seconda riga (opzionale)">
          <input type="text" id="via3" class="fadeIn fourth" name="via3" placeholder="Terza riga (opzionale)">
          <input type="password" id="password" class="fadeIn fifth" name="password" placeholder="********">
          <input type="password" id="confermaPassword" class="fadeIn fifth" name="confermaPassword" placeholder="********">
          <input type="submit" class="fadeIn sixth my-3" value="signup" id="signup" name="signup"><br>
          <a class="underlineHover text-black" href="login.php">oppure accedi!</a><br><br>
        </form>

    </div>
    </div>

    <?php

    if(isset($_POST["signup"])){
        $username = $db_connection->real_escape_string(stripslashes($_POST["username"]));
        $email = $db_connection->real_escape_string(stripslashes($_POST["email"]));
        $nome = $db_connection->real_escape_string(stripslashes($_POST["nome"]));
        $cognome = $db_connection->real_escape_string(stripslashes($_POST["cognome"])); 
        $dataNascita = $db_connection->real_escape_string(stripslashes($_POST["dataNascita"]));
        $citta = $db_connection->real_escape_string(stripslashes($_POST["citta"]));
        $cap = $db_connection->real_escape_string(stripslashes($_POST["cap"]));
        $provincia = $db_connection->real_escape_string(stripslashes($_POST["provincia"]));
        $via = $db_connection->real_escape_string(stripslashes($_POST["via"]))."//".$db_connection->real_escape_string(stripslashes($_POST["via2"]))."//".$db_connection->real_escape_string(stripslashes($_POST["via3"]));
        $password = $db_connection->real_escape_string(stripslashes($_POST["password"]));
        $confermaPassword = $db_connection->real_escape_string(stripslashes($_POST["confermaPassword"]));

        $error = signup($username,$email,$nome,$cognome,$dataNascita,$citta,$cap,$provincia,$via,$password,$confermaPassword);
        if($error == "Errore/i: "){
          alert("Registrazione avvenuta con successo!");
          echo '<script>  window.location.href = "login.php"; </script>';
        }else{
          alert("Registrazione fallita! ".$error);
        }
    }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>


