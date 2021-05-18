<?php

class Producto
{
    public $id;
    public $nombre;
    public $tipo;
    public $stock;
    public $precio;
    public $codigoBarra;
    public $fechaDeRegistro;//yyyy-MM-dd
    public $fechaUltModificacion;
    public $fechaBaja;

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO Productos (nombre, tipo, stock, precio, codigoBarra, fechaDeRegistro, FechaUltModificacion)
                                                        VALUES (:nombre, :tipo, :stock, :precio, :codigoBarra, :fechaDeRegistro, :FechaUltModificacion)");
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);        
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':codigoBarra', $this->codigoBarra, PDO::PARAM_STR);
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':fechaDeRegistro', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->bindValue(':fechaUltModificacion', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, apellido, clave, email, localidad, rubro, fechaDeRegistro
                                                        FROM productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerProducto($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, apellido, clave, email, localidad, rubro, fechaDeRegistro
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
                                                        apellido = :apellido,
                                                        clave = :clave,
                                                        email = :email,
                                                        localidad = :localidad,
                                                        rubro = :rubro 
                                                        WHERE id = :id");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
        $consulta->bindValue(':localidad', $this->localidad, PDO::PARAM_STR);
        $consulta->bindValue(':rubro', $this->rubro, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
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