<?php
header("Content-Type: application/json");

// Incluir el autoloader de Composer para cargar la librería JWT
require_once __DIR__ . '/../vendor/autoload.php'; 

use \Firebase\JWT\JWT;  // Importar la clase JWT

// Leer los datos enviados en el cuerpo del POST
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['usuario']) || !isset($data['contraseña'])) {
    http_response_code(400); // Error si faltan datos
    echo json_encode(["error" => "Parámetros incompletos"]);
    exit;
}

// Leer los usuarios desde el archivo JSON
$usuariosPath = __DIR__ . '/../json/usuarios.json'; // Ruta relativa más robusta
if (!file_exists($usuariosPath)) {
    http_response_code(500);
    echo json_encode(["error" => "El archivo de usuarios no existe"]);
    exit;
}
$usuarios = json_decode(file_get_contents($usuariosPath), true);

// Inicializar variable para verificar si se encuentran las credenciales correctas
$usuarioValido = false;

// Buscar las credenciales en el archivo JSON
foreach ($usuarios as $usuario) {
    if ($usuario['nombre'] === $data['usuario'] && $usuario['contrasena'] === $data['contraseña']) {
        // Credenciales correctas
        $usuarioValido = true;

        $token = bin2hex(random_bytes(16)); // 16 bytes * 2 caracteres hexadecimales por byte


        // Ejecutar productos.php para generar el archivo productos.json
        $productosPath = __DIR__ . '/../php/productos.php';
        include_once($productosPath);  // Esto ejecutará productos.php y generará productos.json

        // Leer los datos de productos
        $productosPathJson = __DIR__ . '/../json/productos.json'; // Ruta al archivo JSON generado
        $productos = file_exists($productosPathJson) ? json_decode(file_get_contents($productosPathJson), true) : [];

        // Devolver el token JWT y los productos como respuesta
        echo json_encode([
            "token" => $token,
            "tienda" => $productos
        ]);
        exit;
    }
}

// Si no se encuentran las credenciales correctas, devolver un error 401
if (!$usuarioValido) {
    http_response_code(401);
    echo json_encode(["error" => "Credenciales inválidas"]);
}
?>
