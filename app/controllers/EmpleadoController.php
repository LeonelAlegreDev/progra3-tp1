<?php
require_once './models/Empleado.php';
require_once './interfaces/IApiUsable.php';

class EmpleadoController extends Empleado implements IApiUsable
{
    /**
     * Crea un nuevo Empleado en la base de datos.
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
        $salario = isset($parametros['salario']) ? $parametros['salario'] : null;
        $rol = isset($parametros['rol']) ? $parametros['rol'] : null;
        
        if( $nombre !== '' && $nombre !== null &&
            $salario !== '' && $salario !== null && 
            $rol !== '' && $rol !== null)
        {            
            // Crea un nuevo objeto Usuario.
            $empleado = new Empleado();
            $empleado->nombre = $nombre;
            $empleado->salario = $salario;
            $empleado->rol = $rol;

            // Crea el usuario en la base de datos.
            $result = $empleado->crearEmpleado();

            // Comprueba que el resultado sea un entero
            if(ctype_digit($result))
            {
                // Crea un mensaje de éxito en formato JSON.
                $payload = json_encode(array("mensaje" => "Empleado creado con exito", "id" => "{$result}"));

                // Establece el contenido de la respuesta en formato JSON.
                $response->getBody()->write($payload);
            }
            else{
                $resultadoJson = json_decode($result);

                if (property_exists($resultadoJson, 'error')) {
                    // Crea un mensaje de eror en formato JSON.
                    $payload = json_encode(array("error" => $resultadoJson->error));

                    // Establece el contenido de la respuesta en formato JSON.
                    $response->getBody()->write($payload);
                } 
                else {
              // Crea un mensaje de eror en formato JSON.
              $payload = json_encode(array("error" => "no se pudo modificar usuario"));

              // Establece el contenido de la respuesta en formato JSON.
              $response->getBody()->write($payload);  
                }
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
     * Obtiene un usuario de la base de datos por su nombre de usuario.
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
        $empleado = Empleado::GetById($id);

        // Convierte el usuario a formato JSON.
        $payload = json_encode($empleado);

        // Establece el contenido de la respuesta en formato JSON.
        $response->getBody()->write($payload);
        
        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Obtiene todos los usuarios de la base de datos.
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con la lista de usuarios en formato JSON.
    */
    public function TraerTodos($request, $response, $args)
    {
        // Obtiene el valor del parámetro rol de la ruta.
        $rol = $request->getQueryParams()['rol'] ?? '';;
        
        // Obtiene la lista de todos los usuarios de la base de datos.
        $lista = Empleado::obtenerTodos($rol);
        
        // Convierte la lista de usuarios a formato JSON.
        $payload = json_encode(array("empleados" => $lista));

        // Establece el contenido de la respuesta en formato JSON.
        $response->getBody()->write($payload);

        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * Modifica un usuario en la base de datos por su nombre de usuario.
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
        $salario = isset($parametros['salario']) ? $parametros['salario'] : null;
        $rol = isset($parametros['rol']) ? $parametros['rol'] : null;

        if($id !== '' && $id !== null){
          // Obtiene el Empleado de la base de datos por ID
          $empleado = Empleado::GetById($id);
          
          // Valida que sea un Usuario
          if($empleado !== null && $empleado instanceof Empleado){
            // Valida que se haya enviado el nuevo nombre
            if($nombre !== null && $nombre !== '' && 
               $salario !== null && $salario !== '' &&
               $rol !== null && $rol !== '')
            {
              // Actualiza los datos
              $empleado->nombre = $nombre;
              $empleado->salario = $salario;
              $empleado->rol = $rol;

              // Modifica el Empleado en la base de datos.
              $result = Empleado::UpdateById($empleado);
              
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
