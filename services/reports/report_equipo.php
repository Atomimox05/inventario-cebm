<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location: ../index.php');
        exit();
    }
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

    $sql = "SELECT * FROM equipos";
    $res = mysqli_query($conn, $sql);

    // Creación del objeto de la clase heredada
    $pdf = new PDF('L', 'mm', 'Letter');
    $pdf -> AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(100);
    $pdf->Cell(60,10,'REPORTE DE INVENTARIO DE BIENES MUEBLES', 0, 0, 'C');
    $pdf->Cell(100);
    $pdf->SetFont('Arial','B',9);
    $pdf->Ln(15);
    $pdf->Cell(60,10);
    $pdf->Cell(200,10,utf8_decode('Reporte solicitado por: ' . $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] . ' - Fecha: ' . $fecha), 0, 0, 'R' );
    $pdf->Ln(15);
    $pdf->Cell(10,10,utf8_decode('#'), 1, 0, 'C');
    $pdf->Cell(50,10,'Equipo', 1, 0, 'C');
    $pdf->Cell(100,10,utf8_decode('Descripción'), 1, 0, 'C');
    $pdf->Cell(30,10,utf8_decode('N° de bien'), 1, 0, 'C');
    $pdf->Cell(30,10,utf8_decode('Disponibilidad'), 1, 0, 'C');
    $pdf->Cell(40,10,utf8_decode('Integridad'), 1, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('Arial','',9);
    while($row = mysqli_fetch_array($res)){
        if ($row[6] != 1) {
            $descripcion = $row[2];
            if ($row[4] == 0) {
                $disponible = ("Disponible");
            } else {
                $disponible = ("No disponible");
            }
            switch ($row[5]) {
                case 0:
                    $integridad = ("Excelentes condiciones");
                    break;
                case 1:
                    $integridad = ("Buenas condiciones");
                    break;
                case 2:
                    $integridad = ("Condiciones regulares");
                    break;
                case 3:
                    $integridad = ("Malas condiciones");
                    break;
            }
            $pdf->Cell(10,10,$contador, 1, 0, 'C');
            $pdf->Cell(50,10,utf8_decode($row[1]), 1, 0, 'C');
            $pdf->Cell(100,10,utf8_decode($descripcion), 1, 0, 'C');
            $pdf->Cell(30,10,utf8_decode($row[3]), 1, 0, 'C');
            $pdf->Cell(30,10,utf8_decode($disponible), 1, 0, 'C');
            $pdf->Cell(40,10,utf8_decode($integridad), 1, 0, 'C');
            $pdf->Ln();
            $contador++;
        }
    }
    $pdf->Ln(50);
    $pdf->Cell(60,10);
    $pdf->Cell(140,10,utf8_decode('VERIFICADO (ÁREA DE BIENES Y ALMACÉN)'), 'T', 0, 'C');
    $pdf->Cell(60,10);
    $pdf->Close();
    $pdf->Output();
?>