<?php
    require('../../config/conex.php');
    session_start();

    if(!isset($_SESSION['id'])){
        header("Location: ../../index.php");
        exit();
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql_check = "SELECT disponible FROM equipos WHERE id = $id";
        $res = mysqli_query($conn, $sql_check);
        $row = mysqli_fetch_array($res);

        if($row[0] != 1){
            $sql = "UPDATE equipos SET activo = 1 WHERE id = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("i", $id);

            if($stmt -> execute()){
                $alert_type = "success";
                $alert_msg = "¡El equipo ha sido desincorporado del inventario!";
            } else {
                $alert_type = "danger";
                $alert_msg = "Ocurrió un error al desincorporar el equipo.";
            }
        } else {
            $alert_type = "warning";
            $alert_msg = "¡No se puede desincorporar a un equipo que se encuentre fuera de la institución del inventario!";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/equipos.php");
        exit();
    }
?>