<?php
    require('../config/conex.php');
    session_start();

    if(!isset($_SESSION['id'])){
        header('location: ../index.php');
        exit();
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $stmt = $conn -> prepare("DELETE FROM mantenimientos WHERE id = ?");
        $stmt -> bind_param("i", $id);

        if($stmt -> execute()){
            $alert_type = "info";
            $alert_msg = "El mantenimiento ha sido eliminado.";
        } else {
            $alert_type = "warning";
            $alert_msg = "Ocurrio un error al eliminar el mantenimiento.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/mantenimiento.php");
        exit();
    }
?>