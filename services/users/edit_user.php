<?php
    require('../../config/conex.php');
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $n_carnet = $_POST['n_carnet'];
    $departamento = $_POST['departamento'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', n_carnet = '$n_carnet', departamento = '$departamento', rol = '$rol' WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } else {
        header('location: ../../pages/usuarios.php');
    }
?>