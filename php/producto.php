<?php

// Clase para las variaciones de los productos (pueden ser colores, ediciones especiales, etc.)
class Variacion {
    public $descripcion;

    public function __construct($descripcion) {
        $this->descripcion = $descripcion;
    }
}

// Clase para los productos
class Producto {
    public $nombre;
    public $precio;
    public $img;
    public $stock;
    public $variaciones = [];

    public function __construct($nombre, $precio, $img, $stock, $variaciones = []) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->img = $img;
        $this->stock = $stock;
        $this->variaciones = $variaciones;
    }
}


class Categoria {
    public $nombre;
    public $productos = [];

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function agregarProducto(Producto $producto) {
        $this->productos[] = $producto;
    }
}

// Clase para la tienda
class Tienda {
    public $nombre;
    public $categorias = [];

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function agregarCategoria(Categoria $categoria) {
        $this->categorias[] = $categoria;
    }
}

// Crear la tienda
$tienda = new Tienda("Tienda de Modelos Gundam");

// Crear las categorías y productos
$categoriasYProductos = [
    "HG" => [
        ["Gundam RX-78-2", 25.99, "https://www.mechauniverse.es/productos/imagenes/img_2193_d5b1bd7d44286d4f61af793c9ec56c76_20.jpg", 10, ["Edición limitada", "Color especial"]],
        ["Gundam Barbatos Lupus", 22.50, 15, ["Armas adicionales"]],
    ],
    "MG" => [
        ["Gundam RX-78-2 Master Grade", 55.99, 8, ["Edición coleccionista"]],
        ["Gundam Unicorn MG", 60.00, 5, ["Edición blanca"]],
    ],
    "RG" => [
        ["Gundam Astray Red Frame", 35.00, 12, ["Color alternativo"]],
        ["Gundam Wing Zero Custom", 38.50, 20, ["Piezas extras"]],
    ],
];

// Agregar los productos y categorías a la tienda
foreach ($categoriasYProductos as $categoriaNombre => $productos) {
    $categoria = new Categoria($categoriaNombre);
    foreach ($productos as $producto) {
        // Crear variaciones directamente
        $variaciones = [];
        foreach ($producto[3] as $descripcion) {
            $variaciones[] = new Variacion($descripcion);
        }

        // Crear el producto y agregarlo a la categoría
        $categoria->agregarProducto(new Producto($producto[0], $producto[1], $producto[2], $variaciones));
    }
    $tienda->agregarCategoria($categoria);
}

// Ruta del archivo productos.json
$productosPathJson = __DIR__ . '/../json/productos.json';

// Verificar si el archivo existe
if (file_exists($productosPathJson)) {
    // Si el archivo existe, leer su contenido
    $productosExistentes = json_decode(file_get_contents($productosPathJson), true);

    // Aquí podrías actualizar los productos si es necesario
    // Por ejemplo, podrías agregar productos nuevos sin eliminar los existentes
    // Para este ejemplo, simplemente sobrescribimos todo, pero puedes ajustarlo según lo que necesites

} else {
    // Si no existe, creamos un arreglo vacío para inicializarlo
    $productosExistentes = [];
}

// Agregar los productos de la tienda al archivo JSON
$productosExistentes = $tienda; // Usamos el objeto tienda como datos a guardar

// Guardar los productos actualizados en el archivo productos.json
file_put_contents($productosPathJson, json_encode($productosExistentes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Devolver los datos de la tienda en formato JSON
header('Content-Type: application/json');
echo json_encode($tienda, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
