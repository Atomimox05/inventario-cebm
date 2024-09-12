<?php
    require('../../fpdf/fpdf.php');
    require('../../config/conex.php');

    $id = $_GET['id'];

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

    $sql = "SELECT * FROM movimientos WHERE id = $id";
    $res = mysqli_query($conn, $sql);

// Creación del objeto de la clase heredada
    $pdf = new PDF('P', 'mm', 'Legal');
    $pdf -> AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(80);
    $pdf->Cell(30,10,'CONTROL DE SALIDA Y ENTRADA DE BIENES MUEBLES', 0, 0, 'C');
    $pdf->Ln(15);
    $pdf->SetFont('Arial','',10);
    while($row = mysqli_fetch_array($res)){
        $pdf->Cell(100,10,'FECHA DE SALIDA DEL BIEN: '.$row[7], 1);
        $pdf->Cell(100,10,'ID DE CONTROL: '.$row[9], 1);
        $pdf->Ln();

        $equipo = $row[1];
        $res2 = mysqli_query($conn, "SELECT * FROM equipos WHERE id = '$equipo'"); 
        $row2 = mysqli_fetch_array($res2);

        $descripcion = "DESCRIPCIÓN DEL BIEN:\n" . $row2[1] . " - " . $row2[2] . "\nN° de bien: " . $row2[3];

        $pdf->MultiCell(200,10,utf8_decode($descripcion), 1);
        $pdf->Cell(200,10,utf8_decode('MOTIVO: '.$row[6]), 1);
        $pdf->Ln();
        $pdf->Cell(200,10,utf8_decode('FUNCIONARIO PÚBLICO RESPONSABLE (Nombre y cargo): '.$row[4] . " - " . $row[5]), 1);
        $pdf->Ln();
        $pdf->Cell(100,10,utf8_decode('USUARIO ENCARGADO'), 1, 0, 'C');

        $user = $row[2];
        $res3 = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$user'");
        $row3 = mysqli_fetch_array($res3);

        $pdf->Cell(100,10,utf8_decode($row3[1] . " " . $row3[2]), 1);
        $pdf->Ln();
        $pdf->Cell(100,25,utf8_decode('APROBADO'), 1, 0, 'C');
        $pdf->Cell(100,25, '', 1);
        $pdf->Ln();
        $pdf->Cell(100,25,utf8_decode('VERIFICADO (ÁREA DE BIENES Y ALMACÉN)'), 1, 0, 'C');
        $pdf->Cell(100,25, '', 1);
        $pdf->Ln();
        $pdf->Cell(100,25,utf8_decode('VERIFICADO (ÁREA DE SEGURIDAD Y CUSTODIA)'), 1, 0, 'C');
        $pdf->Cell(100,25, '', 1);
        $pdf->Ln();
        $pdf->Cell(200,15,utf8_decode('OBSERVACIONES: '.$row[8]), 1);
        $pdf->Ln();
        $pdf->Cell(200,10,utf8_decode('Fecha de retorno del bien: _______/_______/_______ '), 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(100,10,utf8_decode('ENCARGADO'), 1, 0, 'C');
        $pdf->Cell(100,10,'', 1);
        $pdf->Ln();
        $pdf->Cell(100,25,utf8_decode('APROBADO'), 1, 0, 'C');
        $pdf->Cell(100,25, '', 1);
        $pdf->Ln();
        $pdf->Cell(100,25,utf8_decode('VERIFICADO (ÁREA DE BIENES Y ALMACÉN)'), 1, 0, 'C');
        $pdf->Cell(100,25, '', 1);
        $pdf->Ln();
        $pdf->Cell(100,25,utf8_decode('VERIFICADO (ÁREA DE SEGURIDAD Y CUSTODIA)'), 1, 0, 'C');
        $pdf->Cell(100,25, '', 1);
        $pdf->Ln();
        $pdf->Cell(200,20,utf8_decode('OBSERVACIONES:'), 1);
    }
    $pdf->Close();
    $pdf->Output();
?>