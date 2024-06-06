<?php

    function aggiungiAlCarrello($id,$quantita){ 

        $magazzino = controllaMagazzino($id,$quantita);

        if($magazzino==1){
            if(!isset($_SESSION['carrello'])){
                $_SESSION['carrello'][] = array();
            }
    
            if(isset($_SESSION['carrello'][$id])){
                $_SESSION['carrello'][$id]['quantita']=$_SESSION['carrello'][$id]['quantita']+$quantita;
            }else{
                $item = array(
                    'id' => $id,
                    'quantita' => $quantita
                );
                $_SESSION['carrello'][$id] = $item;
            }
            return $magazzino;
        }else{
            return $magazzino;
        }  
    }

    function login($username,$password){

        include "connessione.php";

        $output = false;

        $result = $db_connection->query("SELECT password_user,cart_user FROM utenti WHERE username_user='$username' OR email_user='$username'");
        $rows = $result->num_rows;

        if($rows > 0){
  
            $row = $result->fetch_assoc();
            $psw = $row['password_user'];
  
            if(password_verify($password,$psw)) {
                $output = true;
                recoverCart($row['cart_user']);
              }
            }
          $db_connection->close();
          return $output;
      }

      function signup($username,$email,$nome,$cognome,$dataNascita,$citta,$cap,$provincia,$via,$password,$confermaPassword){
        
        include "connessione.php";
        $output = dataVerify($username,$email,$nome,$cognome,$dataNascita,$citta,$cap,$provincia,$via,$password,$confermaPassword);

        if($output == "Errore/i: "){
            $password = password_hash($password,PASSWORD_DEFAULT);

            $query = "INSERT INTO `utenti`(`nome_user`, `cognome_user`, `dataDiNascita_user`, `citta_user`, `cap_user`, `provincia_user`, `via_user`, `email_user`, `username_user`, `password_user`) VALUES ('$nome','$cognome','$dataNascita','$citta','$cap','$provincia','$via','$email','$username','$password')";
            echo $query;
            $ok=$db_connection->query($query);
        }
        
        $db_connection->close(); 
        return $output;   
    }

    function dataVerify($username,$email,$nome,$cognome,$dataNascita,$citta,$cap,$provincia,$via,$password,$confermaPassword){
        $error = "Errore/i: "; // Inizialmente impostiamo la variabile a Errore:, se uno dei controlli fallisce, aggiungerà un errore

        if($username == ""){
            $error = $error."Username non inserito |";
        }

        if($email == ""){
            $error = $error."Email non inserita |";
        }

        if($nome == ""){
            $error = $error."Nome non inserito |";
        }

        if($cognome == ""){
            $error = $error."Cognome non inserito |";
        }

        if($dataNascita == ""){
            $error = $error."Data di nascita non inserita |";
        }

        if($citta == ""){
            $error = $error."Città non inserita |";
        }

        if($cap == ""){
            $error = $error."CAP non inserito |";
        }

        if($provincia == ""){
            $error = $error."Provincia non inserita |";
        }

        if($via == ""){
            $error = $error."Indirizzo non inserito |";
        }

        if($password == ""){
            $error = $error."Password non inserita |";
        }

        if($confermaPassword == ""){
            $error = $error."Conferma Password non inserita |";
        }

        if($password != $confermaPassword){
            $error = $error."Le password non coincidono  |";
        }

        return $error;
    }

    function saveCartToDB(){
        include "connessione.php";


    }

    function recoverCart($cart){

    }

    function controllaMagazzino($id,$quantita){

        include "connessione.php";
        
        $magazzino = true;

        $result = $db_connection->query("SELECT qnt_prodotto FROM prodotti WHERE id_prodotto='$id'");
        $row = $result->fetch_assoc();
        $qnt = $row['qnt_prodotto'];

        if($quantita > $qnt){
            $magazzino = $qnt;
        }

        return $magazzino;
    }

    function alert($text){
        echo '<script>  alert("'. $text .'"); </script>';
    }

    function controllaEmail($email){
        include "connessione.php";
        
        $esiste = -1;

        $result = $db_connection->query("SELECT email_user FROM utenti WHERE email_user='$email'");
        if($row = $result->fetch_assoc()){
             $esiste = sendCode($email);
        }
        
        return $esiste;     
    }

    function sendCode($email){
        include "SMTP.php";

        $code = mt_rand(111111, 999999);
        $subject = "Richiesta di reset della password";
        $body = "Codice OTP: ".$code;
        sendEmail($email,$subject,$body);
        return $code;
    }

    function changePassword($email,$password){
        include "connessione.php";
        
        $done = false;
        $password = password_hash($password,PASSWORD_DEFAULT);

        $result = $db_connection->query("UPDATE `utenti` SET `password_user`='$password' WHERE `email_user`='$email'");

        //if($row = $result->fetch_assoc()){
            $done = true;
        //}
        
        return $done;     
    }

    function addToNewsletter($email){
        include "connessione.php";
        $isDone = false;

        $query = "SELECT * FROM `newsletter` WHERE `email` = '$email'";
        $check = $db_connection->query($query);

        $rows = $check->num_rows;
  
        if($rows == 0){
            $query = "INSERT INTO `newsletter` (`email`) VALUES ('$email')";
            $ok=$db_connection->query($query);
            $isDone = true;
        }
        
        $db_connection->close(); 
        return $isDone;
    }

    function acquista($id,$quantita){
        include "connessione.php";

        //verifica quantità dal magazzino prima di acquistare
        if(controllaMagazzino($id,$quantita)){
            echo "Quantità verificata! test:". $id;

            $email_user = getIdUser();
            $date = date("Y-m-d");
            $time = date("h:i:s");
            $total = getTotal($id,$quantita);
            echo "variabili ottenute";
            
            $queryAcquisto = "UPDATE `prodotti` SET `qnt_prodotto`=`qnt_prodotto`-".$quantita." WHERE `id_prodotto`='".$id."';";
            $queryTracking = "INSERT INTO `shoptracking`(`email_user`, `id_prodotto`, `qnt_acquistata`, `data_diAcquisto`, `ora_diAcquisto`, `spesa_totale`) VALUES ('$email_user','$id','$quantita','$date','$time','$total')";
            echo $queryTracking;
            $result = $db_connection->query($queryAcquisto); echo "query result";
            $tracking = $db_connection->query($queryTracking); echo "query tracking";
            
            echo "Acquisto effettuato: ".$id;
            header("Location: index.php?aq=true");
        }


    }

    function getIDUser(){
        include "connessione.php";

        $email_user = null;
        if(isset($_SESSION['username'])){
            $usr = $_SESSION['username'];
            $query = "SELECT `email_user` FROM `utenti` WHERE `username_user` = '".$usr."'";
            $result = $db_connection->query($query);
            $row = $result->fetch_assoc();
            $email_user = $row["email_user"];
        }

        return $email_user;
    }

    function getTotal($id,$quantita){
        include "connessione.php";

        $total= null;

        $result = $db_connection->query("SELECT pvu_prodotto FROM prodotti WHERE id_prodotto='$id'");
        $row = $result->fetch_assoc();
        $pvu = $row['pvu_prodotto'];

        $total = $pvu * $quantita;

        return $total;
    }

    function clearCart(){
        $_SESSION['carrello'] = array();
    }

    function aggiungiAlMagazzino($nome,$descrizione,$quantita,$pvu,$estensione,$imgData){
        include "connessione.php";

        $queryAddProdotto = "INSERT INTO `prodotti`(`nome_prodotto`, `pvu_prodotto`, `qnt_prodotto`) VALUES ('".$nome."','".$pvu."','".$quantita."')";
        $addProdotto = $db_connection->query($queryAddProdotto);

        $queryIDProdotto = "SELECT `id_prodotto` FROM prodotti WHERE `nome_prodotto` = '".$nome."'";
        $idRow = $db_connection->query($queryIDProdotto);
        $row = $idRow->fetch_assoc();  
        $id = $row["id_prodotto"];

        $queryImmagine = "INSERT INTO `immagini`(`id_prodotto`,`blob_img`, `estensione`) VALUES ('".$id."','".$imgData."','".$estensione."')";

        $immagineD = $db_connection->query($queryImmagine);
            
        alert("Aggiunta prodotto effettuata!");
    }

    function dataVerifyProduct($nome,$quantita,$pvu){
        $isOk = true; // Inizialmente impostiamo la variabile a true, se uno dei controlli fallisce, diventerà false

        if($nome == ""){
            $isOk = false;
            alert("Nome prodotto non inserito <br />");
        }

        if($quantita == ""){
            $isOk = false;
            alert("Quantità disponibile del prodotto non inserita <br />");
        }

        if($pvu == ""){
            $isOk = false;
            alert("Prezzo unitario del prodotto non inserito <br />");
        }

        if(!(is_numeric($pvu))){
            $isOk = false;
            alert("Prezzo unitario del prodotto inserito con un formato errato! <br />");
        }

        return $isOk;
    }
