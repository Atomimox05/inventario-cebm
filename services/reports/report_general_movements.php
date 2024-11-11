<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location: ../../index.php');
        exit();
    }
    require('../../fpdf/fpdf.php');
    require('../../config/conex.php');

    date_default_timezone_set('America/Caracas');
    $fecha = date('d/m/Y H:i:s');
    $contador = 1;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $type = $_POST['type'];
        $start = $_POST['start_date'];
        $end = $_POST['end_date'];

        // Preparar la consulta
        $sql = "SELECT * FROM movimientos WHERE type = ? AND date BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $type, $start, $end);
        $stmt->execute();
        $res = $stmt->get_result();

        if($type == 0) {
            $movimiento = 'SALIDA';
        } else {
            $movimiento = 'ENTRADA';
        }


        class PDF extends FPDF{
            // Cabecera de página
                function Header(){
                    $this->Image('../../src/assets/Logo-CEBM-270x270.png',15,10,28);
                    $this->SetFont('Times','',16);
                    $this->Cell(80);
                    $this->Cell(20,30,utf8_decode('Contraloría del Estado Bolivariano de Miranda'),0,0,'C');
                    $this->Ln(30);
                }
                
            // Pie de página
                function Footer(){
                    // Posición: a 1,5 cm del final
                    $this->SetY(-15);
                    // Arial italic 8
                    $this->SetFont('Arial','I',8);
                    // Número de página
                    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
                }
            }
        
            // Creación del objeto de la clase heredada
            $pdf = new PDF('L', 'mm', 'Letter');
            $pdf -> AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(100);
            $pdf->Cell(60,10,'REPORTE DE '. $movimiento .' DE BIENES MUEBLES', 0, 0, 'C');
            $pdf->Cell(100);
            $pdf->SetFont('Arial','B',9);
            $pdf->Ln(15);
            $pdf->Cell(130,10, utf8_decode('Rango de fechas: ' . $start . ' a ' . $end), 0, 0);
            $pdf->Cell(130,10,utf8_decode('Reporte solicitado por: ' . $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] . ' - Fecha: ' . $fecha), 0, 0, 'R' );
            $pdf->Ln(15);
            $pdf->Cell(5,10,utf8_decode('#'), 1, 0, 'C');
            $pdf->Cell(25,10,'ID control', 1, 0, 'C');
            $pdf->Cell(110,10,utf8_decode('Equipo'), 1, 0, 'C');
            $pdf->Cell(30,10,utf8_decode('Funcionario'), 1, 0, 'C');
            $pdf->Cell(30,10,utf8_decode('Motivo'), 1, 0, 'C');
            $pdf->Cell(30,10,utf8_decode('Fecha y hora'), 1, 0, 'C');
            $pdf->Cell(30,10,utf8_decode('Encargado'), 1, 0, 'C');
            $pdf->Ln();
            $pdf->SetFont('Arial','',9);

       
            if($res->num_rows == 0) {
                $pdf->Cell(260,10, 'No se encontraron movimientos en el rango de fechas ingresado.', 1, 0, 'C');
            } else {
                while($row = $res->fetch_assoc()){
                    $pdf->Cell(5,10,$contador, 1, 0, 'C');
                    if($type == 0) {
                        $pdf->Cell(25,10,utf8_decode($row['n_control']), 1, 0, 'C');
                    } else {
                        $pdf->Cell(25,10,'-', 1, 0, 'C');
                    }

                    $equipo = $row['equipo'];
                    $res2 = mysqli_query($conn, "SELECT * FROM equipos WHERE id = '$equipo'"); 
                    $row2 = mysqli_fetch_array($res2);

                    $descripcion = $row2['equipo'] . " - " . $row2['descripcion'];

                    $pdf->Cell(110,10,utf8_decode($descripcion), 1);

                    $func = $row['funcionario'];
                    $res4 = mysqli_query($conn, "SELECT * FROM empleados WHERE id= '$func'");
                    $row4 = mysqli_fetch_array($res4);
                    $funcionario = $row4['nombre'] . " " . $row4['apellido'];

                    $pdf->Cell(30,10,utf8_decode($funcionario), 1, 0, 'C');
                    $pdf->Cell(30,10,utf8_decode($row['motivo']), 1, 0, 'C');
                    $pdf->Cell(30,10,utf8_decode($row['date']), 1, 0, 'C');

                    $user = $row['usuario'];
                    $res3 = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$user'"); 
                    $row3 = mysqli_fetch_array($res3);

                    $pdf->Cell(30,10,utf8_decode($row3['nombre'] . " " . $row3['apellido']), 1, 0, 'C');
                    $pdf->Ln();
                    $contador++;
                }
            }
            $pdf->Ln(50);
            $pdf->Close();
            $pdf->Output();
    }
?>