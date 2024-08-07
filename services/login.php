<?php
    require('../config/conex.php');
    session_start();

    $username = $_POST['user'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $rows = $result->num_rows;
    if($rows > 0){
        while($row = mysqli_fetch_array($result)){
            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['rol'] = $row['rol'];
        }
        header('location: ../pages/usuarios.php');
    } else {
        echo('username o password incorrectos');
    }
?>