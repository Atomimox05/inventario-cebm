<?php include ('../config/Header.php'); ?>
<?php include ('../config/NavBar.php'); ?>

    <section class="mt-5">
        <h3 class="text-center">Usuarios</h3>
        <div class="container d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#usuario">
                Crear nuevo usuario
            </button>
        </div>
        <div class="container d-flex justify-content-center mt-4">
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">C.I.</th>
                        <th scope="col">N° Carnet</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $contador = 1;
                        require('../config/conex.php');

                        $res = mysqli_query($conn, "SELECT * FROM usuarios");

                        while($row = mysqli_fetch_array($res)){ 
                    ?>           
                    <tr>
                        <td><?php echo($contador); ?></td>
                        <td><?php echo($row[1]); ?></td>
                        <td><?php echo($row[2]); ?></td>
                        <td><?php echo($row[3]); ?></td>
                        <td><?php echo($row[4]); ?></td>
                        <td><?php echo($row[8]); ?></td>
                        <td><?php if($row[6] == 0){ echo("Administrador"); } else if ($row[6] == 1){ echo("Coordinador"); } else { echo("Analista"); } ?></td>
                        <td>
                            <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#usuario">Editar</button>
                            <button class="btn btn-sm btn-danger">Deshabilitar</button>
                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#usuario">Cambiar contraseña</button>
                        </td>
                    </tr>
                    <?php $contador++; } ?>
                </tbody>
            </table>
        </div>
    </section>

    <div class="modal fade" id="usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input class="form-control" type="text" name="nombre" id="name" maxlength="40" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="apellido">Apellido</label>
                            <input class="form-control" type="text" name="apellido" maxlength="40" id="apellido" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="ci">Cédula de identidad</label>
                            <input  class="form-control" name="ci" id="ci" maxlength="8" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="carnet">N° de carnet</label>
                            <input class="form-control" type="text" name="n_carnet" id="carnet" maxlength="6" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="rol">Perfil</label>
                            <select class="form-select" name="rol" id="rol" required>
                                <option selected disabled>Seleccione...</option>
                                <option value="0">Administrador</option>
                                <option value="1">Coordinador</option>
                                <option value="2">Analista</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="user">Departamento</label>
                            <select class="form-select" name="departamento" id="departamento" required>
                                <option selected disabled>Seleccione...</option>
                                <?php
                                require('../config/conex.php');

                                $res = mysqli_query($conn, "SELECT * FROM departamento");
                                while($row = mysqli_fetch_array($res)){
                                ?>
                                <option value="<?php echo($row[0]); ?>"><?php echo($row[1]); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="user">Usuario</label>
                            <input class="form-control" type="text" name="username" id="user" maxlength="30" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="password">Contraseña</label>
                            <input class="form-control" type="password" name="password" maxlength="20" id="password" required>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <input class="btn btn-primary" type="submit" value="Registrar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

<?php include ('../config/FooterHtml.php'); ?>