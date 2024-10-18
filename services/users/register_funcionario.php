<?php
    session_start();
    require('../../config/conex.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $ci = $_POST['ci'];
        $departamento = $_POST['departamento'];
        $cargo = $_POST['cargo'];

        //Encripta la contraseña usando el algoritmo de hash
        $password = password_hash($pass, PASSWORD_DEFAULT);

        //PREPARA LA SENTENCIA SQL
        $sql= "INSERT INTO empleados(nombre, apellido, ci, departamento, cargo) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('sssis', $nombre, $apellido, $ci, $departamento, $cargo);
        
        //EJECUTA LA SENTENCIA SQL Y MUESTRA ALERTAS SEGÚN EL RESULTADO
        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "Funcionario registrado con éxito.";
        } else {
            $alert_type = "danger";
            $alert_msg = "Error al registrar el funcionario.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/usuarios.php");
        exit();
    }
?>