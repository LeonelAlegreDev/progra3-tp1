<?php

use Psr7Middlewares\Middleware\Payload;

require_once './models/Servicio.php';
require_once './models/Cliente.php';
require_once './interfaces/IApiUsable.php';

class ServicioController extends Servicio implements IApiUsable
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
        // Obtiene los parámetros de la solicitud.
        $parametros = $request->getParsedBody();

        // Obtiene los valores de los parametros
        $id_cliente = isset($parametros['id_cliente']) ? $parametros['id_cliente'] : null;
        $id_mesa = isset($parametros['id_mesa']) ? $parametros['id_mesa'] : null;

        // Valida los parametros
        if($id_cliente !== '' && $id_cliente !== null && $id_mesa !== '' && $id_mesa !== null)
        {            
            // Obtiene el Cliente por ID
            $cliente = new Cliente();
            $cliente = $cliente->GetById($id_cliente);

            // Obtiene las Mesas disponibles
            $mesa = new Mesa();
            $mesa = $mesa->GetById($id_mesa);

            // Comprueba que sea un valido
            if($cliente instanceof Cliente){
                if($mesa instanceof Mesa){
                    if($mesa->estado === 'disponible'){
                        // Crea un nuevo objeto Servicio
                        $servicio = new Servicio();
                        $servicio->id_cliente = $id_cliente; 
                        $servicio->id_mesa = $id_mesa; 

                        // Crea el Servicio en la base de datos.
                        $result = $servicio->PostNew();

                        // Comprueba que el resultado sea un entero
                        if(ctype_digit($result))
                        {
                            // Crea un mensaje de éxito en formato JSON.
                            $payload = json_encode(array("mensaje" => "Servicio creado con exito", "id" => "{$result}"));

                            // Establece el contenido de la respuesta en formato JSON.
                            $response->getBody()->write($payload);
                        }
                        else{
                            $response->getBody()->write($result);
                        }
                    }
                    else{
                        $payload = json_encode(array("error" => "Mesa con ID {$id_mesa} no disponible"));;
                        $response->getBody()->write($payload);
                    }
                }
                else {                
                    // Establece el contenido de la respuesta en formato JSON.
                    $payload = $mesa;
                    $response->getBody()->write($payload);
                }
            }
            else {                
                // Establece el contenido de la respuesta en formato JSON.
                $payload = $cliente;
                $response->getBody()->write($payload);
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
        // // Obtiene la lista de todos los usuarios de la base de datos.
        // $clientes = Cliente::GetAll();
        // $payload = '';

        // if(is_array($clientes) && is_a($clientes[0], 'Cliente')){
        //     // Convierte la lista de usuarios a formato JSON.
        //     $payload = json_encode(array("clientes" => $clientes));
        // }
        // else {
        //     $payload = $clientes;
        // }
        
        // // Establece el contenido de la respuesta en formato JSON.
        // $response->getBody()->write($payload);

        // // Establece el encabezado Content-Type de la respuesta.
        // $response->withHeader('Content-Type', 'application/json');
        
        // return $response;
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