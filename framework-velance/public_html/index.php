<?php

header('Content-Type: application/json');

require_once '../vendor/autoload.php';

try {
    // Verifica se a URL foi passada na requisição
    if (isset($_GET['url'])) {
        // Divide a URL em segmentos
        $url = explode('/', $_GET['url']);

        // Verifica se a chamada é para a API
        if ($url[0] === 'api') {
            array_shift($url); // Remove o "api" da URL

            // Pega o nome do serviço (ex: LoginService)
            $service = 'App\Services\\' . ucfirst($url[0]) . 'Service';
            array_shift($url);

            // Verifica se a classe do serviço existe
            if (!class_exists($service)) {
                throw new \Exception("Serviço não encontrado.");
            }

            // Pega o método HTTP (ex: post, get, etc.)
            $method = strtolower($_SERVER['REQUEST_METHOD']);

            // Verifica se o método existe no serviço
            if (!method_exists($service, $method)) {
                throw new \Exception("Método não suportado.");
            }

            // Para o método POST, captura os dados enviados no corpo da requisição
            if ($method === 'post') {
                $input = json_decode(file_get_contents("php://input"), true);
                if (!$input) {
                    throw new \Exception("Nenhum dado foi enviado no corpo da requisição.");
                }
                $response = (new $service)->post($input); // Passa os dados para o método post
            } else {
                // Para outros métodos (como GET), utiliza os parâmetros da URL
                $response = (new $service)->$method(...$url);
            }

            // Configura o código de resposta HTTP como 200 (sucesso)
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'data' => json_decode($response, true)
            ]);
            exit;
        }
    }

    // Se a URL não for passada ou não for para a API, retorna um erro
    throw new \Exception("Recurso não encontrado.");

} catch (\Throwable $e) {
    // Em caso de erro, retorna uma resposta com status 404 ou outro apropriado
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
