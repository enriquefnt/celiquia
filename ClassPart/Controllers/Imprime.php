<?php

namespace ClassPart\Controllers;

use \ClassGrl\Fpdf;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class  Imprime extends Fpdf

{


    function Header()
    {

        $this->Image('imagenes/logo.png', 10, 6, 30);

        $this->SetFont('Arial', 'B', 16);

        $this->Cell(45);

        $this->Cell(140, 12, iconv('UTF-8', 'Windows-1252', 'Ficha de investigación de Enfermedad Celíaca'), 1, 0, 'C');

        $this->Ln(20);
    }
}
