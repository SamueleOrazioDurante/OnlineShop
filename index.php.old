<?php
    session_start();
    include "connessione.php";
    include "src.php";

    if(!isset($_SESSION['username'])){
        header("Location: login.php");
      }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-image: url('src/img/background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include "navbar.html"; ?>

    <?php 
    
        $query = "SELECT prodotto.id_prodotto,nome_prodotto,pvu_prodotto,img FROM prodotto LEFT JOIN immagini ON immagini.id_prodotto=prodotto.id_prodotto";
        //$query = "SELECT id_prodotto,nome_prodotto,pvu_prodotto FROM prodotto";

        $result = $db_connection->query($query);                      
        $rows = $result->num_rows;  
           
        ?>

    <div class="container">
        <div class="row py-3">
            <?php foreach($result as $item):?>
                <div class="col-3">
                        <form action="#" method="POST">
                            <div class="card border-primary mb-3 text-center" style="width: 19rem;height: 625px;">
                                <img src="<?php echo $item['img']; ?>" class="card-img-top" alt="<?php echo $item['nome_prodotto']; ?> bello/a" style="width: 275px;height: 300px"> <!-- DA RIVEDERE LA LARGHEZZA E ALTEZZA DELLE IMMAGINI-->
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $item['nome_prodotto']; ?></h5>

                                    <br>

                                    <div class="input-group">
                                        <span class="input-group-text">Quantità</span>
                                        <input type="number" class="form-control" id="quantita" name="quantita">
                                    </div>

                                    <br>

                                    <div class="input-group">
                                        <span class="input-group-text">€</span>
                                        <span class="input-group-text"><?php echo $item['pvu_prodotto']; ?></span>
                                    </div>

                                    <input type="hidden" name="id" id="id" value='<?php echo $item['id_prodotto']; ?>' readonly>

                                    <br>

                                    <button type="submit" id="addToCart_btn" name="addToCart_btn" class="btn btn-primary">Aggiungi al carrello</button><br><br>
                                    <button type="submit" id="buyNow_btn" name="buyNow_btn" class="btn btn-success">Acquista ora</button>
                                </div>
                            </div><br>
                        </form>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php

    if(isset($_POST['addToCart_btn'])){
        $id = $_POST["id"];
        $quantita = $_POST['quantita'];

        if($quantita<0){
            echo "Inserisci la quantità.";
        }else{
            $magazzino = aggiungiAlCarrello($id,$quantita);
            if($magazzino==1){
                alert("Prodotto aggiunto con successo al carrello!");
            }else{
                alert("Impossibile aggiungere al carrello. Quantità in magazzino: ".$magazzino);
            }
        }
    }

    if(isset($_POST['buyNow_btn'])){
        $id = $_POST["id"];
        $quantita = $_POST['quantita'];

        if($quantita<0){
            echo "Inserisci la quantità.";
        }else{
            echo '<script>  window.location.href = "acquista.php?id='.$id.'&quantita='.$quantita.'"; </script>';
        }
    }

?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <?php include "footer.html"; ?>
</body>
</html>