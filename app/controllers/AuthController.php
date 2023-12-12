<?php
require_once './interfaces/IApiUsable.php';
require_once './utils/AutentificadorJWT.php';
require_once './models/Cliente.php';
require_once './models/Empleado.php';

class AuthController
{
    public function IngresarCliente($request, $response, $args)
    {
        // Obtiene los parámetros de la solicitud.
        $parametros = $request->getParsedBody();

        // Obtiene los valores de los parámetros usuario y clave.
        $email = isset($parametros['email']) ? $parametros['email'] : null;
        $contrasena = isset($parametros['contrasena']) ? $parametros['contrasena'] : null;

        if($email !== '' && $email !== null &&
            $contrasena !== '' && $contrasena !== null)
        {            
            // Crea un nuevo objeto Cliente.
            $cliente = Cliente::GetByCredentials($email, $contrasena);

            if($cliente instanceof Cliente){
                $datos = array(
                    'email' => $cliente->email,
                    'tipo' => 'cliente'
                );
                $token= AutentificadorJWT::CrearToken($datos); 
                $payload = json_encode(array("mensaje" => "Usuario ingreso con exito", "token" => $token));
            }
            else $payload = $cliente;
        }
        else{
          // Crea un mensaje de éxito en formato JSON.
          $payload = json_encode(array("error" => "faltan parametros"));
        }

        
        // Establece el contenido de la respuesta en formato JSON.
        $response->getBody()->write($payload);

        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }

    public function IngresarEmpleado($request, $response, $args)
    {
        // Obtiene los parámetros de la solicitud.
        $parametros = $request->getParsedBody();

        // Obtiene los valores de los parámetros usuario y clave.
        $email = isset($parametros['email']) ? $parametros['email'] : null;
        $contrasena = isset($parametros['contrasena']) ? $parametros['contrasena'] : null;

        if($email !== '' && $email !== null &&
            $contrasena !== '' && $contrasena !== null)
        {            
            // Crea un nuevo objeto Cliente.
            $empleado = Empleado::GetByCredentials($email, $contrasena);

            if($empleado instanceof Empleado){
                $datos = array(
                    'email' => $empleado->email,
                    'tipo' => 'empleado',
                    'rol'=> $empleado->rol
                );
                $token= AutentificadorJWT::CrearToken($datos); 
                $payload = json_encode(array("mensaje" => "Usuario ingreso con exito", "token" => $token));
            }
            else $payload = $empleado;
        }
        else{
          // Crea un mensaje de éxito en formato JSON.
          $payload = json_encode(array("error" => "faltan parametros"));
        }

        
        // Establece el contenido de la respuesta en formato JSON.
        $response->getBody()->write($payload);

        // Establece el encabezado Content-Type de la respuesta.
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}

?>