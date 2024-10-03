<?php

header('Content-Type: application/json');

require_once '../vendor/autoload.php';

try {
    if (isset($_GET['url'])) {
        $url = explode('/', $_GET['url']);

        if ($url[0] === 'api') {
            array_shift($url); 

            $service = 'App\Services\\' . ucfirst($url[0]) . 'Service';
            array_shift($url);

            if (!class_exists($service)) {
                throw new \Exception("Serviço não encontrado.");
            }

            $method = strtolower($_SERVER['REQUEST_METHOD']);

            if (!method_exists($service, $method)) {
                throw new \Exception("Método não suportado.");
            }

            if ($method === 'post') {
                $input = json_decode(file_get_contents("php://input"), true);
                if (!$input) {
                    throw new \Exception("Nenhum dado foi enviado no corpo da requisição.");
                }
                $response = (new $service)->post($input);
            } elseif ($method === 'get') {
                if (!empty($url)) {
                    $response = (new $service)->get($url[0]);
                } else {
                    $response = (new $service)->getAll();
                }
            } elseif ($method === 'delete') {
                if (!empty($url)) {
                    $response = (new $service)->delete($url[0]);
                } else {
                    throw new \Exception("ID para deletar não fornecido.");
                }
            } else {
                throw new \Exception("Método não suportado.");
            }

            http_response_code(200);
            echo json_encode($response);
            exit;
        }
    }

    throw new \Exception("Recurso não encontrado.");

} catch (\Throwable $e) {
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
