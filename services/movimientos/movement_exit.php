<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location: ../index.php');
        exit();
    }
    require('../../config/conex.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $usuario = $_SESSION['id'];
        $equipo = $_POST['equipo'];
        $type = $_POST['type'];
        $funcionario = $_POST['funcionario'];
        $motivo = $_POST['motivo'];
        $observaciones = $_POST['observaciones'];

        // Generar número de control único
        $n_control = uniqid('', false);

        $sql = "INSERT INTO movimientos (equipo, usuario, type ,funcionario, motivo, observaciones, n_control) VALUES(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('iiissss', $equipo, $usuario, $type, $funcionario, $motivo, $observaciones, $n_control);

        if($stmt -> execute()){
            $sql2 = "UPDATE equipos SET disponible = 1 WHERE id = $equipo";
            $stmt2 = $conn -> prepare($sql2);
            $stmt2 -> execute();
            $alert_type = "success";
            $alert_msg = "Salida del equipo registrada con éxito. Número de control: " . $n_control;
        } else {
            $alert_type = "danger";
            $alert_msg = "Error al registrar la salida del equipo.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        echo "<script type='text/javascript'>
                window.open('../reports/report_movement.php?n_control=" . $n_control . "', '_blank');
            </script>";
        header("Location: ../../pages/movimientos.php");
        exit();
    }
?>