# 🐄 GanadoControl

Sistema web desarrollado en PHP utilizando el patrón de arquitectura MVC (Modelo - Vista - Controlador) para la administración y control de ganado.

Este proyecto permite registrar, visualizar, actualizar y eliminar información de animales dentro de una base de datos MySQL.

---

# 📌 Características

* Registro de animales.
* Visualización de registros.
* Actualización de información.
* Eliminación de registros.
* Arquitectura MVC.
* Conexión a base de datos MySQL.
* Interfaz administrativa sencilla.

---

# 🛠️ Tecnologías utilizadas

* PHP
* MySQL
* HTML5
* CSS3
* Arquitectura MVC
* XAMPP / Apache

---

# 📂 Estructura del proyecto

```bash
GanadoControl/
│
├── config/
│   └── DataBase.php
│
├── controllers/
│   └── animalController.php
│
├── models/
│   └── animalModel.php
│
├── views/
│   ├── admin/
│   │   ├── admin.php
│   │   ├── frmAnimal.php
│   │   ├── animalInsert.php
│   │   ├── animalUpdate.php
│   │   ├── updateAnimal.php
│   │   ├── deleteAnimal.php
│   │   ├── readAllAnimales.php
│   │   └── readOneAnimal.php
│   │
│   └── FontAwesome.html
│
├── ganadero.sql
├── index.php
│
└── README.md
```

---

# ⚙️ Instalación

## 1. Clonar el repositorio

```bash
git clone https://github.com/usuario/GanadoControl.git
```

---

## 2. Mover el proyecto a htdocs

Copiar la carpeta del proyecto dentro de:

```bash
C:\xampp\htdocs\
```

---

## 3. Crear la base de datos

1. Abrir phpMyAdmin.
2. Crear una base de datos llamada:

```sql
ganadero
```

3. Importar el archivo:

```bash
ganadero.sql
```

---

## 4. Configurar conexión

Verificar los datos de conexión en:

```bash
config/DataBase.php
```

Ejemplo:

```php
private $host = "localhost";
private $db_name = "ganadero";
private $username = "root";
private $password = "";
```

---

## 5. Ejecutar el proyecto

Abrir en el navegador:

```bash
http://localhost/GanadoControl/
```

---

# 📖 Funcionamiento

El sistema trabaja bajo el patrón MVC:

* **Modelo:** Gestiona las consultas y conexión con la base de datos.
* **Vista:** Muestra la interfaz gráfica al usuario.
* **Controlador:** Procesa las solicitudes y conecta vistas con modelos.

---

# 🐮 Módulo de animales

El sistema permite administrar información relacionada con:

* Identificador del animal.
* Nombre.
* Tipo o categoría.
* Registro de información.
* Edición de datos.
* Eliminación de registros.

---

# 🚀 Posibles mejoras

* Sistema de inicio de sesión.
* Gestión de usuarios.
* Reportes PDF.
* Dashboard administrativo.
* Registro de vacunas.
* Control de alimentación.
* Historial médico del ganado.
* Diseño responsive.

---

# 👨‍💻 Autor

Proyecto desarrollado con PHP y MVC para fines educativos y de gestión ganadera.

---

# 📄 Licencia

Este proyecto puede utilizarse con fines académicos y de aprendizaje.

Descripción o capturas.
