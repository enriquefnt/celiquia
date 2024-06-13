<?php

namespace ClassPart\Controllers;

use \ClassGrl\Fpdf;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class  Constancia extends Fpdf

{

  function Header()
  {
    $this->SetFont('Arial', 'B', 16);

    $this->Cell(0, 12, iconv('UTF-8', 'Windows-1252', 'CONSTANCIA MÉDICA DE ENFERMEDAD CELÍACA'), 0, 0, 'C');

    $this->Ln(14);
  }
}
