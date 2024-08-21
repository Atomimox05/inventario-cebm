<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: ../index.php');
}
?>
<?php include('../config/Header.php'); ?>
<?php include('../config/NavBar.php'); ?>
<?php
    require('../config/conex.php');

    $equipo = $_GET['equipo'];

    $query = "SELECT * FROM mantenimientos WHERE equipo = $equipo";
    $result = mysqli_query($conn, $query);
    $mant_equipo = mysqli_fetch_array($result);
?>

<section class="mt-5">
    <h3 class="text-center">Mantenimiento a equipo</h3>

    <div class="container mt-4">
        <h6><strong>Nombre del equipo:</strong></h6>
        <h6><strong>Descripción:</strong></h6>
    </div>
    <div class="container mt-4">
        <form class="row g-3 align-items-center mb-4">
            <div class="col">
                <label for="fecha" class="form-label">Fecha de mantenimiento realizado</label>
                <input type="date" name="fecha_mant" class="form-control" id="fecha"required>
            </div>
            <div class="col">
                <label class="form-label" for="observaciones">Observaciones</label>
                <input class="form-control" name="observaciones" id="observaciones">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark">Registrar mantenimiento</button>
            </div>
        </form>
    </div>
    <hr>
    <div class="container mt-4">
        <h5 class="text-center">Historico de mantenimientos</h5>
        <table class="table table-hover text-center mt-4">
            <thead>
                <tr>
                    <th scope="col">Fecha del mantenimiento</th>
                    <th scope="col">Usuario encargado</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
        
</section>

<?php include('../config/FooterHtml.php'); ?>