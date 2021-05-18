<?php

class Mesa
{
    public $id;
    public $codIdentificacion;    
    public $capacidad;
    public $estado;
    public $fechaRegistro;//yyyy-MM-dd
    public $fechaBaja;

    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (codIdentificacion, capacidad, estado, fechaRegistro)
                                                        VALUES (:codIdentificacion, :capacidad, :estado, :fechaRegistro)");
        $consulta->bindValue(':codIdentificacion', $this->codIdentificacion, PDO::PARAM_STR);        
        $consulta->bindValue(':capacidad', $this->capacidad, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':fechaRegistro', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codIdentificacion, capacidad, estado, fechaRegistro, fechaBaja
                                                        FROM mesas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    public static function obtenerMesa($codIdentificacion)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codIdentificacion, capacidad, estado, fechaRegistro, fechaBaja
                                                        FROM mesas WHERE codIdentificacion = :codIdentificacion");
        $consulta->bindValue(':codIdentificacion', $codIdentificacion, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS,'Mesa');
    }

    public function modificarMesa()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas 
                                                        SET capacidad = :capacidad,
                                                        estado = :estado
                                                        WHERE codIdentificacion = :codIdentificacion");
        $consulta->bindValue(':capacidad', $this->capacidad, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->bindValue(':codIdentificacion', $this->codIdentificacion, PDO::PARAM_STR);        
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function borrarMesa($codIdentificacion)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET fechaBaja = :fechaBaja 
                                                        WHERE codIdentificacion = :codIdentificacion");
        $fecha = new DateTime(date("d-m-Y H:i:s"));
        $consulta->bindValue(':codIdentificacion', $codIdentificacion, PDO::PARAM_STR);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
        return $consulta->rowCount();
    }
}