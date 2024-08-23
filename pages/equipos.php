<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: ../index.php');
}
?>

<?php include('../config/Header.php'); ?>
<?php include('../config/NavBar.php'); ?>

<section class="mt-5">
    <h3 class="text-center">Equipos</h3>
    <div class="container mt-5">
        <div class="d-flex row justify-content-between">
            <div class="col-sm-8">
                <form action="equipos.php" method="GET" autocomplete="off">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">Buscar</span>
                        <input type="search" class="form-control" name="search" placeholder="Nombre, descripción o n° de bien">
                        <input class="btn btn-warning text-light" type="submit" id="button-addon2" value="Consultar">
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#equipo">Registar nuevo equipo</button>
                <button class="btn btn-secondary">Generar reporte</button>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center mt-5">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Equipo</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">N° de bien</th>
                    <th scope="col">Disponibilidad</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $contador = 1;
                require('../config/conex.php');

                if (isset($_GET['search'])) {
                    $search = $_GET['search'];

                    $sql = "SELECT * FROM equipos WHERE (equipo LIKE '%$search%' OR descripcion LIKE '%$search%' OR n_bien LIKE '%$search%')";
                    $res = mysqli_query($conn, $sql);
                } else {
                    $res = mysqli_query($conn, "SELECT * FROM equipos");
                }

                while ($row = mysqli_fetch_array($res)) {
                    if ($row[6] != 1) {
                ?>
                        <tr>
                            <td><?php echo ($contador); ?></td>
                            <td><?php echo ($row[1]); ?></td>
                            <td class="text-warp"><?php echo ($row[2]); ?></td>
                            <td><?php echo ($row[3]); ?></td>
                            <td>
                                <?php
                                if ($row[4] == 0) {
                                    echo ("Disponible");
                                } else {
                                    echo ("No disponible");
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                switch ($row[5]) {
                                    case 0:
                                        echo ("Excelentes condiciones");
                                        break;
                                    case 1:
                                        echo ("Buenas condiciones");
                                        break;
                                    case 2:
                                        echo ("Condiciones regulares");
                                        break;
                                    case 3:
                                        echo ("Malas condiciones");
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <div class="btn-group" role="group">
                                        <a href="editEquipo.php?id=<?php echo ($row[0]); ?>" type="button" class="btn btn-sm btn-dark">Editar</a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDisable(<?php echo ($row[0]); ?>)">Desincorporar</button>
                                    </div>
                                    <a href="mantenimiento.php?equipo=<?php echo ($row[0]); ?>" type="button" class="btn btn-sm btn-warning text-light">Mantenimientos</a>
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

<!-- MODAL PARA REGISTRAR UN NUEVO EQUIPO -->
<article class="modal fade" id="equipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo equipo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../services/equipos/create_equipo.php" class="row g-2" autocomplete="off">
                    <input type="hidden" name="activo" value="0">
                    <div class="col-sm-6">
                        <label for="name" class="form-label">Nombre del equipo</label>
                        <input class="form-control" type="text" name="equipo" id="name" maxlength="80" placeholder="Nombre del equipo" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="description">Descripción</label>
                        <input class="form-control" type="text" name="descripcion" id="description" placeholder="Modelo, marca, componentes" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="bien" class="form-label">N° de bien</label>
                        <input type="text" class="form-control" name="n_bien" id="bien" maxlength="8" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="status">Estatus</label>
                        <select class="form-control" name="estatus" id="status" required>
                            <option selected disabled>Seleccione...</option>
                            <option value="0">Excelentes condiciones</option>
                            <option value="1">Buenas condiciones</option>
                            <option value="2">Condiciones regulares</option>
                            <option value="3">Malas condiciones</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <input class="btn btn-dark" type="submit" value="Registrar nuevo equipo">
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>

<script>
    const confirmDisable = (equipo_id) => {
        if (confirm("¿Está seguro de que quiere desincorporar este equipo del inventario? Esta acción no se puede deshacer.")) {
            window.location.href = "../services/equipos/deshabilitar_equipo.php?id=" + equipo_id;
        }
    }
</script>

<?php include('../config/FooterHtml.php'); ?>