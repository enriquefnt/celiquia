<?php
namespace ClassPart;
use \AllowDynamicProperties;
#[AllowDynamicProperties]
class CeliaquiaWebsite implements \ClassGrl\Website  {

	private \ClassGrl\DataTables $tablaFichas;
	//private \ClassGrl\DataTables $tablaUser;
	
	//private \ClassGrl\Authentication $Authentication;

	
	
public function __construct() {


	$pdo = new \PDO('mysql:host=212.1.210.73;dbname=saltaped_sivin2;charset=utf8mb4', 'saltaped_sivin2', 'i1ZYuur=sO1N');
	
	$this->tablaFichas = new \ClassGrl\DataTables($pdo,'NIÑOS', 'IdNinio');	
//	$this->tablaUser = new \ClassGrl\DataTables($pdo,'datos_usuarios', 'id_usuario');	
//	$this->authentication = new \ClassGrl\Authentication($this->tablaUser,'user', 'password'); 
	
}
	public function getLayoutVariables(): array {

	return [

	'loggedIn' => $this->authentication->isLoggedIn()

	];

}


public function getDefaultRoute(): string {

	return 'ficha/home';

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
























