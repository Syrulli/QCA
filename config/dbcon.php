<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "qc_academy";
    $con = mysqli_connect($host, $username, $password, $database);
    if(!$con){
        die("Connection Failed".mysqli_connect_error());
    }
?>