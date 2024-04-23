<?php
namespace ClassPart\Controllers;

use \ClassGrl\DataTables;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class Inter
{
    private $tablaInter;
    private $tablaNinios;
    private $tablaNoti;
    private $tablaInsti;
    private $tablaMotIng;  
    private $tablaDiagEgr;
    private $authentication;

    public function __construct(\ClassGrl\DataTables $tablaInter,
                                \ClassGrl\DataTables $tablaNinios,
                                \ClassGrl\DataTables $tablaNoti,
                                \ClassGrl\DataTables $tablaInsti,
                                \ClassGrl\DataTables $tablaMotIng,  
                                \ClassGrl\DataTables $tablaDiagEgr, 
							                	\ClassGrl\Authentication $authentication)
    {
        $this->tablaInter = $tablaInter;
        $this->tablaNinios = $tablaNinios;
        $this->tablaNoti = $tablaNoti;
        $this->tablaInsti = $tablaInsti;
        $this->tablaMotIng  = $tablaMotIng;
        $this->tablaDiagEgr  = $tablaDiagEgr;
        $this->authentication = $authentication;
    }



    public function inter($Idint=null){

        $instituciones = $this->tablaInsti->findAll();
    
        foreach($instituciones as $institucion)
        {
            $data_insti[] = array(
                'label'     =>  $institucion['Nombre_aop'],
                'value'     =>  $institucion['establecimiento_id']
            );
        }
       

 $datosNinio=$this->tablaNinios->findById($_GET['id'])?? '';
 $datosNinio['edad']=$this->calcularEdad($datosNinio['FechaNto'],date('Y-m-d')) ?? ' ';
 $datosNoti=$this->tablaNoti->findLast('NotNinio', ($_GET['id']));

$datosInter=$this->tablaInter->findLast('IdNotifica',  $datosNoti['NotId']) ?? [] ;
 
if ($datosNoti != false){$ultimaNoti = $datosNoti['NotFecha'];
  $NotId=$datosNoti['NotId']?? '' ;}		
else {$ultimaNoti='1970-01-01';
  $NotId=null;
}
//echo('notid '.$NotId);
$ultiInterna = $this->tablaInter->findLast('IdNotifica', $NotId)['IntFecha']?? '1970-01-02';
if ($datosNoti != false){
$fechaMinima = $ultiInterna > $ultimaNoti ? $ultiInterna : $ultimaNoti; }
else {
  $fechaMinima =date('Y-m-d', strtotime('-60 days'));
  }
  
  $lastInt = $this->tablaInter->findLast('IdNotifica', $NotId);
  if (!is_bool($lastInt) && $lastInt!== null && $lastInt['IntAlta'] == "SI") {
      $_GET['Idint'] = null;
  }



        
        if (isset($_GET['Idint'])) {
      
           $title='Internación';
    
                  return ['template' => 'interna.html.php',
                             'title' => $title ,
                         'variables' => [
                       'data_insti'  =>   $data_insti?? [],
                       'datosNinio'=> $datosNinio?? [],
                       'datosNoti' => $datosNoti  ?? [],
                       'datosInter' => $datosInter ?? [],
                       'fechaMinima'=>$fechaMinima ?? ''
                                         ]
    
                        ]; }
                        

                    
                        $title = 'Internacion';

                        return ['template' => 'interna.html.php',
                                'title' => $title ,
                                'variables' => [
                                'data_insti'  =>   $data_insti?? [],
                                'datosNinio'=> $datosNinio ?? [],
                                'datosNoti' => $datosNoti  ?? [],
                                'fechaMinima'=>$fechaMinima ?? ''
                               // 'datosInter' => $datosInter ?? []
                                ]
                        ];

                    }   
    
    public function interSubmit() {
         
     
       $datosNinio=$this->tablaNinios->findById($_POST['NOTIINTERNADOS']['IdNinio']) ?? ' ';
       $datosNinio['edad']=$this->calcularEdad($datosNinio['FechaNto'],date('Y-m-d')) ?? ' ';
       $usuario = $this->authentication->getUser();
       $Notificacion=$this->tablaNoti->findLast('NotNinio', ($_POST['NOTIINTERNADOS']['IdNinio']));
      
      $NOTIINTERNADOS = $_POST['NOTIINTERNADOS'];
   
       $Internacion=[];

       
      
    
      $Internacion['Idint']=$NOTIINTERNADOS['Idint']??'';
      $Internacion['IdNotifica']=$Notificacion['NotId'] ?? ' ';
      $Internacion['IntFecha']=$NOTIINTERNADOS['IntFecha'];
      $Internacion['IntAo']=$this->tablaInsti->findById($NOTIINTERNADOS['IntEfec'])['AOP'] ?? '';
      $Internacion['IntEfec']=$NOTIINTERNADOS['IntEfec'];
      $Internacion['IntSala']=$NOTIINTERNADOS['IntSala'];
      $Internacion['IntAlta']=isset($NOTIINTERNADOS['IntFechalta']) ? 'SI' : 'NO';
      $Internacion['IntFechalta']=$NOTIINTERNADOS['IntFechalta']?? '';
      $Internacion['IntTipoAlta']=$NOTIINTERNADOS['IntTipoAlta']?? '...';
      $Internacion['IntDerivado']='';
      $Internacion['IntObserva']=trim($NOTIINTERNADOS['IntObserva'])?? '';
      $Internacion['IntUsuario']=$usuario['id_usuario'];
      $Internacion['IntFechapc']=new \DateTime();

// var_dump($Internacion);die;
     $this->tablaInter->save($Internacion);
  

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
if (isset($_POST['NOTIINTERNADOS']['diag_egr'])){
  $diagEgreso = $_POST['NOTIINTERNADOS']['diag_egr'];
  $diagEgresoArray = array_map(function($item) {
    return explode(',', $item);
  }, $diagEgreso);
  foreach ($diagEgresoArray as $diags) {
    foreach ($diags as $diag) {
        $diagEgresos = [
            'MA_Id' => '',
            'MA_IntId' => $this->tablaInter->ultimoReg()['Idint'],
            'MA_Motivo' => trim($diag)
        ];
  
        $this->tablaDiagEgr->save($diagEgresos);
    }
   }
  }
////////////////////////////////////////////////////////////////


    $datosInter=$this->tablaInter->findLast('IdNotifica',  $Internacion['IdNotifica']);

    $datosInter['Nombre_aop']=$this->tablaInsti->findById($NOTIINTERNADOS['IntEfec'])['Nombre_aop'] ?? '';
    
     switch ($datosInter['IntSala']) {
        case 2:
          $datosInter['Sala'] ='Guardia';
          break;
        case 3:
          $datosInter['Sala'] ='Terapia intensiva';
          break;
        case 9:
          $datosInter['Sala'] ='Internación común';
          break;
          case 10:
            $datosInter['Sala'] ='CRENI';
          break;
          case 10:
            $datosInter['Sala'] ='Recuperación Nutricional';
          break;
        default:
        $datosInter['Sala'] ='Otra';
      }
     
      if(isset($datosInter['IntFechalta'])){
        $datosInter['diasInter']=$this->calcularDias($datosInter['IntFecha'], $datosInter['IntFechalta']) ;}

   //  var_dump($datosInter);
 $template = ($datosInter['IntAlta'] == 'NO') ? 'ingreSucess.html.php' : 'altaSucess.html.php';
      $title='Internación';
     
                  return ['template' => $template,
                  'title' => $title ,
              'variables' => [
              'datosNinio'=> $datosNinio?? [],
            'datosInter' => $datosInter  ?? []
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

 