<?php include ('../config/Header.php'); ?>
<?php include ('../config/NavBar.php'); ?>

    <section class="mt-5">
        <h3 class="text-center">Movimientos</h3>
        <div class="container mt-5">
            <div class="d-flex row justify-content-between">
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">Buscar</span>
                        <input type="text" class="form-control" placeholder="Equipo, dirección, funcionario, n° de control">
                        <input type="date" class="form-control" placeholder="Fecha">
                        <button class="btn btn-dark" type="button" id="button-addon2">Consultar</button>
                    </div>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#movimiento">Registar nuevo movimiento</button> 
                </div>             
            </div>
        </div>
        <div class="container d-flex justify-content-center mt-5">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">N° Control</th>
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
                    <tr>
                        <td>0-100018</td>
                        <td>Laptop portatil HP Latitude</td>
                        <td>Salida</td>
                        <td>Pepito El Paisa</td>
                        <td>Consejo legislativo</td>
                        <td>Auditoria</td>
                        <td>2021-01-01 - 12:00Hrs</td>
                        <td>Jefe de tecnología</td>
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
                </tbody>
            </table>
        </center>
    </section>

    <article class="modal fade" id="movimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar movimiento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="row g-2">
                        <div class="col-sm-6">
                            <label for="type" class="form-label">Tipo de movimiento</label>
                            <select class="form-select" name="type" id="type">
                                <option selected disabled>Seleccione...</option>
                                <option value="0">Salida</option>
                                <option value="1">Entrada</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="num_control" class="form-label">N° control (sólo para entradas)</label>
                            <input class="form-control" type="text" name="num_control" id="num_control">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="equipo">Equipo</label>
                            <input class="form-control" list="equipos" id="equipo" name="equipo" placeholder="Seleccione..."/>
                            <datalist id="equipos">
                                <option value="Equipo1"></option>
                                <option value="Equipo2"></option>
                            </datalist>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="responsable">Funcionario</label>
                            <input class="form-control" type="text" name="funcionario" id="responsable">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="cargo">Cargo</label>
                            <input class="form-control" type="text" name="cargo" id="cargo">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="motivo">Motivo del préstamo</label>
                            <input class="form-control" type="text" name="motivo" id="motivo">
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="responsable">Dirección adscrita</label>
                            <input class="form-control" type="text" name="dirección" id="responsable">
                        </div>
                        <!-- La fecha se obtiene al momento de enviar la solicitud al servidor -->
                        <div class="col-sm-12">
                            <label class="form-label" for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones"></textarea>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <input class="btn btn-primary" type="submit" value="Aceptar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </article>

<?php include ('../config/FooterHtml.php'); ?>