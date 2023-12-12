<?php
require_once './models/Comanda.php';

class LogController
{
    public function DescargarComandas($request, $response, $args)
    {
        try{
            $comandas = new Comanda();
            $comandas = $comandas->GetAll('');

            $stream = fopen('php://temp', 'w+');
            foreach ($comandas as $comanda) {
                fputcsv($stream, [
                    $comanda->id,
                    $comanda->id_servicio,
                    $comanda->date_start,
                    $comanda->date_end
                ]);
            }
            $response = $response->withHeader('Content-Type', 'text/csv');
            $response = $response->withHeader('Content-Disposition', 'attachment; filename="comandas.csv"');
            $response = $response->withBody(new \Slim\Psr7\Stream($stream));
            return $response;
        }
        catch (Exception $ex) {
            $payload = json_encode(array("error" => $ex->getMessage()));
        }
    }
}

?>