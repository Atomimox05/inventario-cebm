<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "proyecto";

    $conn = new mysqli($host, $user, $pass, $db);

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
?>    