<?php
session_start();
$idPass = 0;

if (!isset($_SESSION['id'])) {
    header('location: ../index.php');
    exit();
}
if ($_SESSION['rol'] == 1) {
    header('Location: movimientos.php');
    exit();
}
?>
<?php include('../config/Header.php'); ?>
<?php include('../config/NavBar.php'); ?>

<section class="mt-5">
    <h3 class="text-center">Gestión de usuarios</h3>
    <div class="container mt-5">
        <div class="d-flex row justify-content-end">
            <div class="col-sm-4">
                <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#usuario">
                    Crear nuevo usuario
                </button>
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#departamentos">Departamentos</button>
                <button type="button" class="btn btn-sm text-white btn-warning" data-bs-toggle="modal" data-bs-target="#funcionarios">Listado de personal</button>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center text-center mt-3">
        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">C.I.</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $contador = 1;
                require('../config/conex.php');

                $res = mysqli_query($conn, "SELECT * FROM usuarios");

                while ($row = mysqli_fetch_array($res)) {
                    if ($row[7] != 1) {
                ?>
                        <tr>
                            <td><?php echo ($contador); ?></td>
                            <td><?php echo ($row[1]); ?></td>
                            <td><?php echo ($row[2]); ?></td>
                            <td><?php echo ($row[3]); ?></td>
                            <td><?php echo ($row[7]); ?></td>
                            <td><?php if ($row[5] == 0) {
                                    echo ("Administrador");
                                } else if ($row[5] == 1) {
                                    echo ("Coordinador");
                                } else if ($row[5] == 2) {
                                    echo ("Analista");
                                } ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="editUser.php?id=<?php echo ($row[0]); ?>&op=e" class="btn btn-sm btn-dark">Editar</a>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDisable(<?php echo ($row[0]); ?>)">Deshabilitar</button>
                                    <a href="editUser.php?id=<?php echo ($row[0]); ?>&op=p" class="btn btn-sm btn-warning text-white">Cambiar contraseña</a>
                                </div>
                            </td>
                        </tr>
                <?php $contador++;
                    }
                } ?>
            </tbody>
        </table>
    </div>
</section>

<?php if (isset($_SESSION['alert_msg'])): ?>
    <footer class="container fixed-bottom absolute-bottom">
        <article class="d-flex justify-content-end mb-4">
            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?> alert-dismissible fade show shadow" role="alert">
                <?php echo $_SESSION['alert_msg']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </article>
    </footer>
<?php
    unset($_SESSION['alert_msg']);
    unset($_SESSION['alert_type']);
endif;
?>

