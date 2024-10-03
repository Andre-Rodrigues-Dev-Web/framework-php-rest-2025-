<?php

$url = 'http://localhost/www/framework-php-rest-2025-/framework-velance/public_html/api';

// Captura a classe e o parâmetro da URL
$class = isset($_GET['class']) ? '/' . $_GET['class'] : '/user';
$param = isset($_GET['param']) ? '/' . $_GET['param'] : '';

// Verifica a classe usando match
$class = match (true) {
    $class === '/login' => '/login',
    preg_match('/^\/projetos(\/\d+)?$/', $class) => '/projetos',
    preg_match('/^\/videoaulas(\/\d+)?$/', $class) => '/videoaulas', // Adiciona o match para videoaulas
    default => '/user',
};

$response = file_get_contents($url . $class . $param);
