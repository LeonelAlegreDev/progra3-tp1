<?php
require_once './models/Bebida.php';
require_once './interfaces/IApiUsable.php';

class BebidaController extends Bebida implements IApiUsable
{
    /**
     * Crea una nuevo Bebida en la base de datos.
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con el mensaje de éxito.
    */
    public function CargarUno($request, $response, $args)
    {
        // Obtiene los parámetros de la solicitud.
        $parametros = $request->getParsedBody();

        // Obtiene los valores de los parámetros usuario y clave.
        $nombre = isset($parametros['nombre']) ? $parametros['nombre'] : null;
        $marca = isset($parametros['marca']) ? $parametros['marca'] : null;
        $descripcion = isset($parametros['descripcion']) ? $parametros['descripcion'] : null;
        $precio = isset($parametros['precio']) ? $parametros['precio'] : null;
        $litros = isset($parametros['litros']) ? $parametros['litros'] : null;

        
        if( $nombre !== '' && $nombre !== null &&
            $marca !== '' && $marca !== null && 
            $precio !== '' && $precio !== null && 
            $litros !== '' && $litros !== null && 
            $descripcion !== '' && $descripcion !== null)
        {            
            // Crea un nuevo objeto Usuario.
            $bebida = new Bebida();
            $bebida->nombre = $nombre;
            $bebida->marca = $marca;
            $bebida->descripcion = $descripcion;
            $bebida->precio = $precio;
            $bebida->litros = $litros;

            // Crea el usuario en la base de datos.
            $result = $bebida->PostNew();

            // Comprueba que el resultado sea un entero
            if(ctype_digit($result))
            {
                // Crea un mensaje de éxito en formato JSON.
                $payload = json_encode(array("mensaje" => "Bebida creada con exito", "id" => "{$result}"));

                // Establece el contenido de la respuesta en formato JSON.
                $response->getBody()->write($payload);
            }
            else{
                $response->getBody()->write($result);
            }
        }
        else{
          // Crea un mensaje de éxito en formato JSON.
          $payload = json_encode(array("error" => "faltan parametros"));

          // Establece el contenido de la respuesta en formato JSON.
          $response->getBody()->write($payload);
        }

        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Obtiene una Bebida de la base de datos por ID
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con el usuario solicitado en formato JSON.
     */
    public function TraerUno($request, $response, $args)
    {
        // Obtiene el nombre de usuario de los argumentos de la ruta.
        $id = $args['id'];
        
        // Obtiene el usuario de la base de datos por su nombre de usuario.
        $bebida = Bebida::GetById($id);

        // Convierte el usuario a formato JSON.
        $payload = json_encode($bebida);

        // Establece el contenido de la respuesta en formato JSON.
        $response->getBody()->write($payload);
        
        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Obtiene todos las Bebidas de la base de datos.
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con la lista de usuarios en formato JSON.
    */
    public function TraerTodos($request, $response, $args)
    {
      // Obtiene la lista de todos los usuarios de la base de datos.
      $lista = Bebida::GetAll();

      $payload = json_encode($lista);
      
      // Establece el contenido de la respuesta en formato JSON.
      $response->getBody()->write($payload);
      
      // Establece el encabezado Content-Type de la respuesta.
      $response->withHeader('Content-Type', 'application/json');
      
      return $response;
    }
    
    /**
     * Modifica un registro en la base de datos por ID
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con el mensaje de éxito en formato JSON.
    */
    public function ModificarUno($request, $response, $args)
    {
        // Obtiene el nombre de usuario de los argumentos de la ruta.
        $id = isset($args['id']) ? $args['id'] : null;

        // Obtiene los parámetros de la solicitud.
        $parametros = $request->getParsedBody();

        // Obtiene los nuevos valores del Empleado
        $nombre = isset($parametros['nombre']) ? $parametros['nombre'] : null;
        $precio = isset($parametros['precio']) ? $parametros['precio'] : null;
        $descripcion = isset($parametros['descripcion']) ? $parametros['descripcion'] : null;
        $litros = isset($parametros['litros']) ? $parametros['litros'] : null;
        $marca = isset($parametros['marca']) ? $parametros['marca'] : null;


        if($id !== '' && $id !== null){
          // Obtiene el Empleado de la base de datos por ID
          $bebida = Bebida::GetById($id);
          
          // Valida que sea una Bebida
          if($bebida instanceof Bebida){
            // Valida que se haya enviado el nuevo nombre
            if($nombre !== null && $nombre !== '' && 
               $precio !== null && $precio !== '' &&
               $litros !== null && $litros !== '' &&
               $marca !== null && $marca !== '' &&
               $descripcion !== null && $descripcion !== '')
            {
              // Actualiza los datos
              $bebida->nombre = $nombre;
              $bebida->precio = $precio;
              $bebida->litros = $litros;
              $bebida->marca = $marca;
              $bebida->descripcion = $descripcion;


              // CONTINUAR REFACTORIZANDO DESDE AQUI 
              // Modifica el registro en la base de datos.
              $result = Bebida::UpdateById($bebida);
              
              if($result === true){
                // Crea un mensaje de éxito en formato JSON.
                $payload = json_encode(array("mensaje" => "Empleado modificado con exito"));

                // Establece el contenido de la respuesta en formato JSON.
                $response->getBody()->write($payload);
              }
              else{
                $response->getBody()->write($result);
              }
            }
            else{
              // Crea un mensaje de eror en formato JSON.
              $payload = json_encode(array("error" => "faltan parametros"));

              // Establece el contenido de la respuesta en formato JSON.
              $response->getBody()->write($payload);
            }
          }
          else{
            // Crea un mensaje de eror en formato JSON.
            $payload = json_encode(array("error" => "no se encontro usuario en la base de datos"));

            // Establece el contenido de la respuesta en formato JSON.
            $response->getBody()->write($payload);
          }
        }
        else{
          // Crea un mensaje de eror en formato JSON.
          $payload = json_encode(array("error" => "no se envio usuario en la ruta"));

          // Establece el contenido de la respuesta en formato JSON.
          $response->getBody()->write($payload);
        }
        
        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Elimina un usuario de la base de datos por su ID.
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con el mensaje de éxito en formato JSON.
    */
    public function BorrarUno($request, $response, $args)
    {
        // Obtiene el id del usuario desde de la ruta.
        $id = isset($args['id']) ? $args['id'] : null;

        // Valida que se haya enviado un id
        if($id !== null && $id !== ''){
          // Elimina el usuario de la base de datos.
          $result = Empleado::DeleteById($id); 
          
          if($result === true){
            // Crea un mensaje de éxito en formato JSON.
            $payload = json_encode(array("mensaje" => "Usuario dado de baja con exito"));

            // Establece el contenido de la respuesta en formato JSON.
            $response->getBody()->write($payload);
          }
          else{
            $payload = $result;
            $response->getBody()->write($payload);
          }
        }
        else {
          // Crea un mensaje de eror en formato JSON.
          $payload = json_encode(array("error" => "falta parametro id"));

          // Establece el contenido de la respuesta en formato JSON.
          $response->getBody()->write($payload);
        }

        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}
