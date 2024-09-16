<?php
session_start();
require('../config/conex.php');

if (!isset($_SESSION['id'])) {
    header('location: ../index.php');
}
?>

<?php include('../config/Header.php'); ?>
<?php include('../config/NavBar.php'); ?>

<section class="mt-5">
    <h3 class="text-center">Movimientos</h3>
    <div class="container mt-5">
        <div class="d-flex row justify-content-between text-center">
            <div class="col-sm-7">
                <form action="" method="POST" autocomplete="off">
                    <div class="input-group">
                        <?php
                            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                        ?>
                            <a class="input-group-text text-decoration-none bg-secondary text-light" href="movimientos.php" id="basic-addon2">< Volver</a>
                        <?php } else { ?>
                        <span class="input-group-text" id="basic-addon2">Buscar</span>
                        <?php } ?>
                        <input type="search" name="search" class="form-control" placeholder="ID de control, funcionario, motivo">
                        <input type="date" name="date" class="form-control" placeholder="Fecha">
                        <button class="btn btn-warning text-light" type="submit" id="button-addon2">Consultar</button>
                    </div>
                </form>
            </div>
            <div class="col-sm">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#movimiento">Registar movimiento</button>
            </div>
            <div class="col-sm">
                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#reporte_movements_modal">
                    Historial de movimientos
                </button>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center mt-5">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID Control</th>
                    <th scope="col">Equipo</th>
                    <th scope="col">Movimiento</th>
                    <th scope="col">Funcionario</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Fecha y hora</th>
                    <th scope="col">Encargado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $contador = 1;
                $res = null;

                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $search = $_POST['search'];
                    $date = $_POST['date'];

                    $sql = "SELECT * FROM movimientos WHERE 1=1";

                    if (!empty($search)) {
                        $sql .= " AND (n_control LIKE '%$search%' OR motivo LIKE '%$search%' OR cargo LIKE '%$search%' OR funcionario LIKE '%$search%')";
                    }

                    if (!empty($date)) {
                        $sql .= " AND date LIKE '%$date%'";
                    }
                } else {
                    $sql = "SELECT * FROM movimientos ORDER BY id DESC";
                }

                $res = $conn->query($sql);

                if($res != null) {
                    if($res->num_rows > 0){
                        while ($row = mysqli_fetch_array($res)) {
        
            ?>
                <tr>
                    <td><?php echo ($contador); ?></td>
                    <td><?php if($row[9] != "") echo ($row[9]); else echo ("-") ?></td>
                    <td>
                        <?php
                            $equipo = $row[1];
                            $res2 = mysqli_query($conn, "SELECT * FROM equipos WHERE id = '$equipo'"); 
                            $row2 = mysqli_fetch_array($res2);
                            echo ($row2[1] . "<br>" . $row2[2]);
                        ?>
                    </td>
                    <td>
                        <?php
                           if ($row[3] == 0) {
                               echo ("Salida");
                           } else {
                               echo ("Entrada");
                           }
                        ?>
                    </td>
                    <td><?php echo ($row[4]); ?></td>
                    <td><?php echo ($row[6]); ?></td>
                    <td><?php echo ($row[7]); ?></td>
                    <td>
                        <?php
                            $user = $row[2];
                            $res3 = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$user'");
                            $row3 = mysqli_fetch_array($res3);
                            echo ($row3[1] . " " . $row3[2]);
                        ?>
                    </td>
                    <td>
                        <?php
                           if ($row[3] == 0) {
                        ?>
                        <a class="btn btn-sm btn-dark" href="../services/reports/report_movement.php?id=<?php echo $row[0]; ?>" target="_blank">Ver reporte</a>
                        <?php } else {?>
                            <small>No hay opciones disponibles</small>
                        <?php } ?>
                    </td>
                </tr>
            <?php
                $contador++;
                }} else {
            ?>
                <tr>
                    <td colspan="9">
                        <div class="alert alert-secondary mb-0" role="alert">
                            No se encontraron resultados. Intente con otros filtros.
                        </div>
                    </td>
                </tr>
            <?php }} ?>
            </tbody>
        </table>
    </div>
</section>