<!-- Modal para crear nuevo usuario -->
<article class="modal fade" id="usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../services/users/save_user.php" method="POST" class="row g-2" autocomplete="off">
                    <div class="col-sm-6">
                        <label for="name" class="form-label">Nombre</label>
                        <input class="form-control" type="text" name="nombre" id="name" maxlength="40" placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="apellido">Apellido</label>
                        <input class="form-control" type="text" name="apellido" maxlength="40" id="apellido" placeholder="Ingrese su apellido" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="ci">Cédula de identidad</label>
                        <input class="form-control" name="ci" id="ci" maxlength="8" placeholder="14000000" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="rol">Rol</label>
                        <select class="form-select" name="rol" id="rol" required>
                            <option selected disabled>Seleccione...</option>
                            <option value="0">Administrador</option>
                            <option value="1">Analista</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="user">Departamento</label>
                        <select class="form-select" name="departamento" id="departamento" required>
                            <option selected disabled>Seleccione...</option>
                            <?php
                            require('../config/conex.php');

                            $res = mysqli_query($conn, "SELECT * FROM departamento");
                            while ($row = mysqli_fetch_array($res)) {
                            ?>
                                <option value="<?php echo ($row[0]); ?>"><?php echo ($row[1]); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="user">Nombre de usuario</label>
                        <input class="form-control" type="text" name="username" id="user" placeholder="Ingrese su usuario" maxlength="30" required>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="password">Contraseña</label>
                        <input class="form-control" type="password" name="password" placeholder="Ingrese su contraseña" maxlength="20" id="password" required>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <input class="btn btn-dark" type="submit" value="Registrar usuario">
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>

<!-- Modal departamentos -->
<article class="modal fade" id="departamentos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Departamentos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="row align-items-center" action="../services/departamentos/save_dep.php" method="POST">
                        <div class="col-sm-5">
                            <label class="form-label" for="dep_name">Nombre del departamento</label>
                            <input type="text" class="form-control" name="name" id="dep_name" maxlength="60" placeholder="Ingrese el nombre del departamento" required>
                        </div>
                        <div class="col-sm-5">
                            <label for="responsable" class="form-label">Responsable del departamento</label>
                            <input type="text" class="form-control" name="responsable_dep" id="responsable" maxlength="80" placeholder="Ingrese el nombre del responsable" required>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-sm btn-dark">Registrar departamento</button>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="container">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Responsable</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require('../config/conex.php');
                            $res = mysqli_query($conn, "SELECT * FROM departamento");
                            $contador = 1;
                            while ($row = mysqli_fetch_array($res)) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo ($contador); ?></th>
                                    <td><?php echo ($row[1]); ?></td>
                                    <td><?php echo ($row[2]); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Modificar responsable
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form action="../services/departamentos/update_resp.php?id=<?php echo ($row[0]); ?>" class="px-4 py-3 row g-3" autocomplete="off" method="post">
                                                        <div class="col-sm-12">
                                                            <label for="responsable2" class="form-label">Responsable del departamento</label>
                                                            <input type="text" class="form-control form-control-sm" name="responsable_dep" id="responsable2" maxlength="80" placeholder="Ingrese el nombre del responsable" required>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <button type="submit" class="btn btn-sm btn-warning text-light">Modificar</button>
                                                        </div>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $contador++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Modal Funcionarios -->
<article class="modal fade" id="funcionarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Listado de personal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Registrar funcionario
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form action="../services/users/register_funcionario.php" method="post" class="row items-center g-2">
                                    <div class="col-sm-6">
                                        <label class="form-label" for="">Nombre</label>
                                        <input class="form-control" maxlength="50" name="nombre" type="text" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="">Apellido</label>
                                        <input class="form-control" maxlength="50" name="apellido" type="text" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="">Cédula de identidad</label>
                                        <input class="form-control" text="text" maxlength="8" name="ci" type="text" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="">Cargo del funcionario</label>
                                        <input class="form-control" maxlength="50" name="cargo" type="text" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="">Departamento</label>
                                        <select class="form-select" name="departamento" required>
                                            <option selected disabled>Seleccione...</option>
                                            <?php
                                            require('../config/conex.php');

                                            $res = mysqli_query($conn, "SELECT * FROM departamento");
                                            while ($row = mysqli_fetch_array($res)) {
                                            ?>
                                                <option value="<?php echo ($row[0]); ?>"><?php echo ($row[1]); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-dark">Registrar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">C.I.</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $res = mysqli_query($conn, "SELECT * FROM empleados");

                        while ($row = mysqli_fetch_array($res)) {
                            if ($row[6] != 1) {
                        ?>
                                <tr>
                                    <td><?php echo ($counter); ?></td>
                                    <td><?php echo ($row[2]); ?></td>
                                    <td><?php echo ($row[3]); ?></td>
                                    <td><?php echo ($row[1]); ?></td>
                                    <td><?php echo ($row[4]); ?></td>
                                    <td>
                                        <?php
                                            $idDep = $row[5];
                                            $response = mysqli_query($conn, "SELECT * FROM departamento WHERE id= '$idDep'");
                                            $row2 = mysqli_fetch_array($response);
                                            echo($row2[1]);
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="confirmDisableFunc(<?php echo ($row[0]); ?>)">Deshabilitar</button>
                                    </td>
                                </tr>
                            <?php $counter++;
                            }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</article>

<script>
    const confirmDisable = (userId) => {
        if (confirm("¿Está seguro de que quiere deshabilitar este usuario?. Esta acción no se puede deshacer.")) {
            window.location.href = "../services/users/deshabilitar_user.php?id=" + userId;
        }
    }

    const confirmDisableFunc = (funcionarioID) => {
        if (confirm("¿Está seguro de que quiers deshabilitar a este funcionario?. Esta acción no se puede revertir.")) {
            window.location.href = "../services/users/deshabilitar_funcionario.php?id=" + funcionarioID;
        }
    }
</script>

<?php
include('../config/FooterHtml.php');
$conn->close();
?>