<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location: ../../index.php');
        exit();
    }

    $id_equipo = $_GET['id'];

    require('../../fpdf/fpdf.php');
    require('../../config/conex.php');

    date_default_timezone_set('America/Caracas');
    $fecha = date('d/m/Y H:i:s');
    $contador = 1;

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

    $sql = "SELECT * FROM mantenimientos WHERE equipo = $id_equipo";
    $res = mysqli_query($conn, $sql);

    // Creación del objeto de la clase heredada
    $pdf = new PDF('L', 'mm', 'Letter');
    $pdf -> AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(100);
    $pdf->Cell(60,10,'REPORTE DE MANTENIMIENTO A EQUIPOS', 0, 0, 'C');
    $pdf->Cell(100);
    $pdf->SetFont('Arial','B',9);
    $pdf->Ln(12);
    $pdf->Cell(60,10);
    $pdf->Cell(200,10,utf8_decode('Reporte solicitado por: ' . $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] . ' - Fecha: ' . $fecha), 0, 0, 'R' );
    $pdf->Ln(15);
    $pdf->Cell(10,10,utf8_decode('#'), 1, 0, 'C');
    $pdf->Cell(120,10,'Detalles del equipo', 1, 0, 'C');
    $pdf->Cell(30,10,utf8_decode('Fecha'), 1, 0, 'C');
    $pdf->Cell(30,10,utf8_decode('Responsable'), 1, 0, 'C');
    $pdf->Cell(70,10,utf8_decode('Observaciones'), 1, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('Arial','',9);
    while($row = mysqli_fetch_array($res)){
        $pdf->Cell(10,10,$contador, 1, 0, 'C');

        $equipo = $row[1];
        $res2 = mysqli_query($conn, "SELECT * FROM equipos WHERE id = '$row[1]'"); 
        $row2 = mysqli_fetch_array($res2);

        $descripcion = $row2[1] . " - " . $row2[2];

        $pdf->Cell(120,10,utf8_decode($descripcion), 1, 0, 'C');
        $pdf->Cell(30,10,utf8_decode($row[2]), 1, 0, 'C');

        $user = $row[3];
        $res3 = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$user'"); 
        $row3 = mysqli_fetch_array($res3);

        $pdf->Cell(30,10,utf8_decode($row3[1] . " " . $row3[2]), 1, 0, 'C');
        $pdf->Cell(70,10,utf8_decode($row[4]), 1, 0, 'C');
        $pdf->Ln();
        $contador++;
    }
    $pdf->Ln(50);
    $pdf->Cell(60,10);
    $pdf->Cell(140,10,utf8_decode('VERIFICADO POR ENCARGADO'), 'T', 0, 'C');
    $pdf->Cell(60,10);
    $pdf->Close();
    $pdf->Output();
    $pdf->Close();
    $pdf->Output();
?>