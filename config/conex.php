<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "proyecto";

    // $host = "localhost";
    // $user = "codejodc_derek";
    // $pass = "Py1thon.23";
    // $db = "codejodc_proyecto";


    $conn = new mysqli($host, $user, $pass, $db);

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
?>    