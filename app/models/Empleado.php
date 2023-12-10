<?php

require_once __DIR__ . '/../db/AccesoDatos.php';

class Empleado
{
    public $id;
    public $nombre;
    public $salario;
    public $rol;
    public $fechaBaja;

    /**
     *  Crea un nuevo Empleado en la base de datos.
     *  @return int El ID del nuevo Empleado.
     */
    public function crearEmpleado()
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Prepara una consulta INSERT para insertar los datos del nuevo usuario en la tabla empleados.
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO empleados (nombre, salario, rol) VALUES (:nombre, :salario, :rol)");
        
        // Vincula los valores de los parámetros de la consulta.
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':salario', $this->salario, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);

        try{
            // Ejecuta la consulta.
            $consulta->execute();

            // Obtiene el ID del nuevo Empleado.
            return $objAccesoDatos->obtenerUltimoId();
        }
        catch (PDOException $e){
            // Obtiene el codigo de error
            $codigoError = $e->getCode();

            // Comprueba si el error es por intento de duplicar campo unique
            if ($codigoError == '23000 ') {
                return json_encode(array('error' => 'Nombre de rol invalido'));
            } 
            else {
                return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
            }
        }
    }

    /**
     *  Obtiene todos los Empleados de la base de datos.
     *
     *  @return Empleado[] Un array de objetos Usuario con todos los usuarios de la base de datos.
    */
    public static function obtenerTodos($rol)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        if($rol === ''){
            // Prepara una consulta SELECT para obtener todos los usuarios de la tabla usuarios.
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados");
        }
        else{
            
            // Prepara una consulta SELECT para obtener todos los usuarios de la tabla usuarios.
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados WHERE rol = :rol");

            $consulta->bindValue(':rol', $rol, PDO::PARAM_STR);
        }

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

    /**
     *  Obtiene un Empleado de la base de datos por ID
     *
     *  @param string $id El ID de Empleado a obtener.
     *  @return Empleado|null El objeto Empleado, o null si no se encuentra Empleado
     */
    public static function GetById($id)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Prepara la consulta
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados WHERE id = :id");
        
        // Vincula el ID en la consulta
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);


        try{
            // Ejecuta la consulta.
            $consulta->execute();
    
            // Obtiene el Empleado de la consulta como objeto Empleado.
            $result = $consulta->fetchObject('Empleado');

            // Muestra error en caso de no encontrar registro
            if($result === false){
                return json_encode(array("error" => "No se encontro Empleado con ID {$id}"));
            }

            // Devuelve el Empleado encontrado
            return $result;
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
        }
    }

    /**
     *  Realiza una baja logica de un usuario en la base de datos.
     *  
     *  @return bool Devuelve true si relizo la baja correctamente, o false en caso contrario.
     */
    public static function DeleteById($id)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        // Prepara una la consulta
        $consulta = $objAccesoDato->prepararConsulta("UPDATE empleados SET fechaBaja = :fechaBaja WHERE id = :id AND fechaBaja IS NULL");
        
        // Obtiene la fecha actual.
        $fecha = new DateTime(date("d-m-Y"));

        // Vincula los valores de los nuevos datos del usuario a las variables de parámetro.
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));

        // Ejecuta la consulta.
        try{
            $consulta->execute();
            if($consulta->rowCount() > 0){
                // Devuelve true si la modificación se realizó correctamente.
                return true;
            }
            else return json_encode(array('error' => 'No se encontro el registro'));
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
        }
    }

    /**
     *  Modifica los datos de un usuario en la base de datos.
     *
     *  @param Usuario $usuario Objeto del tipo Usuario con valores actualizados
     *  @return bool Devuelve true si la modificación se realizó correctamente, o false en caso contrario.
     */
    public static function UpdateById($empleado)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        
        // Prepara la consulta
        $consulta = $objAccesoDato->prepararConsulta("UPDATE empleados SET nombre = :nombre, salario = :salario, rol = :rol WHERE id = :id");
        
        // Vincula los valores de los nuevos datos del empleado
        $consulta->bindValue(':nombre', $empleado->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':salario', $empleado->salario, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $empleado->rol, PDO::PARAM_STR);
        $consulta->bindValue(':id', $empleado->id, PDO::PARAM_INT);
        
        // Ejecuta la consulta.
        try{
            $consulta->execute();
            // Devuelve true si la modificación se realizó correctamente.
            return true;
        }
        catch (PDOException $e){
            // Obtiene el codigo de error
            $codigoError = $e->getCode();

            // Comprueba si el error es por intento de duplicar campo unique
            if ($codigoError == '23000 ') {
                return json_encode(array('error' => 'El rol no se encuentra en la base de datos'));
            } 
            else {
                return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
            }
        }
    }
}