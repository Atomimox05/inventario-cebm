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
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2">Buscar</span>
                    <input type="text" class="form-control" placeholder="Equipo, dirección, funcionario, n° de control">
                    <input type="date" class="form-control" placeholder="Fecha">
                    <button class="btn btn-warning text-light" type="button" id="button-addon2">Consultar</button>
                </div>
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
                    <th scope="col">Salida</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $contador = 1;

                $res = mysqli_query($conn, "SELECT * FROM movimientos");
                while ($row = mysqli_fetch_array($res)) {
            ?>
                <tr>
                    <td><?php echo ($contador); ?></td>
                    <td><?php echo ($row[10]); ?></td>
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
                                    <input type="hidden" name="type" value="0">
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
                                        <label class="form-label" for="responsable">Dirección adscrita al préstamo</label>
                                        <input class="form-control" type="text" name="direccion" id="responsable" maxlength="100" required>
                                    </div>
                                    <!-- La fecha se obtiene al momento de enviar la solicitud al servidor -->
                                    <div class="col-sm-12">
                                        <label class="form-label" for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones" maxlength="255" required></textarea>
                                    </div>
                                    <div class="d-grid gap-2 mt-4">
                                        <input class="btn btn-primary" type="submit" value="Registrar movimiento">
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
                            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<?php include('../config/FooterHtml.php'); ?>