<?php
    session_start();
    require("../../config/conex.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $responsable = $_POST['responsable_dep'];

        $sql = "INSERT INTO departamento(name, responsable_dep) VALUES(?, ?)";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("ss", $name, $responsable);

        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "Departamento registrado con éxito.";
        } else {
            $alert_type = "danger";
            $alert_msg = "Error al registrar el departamento.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/usuarios.php");
        exit();
    }
?>