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
    <title>E-commerce</title>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <?php include "style.html"; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        input,
        textarea {
        border: 1px solid #eeeeee;
        box-sizing: border-box;
        margin: 0;
        outline: none;
        padding: 10px;
        }

        input[type="button"] {
        -webkit-appearance: button;
        cursor: pointer;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        }

        .input-group {
        clear: both;
        margin: 15px 0;
        position: relative;
        }

        .input-group input[type='button'] {
        background-color: #eeeeee;
        min-width: 38px;
        width: auto;
        transition: all 300ms ease;
        }

        .input-group .button-minus,
        .input-group .button-plus {
        font-weight: bold;
        height: 38px;
        padding: 0;
        width: 38px;
        position: relative;
        }

        .input-group .quantity-field {
        position: relative;
        height: 38px;
        left: -6px;
        text-align: center;
        width: 62px;
        display: inline-block;
        font-size: 13px;
        margin: 0 0 5px;
        resize: vertical;
        }

        .button-plus {
        left: -13px;
        }

        input[type="number"] {
        -moz-appearance: textfield;
        -webkit-appearance: none;
        }

    </style>
</head>
  <body>
    <?php include "navbar.html"; ?>

            <!-- cart + summary -->
        <section class=" my-5">
        <div class="container"><br>
            <div class="row">
            <!-- cart -->
            <div class="col-lg-9">
                <div class="card border shadow-0">
                <div class="m-4">
                    <h4 class="card-title mb-4">Il tuo carrello</h4>

    <?php 
        $totale = 0;
        if(isset($_SESSION['carrello'])):
            if($_SESSION['carrello']!=null): ?>

            <?php
                $carrello = $_SESSION['carrello'];

                foreach($carrello as $item):

                    if(isset($item['id'])):

                    $result = $db_connection->query("SELECT `nome_prodotto`,`pvu_prodotto`,`blob_img`,`estensione`,qnt_prodotto FROM `prodotti` LEFT JOIN immagini ON immagini.id_prodotto=prodotti.id_prodotto WHERE prodotti.id_prodotto = '".$item['id']."'");            
                    $rows = $result->num_rows;  

                    if($rows > 0):  
                        $row = $result->fetch_assoc();
            ?>
                    <!--  TEMPLATE ITEM
                        
                        <div class="col-lg-5">
                            <div class="me-lg-5">
                            <div class="d-flex">
                                <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/11.webp" class="border rounded me-3" style="width: 96px; height: 96px;" />
                                <div class="">
                                <a href="#" class="nav-link">Winter jacket for men and lady</a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                            <div class="">
                            <select style="width: 100px;" class="form-select me-4">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                            </div>
                            <div class="">
                            <text class="h6">$1156.00</text> <br />
                            <small class="text-muted text-nowrap"> $460.00 / per item </small>
                            </div>
                        </div>
                        <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                            <div class="float-md-end">
                            <a href="#" class="btn btn-light border text-danger icon-hover-danger"> Remove</a>
                            </div>
                        </div>

                    -->
                    <div class="row gy-3 mb-4">
                        <div class="col-lg-4">
                            <div class="me-lg-2">
                            <div class="d-flex">
                                <img src="data:image/<?php echo $row['estensione'];?>;charset=utf8;base64,<?php echo base64_encode($row['blob_img']); ?>" class="border rounded me-3" style="width: 96px; height: 96px;" />
                                <div class="">
                                <a href="#" class="nav-link"><?php echo $row['nome_prodotto']; ?></a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group me-4">
                                <!-- <input type="button" value="-" class="button-minus" data-field="quantity"> -->
                                <input type="number" step="1" max="<?php echo $row['qnt_prodotto']; ?>" value="<?php echo $item['quantita']; ?>" name="quantity" class="quantity-field" disabled>
                                <!-- <input type="button" value="+" class="button-plus" data-field="quantity"> -->
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-2 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                            <!-- SNIPPET INPUT https://bootsnipp.com/snippets/e3q3a 
                                <div class="col-lg-2">
                                                <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                                <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity" name="quantity" class="form-control input-number" value="<?php //echo $item['quantita']; ?>" min="1" max="<?php //echo $row['qnt_prodotto']; ?>">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                </div>
                            -->

                            <div class="">
                            <text class="h6"><?php echo $item['quantita'] * $row['pvu_prodotto']; ?> € </text> <br />
                            <?php $totale = $totale + ($item['quantita'] * $row['pvu_prodotto']);?>
                            <small class="text-muted text-nowrap"> <?php echo $row['pvu_prodotto']; ?> / per pezzo </small>
                            </div>
                        </div>
                        <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                            <div class="float-md-end">
                            <a href="deleteItem.php?id=<?php echo $item['id']; ?>" class="btn btn-light border text-danger icon-hover-danger"> Rimuovi</a>
                            </div>
                        </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>

        <?php if($totale == 0): ?>
            <p class="text-center" style="font-family: 'Courier-new';"> Nessun prodotto presente all'interno del carrello.</p>
        <?php endif; ?>

                </div>
                </div>
            </div>
            <!-- cart -->
            <!-- summary -->
            <div class="col-lg-3">
                <div class="card shadow-0 border">
                <div class="card-body">
                    <hr />
                    
                    <?php 
                        if($totale != 0): ?>
                    <div class="d-flex justify-content-between">
                    <p class="mb-2">Totale:</p>
                    <p class="mb-2 fw-bold"><?php echo $totale; ?> €</p>
                    </div>
                    <?php endif; ?>
                    <div class="mt-3">
                    <?php 
                        if($totale != 0): ?>
                    <a href="acquista.php?id=-1" class="btn btn-success w-100 shadow-0 mb-2"> Acquista </a>
                    <?php endif; ?>

                    <a href="index.php" class="btn btn-light w-100 border mt-2"> Torna allo shop </a>

                    <?php 
                        if($totale != 0): ?>
                    <a href="clearCart.php" class="btn btn-danger w-100 border mt-2"> Svuota il carrello </a>
                    </div>
                    <?php endif; ?>
                    
                </div>
                </div>
            </div>
            <!-- summary -->
            </div>
        </div><br>
        </section>
        <!-- cart + summary -->


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <?php include "footer.html"; ?>
    
    <script>
        /*
        function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
        }

        function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
        }

        $('.input-group').on('click', '.button-plus', function(e) {
        incrementValue(e);
        });

        $('.input-group').on('click', '.button-minus', function(e) {
        decrementValue(e);
        });
*/
    </script>
</body>
</html>

