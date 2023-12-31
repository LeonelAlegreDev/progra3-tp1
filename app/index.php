<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Slim\Middleware\RoutingMiddleware;

require __DIR__ . '/../vendor/autoload.php';
require_once './db/AccesoDatos.php';
require_once './controllers/EmpleadoController.php';
require_once './controllers/BebidaController.php';
require_once './controllers/ClienteController.php';
require_once './controllers/ServicioController.php';
require_once './controllers/MesaController.php';
require_once './controllers/ComandaController.php';
require_once './controllers/AuthController.php';
require_once './controllers/LogController.php';
require_once './middlewares/AuthEmpleado.php';

// require_once './middlewares/Logger.php';


// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

$app->setBasePath('/Progra3-TP-Slim/app');

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Index
$app->get('[/]', function (Request $request, Response $response) {    
  $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
  
  $response->getBody()->write($payload);
  return $response->withHeader('Content-Type', 'application/json');
});

// Empleados
$app->group('/empleados', function (RouteCollectorProxy $group) {
  // GET ALL
  $group->get('[/]', \EmpleadoController::class . ':TraerTodos');

  // GET by ID
  $group->get('/{id}', \EmpleadoController::class . ':TraerUno');

  // POST
  $group->post('[/]', \EmpleadoController::class . ':CargarUno')->add(new AuthEmpleado());

  // PUT
  $group->put('/{id}', \EmpleadoController::class . ':ModificarUno')->add(new AuthEmpleado());

  // DELETE by ID
  $group->delete('/{id}', \EmpleadoController::class . ':BorrarUno')->add(new AuthEmpleado());
});

// Productos
$app->group('/productos', function (RouteCollectorProxy $group)
{
  // POST Create new Bebida
  $group->post('/bebidas/', \BebidaController::class . ':CargarUno')->add(new AuthEmpleado());

  // GET ALL
  $group->get('/bebidas/', \BebidaController::class . ':TraerTodos');

  // GET Bebida by ID
  $group->get('/bebidas/{id}', \BebidaController::class . ':TraerUno');

  // PUT Update Bebida by ID
  $group->put('/bebidas/{id}', \BebidaController::class . ':ModificarUno')->add(new AuthEmpleado());
});

// Clientes
$app->group('/clientes', function (RouteCollectorProxy $group)
{
  // GET by ID
  $group->get('/{id}', \ClienteController::class . ':TraerUno');

  // GET ALL
  $group->get('[/]', \ClienteController::class . ':TraerTodos');

  // POST Create new Cliente
  $group->post('[/]', \ClienteController::class . ':CargarUno');

  // PUT Update Cliente
  $group->put('/{id}', \ClienteController::class . ':ModificarUno');

  // DELETE by ID
  $group->delete('/{id}', \ClienteController::class . ':BorrarUno')->add(new AuthEmpleado());
});

// Servicios
$app->group('/servicios', function (RouteCollectorProxy $group)
{
  // POST Create new Servicio
  $group->post('[/]', \ServicioController::class . ':CargarUno')->add(new AuthEmpleado());
});

// Mesas
$app->group('/mesas', function (RouteCollectorProxy $group)
{
  $group->get('[/]', \MesaController::class . ':TraerTodos');
});

// Comandas
$app->group('/comandas', function (RouteCollectorProxy $group)
{
  $group->post('[/]', \ComandaController::class . ':CargarUno')->add(new AuthEmpleado());
  $group->get('[/]', \ComandaController::class . ':TraerTodos')->add(new AuthEmpleado());
  $group->get('/{id}', \ComandaController::class . ':TraerUno');
});

$app->group('/auth', function (RouteCollectorProxy $group) {  
  // POST
  $group->post('/login/clientes', \AuthController::class . ':IngresarCliente');
  $group->post('/login/empleados', \AuthController::class . ':IngresarEmpleado');
});

$app->group('/logs', function (RouteCollectorProxy $group) {  
  // POST
  $group->get('/comandas/descargar', \LogController::class . ':DescargarComandas');

});

$app->run();
