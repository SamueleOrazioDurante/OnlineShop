<?php
    include "connessione.php";

    $query = "SELECT imageData FROM `tbl_image` WHERE `imageId` = '13'";
    $result = $db_connection->query($query);
    $row = $result->fetch_array();
?>
<img src="data:image/png;charset=utf8;base64,<?php echo base64_encode($row['imageData']); ?>"/>  DA CAMBIARE ESTENSIONE
