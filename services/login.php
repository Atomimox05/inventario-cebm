<?php
    //Inicia la sesión y establece la conexión a la base de datos
    $msj_error= "";
    require('../config/conex.php');
    session_start();

    //Valida la sesión activa y redireciona a la página de inicio
    if(isset($_SESSION['id'])){
        header('location: ../pages/movimientos.php');
        exit(); //Evita que se siga ejecutando el script despues de redireccionar
    }

    //Procesa que el formulario haya sido enviado
    if(!empty($_POST)){
        //Valida que el usuario y la contraseña no esten vacios
        if(empty($_POST['user']) || empty($_POST['password'])){
            $_SESSION['msj_error'] = "Ingrese su usuario y contraseña.";
        } else {
            //Escapa los caracteres especiales para evitar inyecciones SQL
            $username = mysqli_real_escape_string($conn, $_POST['user']);
            $pass = $_POST['password'];

            $_SESSION['msj_error'] = "";

            //Prepara la sentencia SQL
            $sql = "SELECT * FROM usuarios WHERE username = ?";
            $stmt = $conn -> prepare($sql);
            //Vincula los valores de la consulta (s = string)
            $stmt -> bind_param('s', $username);
            $stmt -> execute();
            $result = $stmt -> get_result();
            $rows = $result->num_rows;

            //Valida que el usuario exista
            if($rows > 0){
                $row = $result -> fetch_assoc();
                //Valida que el usuario este habilitado
                if($row['estatus'] == 1){
                    $_SESSION['msj_error'] = "Este usuario se encuentra inhabilitado para ingresar al sistema. Comuniquese con el administrador.";
                    header("Location: ../index.php");
                    exit();
                } else {
                    //Valida que la contraseña sea correcta
                    if(password_verify($pass, $row['password'])){
                        //Inicia la sesión y redirecciona a la página de inicio
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['nombre'] = $row['nombre'];
                        $_SESSION['apellido'] = $row['apellido'];
                        $_SESSION['rol'] = $row['rol'];
                        header('Location: ../pages/movimientos.php');
                        exit();
                    } else {
                        $_SESSION['msj_error'] = "Usuario o contraseña incorrecta.";
                        header("Location: ../index.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['msj_error'] = "Usuario o contraseña incorrecta.";
                header("Location: ../index.php");
                exit();
            }
        }
    }
?>