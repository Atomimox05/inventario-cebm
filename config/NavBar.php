<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header('Location: ../index.php');
        exit();
    }

    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $rol = $_SESSION['rol'];
?>

<header>
    <nav class="navbar navbar-expand-md bg-warning-subtle p-2">
        <div class="container">
            <span class="navbar-brand text-muted">
                <img src="../src/assets/Logo-CEBM-270x270.png" style="height: 68px;" alt="Logo CEBM" class="d-inline-block align-text-center me-2">
                Control de bienes muebles - CEBM
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="d-flex">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="movimientos.php">Movimientos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="equipos.php">Equipos</a>
                            </li>
                            <?php
                                if($rol != 1){
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="usuarios.php">Usuarios</a>
                            </li>
                            <?php
                                }
                            ?>
                            <li class="nav-item dropdown">
                                <button class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $nombre.' '.$apellido; ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <!-- <li><a class="dropdown-item" href="#">Manual de usuario</a></li>
                                    <li><hr class="dropdown-divider"></li> -->
                                    <li><a class="dropdown-item" href="../services/logout.php">Cerrar sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>