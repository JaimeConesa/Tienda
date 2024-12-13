<?php
header("Content-Type: application/json");

// Obtener la URI solicitada

$requestUri = $_SERVER['REQUEST_URI'];

$method = $_SERVER['REQUEST_METHOD'];

// Enrutamiento básico

if ($requestUri === '/js/dashboard.js' && $method === 'GET') { 

    include '/php/productos.php';

} elseif ($requestUri === '/js/login.js' && $method === 'POST') {

    include '/php/login.php';

    http_response_code(404);

    }else{

        echo json_encode(["error" => "Recurso no encontrado"]);

    }
