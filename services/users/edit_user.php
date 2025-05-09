<?php
    session_start();
    require('../../config/conex.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $ci = $_POST['ci'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $username = $_POST['username'];
        $departamento = $_POST['departamento'];
        $rol = $_POST['rol'];

        $sql = "UPDATE usuarios SET ci = ?, nombre = ?, apellido = ?, username = ?, departamento = ?, rol = ? WHERE id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("ssssiii", $ci, $nombre, $apellido, $username, $departamento, $rol, $id);

        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "Usuario modificado con éxito.";
        }else{
            $alert_type = "danger";
            $alert_msg = "Error al modificar el usuario.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/usuarios.php");
        exit();
    }
?>