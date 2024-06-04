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
      //  $this->Cell();
        // Title
        $this->Cell(0, 12, iconv('UTF-8', 'Windows-1252', 'CONSTANCIA MÉDICA DE ENFERMEDAD CELÍACA'), 0, 0, 'C');
        // Line break
        $this->Ln(14);
 }
/*
 public function Error($msg)
    {
        // Manejar el error aquí
    }

    //... */
}
