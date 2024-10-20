<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: ../index.php');
    exit();
}
?>
<?php include('../config/Header.php'); ?>
<?php include('../config/NavBar.php'); ?>
<?php
    require('../config/conex.php');

    if(isset($_GET['equipo'])){
        $id_equipo = $_GET['equipo'];

        $stmt = $conn -> prepare("SELECT equipo, descripcion, n_bien FROM equipos WHERE id = ?");
        $stmt -> bind_param("i", $id_equipo);
        $stmt -> execute();
        $resultEquipo = $stmt -> get_result();
        $equipo = $resultEquipo -> fetch_assoc();
        $stmt -> close();
    } else {
        header('location: equipos.php');
        exit();
    }
?>

<section class="mt-5">
    <h3 class="text-center">Mantenimiento a equipo</h3>

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-4">
                <h6><strong>Nombre del equipo: </strong> <?php echo($equipo['equipo'])?></h6>
            </div>
            <div class="col-sm-4">
                <h6><strong>Descripción: </strong> <?php echo($equipo['descripcion'])?></h6>
            </div>
            <div class="col-sm-4">
                <h6><strong>N° de bien: </strong> <?php echo($equipo['n_bien'])?></h6>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <form action="../services/mantenimiento/registrar_mantenimiento.php" method="POST" class="row g-3 align-items-center mb-4">
            <input type="hidden" name="equipo" value="<?php echo($id_equipo)?>">
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
                <?php
                    $result = mysqli_query($conn, "SELECT * FROM mantenimientos WHERE equipo = $id_equipo");

                    if(mysqli_num_rows($result) > 0){
                        while ($mant = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td>
                        <?php echo ($mant[2]); ?>
                    </td>
                    <td>
                        <?php
                            $queryUser = "SELECT nombre, apellido FROM usuarios WHERE id = $mant[3]";
                            $resultUser = mysqli_query($conn, $queryUser);
                            $user = mysqli_fetch_array($resultUser);

                            echo ($user[0] . ' ' . $user[1]);
                        ?>
                    </td>
                    <td>
                        <?php echo ($mant[4]); ?>
                    </td>
                    <td>
                    <?php
                        if($_SESSION['rol'] == 1){
                    ?>
                    <small>No hay opciones disponibles</small>
                    <?php
                        } elseif ($_SESSION['rol'] == 0) {
                    ?>
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo ($mant[0]); ?>)">Eliminar</button>
                    <?php } ?>
                    </td>
                <?php
                    }} else {
                ?>
                <tr>
                    <td colspan="4">
                        <div class="alert alert-info mb-0" role="alert">
                            Este equipo no tiene ningún registro de mantenimiento.
                        </div>
                    </td>
                </tr>
                <?php
                    }
                ?>
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

<script>
    const confirmDelete = (id) => {
        if (confirm('¿Estás seguro de que deseas eliminar este registro de mantenimiento? Esta acción no se puede deshacer.')) {
            window.location.href = '../services/mantenimiento/delete_mantenimiento.php?id=' + id;
        }
    }
</script>

<?php 
    include('../config/FooterHtml.php'); 
    $conn->close();
?>