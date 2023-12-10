<?php

require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    /**
     * Crea un nuevo Cliente en la base de datos.
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con el mensaje de éxito.
    */
    public function CargarUno($request, $response, $args)
    {
        // // Obtiene los parámetros de la solicitud.
        // $parametros = $request->getParsedBody();

        // // Obtiene los valores de los parametros
        // $id_cliente = isset($parametros['id_cliente']) ? $parametros['id_cliente'] : null;
        
        // if( $id_cliente !== '' && $id_cliente !== null)
        // {            
        //     // Crea un nuevo objeto Cliente.
        //     $cliente = new Cliente();
        //     $cliente = $cliente->GetById($id_cliente);

        //     if($cliente instanceof Cliente){
        //         echo var_dump($cliente);
        //     }
        //     else echo $cliente;

        //     // LAMAR a Mesa GetDisponible y obtner ID de la mesa disponible
            
        //     // // Crea el usuario en la base de datos.
        //     // $result = $cliente->PostNew();

        //     // // Comprueba que el resultado sea un entero
        //     // if(ctype_digit($result))
        //     // {
        //     //     // Crea un mensaje de éxito en formato JSON.
        //     //     $payload = json_encode(array("mensaje" => "Cliente creado con exito", "id" => "{$result}"));

        //     //     // Establece el contenido de la respuesta en formato JSON.
        //     //     $response->getBody()->write($payload);
        //     // }
        //     // else{
        //     //     $response->getBody()->write($result);
        //     // }
        // }
        // else{
        //   // Crea un mensaje de éxito en formato JSON.
        //   $payload = json_encode(array("error" => "faltan parametros"));

        //   // Establece el contenido de la respuesta en formato JSON.
        //   $response->getBody()->write($payload);
        // }

        // // Establece el encabezado Content-Type de la respuesta.
        // $response->withHeader('Content-Type', 'application/json');

        // return $response;
    }

    /**
     * Obtiene un Cliente de la base de datos por ID
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con el usuario solicitado en formato JSON.
     */
    public function TraerUno($request, $response, $args)
    {
        // // Obtiene el nombre de usuario de los argumentos de la ruta.
        // $id = $args['id'];
        
        // // Obtiene el usuario de la base de datos por su nombre de usuario.
        // $cliente = Cliente::GetById($id);

        // // Convierte el usuario a formato JSON.
        // $payload = json_encode($cliente);

        // // Establece el contenido de la respuesta en formato JSON.
        // $response->getBody()->write($payload);
        
        // // Establece el encabezado Content-Type de la respuesta.
        // $response->withHeader('Content-Type', 'application/json');

        // return $response;
    }

    /**
     * Obtiene todos los Clientes de la base de datos.
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con la lista de usuarios en formato JSON.
    */
    public function TraerTodos($request, $response, $args)
    {
        $params = $request->getQueryParams();
        $comensales = isset($params['comensales']) ? $params['comensales'] : 1;
        $estado = isset($params['estado']) ? $params['estado'] : null;

        // // Obtiene la lista de Mesas Disponibles
        $mesas = Mesa::GetAll($estado, $comensales);

        if(is_array($mesas) && count($mesas) > 0 && is_a($mesas[0], 'Mesa')){
            // Convierte la lista de Mesas a formato JSON.
            $payload = json_encode(array("mesas" => $mesas));
        }
        else {
            $payload = json_encode(array("error" => "No se encontraron mesas"));
        }

        // Establece el contenido de la respuesta en formato JSON.
        $response->getBody()->write($payload);

        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * Modifica un Cliente en la base de datos por ID
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con el mensaje de éxito en formato JSON.
    */
    public function ModificarUno($request, $response, $args)
    {
        // // Obtiene el id enviado en la ruta
        // $id = isset($args['id']) ? $args['id'] : null;

        // // Obtiene los parámetros de la solicitud.
        // $parametros = $request->getParsedBody();

        // // Obtiene los parametros
        // $nombre = isset($parametros['nombre']) ? $parametros['nombre'] : null;
        // $comensales = isset($parametros['comensales']) ? $parametros['comensales'] : null;

        // if($id !== '' && $id !== null){
        //     // Obtiene el Cliente de la base de datos por ID
        //     $cliente = Cliente::GetById($id);
            
        //     // Valida que sea un Cliente
        //     if($cliente instanceof Cliente){
        //         // Valida que se hayan enviado los parametros
        //         if($nombre !== null && $nombre !== '' && 
        //            $comensales !== null && $comensales !== '')
        //         {
        //             // Actualiza los datos
        //             $cliente->nombre = $nombre;
        //             $cliente->comensales = $comensales;

        //             // Modifica el Empleado en la base de datos.
        //             $result = Cliente::UpdateById($cliente);
                
        //             if($result === true){
        //                 // Crea un mensaje de éxito en formato JSON.
        //                 $payload = json_encode(array("mensaje" => "Cliente modificado con exito"));

        //                 // Establece el contenido de la respuesta en formato JSON.
        //                 $response->getBody()->write($payload);
        //             }
        //             else{
        //                 $response->getBody()->write($result);
        //             }
        //         }
        //         else{
        //         // Crea un mensaje de eror en formato JSON.
        //         $payload = json_encode(array("error" => "faltan parametros"));

        //         // Establece el contenido de la respuesta en formato JSON.
        //         $response->getBody()->write($payload);
        //         }
        //     }
        //     else{
        //         // Crea un mensaje de eror en formato JSON.
        //         $payload = json_encode(array("error" => "No se encontro Cliente en la base de datos"));

        //         // Establece el contenido de la respuesta en formato JSON.
        //         $response->getBody()->write($payload);
        //     }
        // }
        // else{
        //   // Crea un mensaje de eror en formato JSON.
        //   $payload = json_encode(array("error" => "no se envio usuario en la ruta"));

        //   // Establece el contenido de la respuesta en formato JSON.
        //   $response->getBody()->write($payload);
        // }
        
        // // Establece el encabezado Content-Type de la respuesta.
        // $response->withHeader('Content-Type', 'application/json');

        // return $response;
    }

    /**
     * Elimina un Cliente de la base de datos por su ID.
     *
     * @param Request $request Objeto de solicitud HTTP.
     * @param Response $response Objeto de respuesta HTTP.
     * @param array $args Argumentos de la ruta.
     *
     * @return Response Objeto de respuesta HTTP con el mensaje de éxito en formato JSON.
    */
    public function BorrarUno($request, $response, $args)
    {
        // // Obtiene el id desde de la ruta.
        // $id = isset($args['id']) ? $args['id'] : null;

        // // Valida que se haya enviado un id
        // if($id !== null && $id !== ''){
        //   // Elimina el usuario de la base de datos.
        //   $result = Cliente::DeleteById($id); 
          
        //   if($result === true){
        //     // Crea un mensaje de éxito en formato JSON.
        //     $payload = json_encode(array("mensaje" => "Cliente dado de baja con exito"));

        //     // Establece el contenido de la respuesta en formato JSON.
        //     $response->getBody()->write($payload);
        //   }
        //   else{
        //     $payload = $result;
        //     $response->getBody()->write($payload);
        //   }
        // }
        // else {
        //   // Crea un mensaje de eror en formato JSON.
        //   $payload = json_encode(array("error" => "falta parametro id"));

        //   // Establece el contenido de la respuesta en formato JSON.
        //   $response->getBody()->write($payload);
        // }

        // // Establece el encabezado Content-Type de la respuesta.
        // $response->withHeader('Content-Type', 'application/json');

        // return $response;
    }
}

?>