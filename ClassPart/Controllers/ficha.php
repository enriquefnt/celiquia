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

    public function __construct(
        \ClassGrl\DataTables $tablaFichas,
        \ClassGrl\DataTables $tablaInsti,
        \ClassGrl\DataTables $tablaLocal,
        \ClassGrl\DataTables $tablaUser,
        \ClassGrl\Authentication $authentication,
        \ClassPart\Controllers\Imprime $Imprime
    ) {
        $this->tablaFichas = $tablaFichas;
        $this->tablaInsti = $tablaInsti;
        $this->tablaLocal = $tablaLocal;
        $this->tablaUser = $tablaUser;
        $this->Imprime = $Imprime;
        $this->authentication = $authentication;
    }



    public function ficha($Idint = null)
    {

        $instituciones = $this->tablaInsti->findAll();

        foreach ($instituciones as $institucion) {
            $data_insti[] = array(
                'label'     =>  $institucion['Nombre_aop'],
                'value'     =>  $institucion['codi_esta']
            );
        }

        $localidades = $this->tablaLocal->findAll();
        foreach ($localidades as $localidad) {
            $dataLocalidad[] = array(
                'label'     => $localidad['localidad'],
                'value'     => $localidad['gid']
            );
        }

        $dniExisten = $this->tablaFichas->findAll();
        foreach ($dniExisten as $dniExiste) {
            $listaDni[] = array(
                'dni' => $dniExiste['dni']
            );
        }

        // var_dump($listaDni) ;die;




        if (isset($_GET['idficha'])) {
            $datosFicha = count($this->tablaFichas->findById($_GET['idficha']) ?? '');

            $title = 'Ficha';

            return [
                'template' => 'ficha.html.php',
                'title' => $title,
                'variables' => [
                    'data_insti'  =>   $data_insti ?? [],
                    'dataLocalidad'  =>   $dataLocalidad ?? [],
                    'datosFicha' => $datosFicha ?? [],
                    'listaDni' => $listaDni ?? []
                ]

            ];
        }



        $title = 'Ficha';

        return [
            'template' => 'ficha.html.php',
            'title' => $title,
            'variables' => [
                'data_insti'  =>   $data_insti ?? [],
                'dataLocalidad'  =>   $dataLocalidad ?? []
            ]
        ];
    }

    public function fichaSubmit()
    {

        //  var_dump($_POST);
        //  $fichas=$this->tablaFichas->findAll();
        $ficharepe = $this->tablaFichas->find('dni', $_POST['ficha']['dni'])[0] ?? [];
        //var_dump($ficharepe);die;
        if ($ficharep = count($this->tablaFichas->find('dni', $_POST['ficha']['dni'])) > 0 && $_POST['ficha']['dni'] > 0) {
            return [
                'template' => 'errorDni.html.php',
                'title' => 'Error',
                'variables' => [
                    'ficharepe' => $ficharepe ?? []
                ]
            ];
        };
        // var_dump($ficharepe);die;




        $usuario = $this->authentication->getUser();
        $ficha = $_POST['ficha'];


        //  $ficha['nombre'] = 'juan perez';
        $array_nombre = explode(' ', $ficha['nombre']);
        $array_nombre = array_map('ucfirst', $array_nombre);
        $ficha['nombre'] = ltrim(implode(' ', $array_nombre));
        // $ficha['nombre']=ucfirst(ltrim($ficha['nombre']));
        //  $ficha['apellido']=ucfirst(ltrim($ficha['apellido']));
        $array_nombre = explode(' ', $ficha['apellido']);
        $array_apellido = array_map('ucfirst', $array_nombre);
        $ficha['apellido'] = ltrim(implode(' ', $array_apellido));
        $ficha['enfermeasoc'] = ltrim($ficha['enfermeasoc']);
        $ficha['observaciones'] = ltrim($ficha['observaciones']);
        $ficha['fechacarga'] = new \DateTime();
        $ficha['edaddiag'] = $this->calcularEdad($ficha['fechanac'], $ficha['fechanot']);
        $ficha['idUsuario'] = $usuario['id_usuario'];

        $ficha['edad'] = $this->calcularEdad($ficha['fechanac'], $ficha['fechanot']);
        $ficha['profesional'] = $usuario['nombre'] . ' ' . $usuario['apellido'];


        ////// crea el json con los array recibidos ////


        if (isset($ficha['familiar_nombre'])) {
            $familiar_nombre = $ficha['familiar_nombre'];
            $familiar_apellido = $ficha['familiar_apellido'];
            $familiar_parentezco = $ficha['familiar_parentezco'];
            $datos_familiares = array();
            for ($i = 0; $i < count($familiar_nombre); $i++) {
                if (!empty($familiar_nombre)) {
                    $datos_familiares[] = array(
                        'nombre' => ucfirst(ltrim($familiar_nombre[$i])),
                        'apellido' => ucfirst(ltrim($familiar_apellido[$i])),
                        'parentezco' => ucfirst(ltrim($familiar_parentezco[$i]))
                    );
                }
            }

            $ficha['grupofam'] = json_encode($datos_familiares);
        }

        unset($ficha['familiar_parentezco'], $ficha['familiar_nombre'], $ficha['familiar_apellido']);


        $this->tablaFichas->save($ficha);

        return [
            'template' => 'fichasucess.html.php',
            'title' => 'Cargado',
            'variables' => [
                'ficha' => $ficha ?? ' '
            ]
        ];
    }

    public function listar()
    {
        $result = $this->tablaFichas->findAll();

        $caso = [];
        foreach ($result as $caso) {

            $casos[] = [
                'idficha' => $caso['idficha'],
                'fechanot' => date('d/m/Y', strtotime($caso['fechanot'])),
                'nombres' => $caso['nombre'] . ' ' . $caso['apellido'],
                'nombresTitulo' => $caso['nombre'] . $caso['apellido'],
                'edad' => $caso['edad'],
                'institucion' => $caso['institucion'] ?? '',
                'localidad' => $caso['localidad'] ?? ''
            ];
        }
        //var_dump($casos);die;

        $title = 'Lista Casos';



        return [
            'template' => 'listacasos.html.php',
            'title' => $title,
            'variables' => [
                'casos' => $casos,
            ]
        ];
    }

    public function print()
    {


        $datosFicha = $this->tablaFichas->findById($_GET['idficha']);
        $fecha = date('d/m/Y', strtotime($datosFicha['fechanot']));
        $fechanac = date('d/m/Y', strtotime($datosFicha['fechanac']));
        $nombre = $datosFicha['nombre'] . '  ' . $datosFicha['apellido'];
        $informa = $this->tablaUser->findById($datosFicha['idUsuario']);
        $datosFicha['biopsia'] = $datosFicha['biopsia'] == 1 ? 'Si' : 'No';
        $datosFicha['endoscopia'] = $datosFicha['endoscopia'] == 1 ? 'Si' : 'No';
        $datosFicha['iga'] = $datosFicha['iga'] == 1 ? 'Si' : 'No';
        $datosFicha['atgiga'] = $datosFicha['atgiga'] == 1 ? 'Si' : 'No';
        $datosFicha['IgGPDG'] = $datosFicha['IgGPDG'] == 1 ? 'Si' : 'No';
        $datosFicha['EMA'] = $datosFicha['EMA'] == 1 ? 'Si' : 'No';
        $datosFicha['dni'] = $datosFicha['dni'] > 0 ? $datosFicha['dni'] : 'Indocumentado';
        $json = $datosFicha['grupofam'];
        if (!empty($datosFicha['grupofam'])) {
            $familiares = json_decode($json, true);
        }
        //echo($numFamiliares);
        //var_dump($familiares);die;
        $usuario = $this->authentication->getUser();

        $quienImprime = $usuario['nombre'] . ' ' . $usuario['apellido'];
        $tituloVentana = $datosFicha['nombre'] . $datosFicha['apellido'];
        $pdf = new \ClassPart\Controllers\Imprime('P', 'mm', 'A4');
        $pdf->SetTitle(iconv('UTF-8', 'Windows-1252', $tituloVentana));
        // $pdf->AddFont('Medico','','medico.php');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        //$pdf->Ln(8);
        $pdf->SetLineWidth(0.5);
        $pdf->SetFillColor(220, 220, 220);
        // $pdf->Rect(10, 40, 190, 20, 'D');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        ///////////////declarante ////////////////////
        $pdf->Ln(6);
        $pdf->Cell(0, 7, 'Declarante', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 10, 'Fecha: ' . $fecha, 0, 0);
        $pdf->Cell(140, 10, iconv('UTF-8', 'Windows-1252', 'Institución: ') .  iconv('UTF-8', 'Windows-1252', $datosFicha['institucion']), 0, 0);
        $pdf->Ln(8);
        $pdf->Cell(0, 7, 'Profesional: ' . iconv('UTF-8', 'Windows-1252', $datosFicha['profesional']), 0, 1);
        // $pdf->Ln(6);
        /////////////////paciente/////////////////////////
        // $pdf->Rect(10, 67, 190, 20, 'D');
        $pdf->SetFont('Arial', 'B', 12);
        //$pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 7, 'Paciente', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(82, 10, 'Nombre: ' .  iconv('UTF-8', 'Windows-1252', $nombre), 0, 0);
        $pdf->Cell(45, 10, 'Fecha de nac.: ' . $fechanac, 0, 0);
        $pdf->Cell(29, 10, 'Edad: ' . $datosFicha['edad'], 0, 0);
        $pdf->Cell(34, 10, 'DNI: ' . $datosFicha['dni'], 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(110, 10, 'Domicilio: ' .  iconv('UTF-8', 'Windows-1252', $datosFicha['domicilio']), 0, 0);
        $pdf->Cell(95, 10, 'Localidad: ' .  iconv('UTF-8', 'Windows-1252', $datosFicha['localidad']), 0, 0);
        $pdf->Ln();
        ////////////////////////diagnostico //////////////////
        //  $pdf->Rect(10, 94, 190, 20, 'D');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 7, iconv('UTF-8', 'Windows-1252', 'Diagnóstico'), 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(100, 10, 'Fecha' . iconv('UTF-8', 'Windows-1252', ' Diagnóstico: ') .  $datosFicha['fechadiag'], 0, 0);
        $pdf->Cell(80, 10, 'Edad' . iconv('UTF-8', 'Windows-1252', ' Diagnóstico: ') . $datosFicha['edaddiag'], 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(49, 10, iconv('UTF-8', 'Windows-1252', 'Biopsia: ') .  $datosFicha['biopsia'], 0, 0);
        $pdf->Cell(50, 10,  iconv('UTF-8', 'Windows-1252', 'Endoscopía: ') . $datosFicha['endoscopia'], 0, 0);
        $pdf->Cell(49, 10,  iconv('UTF-8', 'Windows-1252', 'Grado: ') . $datosFicha['grados'], 0, 0);
        $pdf->Cell(49, 10,  iconv('UTF-8', 'Windows-1252', 'Protocolo Nº: ') . $datosFicha['protocolo'], 0, 0);
        $pdf->Ln();
        /////////SIgnos y sintomas ///////////////////////////
        // $pdf->Rect(10, 121, 190, 20, 'D');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 7, iconv('UTF-8', 'Windows-1252', 'Clínica'), 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(100, 10, iconv('UTF-8', 'Windows-1252', 'Forma de presentación: ') . iconv('UTF-8', 'Windows-1252', $datosFicha['formaclin']), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(80, 10,  iconv('UTF-8', 'Windows-1252', 'Enfermedades Asociadas: ') . $datosFicha['enfermeasoc'], 0, 0);
        $pdf->Ln();
        ///////////////////////////////Laboratorio //////////////////
        //  $pdf->Rect(10, 148, 190, 20, 'D');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 7, iconv('UTF-8', 'Windows-1252', 'Laboratorio'), 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 10, iconv('UTF-8', 'Windows-1252', 'Fecha de extracción: ') . iconv('UTF-8', 'Windows-1252', $datosFicha['fechaestrac']), 0, 0);
        $pdf->Ln(5);
        $pdf->Cell(49, 10,  iconv('UTF-8', 'Windows-1252', 'IgA Sérica Total: ') . $datosFicha['iga'], 0, 0);
        $pdf->Cell(49, 10,  iconv('UTF-8', 'Windows-1252', 'Anticuerpo ATG IgA: ') . $datosFicha['atgiga'], 0, 0);
        $pdf->Cell(50, 10,  iconv('UTF-8', 'Windows-1252', 'Anticuerpo ATG IgG: ') . $datosFicha['IgGPDG'], 0, 0);
        $pdf->Cell(50, 10,  iconv('UTF-8', 'Windows-1252', 'Anticuerpo ATG IgG: ') . $datosFicha['EMA'], 0, 0);
        $pdf->Ln();
        ////////////////////////////Familiares/////////////////////////////////
        //$pdf->Rect(10, 175, 190, 20, 'D');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 7, iconv('UTF-8', 'Windows-1252', 'Familiares'), 0, 1, 'L', true);
       // if (!empty($datosFicha['grupofam'])) {
            //$pdf->SetFont('Arial','',10);
            $pdf->Ln(8);
            if (!empty($datosFicha['grupofam'])) {
                $pdf->SetLineWidth(0.3);
                // Definir la cabecera de la tabla
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(40, 8, 'Nombre', 1, 0, 'C');
                $pdf->Cell(40, 8, 'Apellido', 1, 0, 'C');
                $pdf->Cell(60, 8, 'Parentesco', 1, 1, 'C'); // Aumentar el ancho de la celda para Parentesco

                // Agregar los datos a la tabla
                $pdf->SetFont('Arial', '', 7);

                foreach ($familiares as $familiar) {
                    if (!empty($familiar['nombre'])) {
                        // Ajustar el ancho de las celdas según el contenido
                        $pdf->Cell(40, 6, iconv('UTF-8', 'Windows-1252', $familiar['nombre']), 1, 0, 'L');
                        $pdf->Cell(40, 6, iconv('UTF-8', 'Windows-1252', $familiar['apellido']), 1, 0, 'L');
                        $pdf->Cell(60, 6, iconv('UTF-8', 'Windows-1252', $familiar['parentezco']), 1, 1, 'L');
                    }
                }
        //    }

           $pdf->Ln(6);
        } else if(empty($datosFicha['grupofam'])) {
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(190, 20, iconv('UTF-8', 'Windows-1252', 'No se registraron familiares'), 0, 0);
            $pdf->Ln(8);
        }
        //////////////////////Medidas a observar//////////////////////////
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 7, iconv('UTF-8', 'Windows-1252', 'Medidas a Observar'), 0, 1, 'L', true);
        if (!empty($datosFicha['observaciones'])) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(190, 20, iconv('UTF-8', 'Windows-1252', $datosFicha['observaciones']), 0, 0);

            $pdf->Ln(5);
        } else {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(190, 20, iconv('UTF-8', 'Windows-1252', 'No registra observaciones'), 0, 0);
        }
        //$pdf->SetFont('Medico','',14);
        //$pdf->SetFont('Arial','I',8);

        $pdf->SetFont('Arial', 'I', 8);
        $pdf->SetY(-28);
        $pdf->Cell(0, 7, 'Copia realizada por: ' . iconv('UTF-8', 'Windows-1252', $quienImprime), 0, 0, 'C');


        $pdf->Output(($datosFicha[4] . $datosFicha[5]), 'I');
    }



    public function calcularEdad($fechaNacimiento, $fechaActual)
    {
        $nacimiento = new \DateTime($fechaNacimiento);
        $actual = new \DateTime($fechaActual);
        $edad = $nacimiento->diff($actual);
        $anios = $edad->y;
        $meses = $edad->m;
        $dias = $edad->d;
        if ($anios > 0) {
            return " $anios a $meses m    ";
        } else {
            return "  $meses m $dias d   ";
        }
    }

    private function calcularDias($fechaIni, $fechaFin)
    {
        $inicio = new \DateTime($fechaIni);
        $fin = new \DateTime($fechaFin);
        $dias = $inicio->diff($fin);

        $ndias = $dias->days;

        return $ndias;
    }
}


