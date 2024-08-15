<?php
    include("../../config/conex.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $equipo = $_POST['equipo'];
        $descripcion = $_POST['descripcion'];
        $n_bien = $_POST['n_bien'];
        $estatus = $_POST['estatus'];
        $activate = $_POST['activo'];

        $sql = "INSERT INTO equipos(equipo, descripcion, n_bien, estatus, activo) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("sssii", $equipo, $descripcion, $n_bien, $estatus, $activate);

        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "Equipo registrado con éxito.";
        } else {
            $alert_type = "danger";
            $alert_msg = "Error al registrar el equipo.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/equipos.php");
        exit();
    }
?>