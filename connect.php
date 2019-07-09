<?php

$mysqli = new mysqli("10.51.33.97", "root", "", "swap_db");
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
 
date_default_timezone_set('Africa/Nairobi');


?>