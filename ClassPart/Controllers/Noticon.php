<?php
namespace ClassPart\Controllers;

use \ClassGrl\DataTables;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class Noticon
{
    private $tablaNinios;
    private $tablaNoti;
	private $tablaControl;
	private $tablaInter;
    private $tablaInsti;
	private $tablaMotNoti;
	private $pdoZSCORE;   
	private $tablaResi;
	private $tablaEvol;
	private $tablaClin;
	private $tablaEtio;
	private $tablaAccion;
    private $authentication;

    public function __construct(\ClassGrl\DataTables $tablaNinios,
                                \ClassGrl\DataTables $tablaNoti,
                                \ClassGrl\DataTables $tablaControl,
								\ClassGrl\DataTables $tablaInter,
                                \ClassGrl\DataTables $tablaInsti,
								\ClassGrl\DataTables $tablaMotNoti,
								$pdoZSCORE,									
								\ClassGrl\DataTables $tablaResi,
								\ClassGrl\DataTables $tablaEvol,
								\ClassGrl\DataTables $tablaClin,
								\ClassGrl\DataTables $tablaEtio,
								\ClassGrl\DataTables $tablaAccion,
                                \ClassGrl\Authentication $authentication)
    {
        $this->tablaNinios = $tablaNinios;
        $this->tablaNoti = $tablaNoti;
        $this->tablaControl = $tablaControl;
		$this->tablaInter = $tablaInter;
        $this->tablaInsti = $tablaInsti;
		$this->tablaMotNoti = $tablaMotNoti;
		$this->pdoZSCORE = $pdoZSCORE;
		$this->tablaResi = $tablaResi;
		$this->tablaEvol = $tablaEvol;
		$this->tablaClin =$tablaClin;
		$this->tablaEtio =$tablaEtio;
		$this->tablaAccion =$tablaAccion;
        $this->authentication = $authentication;
    }


public function noti($id=null){

	$instituciones = $this->tablaInsti->findAll();

	foreach($instituciones as $institucion)
	{
	    $data_insti[] = array(
	        'label'     =>  $institucion['Nombre_aop'],
	        'value'     =>  $institucion['establecimiento_id']
	    );
	}

	$datosDomi = $this->tablaResi->findLast('ResiNinio', ($_GET['id']));
	$datosNinio=$this->tablaNinios->findById($_GET['id']);
	$datosNoti=$this->tablaNoti->findLast('NotNinio', ($_GET['id'])) ?? [];
	if(!empty($datosNoti)){
	$datosCtrl=$this->tablaControl->findLast('IdNoti',$datosNoti['NotId']) ?? '';}
	$segunevol=$this->tablaEvol->findAll();
	$segunclin=$this->tablaClin->findAll();
	$accion=$this->tablaAccion->findAll();
	$etiologia=$this->tablaEtio->findAll();
//	var_dump($datosNinio);die;
   	$edad=$this->calcularEdad($datosNinio['FechaNto'],date('Y-m-d')) ?? ' ';
	$datosNinio['edad']=$edad ?? ' ';

	// var_dump($datosCtrl);die;
	if ($datosNoti != false){$ultimaNoti = $datosNoti['NotFecha'];
		$NotId=$datosNoti['NotId']?? '' ;}		
	else {$ultimaNoti='1970-01-01';
		$NotId=null;
	}
	
	$ultiControl = $this->tablaControl->findLast('IdNoti', $NotId)['CtrolFecha']?? '1970-01-02';
	
	if ($datosNoti != false){
	$fechaMin = $ultiControl > $ultimaNoti ? $ultiControl : $ultimaNoti; 
    
	$timestampMinima = strtotime($fechaMin);
	
	$timestampMinimaMasUnDia = strtotime('+1 day', $timestampMinima);

	$fechaMinima = date('Y-m-d', $timestampMinimaMasUnDia);
	}
	else {
		$fechaMinima =date('Y-m-d', strtotime('-60 days'));
		}
	$moti=$this->tablaMotNoti->findAll();
//var_dump($moti);die;
$valores= [];	

if($datosNoti != false && str_contains($datosNoti['NotFin'], 'SI')) {$valores= [];}	

  if ($datosNoti != false  && $datosCtrl ==  false) {
	$valores= [
		'motivo'=>$this->tablaMotNoti->findById($datosNoti['NotMotivo'])[1],
		'efector'=>$this->tablaInsti->findById($datosNoti['NotEfec'])[1],
		'efectorId'=>$this->tablaInsti->findById($datosNoti['NotEfec'])['establecimiento_id'],
		'evolucion'=>$this->tablaEvol->findById($datosNoti['NotEvo'])[1] ?? '',
		'evolucionId'=>$this->tablaEvol->findById($datosNoti['NotEvo'])[0] ?? '',
		'gravedad'=>$this->tablaClin->findById($datosNoti['NotClinica'])[1] ?? '',
		'gravedadId'=>$this->tablaClin->findById($datosNoti['NotClinica'])[0] ?? '',
		'etiologia'=>$this->tablaEtio->findById($datosNoti['NotEtio'])[1] ?? '',
		'etiologiaId'=>$this->tablaEtio->findById($datosNoti['NotEtio'])[0] ?? '',
		'accion'=>$this->tablaAccion->findById($datosNoti['NotObserva'])[1] ?? '',
		'accionId'=>$this->tablaAccion->findById($datosNoti['NotObserva'])[0] ?? ''
	];	}
	else if($datosNoti != false && str_contains($datosNoti['NotFin'], 'NO') && $datosCtrl !=  false) {
		$valores=[
		'motivo'=>$this->tablaMotNoti->findById($datosNoti['NotMotivo'])[1],
		'efector'=>$this->tablaInsti->findById($datosCtrl['CtrolEfec'])[1],
		'efectorId'=>$this->tablaInsti->findById($datosCtrl['CtrolEfec'])['establecimiento_id'],
		'evolucion'=>$this->tablaEvol->findById($datosCtrl['CtrolEvo'])[1] ?? '',
		'evolucionId'=>$this->tablaEvol->findById($datosCtrl['CtrolEvo'])[0] ?? '',
		'gravedad'=>$this->tablaClin->findById($datosCtrl['CtrolClinica'])[1] ?? '',
		'gravedadId'=>$this->tablaClin->findById($datosCtrl['CtrolClinica'])[0] ?? '',
		'etiologia'=>$this->tablaEtio->findById($datosCtrl['CtrolEtio'])[1] ?? '',
		'etiologiaId'=>$this->tablaEtio->findById($datosCtrl['CtrolEtio'])[0] ?? '',
		'accion'=>$this->tablaAccion->findById($datosCtrl['CtrolObserva'])[1] ?? '',
		'accionId'=>$this->tablaAccion->findById($datosCtrl['CtrolObserva'])[0] ?? ''];}

	
	//  	var_dump($datosNoti);
	//  var_dump($valores);die;
	if ($_GET['tabla']=='notificacion'){
		$title = 'Notificacion';}
		else if ($_GET['tabla']=='control'){
			$title = 'Control';	}
			else if ($_GET['tabla']=='cierrenoti'){
				$title = 'Cierre notificacion';	}

if (isset($_GET['idNoti'])) {
	
	
							
	if($_GET['tabla']=='notificacion'||$_GET['tabla']=='control')	{				
	

			  return ['template' => 'noticon.html.php',
					     'title' => $title ,
					 'variables' => [
			       'data_insti'  =>   $data_insti,
				   'datosNinio'=> $datosNinio ?? ' ',
				   'datosDomi'=> $datosDomi ?? ' ',
				   'segunevol'=> $segunevol,
				   'segunclin'=> $segunclin ,
				   'etiologia'=> $etiologia ,
				   'accion'=> $accion ,
				   'fechaMinima'=>$fechaMinima,
					 'valores' => $valores  ?? ' '
									 ]

					]; } 
				

	elseif ($_GET['tabla']=='cierrenoti') {
	//	var_dump($datosNoti);

		return ['template' => 'cierrenoti.html.php',
				   'title' => $title ,
			   'variables' => [
			 'data_insti'  =>   $data_insti,
			 'datosNinio'=> $datosNinio ?? ' ',
			 'datosDomi'=> $datosDomi ?? ' ',
			 'segunevol'=> $segunevol,
			 'segunclin'=> $segunclin,
			   'datosNoti' => $datosNoti  ?? ' ',
			   'fechaMinima'=>$fechaMinima
							   ]

			  ]; }
			}
	}

public function notiSubmit() {
$usuario = $this->authentication->getUser();
$instituciones = $this->tablaInsti->findAll();


	foreach($instituciones as $institucion)
	{
	    $data_insti[] = array(
	        'label'     =>  $institucion['Nombre_aop'],
	        'value'     =>  $institucion['establecimiento_id']
	    );
	}

	$datosNinio=$this->tablaNinios->findById($_GET['id']);
	$edad=$this->calcularEdad($datosNinio['FechaNto'],date('Y-m-d'));
	$datosNinio['edad']=$edad;
	$datosDomi = $this->tablaResi->findLast('ResiNinio', ($_GET['id']));
	


	$usuario = $this->authentication->getUser();
	$Notifica=$_POST['Noticon'];

	$Notificacion=[];
	$Control=[];

	//$Notificacion['NotId']=$Notifica['NotId'];
	
	if ($_GET['tabla']=='notificacion') {
	$Notificacion['NotId']=$Notifica['NotId'];
	$Notificacion['NotNinio']=$datosNinio['IdNinio'];
	$Notificacion['NotFecha']=$Notifica['NotFecha'];
	$Notificacion['NotUsuario'] = $usuario['id_usuario'];
	$Notificacion['NotEfec'] = $Notifica['establecimiento_id'];
	$Notificacion['NotMotivo'] = $Notifica['NotMotivo'];
	$Notificacion['NotPeso'] = $Notifica['NotPeso'];
	$Notificacion['NotTalla'] = $Notifica['NotTalla'];
	$Notificacion['NotAo'] = $this->tablaInsti->findById($Notifica['establecimiento_id'])['AOP'] ?? '';
	$Notificacion['NotEvo'] = $Notifica['NotEvo'];
	$Notificacion['NotEtio'] = $Notifica['NotEtio'];
	$Notificacion['NotClinica'] = $Notifica['NotClinica'];
	$Notificacion['NotObserva'] = ltrim($Notifica['NotObserva']);
	$Notificacion['NotObsantro'] = $Notifica['NotObsantro'];
	$Notificacion['NotFin'] = $Notifica['NotFin']?? 'NO ';
	$Notificacion['NotFechaSist'] = new \DateTime();
}
	

	else if($_GET['tabla']=='cierrenoti'){
	$Notificacion['NotId']=$this->tablaNoti->findLast('NotNinio', ($_GET['id']))[0] ?? ' ';
	$Notificacion['NotFecha']=$this->tablaNoti->findLast('NotNinio', ($_GET['id']))['NotFecha'] ?? ' ';
	$Notificacion['NotNinio']=$datosNinio['IdNinio'];
	$Notificacion['NotFin'] = $Notifica['NotFin']?? 'SI ';
	$Notificacion['NotFechaFin'] = $Notifica['NotFechaFin']?? ' ';//
	$Notificacion['NotAlta'] = $Notifica['NotAlta']?? ' ';
	$Notificacion['NotObservafin'] = $Notifica['NotObservafin']?? ' ';
	$Notificacion['NotFechaSist'] = new \DateTime();

	}
	/////////////////////////////////////////////////////////////
	else if($_GET['tabla']=='control'){
	$Control['IdCtrol']=$Notifica['IdCtrol'] ?? ' ';
	$Control['IdNoti']=$this->tablaNoti->findLast('NotNinio', ($_GET['id']))[0] ?? ' ';
	$Control['CtrolFecha']=$Notifica['NotFecha'];
	$Control['CtrolUsuario'] = $usuario['id_usuario'];
	$Control['CtrolEfec'] = $Notifica['establecimiento_id'];
	//$Control['NotMotivo'] = $Notifica['NotMotivo'];
	$Control['CtrolPeso'] = $Notifica['NotPeso'];
	$Control['CtrolTalla'] = $Notifica['NotTalla'];
	$Control['CtrolAo'] = $this->tablaInsti->findById($Notifica['establecimiento_id'])['AOP'] ?? '';
	$Control['CtrolEvo'] = $Notifica['NotEvo'];
	$Control['CtrolEtio'] = $Notifica['NotEtio'];
	$Control['CtrolClinica'] = $Notifica['NotClinica'];
    $Control['CtrolObservaNutri'] = ltrim($Notifica['NotObserva']);
	$Control['CtrolObserva'] = $Notifica['NotObsantro'];
	$Control['CtrolFechapc'] = new \DateTime();

	}

	////////////////////////////////////////////////////////

	if ($_GET['tabla']!='cierrenoti'){
	$imc=($Notifica['NotPeso']/(($Notifica['NotTalla']/100)*($Notifica['NotTalla']/100)));
	$Notificacion['NotImc'] = $imc;
	$sexo = ($datosNinio['sexo'] ='Femenino') ? '2' : '1';

////////////////////revisar esto//////////////////////////////////

	$Notificacion['NotZpe']= $this->calcularZScore(
		$sexo  , 
		"p", 
		$Notifica['NotPeso'], 
		$datosNinio['FechaNto'], 
		$Notifica['NotFecha']
		) ;
		$Notificacion['NotZta']= $this->calcularZScore(
			$sexo  , 
		"t", 
		$Notifica['NotTalla'], 
		$datosNinio['FechaNto'], 
		$Notifica['NotFecha']
		) ;
		$Notificacion['NotZimc'] = $this->calcularZScore(
		$sexo , 
		"i", 
		$imc, 
		$datosNinio['FechaNto'], 
		$Notifica['NotFecha']
		) ;   

		
		$Control['CtrolZp']	= $Notificacion['NotZpe'];
		$Control['CtrolZt']	= $Notificacion['NotZta'];
		$Control['CtrolZimc']	= $Notificacion['NotZimc'];
		}		


	/////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////

		if ($_GET['tabla']=='notificacion'){
			$title = 'Notificacion';}
			else if ($_GET['tabla']=='control'){
				$title = 'Control';	}
				else if ($_GET['tabla']=='cierrenoti'){
					$title = 'Cierre notificacion';	}
	
	$errors = [];



if  (empty($errors)) {

if ($_GET['tabla']=='control'){
$this->tablaControl->save($Control);}
else {
$this->tablaNoti->save($Notificacion);
}

//////////////////////para ventanas modales /////////////////////

$Notificacion=$this->tablaNoti->findLast('NotNinio', ($_GET['id']));
$Control=$this->tablaControl->findLast('IdNoti', ($Notificacion['NotId'])) ?? [];
$datosInter= $this->tablaInter->findLast('IdNotifica', ($Notificacion['NotId'])) ?? [];

if ($_GET['tabla']=='notificacion'){


///////////////colo alerta///////////////////////////////
$Notificacion['alertIMC']=$this->getAlertClass($Notificacion['NotZimc']);
$Notificacion['alertPE']=$this->getAlertClass($Notificacion['NotZpe']);
$Notificacion['alertTA']=$this->getAlertClass($Notificacion['NotZta']);


return ['template' => 'notisucess.html.php',
'title' => $title ,
'variables' => [
	'Notificacion' => $Notificacion ?? [],
	'datosNinio'=> $datosNinio ?? [],
	'datosDomi' => $datosDomi
]
];
     }
	 else if ($_GET['tabla']=='control'){
		
	//	var_dump($datosInter);
		$Control['colorIMC']=$this->getColorClass($Control['CtrolZimc']);
		$Control['colorPE']=$this->getColorClass($Control['CtrolZp']);
		$Control['colorTA']=$this->getColorClass($Control['CtrolZt']);

		$Control['alertIMC']=$this->getAlertClass($Control['CtrolZimc']);
		$Control['alertPE']=$this->getAlertClass($Control['CtrolZp']);
		$Control['alertTA']=$this->getAlertClass($Control['CtrolZt']);



		return ['template' => 'controlsucess.html.php',
		'title' => $title ,
		'variables' => [
			'Control' => $Control ?? ' ',
			'Notificacion' => $Notificacion ?? [],
			'datosNinio'=> $datosNinio ?? [],
			'datosInter' => $datosInter ?? [],
			'datosDomi' => $datosDomi
		]
		];
	 }
	 else if ($_GET['tabla']=='cierrenoti'){
		
		
		
		
		isset($Control[0]) ? $Control['colorIMC']=$this->getColorClass($Control['CtrolZimc']):
		$Notificacion['colorIMC']=$this->getColorClass($Notificacion['NotZimc']);

		isset($Control[0]) ?$Control['colorPE']=$this->getColorClass($Control['CtrolZp']):
		$Notificacion['colorPE']=$this->getColorClass($Notificacion['NotZpe']);

		isset($Control[0]) ?$Control['colorTA']=$this->getColorClass($Control['CtrolZt']):
		$Notificacion['colorTA']=$this->getColorClass($Notificacion['NotZta']);

		
		return ['template' => 'cierreSucess.html.php',
		'title' => 'Cierre noti',
		'variables' => [
			'Notificacion' => $Notificacion ?? [],
			'Control' => $Control ?? [],
			'datosNinio'=> $datosNinio ?? [],
			'datosDomi' => $datosDomi ?? []
		]
		];
	 }

}

else {
	//$title = 'Notificación';


 return ['template' => 'noticon.html.php',
					     'title' => $title ,
					 'variables' => [
					 	'errors' => $errors,
			       'data_insti'  =>   $data_insti,
					 'datosNoti' => $Noticon  ?? ' '
									 ]

					];
}
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

public function calcularZScore($sexo, $bus, $valor, $fecha_nace, $fecha_control) {

    
    $query = "SELECT ZSCORE($sexo, '$bus', $valor, '$fecha_nace', '$fecha_control') AS resultado";
  
    
    $resultado = $this->pdoZSCORE->query($query);
  
  if ($resultado) {
      
      $fila = $resultado->fetchColumn();

    
            $resultadoZSCORE = $fila;
    } else {
      echo("No se pudo calcular");
      $resultadoZSCORE = null;
    }
  
   return $resultadoZSCORE;
  }
  
  public function getColorClass($value) {
    switch (true) {
        case $value > 2:
            return 'red';
        case $value < -2:
            return 'red';
		case ($value >= -1.5 && $value <= 1.5):
			return 'green';		
				case ($value < -1.5 && $value >= -2):
			return 'yellow';	
        default:
            return 'green';
    }
}

public function getAlertClass($value) {
    switch (true) {
        case $value > 2 && $value <= 6 :
            return 'danger';
        case $value < -2 && $value >= - 6 :
            return 'danger';
		case $value >= -1.5 && $value <= 2:
			return 'success';		
				case $value < -1.5 && $value >= -2:
			return 'warning';	
        default:
            return 'dark';
    }
}

public function relacionaCodigos($Codigo,$tablaValores){
$valor=$this->$tablaValores->findById($Codigo)[1];
return $valor;
}


}