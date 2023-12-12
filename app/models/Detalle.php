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

    public static function GetAllByComanda($id_comanda)
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM detalles WHERE id_comanda = :id_comanda");

        $consulta->bindValue(':id_comanda', $id_comanda, PDO::PARAM_STR);

        try{
            $consulta->execute();
    
            // Obtiene todos los Clientes de la consulta.
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Detalle');
        }
        catch (PDOException $e){
            return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
        }
    }
}
?>