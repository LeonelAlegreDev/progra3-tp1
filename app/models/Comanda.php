<?php 

require_once __DIR__ . '/../db/AccesoDatos.php';

class Comanda{
    public $id;
    public $id_servicio;
    public $date_start;
    public $date_end;

    /**
     *  Crea un nuevo Cliente en la base de datos.
     *  @return int El ID del nuevo registro.
     */
    public function PostNew()
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Prepara la consulta
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO comandas (id_servicio) VALUES (:id_servicio)");
        
        // Vincula los valores de los parámetros de la consulta.
        $consulta->bindValue(':id_servicio', $this->id_servicio, PDO::PARAM_STR);

        try{
            // Ejecuta la consulta.
            $consulta->execute();

            // Obtiene el ID del nuevo registro.
            return $objAccesoDatos->obtenerUltimoId();
        }
        catch (PDOException $e){
            // return json_encode(array('error' => 'No se pudo cargar Comanda'));
            return json_encode(array('error' => $e));

        }
    }

    public function GetById($id)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Prepara la consulta
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM comandas WHERE id = :id");

        // Vincula el ID en la consulta
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);

        try{
            // Ejecuta la consulta.
            $consulta->execute();
    
            // Obtiene el registro de la consulta como objeto Bebida.
            $result = $consulta->fetchObject('Comanda');

            // Muestra error en caso de no encontrar registro
            if($result === false){
                return json_encode(array('error' => "No se encontro Comanda con ID {$id}"));
            }

            return $result;
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
        }
    }

    public function GetAll($estado)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        if($estado !== null && $estado !== ''){
            switch ($estado) {
                case 'pendiente':
                    $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM comandas WHERE date_end IS NULL");
                    break;
                
                case 'terminada':
                    $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM comandas WHERE date_end IS NOT NULL");
                    break;
            }
        }
        else{
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM comandas");
        }
        try{
            $consulta->execute();
    
            // Obtiene todos los Clientes de la consulta.
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Comanda');
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
        }
    }
}
?>