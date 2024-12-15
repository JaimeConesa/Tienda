<?php
header("Content-Type: application/json");

// Obtener la URI solicitada
$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Enrutamiento básico
if ($requestUri === '/js/dashboard.js' && $method === 'GET') { 
    include 'productos.php'; // Ruta relativa
} elseif ($requestUri === '/js/login.js' && $method === 'POST') {
    if (file_exists('login.php')) {
        include 'login.php';
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Archivo no encontrado"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Recurso no encontrado"]);
}
?>
