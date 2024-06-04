<?php
namespace ClassPart\Controllers;
use \ClassGrl\Fpdf;
use \AllowDynamicProperties;
#[AllowDynamicProperties]
class  Constancia extends Fpdf

{
 // Add a background image
 function Header()
 {
    $this->SetFont('Arial', 'B', 16);
        // Move to the right
        $this->Cell(45);
        // Title
        $this->Cell(140, 12, iconv('UTF-8', 'Windows-1252', 'CONSTANCIA MÉDICA DE ENFERMEDAD CELÍACA'), 1, 0, 'C');
        // Line break
        $this->Ln(20);
 }
/*
 public function Error($msg)
    {
        // Manejar el error aquí
    }

    //... */
}
