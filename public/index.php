<?php

include __DIR__ . '/../includes/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');

$CeliaquiaWebsite = new \ClassPart\CeliaquiaWebsite();
$entryPoint = new \ClassGrl\EntryPoint($CeliaquiaWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);
