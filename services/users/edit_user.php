<?php
    require('../../config/conex.php');
    $id = $_GET['id'];
    $query = "SELECT * FROM usuarios WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
?>