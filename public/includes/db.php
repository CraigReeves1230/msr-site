<?php

// connects to database
if(!$database = mysqli_connect('localhost','root','','msr3')){
    die('Could not connect to database. ' . mysqli_error($database));
}


?>