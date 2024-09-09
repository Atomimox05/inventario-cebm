<?php
    //Inicia la sesión y establece la conexión a la base de datos
    $msj_error= "";
    require('config/conex.php');
    session_start();

    //Valida la sesión activa y redireciona a la página de inicio
    if(isset($_SESSION['id'])){
        header('location: pages/movimientos.php');
        exit(); //Evita que se siga ejecutando el script despues de redireccionar
    }

    //Procesa que el formulario haya sido enviado
    if(!empty($_POST)){
        //Valida que el usuario y la contraseña no esten vacios
        if(empty($_POST['user']) || empty($_POST['password'])){
            $msj_error = "Ingrese su usuario y contraseña.";
        } else {
            //Escapa los caracteres especiales para evitar inyecciones SQL
            $username = mysqli_real_escape_string($conn, $_POST['user']);
            $pass = $_POST['password'];

            $msj_error = "";

            //Prpepara la sentencia SQL
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
                    $msj_error = "Este usuario se encuentra inhabilitado para ingresar al sistema. Comuniquese con el administrador.";
                } else {
                    //Valida que la contraseña sea correcta
                    if(password_verify($pass, $row['password'])){
                        //Inicia la sesión y redirecciona a la página de inicio
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['nombre'] = $row['nombre'];
                        $_SESSION['apellido'] = $row['apellido'];
                        $_SESSION['rol'] = $row['rol'];
                        header('location: pages/movimientos.php');
                        exit();
                    } else {
                        $msj_error = "Usuario o contraseña incorrecta.";
                    }
                }
            } else {
                $msj_error = "Usuario o contraseña incorrecta.";
            }
        }
    }
?>
<!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CONTROL DE BIENES MUEBLES - CEBM</title>
        <link rel="shortcut icon" href="src/assets/Logo-CEBM-270x270.png" type="image/png">
        <link rel="stylesheet" href="src/global.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <section>
            <br><br><br><br>
            <div class="container mt-5">
                <div class="d-flex justify-content-center mt-5">
                    <div class="card w-100 p-5 shadow-sm">
                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <img src="src/assets/Logo-CEBM-270x270.png" style="height: 200px;"  alt="Logo CEBM">
                                <h5 class="mt-3"><strong>CONTROL DE BIENES MUEBLES</strong></h5>
                                <h5>Contraloría del Estado Bolivariano de Miranda</h5>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="text-center fw-bold text-danger mb-3">Iniciar <span class="text-dark-emphasis">Sesión</span></h4>
                                <form method="POST" action="index.php" autocomplete="off">
                                    <div class="mb-3">
                                        <label for="user" class="form-label">Usuario</label>
                                        <input class="form-control" type="text" name="user" id="user" placeholder="Ingrese su usuario" autofocus required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Ingrese su contraseña" aria-describedby="passwordHelpBlock" required>
                                    </div>
                                    <div id="passwordHelpBlock" class="form-text text-danger text-center">
                                        <span class="fw-bold"><?php echo isset($msj_error) ? $msj_error : ''; ?></span>
                                    </div>
                                    <div class="d-grid gap-2 mt-4">
                                        <input type="submit" class="btn btn-dark" value="Ingresar">
                                        <!-- <a href="pages/movimientos.php" class="btn btn-dark">Ingresar</a> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 bg-dark"></div>
                    <div class="p-2 bg-danger"></div>
                    <div class="p-2 bg-warning"></div>
                </div>
            </div>
        </section>
        <script src="bootstrap/js/bootstrap.bundle.min.js" defer></script>
        <script src="bootstrap/js/popper.min.js" defer></script>
    </body>
</html>