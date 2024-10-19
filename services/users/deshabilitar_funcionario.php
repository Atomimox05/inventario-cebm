<?php
    require('../../config/conex.php');
    session_start();

    if(!isset($_SESSION['id'])){
        header("Location: ../../index.php");
        exit();
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        $sql = "UPDATE empleados SET activo = 1 WHERE id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("i", $id);

        if($stmt -> execute()){
            $alert_type = "info";
            $alert_msg = "El funcionario fue deshabilitado exitosamente.";
        } else {
            $alert_type = "danger";
            $alert_msg = "Ocurrió un error al deshabilitar al funcionario.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/usuarios.php");
        exit();
    }
?>