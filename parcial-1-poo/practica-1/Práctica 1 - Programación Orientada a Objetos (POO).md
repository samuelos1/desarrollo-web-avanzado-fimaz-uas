Práctica 1 - Programación Orientada a Objetos (POO)

Objetivo de la práctica
El objetivo de esta práctica es aplicar los conceptos básicos de Programación Orientada a Objetos en PHP, mediante la creación de una clase `Usuario`, sus atributos y métodos, y la posterior prueba de su funcionamiento.
Descripción de la clase creada
Se creó la clase `Usuario` con los siguientes elementos:

- **Atributos privados**:
  - `nombre`
  - `correo`

- **Métodos públicos**:
  - Constructor para inicializar los atributos.
  - `getNombre()` y `getCorreo()` para obtener los valores de los atributos.
  - `setNombre($nombre)` y `setCorreo($correo)` para modificar los valores de los atributos.

---
Instrucciones de ejecución

1. Incluir el archivo `Usuario.php` en el script principal `index.php`:

```php
require_once 'Usuario.php';
