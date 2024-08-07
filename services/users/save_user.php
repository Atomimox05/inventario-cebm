<?php
    include('../../config/conex.php');

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $ci = $_POST['ci'];
    $n_carnet = $_POST['n_carnet'];
    $departamento = $_POST['departamento'];
    $rol = $_POST['rol'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql= "INSERT INTO usuarios(nombre, apellido, ci, n_carnet, departamento, rol, username, password) VALUES('$nombre', '$apellido', '$ci', '$n_carnet', '$departamento', '$rol', '$username', '$password')";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        die("Query Failed.");
    } else {
        header('location: ../../pages/usuarios.php');
        echo('');
    }
?>