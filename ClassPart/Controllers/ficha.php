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
                'label'     =>  $institucion['establecimiento_nombre'],
                'value'     =>  $institucion['codi_esta']
            );
        }

       

 
  
          
        if (isset($_GET['idficha'])) {
          $datosFicha=$this->tablaFichas->findById($_GET['idficha'])?? '';
      
           $title='Ficha';
    
                  return ['template' => 'ficha.html.php',
                             'title' => $title ,
                         'variables' => [
                       'data_insti'  =>   $data_insti?? [],
                       'datosFicha'=> $datosFicha?? []
                                   ]
    
                        ]; }
                        

                    
                        $title = 'Ficha';

                        return ['template' => 'ficha.html.php',
                                'title' => $title ,
                                'variables' => [
                                'data_insti'  =>   $data_insti?? []
                                 ]
                        ];

                    }   
    
    public function fichaSubmit() {
         
     
       
       $usuario = $this->authentication->getUser();
       $ficha = $_POST['ficha'];
   
        
      
    
      $ficha['fechacarga']=new \DateTime();

// var_dump($Internacion);die;
     $this->tablaInter->save($ficha);
  

/////////////////guarda motivos de ingreso /////////////////////

   
if (isset($_POST['NOTIINTERNADOS']['diagnosticos'])){
  $motivosInter = $_POST['NOTIINTERNADOS']['diagnosticos'];
  $motivosInterArray = array_map(function($item) {
    return explode(',', $item);
  }, $motivosInter);
  foreach ($motivosInterArray as $motivos) {
    foreach ($motivos as $motivo) {
        $motivoInternacion = [
            'MI_Id' => '',
            'MI_IntId' => $this->tablaInter->ultimoReg()['Idint'],
            'MI_Motivo' => trim($motivo)
        ];
  
        $this->tablaMotIng->save($motivoInternacion);
    }
   }
  }



///////////////////guarda diagnosticos de alta ///////////////////
// if (isset($_POST['NOTIINTERNADOS']['diag_egr'])){
//   $diagEgreso = $_POST['NOTIINTERNADOS']['diag_egr'];
//   $diagEgresoArray = array_map(function($item) {
//     return explode(',', $item);
//   }, $diagEgreso);
//   foreach ($diagEgresoArray as $diags) {
//     foreach ($diags as $diag) {
//         $diagEgresos = [
//             'MA_Id' => '',
//             'MA_IntId' => $this->tablaInter->ultimoReg()['Idint'],
//             'MA_Motivo' => trim($diag)
//         ];
  
//         $this->tablaDiagEgr->save($diagEgresos);
//     }
//    }
//   }
// ////////////////////////////////////////////////////////////////


//     $datosInter=$this->tablaInter->findLast('IdNotifica',  $Internacion['IdNotifica']);

//     $datosInter['Nombre_aop']=$this->tablaInsti->findById($NOTIINTERNADOS['IntEfec'])['Nombre_aop'] ?? '';
    
//      switch ($datosInter['IntSala']) {
//         case 2:
//           $datosInter['Sala'] ='Guardia';
//           break;
//         case 3:
//           $datosInter['Sala'] ='Terapia intensiva';
//           break;
//         case 9:
//           $datosInter['Sala'] ='Internación común';
//           break;
//           case 10:
//             $datosInter['Sala'] ='CRENI';
//           break;
//           case 10:
//             $datosInter['Sala'] ='Recuperación Nutricional';
//           break;
//         default:
//         $datosInter['Sala'] ='Otra';
//       }
     
//       if(isset($datosInter['IntFechalta'])){
//         $datosInter['diasInter']=$this->calcularDias($datosInter['IntFecha'], $datosInter['IntFechalta']) ;}

//    //  var_dump($datosInter);
//  $template = ($datosInter['IntAlta'] == 'NO') ? 'ingreSucess.html.php' : 'altaSucess.html.php';
//       $title='Internación';
     
//                   return ['template' => $template,
//                   'title' => $title ,
//               'variables' => [
//               'datosNinio'=> $datosNinio?? [],
//             'datosInter' => $datosInter  ?? []
//                               ]

//              ]; 
     

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

 