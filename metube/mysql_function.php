<?php

function db_connect($host, $uname, $pword, $database) {

    $connection = mysqli_connect($host, $uname, $pword, $database);
	
    if (!$connection) {
        die("Connection failed:" . mysqli_connect_error());
    }

    return $connection;

}

function db_connect_close($connection) {
    mysqli_close($connection);
}



?>
