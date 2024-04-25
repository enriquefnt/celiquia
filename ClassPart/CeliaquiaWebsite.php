<?php
namespace ClassPart;
use \AllowDynamicProperties;
#[AllowDynamicProperties]
class CeliaquiaWebsite implements \ClassGrl\Website  {

	private \ClassGrl\DataTables $tablaFichas;
	private \ClassGrl\DataTables $tablaInsti;
	private \ClassGrl\DataTables $tablaUser;
	private \ClassGrl\DataTables $tablaLocal;
	private \ClassGrl\Authentication $Authentication;

	
	
public function __construct() {


$pdo = new \PDO('mysql:host=212.1.210.73;dbname=saltaped_celiaquia;charset=utf8mb4', 'saltaped_userceliaquia', '1XS8I8nu5NXl');
	
	$this->tablaFichas = new \ClassGrl\DataTables($pdo,'ficha', 'idficha');	
	$this->tablaInsti = new \ClassGrl\DataTables($pdo,'datos_institucion', 'codi_esta');	
	$this->tablaUser = new \ClassGrl\DataTables($pdo,'datos_usuarios', 'id_usuario');	
	$this->tablaLocal = new \ClassGrl\DataTables($pdo,'datos_localidad', 'gid');	
	$this->authentication = new \ClassGrl\Authentication($this->tablaUser,'user', 'password'); 
	
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

	else if ($controllerName === 'ficha') {

		$controller = new  \ClassPart\Controllers\Ficha($this->tablaFichas, $this->tablaInsti, $this->tablaLocal,
		 $this->authentication);

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
























