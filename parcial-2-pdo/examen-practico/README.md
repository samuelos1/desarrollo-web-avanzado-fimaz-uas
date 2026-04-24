CRUD de Productos con PHP (PDO) y POOEste proyecto consiste en una aplicación web dinámica para la gestión de productos, desarrollada bajo el paradigma de Programación Orientada a Objetos (POO) y utilizando PHP Data Objects (PDO) para una conexión segura a bases de datos MySQL.📋 DescripciónEl sistema permite realizar las operaciones básicas de un CRUD (Crear, Leer, Actualizar y Eliminar) desde una interfaz única e intuitiva diseñada con HTML y Bootstrap.Características principales:Encapsulamiento: Uso de getters y setters para la manipulación de datos.Seguridad: Consultas preparadas (prepare()) para prevenir inyecciones SQL.Arquitectura Organizada: Separación de responsabilidades en modelos, controladores y configuración.📂 Estructura del ProyectoEl proyecto sigue la siguiente jerarquía de archivos:PlaintextCLASEPDO/
├── config/
│   └── Database.php           # Clase de conexión a la BD
├── controllers/
│   └── ProductoController.php   # Lógica de operaciones CRUD
├── models/
│   └── Producto.php             # Clase entidad del producto
└── index.php                    # Interfaz de usuario (Vista)
🛠️ Requisitos e Instalación1. Base de DatosCrea una base de datos llamada phppdobd y ejecuta el siguiente script SQL para crear la tabla de productos:SQLCREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    existencia INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);
2. Configuración de ConexiónAsegúrate de que los parámetros en config/Database.php coincidan con tu entorno local:Host: localhost Usuario: root Password: "" (vacío por defecto en XAMPP) 🏗️ Componentes del SistemaComponenteFunciónDatabase.phpGestiona la conexión mediante PDO y devuelve el objeto de conexión.Producto.phpDefine el objeto Producto con sus atributos (id, nombre, precio, etc.) y métodos de acceso.ProductoController.phpContiene los métodos crear(), listar(), obtenerPorId(), actualizar() y eliminar().index.phpPunto de interacción que integra el formulario de captura y la tabla de registros.🚀 Uso de la AplicaciónRegistrar: Completa el formulario y presiona "Guardar".Visualizar: Los productos aparecerán automáticamente en la tabla inferior ordenados por ID descendente.Editar: Haz clic en "Editar" para cargar los datos en el formulario; el botón cambiará automáticamente a "Actualizar".Eliminar: Usa el botón "Eliminar" (incluye confirmación) para borrar un registro permanentemente

