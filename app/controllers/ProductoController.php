<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $prod = new Producto();
        $prod->nombre = $parametros['nombre'];
        $prod->tipo = $parametros['tipo'];
        $prod->stock = $parametros['stock'];
        $prod->precio = $parametros['precio'];
        $prod->codigoBarra = $parametros['codigoBarra']; 
        $prod->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
      // Buscamos Producto por id
      $id = $args['id'];
      $Producto = Producto::obtenerProducto($id);
      $payload = json_encode($Producto);
      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
      $lista = Producto::obtenerTodos();
      $payload = json_encode(array("listaProducto" => $lista));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    { 
      $parametros = $request->getParsedBody();             
      //TODO Arreglart keys
      $prod = new Producto();
      $prod->id = $parametros['id'];
      $prod->nombre = $parametros['nombre'];
      $prod->tipo = $parametros['tipo'];
      $prod->stock = $parametros['stock'];
      $prod->precio = $parametros['precio'];
      $prod->codigoBarra = $parametros['codigoBarra']; 
      $var = $prod->modificarProducto();
      //TODO: Validar si el Producto se modifico para mostrar el mensaje OK

      $payload = json_encode(array("mensaje" => "Producto modificado con exito"));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {            
        $prodId = $args['productoId'];        
        //TODO Falta columna fecha baja
        if(Producto::borrarProducto($prodId)){
          $payload = json_encode(array("mensaje" => "Producto borrado con exito"));      
          $response->getBody()->write($payload);
        }

        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
