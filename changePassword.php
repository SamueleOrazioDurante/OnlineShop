<?php
    session_start();
    include "connessione.php";
    include "src.php";

    if(isset($_SESSION['username'])){
      header("Location: index.php");
    }
    if($_SESSION['email']==null){
        header("Location: login.php");
    }
    if($_SESSION['code']==null){
        header("Location: login.php");
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

        <!-- Change password Form -->
        <form action="#" method="POST"><br>
          <input type="email" id="email" class="fadeIn second" name="email" value="<?php echo $_SESSION['email']; ?>" disabled>
          <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
          <input type="password" id="confermaPassword" class="fadeIn third" name="confermaPassword" placeholder="Conferma la password">
          <input type="submit" class="fadeIn fourth my-3" value="Invia" id="changePsw" name="changePsw"><br>
        </form>
    </div>
    </div>

    <?php
      if(isset($_POST["changePsw"])){
        include "connessione.php";

        $email = $_SESSION["email"];
        $password = $db_connection->real_escape_string(stripslashes($_POST["password"]));
        $confermaPassword = $db_connection->real_escape_string(stripslashes($_POST["confermaPassword"]));
        
        if($password == $confermaPassword){
            if(changePassword($email,$password)){
                alert("Cambio password avvenuto con successo.");

                //resetto le variabili di sessione utilizzate
                $_SESSION['email']=null;
                $_SESSION['code']=null;

                //windowHREF("login.php",10);
                echo '<script>  window.location.href = "login.php"; </script>';
            }
        }else{
            alert("Le password non coincidono");
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>


