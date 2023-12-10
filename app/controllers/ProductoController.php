<?php

class ProductoController
{
    public function GetAll()
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Prepara la consulta
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados");

        // Ejecuta la consulta.
        try{
            $consulta->execute();
    
            // Obtiene todos los usuarios de la consulta.
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Empleado');
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
        }
    }
}

?>