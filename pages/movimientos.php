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
        <div class="row">
            <div class="col-sm-7">
                <form action="movimientos.php" method="get" autocomplete="off">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">Buscar</span>
                        <input type="text" name="search" class="form-control" placeholder="ID de control, funcionario, dirección, motivo">
                        <input type="date" name="date" class="form-control" placeholder="Fecha">
                        <button class="btn btn-warning text-light" type="submit" id="button-addon2">Consultar</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#movimiento">Registar movimiento</button>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-danger">Reporte de movimientos</button>
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
                    <th scope="col">Dirección</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Fecha y hora</th>
                    <th scope="col">Encargado</th>
                    <th scope="col">Detalles</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $contador = 1;

                if (isset($_GET['search']) || isset($_GET['date'])) {
                    $search = $_GET['search'] ?? '';
                    $date = $_GET['date'] ?? '';

                    $stmt = $conn->prepare("SELECT * FROM movimientos WHERE (n_control LIKE ? OR motivo LIKE ? OR cargo LIKE ? OR direccion LIKE ? OR funcionario LIKE ? OR date LIKE ?) ORDER BY id DESC");

                    $search = "%$search%";
                    $date = "%$date%";

                    $stmt->bind_param("ssssss", $search, $search, $search, $search, $search, $date);

                    $stmt->execute();

                    $res = $stmt->get_result();
                } else {
                    $res = $conn->query("SELECT * FROM movimientos ORDER BY id DESC");
                }

                while ($row = mysqli_fetch_array($res)) {
            ?>
                <tr>
                    <td><?php echo ($contador); ?></td>
                    <td><?php if($row[10] != "") echo ($row[10]); else echo ("-") ?></td>
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
                    <td><?php echo ($row[8]); ?></td>
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
                        <form class="d-flex gap-2">
                            <div class="form-check">
                                <label for="aprobe" class="form-check-label">Aprobar</label>
                                <input class="form-check-input" type="checkbox" value="0" id="aprobe">
                            </div>
                            <button class="btn btn-sm btn-dark" type="button">Aceptar</button>
                        </form>
                        Aprobado por: (Usuario)
                    </td>
                </tr>
            <?php
                $contador++;
                }
            ?>
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
                                    <div class="col-sm-12">
                                        <label class="form-label" for="direccion">Dirección adscrita al préstamo</label>
                                        <input class="form-control" type="text" name="direccion" id="direccion" maxlength="100" required>
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
                                    <div class="col-sm-6">
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
                                    <div class="col-sm-6">
                                        <label class="form-label" for="direccion2">Dirección adscrita al préstamo</label>
                                        <input class="form-control" type="text" name="direccion" id="direccion2" maxlength="100" required>
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

<?php include('../config/FooterHtml.php'); ?>