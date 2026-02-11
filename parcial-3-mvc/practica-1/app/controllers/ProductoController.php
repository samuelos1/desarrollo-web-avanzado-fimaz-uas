<?php
require_once '../models/Producto.php';

class ProductoController {
    public function index() {
        $modelo = new Producto();
        $productos = $modelo->obtenerProductos();
        require '../views/productos.php';
    }
}
