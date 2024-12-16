<?php
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

// Leer los datos del cuerpo si es POST
$data = json_decode(file_get_contents("php://input"), true);

if ($method === 'POST') {
    if (isset($data['action']) && $data['action'] === 'login') {
        include 'login.php'; // Procesar login
    } else {
        http_response_code(400); // Error de cliente
        echo json_encode(["error" => "Acción no especificada o no válida"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Método no soportado"]);
}
?>
