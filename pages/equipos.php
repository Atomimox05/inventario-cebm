<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header('location: ../index.php');
    }
?>

<?php include ('../config/Header.php'); ?>
<?php include ('../config/NavBar.php'); ?>

    <section class="mt-5">
        <h3 class="text-center">Equipos</h3>
        <div class="container mt-5">
            <div class="d-flex row justify-content-between">
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">Buscar</span>
                        <input type="search" class="form-control" placeholder="Nombre, descripción, n° de bien, estatus">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Consultar</button>
                    </div>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#equipo">Registar nuevo equipo</button> 
                    <button class="btn btn-secondary">Generar reporte</button>
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-center mt-4">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">N° de bien</th>
                        <th scope="col">Disponibilidad</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Último mantenimiento</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Laptop HP</td>
                        <td>Laptop HP Latitude Intel core i7 6800 8GB 256GB SSD</td>
                        <td>0-2345</td>
                        <td>Disponible</td>
                        <td>Excelentes condiciones</td>
                        <td>2024-05-27</td>
                        <td>
                            <div class="d-flex gap-2">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-dark">Editar</button>
                                    <button type="button" class="btn btn-sm btn-danger">Desincorporar</button>
                                </div>
                                <button type="button" class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#mantenimiento">Mantenimiento</button>
                            </div>
                        </td>
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

    <!-- MODAL PARA REGISTRAR UN NUEVO EQUIPO -->
    <article class="modal fade" id="equipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo equipo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../services/equipos/create_equipo.php" class="row g-2">
                        <input type="hidden" name="activo" value="0">
                        <div class="col-sm-6">
                            <label for="name" class="form-label">Nombre del equipo</label>
                            <input class="form-control" type="text" name="equipo" id="name" maxlength="80" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="description">Descripción</label>
                            <input class="form-control" type="text" name="descripcion" id="description" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="bien" class="form-label">N° de bien</label>
                            <input type="text" class="form-control" name="n_bien" id="bien" maxlength="6" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="status">Estatus</label>
                            <select class="form-control" name="estatus" id="status" required>
                                <option selected disabled>Seleccione...</option>
                                <option value="1">Excelentes condiciones</option>
                                <option value="2">Buenas condiciones</option>
                                <option value="3">Condiciones regulares</option>
                                <option value="4">Malas condiciones</option>
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

    <!-- <article class="modal fade" id="equipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo equipo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="row g-2">
                        <div class="col-sm-6">
                            <label for="name" class="form-label">Nombre del equipo</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="description">Descripción</label>
                            <input class="form-control" type="text" name="description" id="description">
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <input class="btn btn-primary" type="submit" value="Registrar equipo">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </article> -->

    <article class="modal fade" id="mantenimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mantenimiento a equipo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="row g-2">
                        <div class="col">
                            <label for="date" class="form-label">Fecha del mantenimiento</label>
                            <input class="form-control" type="date" name="date" id="date">
                        </div>
                        <div class="col">
                            <label class="form-label" for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones"></textarea>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <input class="btn btn-primary" type="submit" value="Guardar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </article>

    <?php include ('../config/FooterHtml.php'); ?>