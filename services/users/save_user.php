<?php
    session_start();
    require('../../config/conex.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $ci = $_POST['ci'];
        $n_carnet = $_POST['n_carnet'];
        $departamento = $_POST['departamento'];
        $rol = $_POST['rol'];
        $username = $_POST['username'];
        $pass = $_POST['password'];

        //Encripta la contraseña usando el algoritmo de hash
        $password = password_hash($pass, PASSWORD_DEFAULT);

        //PREPARA LA SENTENCIA SQL
        $sql= "INSERT INTO usuarios(nombre, apellido, ci, n_carnet, departamento, rol, username, password) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('ssssiiss', $nombre, $apellido, $ci, $n_carnet, $departamento, $rol, $username, $password);
        
        //EJECUTA LA SENTENCIA SQL Y MUESTRA ALERTAS SEGÚN EL RESULTADO
        if($stmt -> execute()){
            $alert_type = "success";
            $alert_msg = "Usuario registrado con éxito.";
        } else {
            $alert_type = "danger";
            $alert_msg = "Error al registrar el usuario.";
        }

        $_SESSION['alert_type'] = $alert_type;
        $_SESSION['alert_msg'] = $alert_msg;
        header("Location: ../../pages/usuarios.php");
        exit();
    }
?>