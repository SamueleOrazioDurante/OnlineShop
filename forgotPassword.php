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
    <title>Login</title>
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

        <!-- Recovery Form -->
        <form action="#" method="POST" id="emailForm">
          <input type="email" id="email" class="fadeIn second" name="email" placeholder="Inserisci l'e-mail">
          <input type="submit" class="fadeIn fourth my-3" value="Invia" id="sendCode" name="sendCode"><br>
          <a class="underlineHover text-black" href="signup.php">oppure registrati!</a><br><br>
        </form>

        <!-- Code Form -->
        <form action="#" method="POST" id="verifyForm">
              <input type="text" id="code" name="code" placeholder="Inserisci il codice">
              <input type="submit" class="fadeIn fourth my-3" value="Invia" id="verifyCode" name="verifyCode"><br>
              <a class="underlineHover text-black" href="signup.php">oppure registrati!</a><br><br>
        </form>

        <script>
        
        //nascondo il form verifyForm
        document.getElementById("verifyForm").style.display = "none";

        </script>

        <!-- Back to login -->
        <div id="formFooter">
        <a class="underlineHover text-black" href="login.php">Torna la login</a>
        </div>

    </div>
    </div>
    
    <?php

      if(isset($_POST["sendCode"])){
        include "connessione.php";

        $email = $db_connection->real_escape_string(stripslashes($_POST["email"]));
        $code = controllaEmail($email);
        $_SESSION['code'] = $code;
        if($code!=-1){ // se è -1 l'utente non esiste o il codice non è stato inviato

            alert("Controlla la posta elettronica associata all'account per ricevere il codice!");
            $_SESSION['email'] = $email;

            //nascondo il vecchio form
            echo '
                <script>
                    document.getElementById("emailForm").style.display = "none";
                </script>
            ';
            //rendo visibile il nuovo form
            echo '
                <script>
                    document.getElementById("verifyForm").style.display = "inline";
                </script>
            ';

        }
      }

      if(isset($_POST["verifyCode"])){
        $code = $_SESSION['code'];
        $_SESSION['code'] = null;

        $codeForm = $db_connection->real_escape_string(stripslashes($_POST["code"]));
        if($codeForm == $code){
            alert("Codice verificato!");
            $_SESSION['code'] = $code;
            echo '<script>  window.location.href = "changePassword.php"; </script>';
        }else{
            alert("Codice errato!");
        }
      }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>


