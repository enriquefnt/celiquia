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
     // Insert the background image
     $this->Image('imagenes/constancia.png', 0, 0, $this->GetPageWidth(), $this->GetPageHeight());
     //$this->Image('imagenes/logo.png', 10, 6, 30);
 }

 public function Error($msg)
    {
        // Manejar el error aquí
    }

    //...
}
