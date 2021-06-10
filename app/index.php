<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
// require_once './middlewares/Logger.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';

require './middlewares/MWparaAutentificar.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);


// Routes
// $app->group("[/]",function (RouteCollectorProxy $group1){
  
  
//   $group1->group('/productos', function (RouteCollectorProxy $group) {
//     $group->get('[/]', \ProductoController::class . ':TraerTodos');
//     $group->get('/id={id}', \ProductoController::class . ':TraerUno');
//     $group->post('[/]', \ProductoController::class . ':CargarUno');
//     $group->post('/Modificar', \ProductoController::class . ':ModificarUno');
//     $group->delete('/id={productoId}', \ProductoController::class . ':BorrarUno');
//   })->add(\MWparaAutentificar::class . ':VerificarUsuario');
// });

$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->get('[/]', \UsuarioController::class . ':TraerTodos');
  $group->get('/id={id}', \UsuarioController::class . ':TraerUno');
  $group->post('[/]', \UsuarioController::class . ':CargarUno');
  $group->post('/Modificar', \UsuarioController::class . ':ModificarUno');
  $group->delete('/id={usuarioId}', \UsuarioController::class . ':BorrarUno');
})->add(\MWparaAutentificar::class . ':VerificarUsuario');

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesaController::class . ':TraerTodos');
  $group->get('/id={codIdentificacion}', \MesaController::class . ':TraerUno');
  $group->post('[/]', \MesaController::class . ':CargarUno');
  $group->post('/Modificar', \MesaController::class . ':ModificarUno');
  $group->delete('/id={codIdentificacion}', \MesaController::class . ':BorrarUno');
})->add(\MWparaAutentificar::class . ':VerificarUsuario');

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \PedidoController::class . ':TraerTodos');
  $group->get('/id={id}', \PedidoController::class . ':TraerUno'); 
  $group->post('[/]', \PedidoController::class . ':CargarUno');
  $group->post('/Modificar', \PedidoController::class . ':ModificarUno');
  $group->delete('/{id}', \PedidoController::class . ':BorrarUno');
  //Filtros
  //$group->get('/mesa={idMesa}', \PedidoController::class . ':TraerTodosFilterByMesa');
})->add(\MWparaAutentificar::class . ':VerificarUsuario');

$app->get('[/]', function (Request $request, Response $response) { 
  $response->getBody()->write("Bienvenido a la Comanda");
  return $response;
});

$app->run();
