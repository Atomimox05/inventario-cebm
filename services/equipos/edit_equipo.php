<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location: ../index.php');
        exit();
    }
    require('../../config/conex.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $equipo = $_POST['equipo'];
        $descripcion = $_POST['descripcion'];
        $n_bien = $_POST['n_bien'];
        $estatus = $_POST['estatus'];

        $sql = "UPDATE equipos SET equipo = ?, descripcion = ?, n_bien = ?, estatus = ? WHERE id = ?";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("sssii", $equipo, $descripcion, $n_bien, $estatus, $id);

        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "Equipo modificado con éxito.";
        }else{
            $alert_type = "danger";
            $alert_msg = "Error al modificar el equipo.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/equipos.php");
        exit();
    }
?>