<?php
header("Content-Type: application/json");

// Obtener la URI solicitada
$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Enrutamiento simplificado
// Si la solicitud es a 'login.php' (y no la de un archivo js), procesamos la solicitud de inicio de sesión
if ($requestUri === '/Tienda/php/login.php' && $method === 'POST') {
    include 'login.php'; // Procesar el login en el archivo login.php
} else {
    http_response_code(404);  // Si la ruta no corresponde, devolvemos error 404
    echo json_encode(["error" => "Recurso no encontrado"]);
}
?>
