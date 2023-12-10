<?php 

require_once __DIR__ . '/../db/AccesoDatos.php';

class Mesa{
    public $id;
    public $estado;
    public $capacidad;

    public function GetAll($estado, $comensales)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Valida el estado y prepara la consulta segun el caso
        if($estado !== null && $estado !== ''){
            if($estado === 'fuera-de-servicio') $estado = 'fuera de servicio';

            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mesas WHERE estado = :estado AND capacidad >= :comensales");
        
            // Vincula los parametros en la consulta
            $consulta->bindValue(':comensales', $comensales, PDO::PARAM_STR);
            $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        }
        else{
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mesas WHERE capacidad >= :comensales");
            
            // Vincula los parametros en la consulta
            $consulta->bindValue(':comensales', $comensales, PDO::PARAM_STR);
        }

        try{
            // Ejecuta la consulta.
            $consulta->execute();
    
            // Obtiene el registro de la consulta como objeto Mesa.
            $result = $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');

            // Muestra error en caso de no encontrar registro
            if($result === false){
                return json_encode(array("error" => "No se encontro Mesa disponible"));
            }

            return $result;
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
        }
    }

    public function GetById($id)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Prepara la consulta
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mesas WHERE id = :id");

        // Vincula el ID en la consulta
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);

        try{
            // Ejecuta la consulta.
            $consulta->execute();
    
            // Obtiene el registro de la consulta como objeto Mesa.
            $result = $consulta->fetchObject('Mesa');

            // Muestra error en caso de no encontrar registro
            if($result === false){
                return json_encode(array("error" => "No se encontro Mesa con ID {$id}"));
            }

            return $result;
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
        }
    }
}