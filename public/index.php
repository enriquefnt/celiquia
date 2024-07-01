<?php

// Configuración de cabeceras de seguridad
header('X-Frame-Options: SAMEORIGIN');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://code.jquery.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://kit.fontawesome.com https://cdn.datatables.net; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdn.datatables.net https://ka-f.fontawesome.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com https://kit.fontawesome.com https://cdn.datatables.net https://ka-f.fontawesome.com https://cdn.jsdelivr.net; connect-src 'self' https://ka-f.fontawesome.com; img-src 'self' data:; object-src 'none'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';");

// Configuración de cookies de sesión
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 21600, // 6 horas de expiración
        'path' => '/',
      //  'domain' => 'celiquia.v.je',
        'secure' => true, // Asegúrate de que la cookie solo se envíe a través de HTTPS
        'httponly' => true, // Marca HttpOnly
        'samesite' => 'Strict' // Configura el atributo SameSite
    ]);
    session_start();
}

// Iniciar sesión
//session_start();

// Incluir autoload.php para cargar las clases necesarias
include __DIR__ . '/../includes/autoload.php';

// Obtener la URI solicitada y el método de solicitud HTTP
$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');

// Crear instancias de las clases necesarias y ejecutar el punto de entrada de la aplicación
$CeliaquiaWebsite = new \ClassPart\CeliaquiaWebsite();
$entryPoint = new \ClassGrl\EntryPoint($CeliaquiaWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);
