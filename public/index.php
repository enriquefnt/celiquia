<?php

include __DIR__ . '/../includes/autoload.php';
 
$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');

$SivinWebsite = new \ClassPart\SivinWebsite();
$entryPoint = new \ClassGrl\EntryPoint($SivinWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);
/*//set_error_handler("mi_error_handler");
define("ninios", "MiClase");
include __DIR__ . '/../ClassPart/Controllers/ninios.php'; // Adjust path as needed
//set_error_handler(["ClassPart\Controllers\ninios", "mi_error_handler"]);
set_error_handler(["\ClassPart\Controllers\ninios", "mi_error_handler"]);
*/