<html>
    <body>
        <?php
            include "src.php";
            
            $email = $_POST["email-newsletter"];
            if(addToNewsletter($email)){
                alert("Iscrizione avvenuta con successo! Buona giornata.");
                echo "<script> window.location.href = 'index.php'; </script>";
            }else{
                alert("Email già presente nel database. Buona giornata.");
                echo "<script> window.location.href = 'index.php'; </script>";
            }

            
        ?>
    </body>
</html>