<?php
require_once './models/Producto.php';

class Bebida extends Producto
{
    public $litros;
    public $marca;

    /**
     *  Crea una nueva Bebida en la base de datos.
     *  @return int El ID del registro creado.
     */
    public function PostNew()
    {
        // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        // Prepara la consulta
        $consulta = $objAccesoDatos->prepararConsulta(
            "INSERT INTO bebidas (nombre, precio, descripcion, litros, marca) 
            VALUES (:nombre, :precio, :descripcion, :litros, :marca)"
        );
        
        // Vincula los valores de los parámetros de la consulta.
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':litros', $this->litros, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);

        try{
            // Ejecuta la consulta.
            $consulta->execute();

            // Obtiene el ID del nuevo registro.
            return $objAccesoDatos->obtenerUltimoId();
        }
        catch (PDOException $e){
            // Obtiene el codigo de error
            $codigoError = $e->getCode();

            // Comprueba si el error es por intento de duplicar campo unique
            if ($codigoError == '23000 ') {
                return json_encode(array('error' => 'Error campo duplicado'));
            } 
            else {
                return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
            }
        }
    }
  
    public function GetAll()
    {
      // Obtiene una instancia de la clase AccesoDatos.
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

      // Ejecuta la consulta.
        try{
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM bebidas");

            $consulta->execute();
    
            // Obtiene todos los usuarios de la consulta.
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Bebida');
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
      $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM bebidas WHERE id = :id");
      
      // Vincula el ID en la consulta
      $consulta->bindValue(':id', $id, PDO::PARAM_STR);

      try{
          // Ejecuta la consulta.
          $consulta->execute();
  
          // Obtiene el registro de la consulta como objeto Bebida.
          $result = $consulta->fetchObject('Bebida');

          // Muestra error en caso de no encontrar registro
          if($result === false){
              return json_encode(array("error" => "No se encontro Bebida con ID {$id}"));
          }

          // Devuelve el Empleado encontrado
          return $result;
      }
      catch (PDOException $e){
          return json_encode(array('error' => 'Fallo la ejecucion de la consulta a la base de datos'));
      }
  }
  
    public function DeleteById($id)
    {
      // Implementar logica para eliminar un producto de tipo bebida por ID
    }
  
    public function UpdateById($id)
    {
      // Implementar logica para actualizar un producto de tipo bebida por ID
    }
}

?>