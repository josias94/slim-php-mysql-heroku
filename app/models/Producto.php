<?php

class Producto
{
    public $id;
    public $nombre;
    public $tipo;
    public $stock;
    public $precio;
    public $codigoBarra;
    public $fechaRegistro;//yyyy-MM-dd
    public $FechaUltimaModificacion;
    public $fechaBaja;

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombre, tipo, stock, precio, codigoBarra, fechaRegistro, FechaUltimaModificacion)
                                                        VALUES (:nombre, :tipo, :stock, :precio, :codigoBarra, :fechaRegistro, :FechaUltimaModificacion)");
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);        
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':codigoBarra', $this->codigoBarra, PDO::PARAM_STR);
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':fechaRegistro', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->bindValue(':FechaUltimaModificacion', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, tipo, stock, precio, codigoBarra, fechaRegistro, FechaUltimaModificacion
                                                        FROM productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function obtenerProducto($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, tipo, stock, precio, codigoBarra, fechaRegistro, FechaUltimaModificacion
                                                        FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS,'Producto');
    }

    public function modificarProducto()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos 
                                                        SET nombre = :nombre,
                                                        tipo = :tipo,
                                                        stock = :stock,
                                                        precio = :precio,
                                                        codigoBarra = :codigoBarra,
                                                        FechaUltimaModificacion = :FechaUltimaModificacion
                                                        WHERE id = :id");
        //TODO:Stock y precio con validacionincorrecta
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);        
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':codigoBarra', $this->codigoBarra, PDO::PARAM_STR);
        $fecha = new DateTime(date("d-m-Y"));    
        $consulta->bindValue(':FechaUltimaModificacion', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function borrarProducto($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET fechaBaja = :fechaBaja 
                                                        WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
        return $consulta->rowCount();
    }
}