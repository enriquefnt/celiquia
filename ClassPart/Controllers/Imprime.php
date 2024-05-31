<?php

namespace ClassPart\Controllers;

use \ClassGrl\Fpdf;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class  Imprime extends Fpdf

{

    // Page header
    function Header()
    {
        // Logo
        $this->Image('imagenes/logo.png', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 16);
        // Move to the right
        $this->Cell(45);
        // Title
        $this->Cell(140, 12, iconv('UTF-8', 'Windows-1252', 'Ficha de investigación de Enfermedad Celíaca'), 1, 0, 'C');
        // Line break
        $this->Ln(20);
    }
}
