<?php
namespace ClassPart\Controllers;
use \ClassGrl\DataTables;
use \ClasPart\Controllers\Imprime;
use \AllowDynamicProperties;
use \font;
#[AllowDynamicProperties]
class Ficha
{
    private $tablaFichas;
    private $tablaInsti;
    private $tablaLocal;
    private $tablaUser;
    private $authentication;

    public function __construct(\ClassGrl\DataTables $tablaFichas,
                                \ClassGrl\DataTables $tablaInsti,
                                \ClassGrl\DataTables $tablaLocal,
                                \ClassGrl\DataTables $tablaUser,
                               	\ClassGrl\Authentication $authentication,
                                \ClassPart\Controllers\Imprime $Imprime)
    {
        $this->tablaFichas = $tablaFichas;
        $this->tablaInsti = $tablaInsti;
        $this->tablaLocal = $tablaLocal;
        $this->tablaUser = $tablaUser;
        $this->Imprime = $Imprime;
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
   
       $ficha['nombre']=ucfirst(ltrim($ficha['nombre']));
       $ficha['apellido']=ucfirst(ltrim($ficha['apellido']));
       $ficha['enfermeasoc']=ltrim($ficha['enfermeasoc']);
       $ficha['observaciones']=ltrim($ficha['observaciones']);
       $ficha['fechacarga']=new \DateTime();
       $ficha['idUsuario']=$usuario['id_usuario'];

       $ficha['edad']=$this->calcularEdad($ficha['fechanac'],$ficha['fechanot']);
       $ficha['profesional']=$usuario['nombre'].' '.$usuario['apellido'];
      
      
       ////// crea el json con los array recibidos ////
if (isset($ficha['familiar_nombre'])){
       $familiar_nombre = $ficha['familiar_nombre'];
       $familiar_apellido = $ficha['familiar_apellido'];
       $familiar_parentezco = $ficha['familiar_parentezco'];
       $datos_familiares = array();
       for ($i = 0; $i < count($familiar_nombre); $i++) {
        $datos_familiares[] = array(
            'nombre' => $familiar_nombre[$i],
            'apellido' => $familiar_apellido[$i],
            'parentezco' => $familiar_parentezco[$i]
        );
            }
        }
       $ficha['grupofam']=json_encode($datos_familiares);

       
    unset($ficha['familiar_parentezco'], $ficha['familiar_nombre'], $ficha['familiar_apellido']);

 //var_dump($ficha);die;
     $this->tablaFichas->save($ficha);
  
     return ['template' => 'fichasucess.html.php',
     'title' => 'Cargado' ,
     'variables' => [
         'ficha' => $ficha ?? ' '
     ]
     ];

}    

public function listar() {
    $result = $this->tablaFichas->findAll();

    $caso = [];
    foreach ($result as $caso) {
        
        $casos[] = [
            'idficha' => $caso['idficha'],
            'fechanot' => date('d/m/Y', strtotime($caso['fechanot'])),
            'nombres' => $caso['nombre']. ' '.$caso['apellido'],
            'edad' => $caso['edad'],
            'institucion' => $caso['institucion']?? '',
            'localidad' => $caso['localidad'] ?? ''
                                ];
            }
  //var_dump($casos);die;
    
            $title = 'Lista Casos';

   

    return ['template' => 'listacasos.html.php',
            'title' => $title,
            'variables' => [
            'casos' => $casos,
         ]
        ];




}

public function print() {

	
	$datosFicha = $this->tablaFichas->findById($_GET['idficha']);
   
	$fecha= date('d/m/Y',strtotime($datosFicha['fechanot']));
    $nombre= $datosFicha['nombre']. '  '. $datosFicha['apellido'];
	
	$informa = $this->tablaUser->findById($datosFicha['idUsuario']);
	//var_dump($informa);die;

	$usuario = $this->authentication->getUser();
   
	$quienImprime = $usuario['nombre'] .' '.$usuario['apellido'] ;

	$pdf = new \ClassPart\Controllers\Imprime('P','mm','A4');
	// $pdf->AddFont('Medico','','medico.php');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->Ln(10);
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Rect(10, 40, 190, 20, 'D');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,7, 'Informante', 0, 1, 'L', true);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(35,10, 'Fecha: ' . $fecha  ,0,0); 
	//$pdf->Ln(5);
	$pdf->Cell(80,10,iconv('UTF-8', 'Windows-1252','Institución: ').  iconv('UTF-8', 'Windows-1252', $datosFicha['institucion'])  ,0,0); 
	$pdf->Ln(6);
	$pdf->Cell(0,7,'Profesional: '.iconv('UTF-8', 'Windows-1252', $datosFicha['profesional'] )   ,0,1); 
    $pdf->Ln();
//	$pdf->SetFillColor(220, 220, 220);
    $pdf->Rect(10, 67, 190, 20, 'D');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0,7, 'Persona', 0, 1, 'L', true);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(100,10,'Nombre: '.  iconv('UTF-8', 'Windows-1252', $nombre)  ,0,0); 
    $pdf->Cell(80,10, 'Edad: ' . $datosFicha['edad'] ,0,0); 
    $pdf->Ln(5);
    $pdf->Cell(100,10,'Domicilio: '.  iconv('UTF-8', 'Windows-1252', $datosFicha['domicilio'])  ,0,0); 
    $pdf->Cell(60,10,'Localidad: '.  iconv('UTF-8', 'Windows-1252', $datosFicha['localidad'])  ,0,0); 
	//$pdf->Ln(5);
	//$pdf->SetFont('Medico','',14);
	$pdf->SetFont('Arial','I',8);
	$pdf->SetY(-28);
	$pdf->Output($datosFicha[1],'I');
}




public function home()
{
    $title = 'Instructivo';


    return ['template' => 'home.html.php', 'title' => $title, 'variables' => []];
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

 