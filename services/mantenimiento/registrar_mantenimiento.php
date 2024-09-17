<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location: ../index.php');
        exit();
    }
    require('../../config/conex.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $equipo = $_POST['equipo'];
        $fecha_mant = $_POST['fecha_mant'];
        $observaciones = $_POST['observaciones'];
        $usuario = $_SESSION['id'];

        $query = "INSERT INTO mantenimientos (equipo, fecha_mant, observaciones, usuario) VALUES (?, ?, ?, ?)";
        $stmt = $conn -> prepare($query);
        $stmt -> bind_param("issi", $equipo, $fecha_mant, $observaciones, $usuario);

        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "Mantenimiento registrado con éxito.";
        } else {
            $alert_type = "danger";
            $alert_msg = "Error al registrar el mantenimiento.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/equipos.php");
        exit();
    }
?>