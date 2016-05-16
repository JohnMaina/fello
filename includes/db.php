<?php

include "vars.php";

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

if (!$connection){
    echo "Connection to db NOT successful!" . mysqli_error();
}