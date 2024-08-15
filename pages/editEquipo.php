<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header('location: ../index.php');
    }
?>

<?php include ('../config/Header.php'); ?>
<?php include ('../config/NavBar.php'); ?>
<?php
    require('../config/conex.php');

    $id = $_GET['id'];
    
    $query = "SELECT * FROM equipos WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_array($result);
?>

<section class="mt-5">
    <h3 class="text-center">Editar datos del equipo</h3>
    <div class="container d-flex justify-content-center mt-5">
        <form action="../services/equipos/edit_equipo.php" method="post" class="row g-2" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo($id)?>">
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
                <input class="btn btn-dark" type="submit" value="Editar datos del equipo">
            </div>
        </form>
    </div>
</section>