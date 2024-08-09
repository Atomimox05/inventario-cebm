<?php
    require('../../config/conex.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        $sql = "UPDATE usuarios SET estatus = 1 WHERE id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i", $id);

        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "¡El usuario ha sido deshabilitado!";
        } else {
            $alert_type = "danger";
            $alert_msg = "Ocurrió un error al deshabilitar el usuario.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/usuarios.php");
        exit();
    }
?>