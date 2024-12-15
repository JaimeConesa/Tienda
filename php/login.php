<?php
header("Content-Type: application/json");

// Leer los datos enviados en el cuerpo del POST
$data = json_decode(file_get_contents("php://input"), true);

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
    if ($usuario['usuario'] === $data['usuario'] && $usuario['contraseña'] === $data['contraseña']) {
        // Credenciales correctas
        $usuarioValido = true;
        
        // Crear el token simulado con datos codificados en base64
        $token = base64_encode(json_encode([
            "userId" => $usuario['usuario'],  // Usamos el nombre del usuario (puedes cambiarlo por un ID)
            "rol" => "user",  // Asignar rol, por ejemplo, 'user' o 'admin', según sea necesario
            "exp" => time() + 3600 // Expiración en 1 hora
        ]));

        // Ejecutar productos.php para generar el archivo productos.json
        $productosPath = __DIR__ . '/../php/productos.php';
        include_once($productosPath);  // Esto ejecutará productos.php y generará productos.json

        // Leer los datos de productos
        $productosPathJson = __DIR__ . '/../json/productos.json'; // Ruta al archivo JSON generado
        $productos = file_exists($productosPathJson) ? json_decode(file_get_contents($productosPathJson), true) : [];

        // Devolver el token y los productos como respuesta
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
