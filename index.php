<?php
session_start();
include "connessione.php";
include "src.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if(isset($_GET['aq'])){
    alert("Acquisto effettuato con successo!");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include "style.html"; ?>
    <title>Homepage</title>
    <link rel="stylesheet" href="src/css/base.css">
    <link rel="stylesheet" href="src/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include "navbar.html"; ?>

    <?php

    $query = "SELECT prodotti.id_prodotto,nome_prodotto,pvu_prodotto,blob_img,estensione FROM prodotti LEFT JOIN immagini ON immagini.id_prodotto=prodotti.id_prodotto";
    //$query = "SELECT id_prodotto,nome_prodotto,pvu_prodotto FROM prodotto";
    
    $result = $db_connection->query($query);
    $rows = $result->num_rows;

    ?>

    <div class="container">
        <div class="row py-3">
            <?php foreach ($result as $item): ?>
                <div class="col-md-3">
                    <form action="#" method="POST" class="py-3">
                        <div class="card-sl">
                            <div class="card-image">
                                <img src="data:image/<?php echo $item['estensione'];?>;charset=utf8;base64,<?php echo base64_encode($item['blob_img']); ?>"  style="height: 350px; object-fit: cover"/>
                            </div>
                            <div class="card-heading">
                                <?php echo $item['nome_prodotto']; ?>
                            </div>
                            <div class="card-text">
                                Quantità:
                                <input type="number" name="quantita" id="quantita" value="0">
                            </div>
                            <input type="hidden" name="id" id="id" value='<?php echo $item['id_prodotto']; ?>' readonly>
                            <div class="card-text">
                                €
                                <?php echo $item['pvu_prodotto']; ?>
                            </div>
                            <button class="card-button" type="submit" id="addToCart_btn" name="addToCart_btn">Aggiungi al
                                carrello</button>
                            <button class="card-button1" type="submit" id="buyNow_btn" name="buyNow_btn">Acquista
                                ora</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php

    if (isset($_POST['addToCart_btn'])) {
        $id = $_POST["id"];
        $quantita = $_POST['quantita'];

        if ($quantita <= 0) {
            alert("Quantità non valida!");
        } else {
            $magazzino = aggiungiAlCarrello($id, $quantita);
            if ($magazzino == 1) {
                alert("Prodotto aggiunto con successo al carrello!");
            } else {
                alert("Impossibile aggiungere al carrello. Quantità in magazzino: " . $magazzino);
            }
        }
    }

    if (isset($_POST['buyNow_btn'])) {
        $id = $_POST["id"];
        $quantita = $_POST['quantita'];

        if ($quantita <= 0) {
            alert("Quantità non valida!");
        } else {
            echo '<script>  window.location.href = "acquista.php?id=' . $id . '&quantita=' . $quantita . '"; </script>';
        }
    }

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <?php include "footer.html"; ?>
</body>

</html>