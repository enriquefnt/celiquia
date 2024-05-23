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
   $this->Image('imagenes/logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',16);
    // Move to the right
    $this->Cell(45);
    // Title
    $this->Cell(140,12,iconv('UTF-8', 'Windows-1252', 'Ficha de investigación de Enfermedad Celíaca'),1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // $usuario = $this->authentication->getUser();
   
	// $quienImprime = $usuario['nombre'] .' '.$usuario['apellido'] ;
    // Position at 1.5 cm from bottom
//    $this->SetY(-15);
    // Arial italic 8
//    $this->SetFont('Arial','I',8);
    // Page number
//    $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}'. 'Copia Impresa por: ' //. //$quienImprime
//    ,0,0,'C');
    }
}