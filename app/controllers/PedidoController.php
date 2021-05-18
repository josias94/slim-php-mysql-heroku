<?php
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

class PedidoController extends Pedido implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $Pedido = new Pedido();
    $Pedido->mesaId = $parametros['mesaId'];
    $Pedido->usuarioId = $parametros['usuarioId'];
    $Pedido->productoId = $parametros['productoId'];
    $Pedido->crearPedido();

    $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    $pedidoTicket = $args['id'];
    $Pedido = Pedido::obtenerPedido($pedidoTicket);
    $payload = json_encode($Pedido);
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Pedido::obtenerTodos();
    $payload = json_encode(array("listaPedidos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  { 
    $parametros = $request->getParsedBody();
    $Pedido = new Pedido();
    $Pedido->codIdentificacion = $parametros['codIdentificacion'];
    $Pedido->capacidad = $parametros['capacidad'];
    $Pedido->estado = $parametros['estado']; 
    $var = $Pedido->modificarPedido();
    //TODO: Validar si el Pedido se modifico para mostrar el mensaje OK

    $payload = json_encode(array("mensaje" => "Pedido modificada con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {            
    $PedidoId = $args['PedidoId'];
    //TODO Falta columna fecha baja
    if(Pedido::borrarPedido($PedidoId)){
      $payload = json_encode(array("mensaje" => "Pedido borrada con exito"));      
      $response->getBody()->write($payload);
    }

    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  // public function TraerTodosFilterByMesa($request, $response, $args)
  // {
  //   $idMesa = $args['idMesa'];
  //   $lista = Pedido::obtenerTodosFilter($idMesa);    
  //   $payload = json_encode(array("listaPedidosFiltrado" => $lista));

  //   $response->getBody()->write($payload);
  //   return $response
  //     ->withHeader('Content-Type', 'application/json');
  // }
}
