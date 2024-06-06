<?php

$db = "OnlineShop";                                                                                               
$db_host = "localhost";                                                                                     
$db_user = "root";                                                                                         
$db_password = "";                                                                              

$db_connection = new mysqli($db_host,$db_user,$db_password,$db);                                            

if($db_connection->connect_error){                                                                          
    die("Si e' verificato il seguente problema tecnico: " . $db_connection->connect_error);                 
}                                                                                                           
