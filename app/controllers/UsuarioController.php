<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usr = new Usuario();
        $usr->nombre = $parametros['nombre'];
        $usr->apellido = $parametros['apellido'];
        $usr->clave = $parametros['clave'];
        $usr->email = $parametros['email'];
        $usr->localidad = $parametros['localidad'];
        $usr->rubro = $parametros['rubro'];       
        $usr->crearUsuario();

        $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
      // Buscamos usuario por id
      $id = $args['id'];
      $usuario = Usuario::obtenerUsuario($id);
      $payload = json_encode($usuario);
      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
      $lista = Usuario::obtenerTodos();
      $payload = json_encode(array("listaUsuario" => $lista));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    { 
      $parametros = $request->getParsedBody();             
      
      $usr = new Usuario();
      $usr->id = $parametros['id'];
      $usr->nombre = $parametros['nombre'];
      $usr->apellido = $parametros['apellido'];
      $usr->clave = $parametros['clave'];
      $usr->email = $parametros['email'];
      $usr->localidad = $parametros['localidad'];
      $usr->rubro = $parametros['rubro'];
      $var = $usr->modificarUsuario();
      //TODO: Validar si el usuario se modifico para mostrar el mensaje OK

      $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {            
        $usuarioId = $args['usuarioId'];        
        
        if(Usuario::borrarUsuario($usuarioId)){
          $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));      
          $response->getBody()->write($payload);
        }

        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
