<?php
    require('../../fpdf/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','R',12);
    $pdf->Cell(40,10,'CONTRALORÍA DEL ESTADO BOLIVARIANO DE MIRANDA');
    $pdf->Output();
?>