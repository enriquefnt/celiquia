<?php
//header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://code.jquery.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://kit.fontawesome.com https://cdn.datatables.net; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdn.datatables.net; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com https://kit.fontawesome.com https://cdn.datatables.net; connect-src 'self'; img-src 'self' data:; object-src 'none'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://code.jquery.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://kit.fontawesome.com https://cdn.datatables.net; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdn.datatables.net https://ka-f.fontawesome.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com https://kit.fontawesome.com https://cdn.datatables.net https://ka-f.fontawesome.com https://cdn.jsdelivr.net; connect-src 'self' https://ka-f.fontawesome.com; img-src 'self' data:; object-src 'none'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';");


include __DIR__ . '/../includes/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');

$CeliaquiaWebsite = new \ClassPart\CeliaquiaWebsite();
$entryPoint = new \ClassGrl\EntryPoint($CeliaquiaWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);
