<?php

class Pedido
{
    public $id;
    public $mesaId;
    public $pedidoTicket;
    public $usuarioId;
    public $productoId;    
    public $estado;
    public $fechaRegistro;
    public $fechaFinalizacion;
    public $fechaBaja;
    

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (mesaId, pedidoTicket, usuarioId, productoId, estado, fechaRegistro)
                                                        VALUES (:mesaId, :pedidoTicket, :usuarioId, :productoId, :estado, :fechaRegistro)");
        $consulta->bindValue(':mesaId', $this->mesaId, PDO::PARAM_INT); 
        $uniqid =  substr(uniqid(), 8,5);
        $this->pedidoTicket = $uniqid;
        $consulta->bindValue(':pedidoTicket', $this->pedidoTicket, PDO::PARAM_STR);        
        $consulta->bindValue(':usuarioId', $this->usuarioId, PDO::PARAM_INT);
        $consulta->bindValue(':productoId', $this->productoId, PDO::PARAM_INT);
        $consulta->bindValue(':estado', 0, PDO::PARAM_INT);
        $fecha = new DateTime(date("d-m-Y  H:i:s"));
        $consulta->bindValue(':fechaRegistro', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, mesaId, pedidoTicket, usuarioId, productoId, estado, fechaRegistro, fechaFinalizacion, fechaBaja
                                                        FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($pedidoTicket)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, mesaId, pedidoTicket, usuarioId, productoId, estado, fechaRegistro, fechaFinalizacion, fechaBaja
                                                        FROM pedidos WHERE pedidoTicket = :pedidoTicket");
        $consulta->bindValue(':pedidoTicket', $pedidoTicket, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS,'Pedido');
    }

    public function modificarPedido()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos
                                                        SET usuarioId = :usuarioId,
                                                        estado = :estado
                                                        WHERE pedidoTicket = :pedidoTicket");
        $consulta->bindValue(':usuarioId', $this->usuarioId, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->bindValue(':pedidoTicket', $this->pedidoTicket, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function borrarPedido($PedidoId)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET fechaBaja = :fechaBaja 
                                                        WHERE pedidoTicket = :pedidoTicket");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':pedidoTicket', $PedidoId, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
        return $consulta->rowCount();
    }


    // public static function obtenerTodosFilter($codIdentificacion)
    // {
    //     $objAccesoDatos = AccesoDatos::obtenerInstancia();
    //     $consulta = $objAccesoDatos->prepararConsulta("SELECT P.id, M.codIdentificacion, U.nombre as 'Usuario', Prod.nombre as 'Producto', P.estado FROM pedidos P 
    //                                                     INNER JOIN usuarios U ON P.usuarioId = U.id 
    //                                                     INNER JOIN mesas M ON P.mesaId = M.id 
    //                                                     INNER JOIN productos Prod ON P.productoId = Prod.id
    //                                                     WHERE M.codIdentificacion = :codIdentificacion");
    //     $consulta->bindValue(':codIdentificacion', $codIdentificacion, PDO::PARAM_STR);
    //     $consulta->execute();

    //     return $consulta->fetchAll(PDO::FETCH_CLASS, 'Filtro');
        
    // }
}
class Filtro{

}