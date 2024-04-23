<?php
namespace ClassPart\Controllers;
use \ClassGrl\DataTables;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class Antro
{
    private $tablaAntro;
    private $pdoZSCORE;   


    public function __construct(\ClassGrl\DataTables $tablaAntro, $pdoZSCORE) 
    {
        $this->tablaAntro = $tablaAntro;
        $this->pdoZSCORE = $pdoZSCORE;
    }



    public function antro($id=null){     
    
    if (isset($_GET['id'])) {
        
        $datosNinio=$this->tablaAntro->findById($_GET['id']);
      }
    
                            
                
    $title = 'Carga Antro';
    
            
    
            return ['template' => 'antro.html.php',
            'title' => $title,
            'variables' => [
                'datosNinio' => $datosNinio ?? '',
                'antro' => $this 
                            ]
                ];
    
    }
  

    public function antroSubmit() {

        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        

       
            $datosNinio=$_POST['Antro'];
            $datos=[]; 
            $imc=($datosNinio['peso']/(($datosNinio['talla']/100)*($datosNinio['talla']/100)));
            $datos['idAnt'] = $datosNinio['idAnt'];
            $datos['idNoti'] = $datosNinio['idNoti'];
            $datos['nombre'] = $datosNinio['nombre'];
            $datos['fecha_nace'] = $datosNinio['fecha_nace'];
            $datos['sexo'] = ($datosNinio['sexo'] ='Femenino') ? '2' : '1';
            $datos['fecha_control'] = $datosNinio['fecha_control'];
            $datos['peso'] = $datosNinio['peso'];
            $datos['talla'] = $datosNinio['talla'];
            $datos['ZPE']= $this->calcularZScore(
                                                    $datos['sexo']  , 
                                                    "p", 
                                                    $datosNinio['peso'], 
                                                    $datosNinio['fecha_nace'], 
                                                    $datosNinio['fecha_control']
                                                    ) ;
            $datos['ZTE']= $this->calcularZScore(
                                                    $datos['sexo']  , 
                                                    "t", 
                                                    $datosNinio['talla'], 
                                                    $datosNinio['fecha_nace'], 
                                                    $datosNinio['fecha_control']
                                                    ) ;
            $datos['ZIMCE'] = $this->calcularZScore(
                                                    $datos['sexo']  , 
                                                    "i", 
                                                    $imc, 
                                                    $datosNinio['fecha_nace'], 
                                                    $datosNinio['fecha_control']
                                                    ) ;   
      $this->tablaAntro->save($datos);
        
       header('Location: /ninios/home');
       
}
public function calcularZScore($sexo, $bus, $valor, $fecha_nace, $fecha_control) {

    
    $query = "SELECT ZSCORE($sexo, '$bus', $valor, '$fecha_nace', '$fecha_control') AS resultado";
  
    
    $resultado = $this->pdoZSCORE->query($query);
  
  if ($resultado) {
      
      $fila = $resultado->fetchColumn();

  //    var_dump($fila);  
            $resultadoZSCORE = $fila;
    } else {
      
      $resultadoZSCORE = null;
    }
  
   return $resultadoZSCORE;
  }
}

