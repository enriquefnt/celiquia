<?php
namespace ClassPart\Controllers;

use \ClassGrl\DataTables;

class Usuarios
{
    private $userTable;
    private $tablaInsti;

    public function __construct(
        \ClassGrl\DataTables $userTable,
        \ClassGrl\DataTables $tablaInsti,
    ) {
        $this->userTable = $userTable;
        $this->tablaInsti = $tablaInsti;
    }

    // Método para generar el token CSRF
    private function generate_csrf_token() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Método para validar el token CSRF
    private function validate_csrf_token($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $token === $_SESSION['csrf_token'];
    }

    // Método para mostrar el formulario con el token CSRF
    public function user($id = null) {
        $csrf_token = $this->generate_csrf_token();
        $instituciones = $this->tablaInsti->findAll();

        foreach ($instituciones as $institucion) {
            $data_insti[] = array(
                'label'     =>  $institucion['Nombre_aop'],
                'value'     =>  $institucion['codi_esta']
            );
        }

        if (isset($_GET['id'])) {
            $datosUser = $this->userTable->findById($_GET['id']);
            $datosUser['pasword'] = 'xxxxxxx';
        }

        $title = 'Carga Usuarios';

        return [
            'template' => 'carga_user.html.php',
            'title' => $title,
            'variables' => [
                'csrf_token' => $csrf_token,
                'data_insti'  =>   $data_insti,
                'datosUser' => $datosUser ?? ' '
            ]
        ];
    }

    // Método para manejar el envío del formulario y validar el token CSRF
    public function userSubmit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !$this->validate_csrf_token($_POST['csrf_token'])) {
                die('CSRF token mismatch');
            }
            
            $instituciones = $this->tablaInsti->findAll();

            foreach ($instituciones as $institucion) {
                $data_insti[] = array(
                    'label'     =>  $institucion['Nombre_aop'],
                    'value'     =>  $institucion['codi_esta']
                );
            }

            $Usuario = $_POST['Usuario'];
            $Usuario['nombre'] = ltrim(ucwords(strtolower($Usuario['nombre'])));
            $Usuario['apellido'] = ltrim(ucwords(strtolower($Usuario['apellido'])));
            $Usuario['email'] = ltrim(strtolower($Usuario['email']));
            $user = $this->userTable->findById($Usuario['id_usuario']) ?? '';

            if (empty($user['password'])) {
                $Usuario['password'] = password_hash($Usuario['password'], PASSWORD_DEFAULT);
            }

            $Usuario['usuAo'] = $this->tablaInsti->findById($Usuario['codi_esta'])['AOP'] ?? '';
            $Usuario['fechaCarga'] = new \DateTime();

            $title = 'Carga Usuarios';

            $errors = [];

            if (empty($Usuario['nombre'])) {
                $errors[] = 'Debe indicar el nombre';
            }

            if (empty($Usuario['apellido'])) {
                $errors[] = 'Debe indicar el Apellido';
            }

            if (filter_var($Usuario['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errors[] = 'El formato del correo no es válido';
            }

            if (empty($_GET['id']) && count($this->userTable->find('email', $Usuario['email'])) > 0) {
                $errors[] = 'Un usuario con este e-mail ya está registrado';
            }

            if (empty($_GET['id']) && count($this->userTable->find('user', $Usuario['user'])) > 0) {
                $errors[] = 'Un usuario con este nombre de usuario ya está registrado, carguelo nuevamente con otro nombre de usuario';
            }

            if (empty($errors)) {
                $this->userTable->save($Usuario);
                header('Location: /user/listar');
                exit;
            } else {
                $title = 'Usuarios';

                return [
                    'template' => 'carga_user.html.php',
                    'title' => $title,
                    'variables' => [
                        'csrf_token' => $this->generate_csrf_token(), // Regenerar el token CSRF
                        'errors' => $errors,
                        'data_insti'  =>   $data_insti,
                        'datosUser' => $Usuario ?? ' '
                    ]
                ];
            }
        }
    }

    


	public function listar()
	{

		$result = $this->userTable->findAll();

		$usuario = [];
		foreach ($result as $usuario) {

			$usuarios[] = [
				'id_usuario' => $usuario['id_usuario'],
				'nombres' => $usuario['nombre'] . ' ' . $usuario['apellido'],
				'establecimiento_nombre' => $usuario['establecimiento_nombre'] ?? '',
				'celular' => $usuario['celular'] ?? ''
			];
		}

		$title = 'Lista Usuarios';



		return [
			'template' => 'listausuarios.html.php',
			'title' => $title,
			'variables' => [
				'usuarios' => $usuarios,
			]
		];
	}

	public function success()
	{
		return [
			'template' => 'registersuccess.html.php',
			'title' => 'Registro OK'
		];
	}
}
