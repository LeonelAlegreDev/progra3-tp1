<?php

// use Slim\Routing\RouteCollectorProxy;

echo "hasta aqui";

// $app->get('/', require "../controllers/DefaultController.php");

$ruta = require_once dirname(__FILE__) . '\controllers\DefaultController.php';

var_dump($ruta);

?>