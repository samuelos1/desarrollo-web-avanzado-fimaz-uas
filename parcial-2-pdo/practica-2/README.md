# Práctica 2 – Parcial 2
## Objetivo
Implementación de operaciones CRUD con PDO.
## Tecnologías utilizadas
- PHP 8+
- MySQL
- PDO
## Instrucciones de ejecución
Configurar base de datos y ejecutar en servidor local.
## Evidencia de funcionamiento
Descripción o capturas.
Este proyecto consiste en un sistema CRUD de productos que permite registrar, listar, editar, buscar y eliminar información de manera eficiente. Está desarrollado en PHP utilizando el paradigma de Programación Orientada a Objetos (POO) y establece la conexión con una base de datos MySQL mediante PDO.

Estructura del proyecto

config/Database.php
Se encarga de gestionar la conexión a la base de datos utilizando PDO.

models/Producto.php
Define la entidad Producto (atributos como id, nombre, precio, etc.) y contiene sus métodos.

controllers/ProductoController.php
Implementa la lógica de negocio para realizar las operaciones CRUD: crear, leer, actualizar y eliminar registros.

index.php
Actúa como la interfaz principal del sistema, incluyendo el formulario de captura y la visualización de la tabla de productos.