<?php if(isset($_SESSION['alert_msg'])): ?>
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

<!-- MODAL PARA REGISTRAR UN NUEVO MOVIMIENTO -->
<article class="modal fade" id="movimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar movimiento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Registar salida
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <form action="../services/movimientos/movement_exit.php" method="POST" class="row g-2">
                                    <input type="hidden" name="type" value="0"> <!-- 0 = salida, 1 = entrada -->
                                    <div class="col-sm-6">
                                        <label class="form-label" for="equipo">Equipo</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon4">Buscar</span>
                                            <input class="form-control" list="equipos" id="equipo" name="equipo" placeholder="Seleccione..." required/>
                                            <datalist id="equipos">
                                                <?php
                                                    require('../config/conex.php');

                                                    $res = mysqli_query($conn, "SELECT id,equipo, descripcion, n_bien FROM equipos WHERE disponible = 0 AND activo = 0");//Busca solo equipos que esten disponibles en inventario y activos
                                                    while($row = mysqli_fetch_array($res)){
                                                    ?>
                                                    <option value="<?php echo($row[0]); ?>">N° de bien: <?php echo($row[3]); ?> - <?php echo($row[1]); ?>, <?php echo($row[2]); ?></option>
                                                <?php } ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="responsable">Funcionario que retira</label>
                                        <input class="form-control" type="text" name="funcionario" id="responsable" maxlength="80" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="cargo">Cargo del funcionario</label>
                                        <input class="form-control" type="text" name="cargo" id="cargo" maxlength="30" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="motivo">Motivo del préstamo</label>
                                        <input class="form-control" type="text" name="motivo" id="motivo" maxlength="80" required>
                                    </div>
                                    <!-- La fecha se obtiene al momento de enviar la solicitud al servidor -->
                                    <div class="col-sm-12">
                                        <label class="form-label" for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones" maxlength="255" required></textarea>
                                    </div>
                                    <div class="d-grid gap-2 mt-4">
                                        <input class="btn btn-primary" type="submit" value="Registrar salida del equipo">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Registrar entrada
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <form action="../services/movimientos/movement_entry.php" method="POST" class="row g-2">
                                    <input type="hidden" name="type" value="1"> <!-- 0 = salida, 1 = entrada -->
                                    <div class="col-sm-12">
                                        <label class="form-label" for="n_control">ID de control</label>
                                        <input type="text" name="n_control" id="n_control" class="form-control" placeholder="Ingrese el ID de control asignado" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="responsable2" class="form-label">Funcionario que entrega</label>
                                        <input class="form-control" type="text" name="funcionario" id="responsable2" maxlength="80" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="cargo">Cargo del funcionario</label>
                                        <input class="form-control" type="text" name="cargo" id="cargo" maxlength="30" required>
                                    </div>
                                    <!-- La fecha se obtiene al momento de enviar la solicitud al servidor -->
                                    <div class="col-sm-12">
                                        <label class="form-label" for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones" maxlength="255" required></textarea>
                                    </div>
                                    <div class="d-grid gap-2 mt-4">
                                        <input class="btn btn-primary" type="submit" value="Registrar entrada del equipo">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- MODAL PARA SOLICITAR REPORTE DE MOVIMIENTOS -->
<div class="modal fade" id="reporte_movements_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Reporte de movimientos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../services/reports/report_general_movements.php" target="_blank" method="post" autocomplete="off">
                    <div class="row g-2">
                        <div class="col-sm-12">
                            <label class="form-label" for="type">Tipo de movimiento</label>
                            <select class="form-select" name="type" id="type" required>
                                <option disabled selected>Seleccione...</option>
                                <option value="0">Salida</option>
                                <option value="1">Entrada</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="start_date">Desde</label>
                            <input class="form-control" type="date" min="2024-09-01" name="start_date" id="start_date">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="end_date">Hasta</label>
                            <input class="form-control" type="date" name="end_date" id="end_date">
                        </div>
                        <div class="col-sm-12 mt-4">
                            <div class="d-grid gap-2">
                                <input class="btn btn-dark" type="submit" value="Generar reporte">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
    include('../config/FooterHtml.php'); 
    $conn->close();
?>