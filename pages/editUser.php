<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header('location: ../index.php');
        exit();
    }
?>

<?php include ('../config/Header.php'); ?>
<?php include ('../config/NavBar.php'); ?>
<?php
    require('../config/conex.php');

    $id = $_GET['id'];
    $op = $_GET['op'];
    
    $query = "SELECT * FROM usuarios WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_array($result);
?>

<section class="mt-5">
    <h3 class="text-center">
        <?php
            if($op === 'e'){
                echo("Editar usuario");
            } else if ($op === 'p'){
                echo("Cambiar contraseña");
            }
        ?>
    </h3>
    <div class="container d-flex justify-content-center mt-5">
        <?php
            if($op === 'e'){
        ?>
        <form action="../services/users/edit_user.php" method="POST" class="row g-2" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo($id)?>">
            <div class="col-sm-6">
                <label class="form-label" for="ci">Cédula de identidad</label>
                <input class="form-control" name="ci" id="ci" maxlength="8" placeholder="14000000" value="<?php echo($user[3])?>">
            </div>
            <div class="col-sm-6">
                <label for="name" class="form-label">Nombre</label>
                <input class="form-control" type="text" name="nombre" id="name" maxlength="40" placeholder="Ingrese su nombre" value="<?php echo($user[1])?>" required>
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="apellido">Apellido</label>
                <input class="form-control" type="text" name="apellido" maxlength="40" id="apellido" placeholder="Ingrese su apellido" value="<?php echo($user[2])?>" required>
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="user">Nombre de usuario</label>
                <input class="form-control" type="text" name="username" id="user" placeholder="Ingrese su usuario" maxlength="30" value="<?php echo($user[7])?>" required>
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="rol">Perfil</label>
                <select class="form-select" name="rol" id="rol" required>
                    <option disabled>Seleccione...</option>
                    <?php
                        $roles = ["Administrador", "Analista"];
                        foreach($roles as $key => $role){
                            $selected = ($user[5] == $key) ? "selected" : "";
                            echo("<option value='$key' $selected>$role</option>");
                        }
                    ?>
                </select>
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="user">Dirección adscrita</label>
                <select class="form-select" name="departamento" id="departamento" required>
                    <option disabled>Seleccione...</option>
                    <?php
                        require('../config/conex.php');

                        $res = mysqli_query($conn, "SELECT * FROM departamento");
                        while($row = mysqli_fetch_array($res)){
                            if($user[4] == $row[0]){
                                ?>
                                <option selected value="<?php echo($row[0]); ?>"><?php echo($row[1]); ?></option>
                                <?php
                            } else {
                                ?>
                                <option value="<?php echo($row[0]); ?>"><?php echo($row[1]); ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="d-grid gap-2 mt-5">
                <input class="btn btn-dark" type="submit" value="Editar datos del usuario">
            </div>
        </form>
        <?php
            } elseif($op === 'p'){
        ?>
        <form action="../services/users/change_pass.php" method="POST" class="row g-2" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo($id)?>">
            <div class="col-sm-6">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <div class="col-sm-6">
                <label for="confirmPassword" class="form-label">Confirmar contraseña</label>
                <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirmar contraseña" required>
            </div>
            <div class="d-grid gap-2 mt-4">
                <input class="btn btn-dark" type="submit" value="Cambiar contraseña">
            </div>
        </form>
        <?php
            }
        ?>
    </div>
</section>

<?php 
    include('../config/FooterHtml.php'); 
    $conn->close();
?>