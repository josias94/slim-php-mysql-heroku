<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $Mesa = new Mesa();
    $Mesa->codIdentificacion = $parametros['codIdentificacion'];
    $Mesa->capacidad = $parametros['capacidad'];
    $Mesa->estado = $parametros['estado'];
    $Mesa->crearMesa();

    $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    $codIdentificacion = $args['codIdentificacion'];
    $Mesa = Mesa::obtenerMesa($codIdentificacion);
    $payload = json_encode($Mesa);
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Mesa::obtenerTodos();
    $payload = json_encode(array("listaMesas" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  { 
    $parametros = $request->getParsedBody();
    $Mesa = new Mesa();
    $Mesa->codIdentificacion = $parametros['codIdentificacion'];
    $Mesa->capacidad = $parametros['capacidad'];
    $Mesa->estado = $parametros['estado']; 
    $var = $Mesa->modificarMesa();
    //TODO: Validar si el Mesa se modifico para mostrar el mensaje OK

    $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {            
    $prodId = $args['codIdentificacion'];
    //TODO Falta columna fecha baja
    if(Mesa::borrarMesa($prodId)){
      $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));      
      $response->getBody()->write($payload);
    }

    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
