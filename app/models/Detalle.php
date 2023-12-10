<?php 

require_once __DIR__ . '/../db/AccesoDatos.php';

class Detalle{
    public $id;
    public $id_comanda;
    public $id_bebida;
    public $id_comida;

    /**
     *  Crea un nuevo Detalle en la base de datos.
     *  @return int El ID del nuevo registro.
     */
    public function PostNew()
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Prepara la consulta
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO detalles (id_comanda, id_bebida, id_comida) VALUES (:id_comanda, :id_bebida, :id_comida)");
        
        // Vincula los valores de los parámetros de la consulta.
        $consulta->bindValue(':id_comanda', $this->id_comanda, PDO::PARAM_STR);
        $consulta->bindValue(':id_bebida', $this->id_bebida, PDO::PARAM_STR);
        $consulta->bindValue(':id_comida', $this->id_comida, PDO::PARAM_STR);

        try{
            // Ejecuta la consulta.
            $consulta->execute();

            // Obtiene el ID del nuevo registro.
            return $objAccesoDatos->obtenerUltimoId();
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'No se pudo cargar detalle'));
        }
    }

    // public function GetById($id)
    // {
    //     // Obtiene una instancia de la clase AccesoDatos.
    //     $objAccesoDatos = AccesoDatos::obtenerInstancia();

    //     // Prepara la consulta
    //     $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM servicios WHERE id = :id");

    //     // Vincula el ID en la consulta
    //     $consulta->bindValue(':id', $id, PDO::PARAM_STR);

    //     try{
    //         // Ejecuta la consulta.
    //         $consulta->execute();
    
    //         // Obtiene el registro de la consulta como objeto Bebida.
    //         $result = $consulta->fetchObject('Cliente');

    //         // Muestra error en caso de no encontrar registro
    //         if($result === false){
    //             return json_encode(array("error" => "No se encontro Cliente con ID {$id}"));
    //         }

    //         // Devuelve el Empleado encontrado
    //         return $result;
    //     }
    //     catch (PDOException $e){
    //         return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
    //     }
    // }

    // public function GetAll()
    // {
    //   // Obtiene una instancia de la clase AccesoDatos.
    //     $objAccesoDatos = AccesoDatos::obtenerInstancia();

    //     try{
    //         // Preapara la consulta.
    //         $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM clientes");

    //         $consulta->execute();
    
    //         // Obtiene todos los Clientes de la consulta.
    //         return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cliente');
    //     }
    //     catch (PDOException $e){
    //         return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
    //     }
    // }

    // /**
    //  *  Modifica los datos de un Cliente en la base de datos.
    //  *
    //  *  @param Cliente $cliente Objeto del tipo Cliente con valores actualizados
    //  *  @return bool Devuelve true si la modificación se realizó correctamente, o false en caso contrario.
    //  */
    // public static function UpdateById($cliente)
    // {        
    //     // Obtiene una instancia de la clase AccesoDatos.
    //     $objAccesoDato = AccesoDatos::obtenerInstancia();
        
    //     // Prepara la consulta
    //     $consulta = $objAccesoDato->prepararConsulta("UPDATE clientes SET nombre = :nombre, comensales = :comensales WHERE id = :id");
        
    //     // Vincula los valores de los nuevos datos del empleado
    //     $consulta->bindValue(':nombre', $cliente->nombre, PDO::PARAM_STR);
    //     $consulta->bindValue(':comensales', $cliente->comensales, PDO::PARAM_STR);
    //     $consulta->bindValue(':id', $cliente->id, PDO::PARAM_INT);
        
    //     // Ejecuta la consulta.
    //     try{
    //         $consulta->execute();
    //         // Devuelve true si la modificación se realizó correctamente.
    //         return true;
    //     }
    //     catch (PDOException $e){
    //         return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
    //     }
    // }

    // /**
    //  *  Realiza una baja logica de un Cliente en la base de datos.
    //  *  
    //  *  @return bool Devuelve true si relizo la baja correctamente, o false en caso contrario.
    //  */
    // public static function DeleteById($id)
    // {
    //     // Obtiene una instancia de la clase AccesoDatos.
    //     $objAccesoDato = AccesoDatos::obtenerInstancia();

    //     // Prepara una la consulta
    //     $consulta = $objAccesoDato->prepararConsulta("UPDATE clientes SET fecha_baja = :fecha_baja WHERE id = :id AND fecha_baja IS NULL");
        
    //     // Obtiene la fecha actual.
    //     $fecha = new DateTime(date("d-m-Y"));

    //     // Vincula los valores de los nuevos datos del usuario a las variables de parámetro.
    //     $consulta->bindValue(':id', $id, PDO::PARAM_INT);
    //     $consulta->bindValue(':fecha_baja', date_format($fecha, 'Y-m-d H:i:s'));

    //     // Ejecuta la consulta.
    //     try{
    //         $consulta->execute();
    //         if($consulta->rowCount() > 0){
    //             // Devuelve true si la modificación se realizó correctamente.
    //             return true;
    //         }
    //         else return json_encode(array('error' => 'No se encontro el registro'));
    //     }
    //     catch (PDOException $e){
    //         return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
    //     }
    // }
}
?>