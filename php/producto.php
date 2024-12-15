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
    public $stock;
    public $variaciones = [];

    public function __construct($nombre, $precio, $stock, $variaciones = []) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->variaciones = $variaciones;
    }
}

// Clase para las categorías de productos
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
        ["Gundam RX-78-2", 25.99, 10, ["Edición limitada", "Color especial"]],
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

// Convertir el objeto de la tienda a JSON y mostrarlo
header('Content-Type: application/json');
echo json_encode($tienda, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
