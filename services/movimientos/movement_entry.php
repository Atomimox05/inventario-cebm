<?php
    session_start(); // Inicia la sesión
    require('../../config/conex.php'); // Requiere la configuración de la base de datos

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Obtiene los datos del formulario y de la sesión
        $usuario = $_SESSION['id'];
        $type = $_POST['type'];
        $funcionario = $_POST['funcionario'];
        $cargo = $_POST['cargo'];
        $observaciones = $_POST['observaciones'];
        $n_control = $_POST['n_control'];
        $defeated = 1;
        
        // Verificar si el número de control existe, corresponda una salida y no esté vencida
        $sql_check = "SELECT equipo, motivo FROM movimientos WHERE n_control = '$n_control' AND type = 0 AND defeated = 0";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            //Si el número de control existe, obtener los datos del equipo y el motivo
            $row = $result->fetch_assoc();
            $equipo = $row['equipo'];
            $motivo = $row['motivo'];
 
            // Insertar la entrada en la base de datos
            $sql = "INSERT INTO movimientos (equipo, usuario, type ,funcionario, cargo, motivo, observaciones, defeated) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param('iiissssi', $equipo, $usuario, $type, $funcionario, $cargo, $motivo, $observaciones, $defeated);

            if($stmt -> execute()){
                // Actualizar el estado del equipo a disponible
                $sql_update = "UPDATE equipos SET disponible = 0 WHERE id = $equipo";
                $stmt2 = $conn -> prepare($sql_update);
                if($stmt2 -> execute()){
                    $alert_type = "success";
                    $alert_msg = "Entrada del equipo registrada satisfactoriamente.";
                } else {
                    $alert_type = "danger";
                    $alert_msg = "Error al actualizar el estado del equipo.";
                }
            } else {
                $alert_type = "danger";
                $alert_msg = "Error al registrar la entrada del equipo.";
            }

            $_SESSION['alert_type'] = $alert_type;
            $_SESSION['alert_msg'] = $alert_msg;
            header("Location: ../../pages/movimientos.php");
            exit();
        } else {
            $alert_type = "danger";
            $alert_msg = "El ID de control no existe o no es válido.";
            $_SESSION['alert_type'] = $alert_type;
            $_SESSION['alert_msg'] = $alert_msg;
            exit();
        }
    }
?>