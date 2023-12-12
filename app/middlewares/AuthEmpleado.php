<?php

require_once './utils/AutentificadorJWT.php';
use Slim\Psr7\Response;


class AuthEmpleado
{
    public function __invoke($request, $handler)
    {
        // Obtiene el token del encabezado
        $token = $request->getHeader('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $token = isset($token[0]) ? $token[0] : null;

        try {
            if($token !== null){
                $verificacion = AutentificadorJWT::VerificarToken($token);

                if(isset($verificacion->data->tipo) && $verificacion->data->tipo !== 'empleado'){
                    throw new Exception("Acceso no autorizado");
                }
            }
            else throw new Exception("No se envio token");
            
        } catch (Exception $ex) {

            $response = new Response();
            $payload = json_encode(array("error" => $ex->getMessage()));
            $response->getBody()->write($payload);
            return $response->withStatus(403);
        }

        return $handler->handle($request);
    }
}

?>