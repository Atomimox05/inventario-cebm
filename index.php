<?php
    include_once('config/conex.php');
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
                                <!-- <form method="post" action="/services/login.php" autocomplete="off"> -->
                                    <div class="mb-3">
                                        <label for="user" class="form-label">Usuario</label>
                                        <input class="form-control" type="text" name="user" id="user" placeholder="Ingrese su usuario" autofocus>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Ingrese su contraseña">
                                    </div>
                                    <div class="d-grid gap-2 mt-4">
                                        <!-- <input type="submit" class="btn btn-dark" value="Ingresar"> -->
                                        <a href="pages/movimientos.php" class="btn btn-dark">Ingresar</a>
                                    </div>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                    <div class="p-2 bg-dark"></div>
                    <div class="p-2 bg-danger"></div>
                    <div class="p-2 bg-warning"></div>
                </div>
            </div>
        </section>
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="bootstrap/js/popper.min.js"></script>
    </body>
</html>