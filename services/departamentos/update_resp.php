<?php
    session_start();
    require("../../config/conex.php");

    $id = $_GET['id'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $responsable = $_POST['responsable_dep'];

        $sql = "UPDATE departamento SET responsable_dep = ? WHERE id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("si", $responsable, $id);

        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "Se ha cambiado el responsable del departamento.";
        } else {
            $alert_type = "danger";
            $alert_msg = "Error al cambiar el responsable del departamento.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/usuarios.php");
        exit();
    }
?>