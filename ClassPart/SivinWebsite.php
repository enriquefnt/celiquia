<?php
namespace ClassPart;
use \AllowDynamicProperties;
#[AllowDynamicProperties]
class SivinWebsite implements \ClassGrl\Website  {

	private \ClassGrl\DataTables $tablaNinios;
	private \ClassGrl\DataTables $tablaUser;
	private \ClassGrl\DataTables $tablaEtnia;
	private \ClassGrl\DataTables $tablaLoc;
	private \ClassGrl\DataTables $tablaResi;
	private \ClassGrl\DataTables $tablaNoti;
	private \ClassGrl\DataTables $tablaControl;
	private \ClassGrl\DataTables $tablaInter;
	private \ClassGrl\DataTables $tablaMotNoti;
	private \ClassGrl\DataTables $tablaEvol;
	private \ClassGrl\DataTables $tablaClin;
	private \ClassGrl\DataTables $tablaEtio;
	private \ClassGrl\DataTables $tablaMotIng;
	private \ClassGrl\DataTables $tablaAccion;
	private \ClassGrl\DataTables $tablaDiagEgr;
	//private \ClassGrl\Authentication $Authentication;
	private \ClassGrl\DataTables $tablaAntro;
	private \ClassGrl\DataTables $tablaZscore;
	private $pdoZSCORE;
	//private $pdoSivin;
//	private $pdoProc; tablaDiagEgr
	
	
public function __construct() {


	$pdo = new \PDO('mysql:host=212.1.210.73;dbname=saltaped_sivin2;charset=utf8mb4', 'saltaped_sivin2', 'i1ZYuur=sO1N');
	$pdoSivin = new \PDO('mysql:host=200.45.111.99;dbname=MSP_NUTRICION;charset=utf8mb4', 'SiViNSalta', '@#sivin#@salta!%2020&&');
	$this->tablaNinios = new \ClassGrl\DataTables($pdo,'NIÑOS', 'IdNinio');	
	$this->tablaUser = new \ClassGrl\DataTables($pdo,'datos_usuarios', 'id_usuario');	
	$this->tablaEtnia = new \ClassGrl\DataTables($pdo,'etnias', 'IdEtnia');
	$this->tablaLoc = new \ClassGrl\DataTables($pdo,'localidades', 'gid');
	$this->tablaInsti = new \ClassGrl\DataTables($pdo,'institucion', 'establecimiento_id');
	$this->tablaResi = new \ClassGrl\DataTables($pdo,'NIÑORESIDENCIA', 'IdResi');
	$this->tablaNoti = new \ClassGrl\DataTables($pdo,'NOTIFICACION', 'NotId');
	$this->tablaControl = new \ClassGrl\DataTables($pdo,'NOTICONTROL', 'IdCtrol');
	$this->tablaInter = new \ClassGrl\DataTables($pdo,'NOTIINTERNADOS', 'Idint');
	$this->tablaMotNoti = new \ClassGrl\DataTables($pdo , 'MOTIVOSNOTI', 'MotId');
	$this->tablaEvol = new \ClassGrl\DataTables($pdo , 'SEGUNEVOLUCION', 'SevoId');
	$this->tablaClin = new \ClassGrl\DataTables($pdo , 'SEGUNCLINICA', 'SclinId');
	$this->tablaEtio = new \ClassGrl\DataTables($pdo , 'ETIOLOGIA', 'idEtiologia');
	$this->tablaAccion = new \ClassGrl\DataTables($pdo , 'ACCIONES', 'idAcciones');
	$this->tablaMotIng = new \ClassGrl\DataTables($pdo , 'NOTIMOTIVOINTERNACION', 'MI_Id');
	$this->tablaDiagEgr = new \ClassGrl\DataTables($pdo , 'MOTIVOALTAINTERNACION', 'MA_Id');
	$this->authentication = new \ClassGrl\Authentication($this->tablaUser,'user', 'password'); 
	$this->tablaAntro = new \ClassGrl\DataTables($pdo,'calc_antro', 'idAnt');
	$this->tablaZscore = new \ClassGrl\DataTables($pdo,'scoresZ;', 'edadDias');
	$this->pdoZSCORE = new \PDO('mysql:host=212.1.210.73;dbname=saltaped_sivin2;charset=utf8mb4', 'saltaped_sivin2', 'i1ZYuur=sO1N'); // Asignar el valor a la variable $pdoZSCORE
	$this->tablaUserSivin = new \ClassGrl\DataTables($pdoSivin,'UsuariosExport', 'Idusuario');	

//	$this->pdoProc = new \PDO('mysql:host=212.1.210.73;dbname=saltaped_sivin2;charset=utf8mb4', 'saltaped_sivin2', 'i1ZYuur=sO1N'); // Asignar el valor a la variable $pdoZSCORE
}
	public function getLayoutVariables(): array {

	return [

	'loggedIn' => $this->authentication->isLoggedIn()

	];

}


public function getDefaultRoute(): string {

	return 'ninios/home';

	}

public function getController(string $controllerName): ?object {	


    if ($controllerName === 'user') {

		$controller = new \ClassPart\Controllers\Usuarios($this->tablaUser,$this->tablaInsti,$this->tablaUserSivin);

		}

	else if ($controllerName === 'ninios') {

		$controller = new  \ClassPart\Controllers\Ninios($this->tablaNinios,$this->tablaNoti,
		$this->tablaEtnia,$this->tablaLoc, 
		$this->tablaResi, $this->authentication);

		}
	
		else if ($controllerName === 'noticon') {

			$controller = new  \ClassPart\Controllers\Noticon($this->tablaNinios, $this->tablaNoti, 
			$this->tablaControl, $this->tablaInter, $this->tablaInsti, $this->tablaMotNoti, $this->pdoZSCORE,
			$this->tablaResi,$this->tablaEvol,	$this->tablaClin, $this->tablaEtio, 
			$this->tablaAccion, $this->authentication);
			}

			else if ($controllerName === 'interna') {

				$controller = new  \ClassPart\Controllers\Inter($this->tablaInter, $this->tablaNinios, 
				$this->tablaNoti, $this->tablaInsti, $this->tablaMotIng, $this->tablaDiagEgr, 
				$this->authentication);
				}

				 else if ($controllerName === 'lista') {

				 	$controller = new  \ClassPart\Controllers\Lista($this->tablaNinios, $this->pdoZSCORE, 
					$this->tablaZscore,$this->authentication);
				 	}
					 
	else if ($controllerName === 'antro') {

				$controller = new \ClassPart\Controllers\Antro($this->tablaAntro, $this->pdoZSCORE);
						}

	else if ($controllerName == 'login') {

		$controller = new \ClassPart\Controllers\Login($this->authentication);

		}	

 else {

            $controller = null;

        }


	return $controller;
  }

public function checkLogin(string $uri): ?string {

        $restrictedPages = [
			'ninios/ninios', 
			'user/user', 
			'noticon/noticon',
			 'interna/inter',
			 'antro/antro',
			  'lista/nominal'
			];
        
       foreach ($restrictedPages as $page) {

        if (in_array($uri, $restrictedPages) && !$this->authentication->isLoggedIn()) {

            header('location: /login/login');

            exit();

        }
        return $uri;

    }
}


}
























