<?php
namespace ClassPart\Controllers;

use \ClassGrl\DataTables;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class Ficha
{
    private $tablaFichas;
    private $tablaInsti;
    private $tablaLocal;
    private $authentication;

    public function __construct(\ClassGrl\DataTables $tablaFichas,
                                \ClassGrl\DataTables $tablaInsti,
                                \ClassGrl\DataTables $tablaLocal,
                               	\ClassGrl\Authentication $authentication)
    {
        $this->tablaFichas = $tablaFichas;
        $this->tablaInsti = $tablaInsti;
        $this->tablaLocal = $tablaLocal;
        $this->authentication = $authentication;
    }



    public function ficha($Idint=null){

        $instituciones = $this->tablaInsti->findAll();
    
        foreach($instituciones as $institucion)
        {
            $data_insti[] = array(
                'label'     =>  $institucion['Nombre_aop'],
                'value'     =>  $institucion['codi_esta']
            );
        }

        $localidades = $this->tablaLocal->findAll();
        foreach($localidades as $localidad)
        {
            $dataLocalidad[] = array(
                'label'     => $localidad['localidad'],
                'value'     => $localidad['gid']
            );
        }
       

 
  
          
        if (isset($_GET['idficha'])) {
          $datosFicha=$this->tablaFichas->findById($_GET['idficha'])?? '';
      
           $title='Ficha';
    
                  return ['template' => 'ficha.html.php',
                             'title' => $title ,
                         'variables' => [
                       'data_insti'  =>   $data_insti?? [],
                       'dataLocalidad'  =>   $dataLocalidad?? [],
                       'datosFicha'=> $datosFicha?? []
                                   ]
    
                        ]; }
                        

                    
                        $title = 'Ficha';

                        return ['template' => 'ficha.html.php',
                                'title' => $title ,
                                'variables' => [
                                'data_insti'  =>   $data_insti?? [],
                                'dataLocalidad'  =>   $dataLocalidad?? []
                                 ]
                        ];

                    }   
    
    public function fichaSubmit() {
         
     
       
       $usuario = $this->authentication->getUser();
       $ficha = $_POST['ficha'];
   
        
      
    
      $ficha['fechacarga']=new \DateTime();
      $ficha['idUsuario']=$usuario['id_usuario'];
      $ficha['edad']=$this->calcularEdad($ficha['fechanac'],$ficha['fechanot']);
     

 // var_dump($ficha);die;
     $this->tablaFichas->save($ficha);
  
     return ['template' => 'fichasucess.html.php',
     'title' => 'Cargado' ,
     'variables' => [
         'ficha' => $ficha ?? ' '
     ]
     ];

}    
     
    
    
    public function calcularEdad($fechaNacimiento, $fechaActual) {
        $nacimiento = new \DateTime($fechaNacimiento);
        $actual = new \DateTime($fechaActual);
        $edad = $nacimiento->diff($actual);
            $anios = $edad->y;
            $meses = $edad->m;
            $dias = $edad->d;
     if($anios>0){
        return " $anios a $meses m    ";
    }
    else {
        return "  $meses m $dias d   ";
    }
  }

    private function calcularDias($fechaIni, $fechaFin) {
      $inicio = new \DateTime($fechaIni);
      $fin = new \DateTime($fechaFin);
      $dias = $inicio->diff($fin);
        
          $ndias = $dias->days;
   
      return $ndias;
  }
  }

 