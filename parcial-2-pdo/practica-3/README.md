Práctica: Manejo de Errores y Transacciones con PDO 🚀
Institución: Facultad de Informática Mazatlán (FIMAZ) - UAS
Materia: Desarrollo Web Avanzado
Profesor: Dr. José Alfonso Aguilar Calderón

📝 Descripción
Esta actividad demuestra la implementación de Transacciones SQL mediante la interfaz PDO en PHP. El objetivo principal es garantizar la integridad referencial de los datos y el manejo robusto de excepciones utilizando bloques try...catch.

El sistema realiza una operación doble:

Registra un nuevo alumno en la tabla alumnos.

Genera un registro de auditoría en la tabla logs_alumnos.

Ambas acciones están ligadas. Si una falla, la otra no se ejecuta (Rollback), asegurando que no existan datos huérfanos.

🛠️ Tecnologías Utilizadas
Backend: PHP 8.x

Base de Datos: MySQL / MariaDB

Interfaz de BD: PDO (PHP Data Objects)

Frontend: HTML5 / CSS3

🗄️ Estructura de la Base de Datos
Para que el proyecto funcione, se debe ejecutar el siguiente script en MySQL:

SQL
CREATE DATABASE escuela;
USE escuela;

CREATE TABLE alumnos (
    idAlumno INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo VARCHAR(100) UNIQUE -- Crucial para la prueba de integridad
);

CREATE TABLE logs_alumnos (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idAlumno INT,
    accion VARCHAR(50),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idAlumno) REFERENCES alumnos(idAlumno)
);
🧪 Pruebas de Verificación (Paso a Paso)
El sistema incluye un mecanismo para validar los tres estados principales de una transacción:

1. Prueba de COMMIT (Éxito)

Acción: Llenar el formulario y hacer clic en "Registrar alumno" (con el checkbox desmarcado).

Resultado: Los datos se guardan en ambas tablas. Se confirma la transacción permanentemente.

2. Prueba de ROLLBACK (Error Forzado)

Acción: Marcar la casilla "Simular error para forzar ROLLBACK".

Resultado: El código lanza una Exception manual después del primer insert. El bloque catch ejecuta $pdo->rollBack(), eliminando cualquier rastro de la operación. Las tablas permanecen sin cambios.

3. Prueba de Integridad (UNIQUE)

Acción: Intentar registrar dos veces el mismo correo electrónico.

Resultado: PDO detecta una violación de restricción única (Integrity constraint violation). El sistema captura el error de MySQL, realiza un Rollback automático y muestra el detalle técnico en pantalla.

📁 Instalación
Clonar o descargar el archivo index.php en la carpeta htdocs/practica-transacciones/.

Iniciar Apache y MySQL desde el panel de XAMPP.

Importar el código SQL proporcionado arriba.

Acceder vía navegador a localhost/practica-transacciones/index.php.

"Los errores no se evitan, se controlan."
