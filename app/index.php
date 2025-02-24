<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';
require_once "./controllers/UsuarioController.php";
require_once "./controllers/ProductoController.php";
require_once "./controllers/MesaController.php";
require_once "./controllers/PedidoController.php";
require_once './db/AccesoDatos.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
// Instantiate App
$app = AppFactory::create();

$app->setBasePath('/slim-php-deployment/app'); 

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->get('[/]', function (Request $request, Response $response) {
    $payload = json_encode(array('method' => 'GET', 'msg' => "Bienvenido a SlimFramework 2028"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/usuarios/crear', \UsuarioController::class . ':CargarUno');

$app->get('/usuarios/mostrar', \UsuarioController::class . ':TraerTodos');

$app->post('/productos/crear', \ProductoController::class .':CargarUno');

$app->get('/productos/mostrar', \ProductoController::class .':TraerTodos');

$app->post('/mesas/crear', \MesaController::class .':CargarUno');

$app->get('/mesas/mostrar', \MesaController::class .':TraerTodos');

$app->post('/pedidos/crear', \PedidoController::class .':CargarUno');

$app->get('/pedidos/mostrar', \PedidoController::class .':TraerTodos');


$app->get('/test', function (Request $request, Response $response) {
    $payload = json_encode(array('method' => 'GET', 'msg' => "test"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('[/]', function (Request $request, Response $response) {
    $payload = json_encode(array('method' => 'POST', 'msg' => "Bienvenido a SlimFramework 2023"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/test', function (Request $request, Response $response) {
    $payload = json_encode(array('method' => 'POST', 'msg' => "Bienvenido a SlimFramework 2023"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
