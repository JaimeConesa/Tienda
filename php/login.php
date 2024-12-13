<?php
header("Content-Type: application/json");

// Leer los datos enviados en el cuerpo del POST
$data = json_decode(file_get_contents("php://input"), true);

// Leer los usuarios desde el archivo JSON
$usuarios = json_decode(file_get_contents("usuarios.json"), true);

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

        // Devolver el token como respuesta
        echo json_encode(["token" => $token]);
        exit;
    }
}

// Si no se encuentran las credenciales correctas, devolver un error 401 pepe
if (!$usuarioValido) {
    http_response_code(401);
    echo json_encode(["error" => "Credenciales inválidas"]);
}
?>