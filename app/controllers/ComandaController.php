<?php

use Psr7Middlewares\Middleware\Payload;

require_once './models/Comanda.php';
require_once './models/Servicio.php';
require_once './models/Detalle.php';
require_once './interfaces/IApiUsable.php';

class ComandaController extends Comanda implements IApiUsable
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
        $id_servicio = isset($parametros['id_servicio']) ? $parametros['id_servicio'] : null;
        $comidas = isset($parametros['comidas']) ? $parametros['comidas'] : null;
        $bebidas = isset($parametros['bebidas']) ? $parametros['bebidas'] : null;

        // Valida los parametros
        if($id_servicio !== '' && $id_servicio !== null)
        {            
            // Obtiene el Cliente por ID
            $servicio = new Servicio();
            $servicio = $servicio->GetById($id_servicio);

            // Comprueba que sea un Servicio valido
            if($servicio instanceof Servicio){
                // Verifica si se envio algun producto
                if(count($bebidas) > 0 || count($comidas) > 0){
                    // Se crea una comanda
                    $comanda = new Comanda();
                    $comanda->id_servicio = $servicio->id;
                    $id_comanda = $comanda->PostNew();

                    // Comprueba que el resultado sea un entero
                    if(ctype_digit($id_comanda))
                    {
                        $error_bebidas = false;
                        $error_comidas = false;
                        if(count($bebidas) > 0){
                            // Recorre el array de bebidas
                            foreach ($bebidas as $bebida) {
                                if(isset($bebida["id"])){
                                    // Carga un detalle con el id de la bebida y el id de la comanda
                                    $detalle_bebida = new Detalle();
                                    $detalle_bebida->id_comanda = $id_comanda;
                                    $detalle_bebida->id_bebida = $bebida["id"];
                                    $result = $detalle_bebida->PostNew();

                                    // valida que el resultado NO sea un entero
                                    if(!ctype_digit($result)){
                                        $response->getBody()->write($result);
                                        $error_bebidas = true;
                                    }
                                }
                            }
                        }
                        if(count($comidas) > 0){
                            foreach ($comidas as $comida) {
                                if(isset($comida["id"])){
                                    // Carga un detalle con el id de la comida y el id de la comanda
                                    $detalle = new Detalle();
                                    $detalle->id_comanda = $id_comanda;
                                    $detalle->id_comida = $comida["id"];
                                    $result = $detalle->PostNew();

                                    // valida que el resultado NO sea un entero
                                    if(!ctype_digit($result)){
                                        $response->getBody()->write($result);
                                        $error_comidas = true;
                                    }
                                }
                            }
                        }

                        if(!$error_comidas && !$error_bebidas){
                            // Crea un mensaje de éxito en formato JSON.
                            $payload = json_encode(array("mensaje" => "Comanda creada con exito", "id" => "{$id_comanda}"));

                            // Establece el contenido de la respuesta en formato JSON.
                            $response->getBody()->write($payload);
                        }
                    }
                    else{
                        $response->getBody()->write($id_comanda);
                    }
                }
                else{
                    // Crea un mensaje de error en formato JSON.
                    $payload = json_encode(array("error" => "Falta enviar productos"));

                    // Establece el contenido de la respuesta en formato JSON.
                    $response->getBody()->write($payload);
                }
                // if($mesa instanceof Mesa){
                //     if($mesa->estado === 'disponible'){
                //         // Crea un nuevo objeto Servicio
                //         $servicio = new Servicio();
                //         $servicio->id_cliente = $id_cliente; 
                //         $servicio->id_mesa = $id_mesa; 

                //         // Crea el Servicio en la base de datos.
                //         $result = $servicio->PostNew();

                //         // Comprueba que el resultado sea un entero
                //         if(ctype_digit($result))
                //         {
                //             // Crea un mensaje de éxito en formato JSON.
                //             $payload = json_encode(array("mensaje" => "Servicio creado con exito", "id" => "{$result}"));

                //             // Establece el contenido de la respuesta en formato JSON.
                //             $response->getBody()->write($payload);
                //         }
                //         else{
                //             $response->getBody()->write($result);
                //         }
                //     }
                //     else{
                //         $payload = json_encode(array("error" => "Mesa con ID {$id_mesa} no disponible"));;
                //         $response->getBody()->write($payload);
                //     }
                // }
                // else {                
                //     // Establece el contenido de la respuesta en formato JSON.
                //     $payload = $mesa;
                //     $response->getBody()->write($payload);
                // }
            }
            else {                
                // Establece el contenido de la respuesta en formato JSON.
                $payload = $servicio;
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
        $params = $request->getQueryParams();
        $estado = isset($params['estado']) ? $params['estado'] : null;

        // Obtiene la lista de todos las Comandas de la base de datos.
        $comandas = Comanda::GetAll($estado);
        $payload = '';

        if(is_array($comandas) && is_a($comandas[0], 'Comanda')){
            // Convierte la lista de usuarios a formato JSON.
            $payload = json_encode(array("comandas" => $comandas));
        }
        else {
            $payload = $comandas;
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