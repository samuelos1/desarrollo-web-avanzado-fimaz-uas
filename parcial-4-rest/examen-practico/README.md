# Examen Práctico – Parcial 4
## Objetivo
Resolución del examen práctico con API REST.
## Tecnologías utilizadas
- PHP 8+
- REST
- JSON
## Instrucciones de ejecución
Probar con Postman.
## Evidencia de funcionamiento
Descripción o capturas.
# 🛒 API REST — Gestión de Productos

**Alumno** Samuel Osuna Tirado
**Materia:** Desarrollo Web Avanzado  
**Tecnologías:** PHP · MySQL · PDO · Apache

---

## ¿Qué hace esta API?

Permite gestionar un catálogo de productos a través de peticiones HTTP estándar. Cada producto cuenta con nombre, descripción, precio de compra, precio de venta y existencia en inventario.

---

## Organización del proyecto

```
RESTful/
│
├── api/
│   ├── .htaccess       → Redirige todas las rutas hacia index.php
│   └── index.php       → Punto de entrada: detecta método HTTP y ejecuta la acción
│
├── clases/
│   └── Productos.php   → Lógica de negocio: consultas SQL con sentencias preparadas
│
├── configuracion/
│   └── Database.php    → Conexión PDO reutilizable a MySQL
│
└── productos.sql       → Script para crear la base de datos y datos de prueba
```

---

## Cómo correrlo localmente

**Requisitos:** XAMPP (o cualquier servidor con Apache + MySQL + PHP 7.4+)

```bash
# 1. Copiar la carpeta RESTful/ dentro de htdocs/
# 2. Importar productos.sql en phpMyAdmin
# 3. Iniciar Apache y MySQL desde el panel de XAMPP
# 4. Probar en Postman o navegador
```

Si tu MySQL tiene contraseña, editar `configuracion/Database.php`:
```php
private $password = "tu_contraseña";
```

---

## Endpoints disponibles

| Método   | Endpoint                      | Descripción              | Estado      |
|----------|-------------------------------|--------------------------|-------------|
| `GET`    | `/RESTful/api/productos`      | Listar todos             | ✅ Listo    |
| `GET`    | `/RESTful/api/productos/{id}` | Obtener uno por ID       | ✅ Listo    |
| `POST`   | `/RESTful/api/productos`      | Crear nuevo producto     | 🔧 Trabajo final |
| `PUT`    | `/RESTful/api/productos/{id}` | Actualizar producto      | 🔧 Trabajo final |
| `DELETE` | `/RESTful/api/productos/{id}` | Eliminar producto        | 🔧 Trabajo final |

---

## Ejemplo de respuesta — GET /productos

```json
[
  {
    "idProducto": 1,
    "nombreproducto": "Harley-Davidson Sportster S 1250",
    "descripcion": "Motocicleta deportiva con motor Revolution Max 1250T.",
    "precioCompra": "255000.00",
    "precioVenta": "295000.00",
    "existencia": "5"
  },
  {
    "idProducto": 2,
    "nombreproducto": "Harley-Davidson Road King 1450cc",
    "descripcion": "Motocicleta Harley-Davidson modelo Electra Glide, motor Twin Cam.",
    "precioCompra": "280000.00",
    "precioVenta": "325000.00",
    "existencia": "3"
  }
]
```

---

## Validaciones del lado del servidor

- Nombre del producto requerido
- Precios y existencia no pueden ser negativos
- El precio de venta debe ser mayor o igual al de compra
- Todas las entradas se sanitizan antes de guardarse en BD

---

## Códigos HTTP que maneja la API

| Código | Situación |
|--------|-----------|
| `200`  | Petición exitosa |
| `201`  | Recurso creado correctamente |
| `400`  | Datos inválidos o incompletos |
| `404`  | Producto o ruta no encontrada |
| `405`  | Método HTTP no permitido |
| `500`  | Error interno del servidor |

---

## Flujo de una petición

```
Cliente (Postman / Frontend)
        ↓
   .htaccess  →  redirige a index.php
        ↓
   index.php  →  detecta método + segmentos de URL
        ↓
  Productos.php  →  ejecuta la consulta SQL
        ↓
   Base de datos  →  devuelve datos
        ↓
   Respuesta JSON al cliente
```
