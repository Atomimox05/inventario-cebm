<?php
    session_start();
    require('../../config/conex.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $newPassword = $_POST['password'];
        $confirmPasswword = $_POST['confirmPassword'];


        if($newPassword === $confirmPasswword){
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt -> bind_param("si", $hashedPassword, $id);

            if($stmt -> execute()){
                $_SESSION['alert_type'] = "success";
                $_SESSION['alert_msg'] = "¡Contraseña cambiada éxitosamente!";
            }else{
                $_SESSION['alert_type'] = "warning";
                $_SESSION['alert_msg'] = "Error al cambiar la contraseña.";
            }
        } else {
            $_SESSION['alert_type'] = "danger";
            $_SESSION['alert_msg'] = "Las contraseñas ingresadas no coinciden.";
        }

        header("Location: ../../pages/usuarios.php");
        exit();
    } else {
        $_SESSION['alert_type'] = "info";
        $_SESSION['alert_msg'] = "Método de solicitud no aceptado.";
        header("Location: ../../pages/usuarios.php");
        exit();
    }

?>