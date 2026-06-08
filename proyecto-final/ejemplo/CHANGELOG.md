# Changelog

Todas las modificaciones realizadas en el proyecto Tienda MVC durante esta sesion.

## [1.0.0] - 2026-06-03

### Resumen general

Esta version introduce proteccion CSRF, bitacora de actividades, API REST, paginacion,
subida de imagenes con redimension automatica, rutas amigables via .htaccess,
validaciones de negocio, footer responsivo con sticky footer, mejora visual de
imagenes (centrado y relacion de aspecto), y documentacion completa del codigo
via DocBlocks en formato Mintlify.

---

### ARCHIVOS CREADOS

---

#### `helpers/Csrf.php` — Proteccion CSRF

Clase con metodos estaticos para generar y validar tokens CSRF.

- **`generar()`** — Inicia sesion si es necesario, genera un token de 64 caracteres
  hexadecimales via `random_bytes(32)` y lo almacena en `$_SESSION['csrf_token']`.
  Si ya existe un token, lo retorna sin regenerarlo para mantener persistencia
  entre peticiones.

- **`campo()`** — Genera el HTML `<input type="hidden" name="csrf_token" value="...">`
  listo para incluir en formularios. Llama internamente a `generar()`.

- **`validar(?string $token)`** — Compara el token recibido contra el almacenado en
  sesion usando `hash_equals()` para mitigar ataques de timing. Retorna `false` si
  cualquiera de los dos esta vacio o no coinciden.

**Flujo tipico**: El formulario renderiza `<?= Csrf::campo() ?>`, el controlador
valida con `Csrf::validar($_POST['csrf_token'] ?? '')` antes de procesar los datos.

**Lineas:** 55 (archivo completo nuevo)

---

#### `models/LogModel.php` — Modelo de bitacora (auditoria)

Gestiona el registro y consulta de la tabla `bitacora`. Cada accion del administrador
queda registrada con timestamp.

- **`registrar(int $adminId, string $adminUsername, string $accion, ?string $detalles)`**
  — Inserta un registro en la tabla `bitacora` con los datos del administrador,
  la accion realizada y detalles opcionales. Retorna `true` en exito, `false` si falla.

- **`obtenerTodos(int $page, int $perPage)`** — Devuelve registros paginados
  ordenados por fecha descendente (`ORDER BY created_at DESC`). Calcula el offset
  como `(page - 1) * perPage`. Por defecto 20 registros por pagina.

- **`contarTodos()`** — Cuenta el total de registros en la bitacora via `SELECT COUNT(*)`.

**Flujo tipico**: Un controlador instancia `LogModel`, llama a `registrar()` tras
cada accion del CRUD (crear, actualizar, eliminar, login, logout). La vista
`productos/bitacora.php` consume `obtenerTodos()` y `contarTodos()` para mostrar
el listado paginado.

**Lineas:** 92 (archivo completo nuevo)

---

#### `controllers/ApiController.php` — API REST de productos

Expone endpoints JSON para consumir productos desde frontends externos (React, Vue,
app movil, etc.).

- **`jsonResponse(mixed $data, int $status)`** — Metodo privado auxiliar. Establece
  el header `Content-Type: application/json; charset=utf-8`, asigna el codigo HTTP
  via `http_response_code()`, convierte los datos con `json_encode()` usando
  `JSON_UNESCAPED_UNICODE` (para preservar acentos y eñes), y termina con `exit`
  para no mezclar salida HTML.

- **`productos()`** — Endpoint `GET /api/productos`. Llama a
  `ProductoModel::obtenerTodos()` y retorna `{"success": true, "data": [...]}`.
  HTTP 200.

- **`productoPorId(int $id)`** — Endpoint `GET /api/productos/{id}`. Busca un
  producto por ID. Si no existe retorna `{"success": false, "error": "Producto no encontrado"}`
  con **HTTP 404**. Si existe, retorna `{"success": true, "data": {...}}` con HTTP 200.

**Flujo de enrutamiento en index.php:**
```php
// Ruta con ID: api/productos/5 → capturada por regex antes del switch
if (preg_match('#^api/productos/(\d+)$#', $route, $matches)) {
    $apiController->productoPorId((int)$matches[1]);
}
// Ruta general: api/productos → capturada por el switch
case 'api/productos':
    $apiController->productos();
    break;
```

**Lineas:** 66 (archivo completo nuevo)

---

#### `views/productos/bitacora.php` — Vista de bitacora

Tabla responsiva con columnas: ID, Administrador, Accion, Detalles, Fecha.

- Muestra paginacion Bootstrap si `$totalPages > 1`.
- Muestra mensaje "No hay registros en la bitacora" si `$logs` esta vacio.
- Enlace "Volver a productos" en la cabecera.
- Usa `BASE_URL` para todos los enlaces de paginacion.

**Lineas:** 55 (archivo completo nuevo)

---

#### `.htaccess` — Rutas amigables

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=$1 [QSA,L]
```

**Regla 1** (`RewriteCond %{REQUEST_FILENAME} !-f`): Si la ruta NO es un archivo
existente, continua.

**Regla 2** (`RewriteCond %{REQUEST_FILENAME} !-d`): Si la ruta NO es un directorio
existente, continua.

**Regla 3** (`RewriteRule`): Redirige internamente a `index.php?route=...`, pasando
la ruta como parametro `route`. `QSA` = preserva query strings existentes.

**Ejemplos de transformacion:**
```
/ejemplo/productos           → index.php?route=productos
/ejemplo/productos/edit?id=5 → index.php?route=productos/edit&id=5
/ejemplo/api/productos/5     → index.php?route=api/productos/5
/ejemplo/catalogo?buscar=abc → index.php?route=catalogo&buscar=abc
```

Archivos reales (CSS, JS, imagenes) no son redirigidos porque existen fisicamente.

**Lineas:** 3 (archivo completo nuevo)

---

#### `README.md` — Documentacion del proyecto

Incluye: requisitos, instalacion paso a paso, funcionalidades, estructura del
proyecto, y validaciones incluidas en el sistema.

**Lineas:** 93 (archivo completo nuevo)

---

#### `CHANGELOG.md` — Este archivo

Documenta cada cambio realizado: archivos creados, modificados, eliminados,
y bugs corregidos, con flujo y linea de codigo detallada.

---

### ARCHIVOS MODIFICADOS

---

#### `database.sql` — Esquema de base de datos

**Agregado:**
- Columna `imagen VARCHAR(255) DEFAULT NULL` en tabla `productos` — almacena el
  nombre del archivo de imagen subido.
- Restriccion `UNIQUE KEY sku (sku)` en `productos` — impide SKUs duplicados
  a nivel de base de datos.
- Tabla `bitacora` con columnas:
  - `id INT AUTO_INCREMENT PRIMARY KEY`
  - `admin_id INT NOT NULL` — ID del administrador que realizo la accion
  - `admin_username VARCHAR(50) NOT NULL` — username del administrador
  - `accion VARCHAR(100) NOT NULL` — nombre de la accion (ej. "Crear producto")
  - `detalles TEXT DEFAULT NULL` — detalles adicionales opcionales
  - `created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP` — fecha/hora automatica
- `AUTO_INCREMENT` y `UNIQUE KEY username` en `usuarios` — antes no tenia PK ni UNIQUE.

**Flujo**: Al importar `database.sql` se crean las 3 tablas con las restricciones
necesarias. La tabla `bitacora` no tiene FK para mantener simplicidad de despliegue.

---

#### `config/Database.php` — Conexion PDO

**Corregido — Bug critico en DSN:**
```
Antes:  "mysql:host=($this->host);dbname=($this->dbName);charset=($this->charset)"
Despues:"mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}"
```
Los parentesis `()` literales en el string causaban que PDO interpretara literalmente
`(localhost)` como host, produciendo error de conexion. Las llaves `{}` realizan
interpolacion correcta de las propiedades de la clase.

**Agregado:** DocBlocks completos:
- Clase `Database`: `@package Config`, `@author Tienda MVC`, `@version 1.0.0`
- 5 propiedades: cada una con `@var string` y descripcion en linea propia
- Metodo `connect()`: `@return PDO` con descripcion del objeto retornado

---

#### `config/Autoload.php` — Autoloader de clases

**Agregado:** DocBlock completo que explica el proposito y funcionamiento del
autoloader, con `@package Config`, `@author Tienda MVC`, `@version 1.0.0`.

**Flujo**: Cuando se usa `use Controllers\ProductoController`, PHP busca la clase
y el autoloader:
1. Convierte `\` a `/` → `Controllers/ProductoController`
2. Separa por `/` y convierte la primera parte a minusculas → `controllers/ProductoController`
3. Concatena con el directorio base → `/config/../controllers/ProductoController.php`
4. Si el archivo existe, lo carga con `require_once`

---

#### `index.php` — Front Controller (punto de entrada)

**Agregado:**

- `BASE_URL` — Constante definida dinamicamente:
  ```php
  $baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
  define('BASE_URL', $baseDir . '/');
  ```
  `$_SERVER['SCRIPT_NAME']` retorna algo como `/ejemplo/index.php`. `dirname()`
  extrae `/ejemplo`. Resultado: `BASE_URL = '/ejemplo/'`. Si el proyecto se copia
  a otra carpeta, la URL base se ajusta automaticamente.

- **API REST**: Import de `Controllers\ApiController`, instancia `$apiController`,
  regex antes del switch para `api/productos/{id}` y case `api/productos`.

- **Ruta bitacora**: Case `productos/bitacora` → `$productoController->bitacora()`.

**Corregido — Bug critico: pagina en blanco en rutas POST con metodo GET:**

*Problema*: Al ingresar credenciales incorrectas, `AuthController::login()` ejecutaba
`header('Location: login')`. Esa ruta relativa era resuelta por el navegador contra
la URL actual (`/ejemplo/auth/login`), haciendo un GET a la misma ruta `auth/login`.
El case del switch solo tenia `if ($_SERVER['REQUEST_METHOD'] === 'POST') { ... }`
sin bloque `else`, por lo que no se ejecutaba nada y el HTML quedaba vacio.

*Solucion*: Se agregaron bloques `else` a los 4 casos que solo esperaban POST:

| Ruta | GET → Comportamiento |
|---|---|
| `auth/login` | `$authController->showLogin()` — muestra el formulario |
| `productos/store` | `header('Location: ' . BASE_URL . 'productos')` — redirige al listado |
| `productos/update` | Idem |
| `productos/delete` | Idem |

Las redirecciones de `store/update/delete` usan `BASE_URL` (ruta absoluta) para
evitar el mismo problema de resolucion relativa que causo el bug originalmente.

**Flujo de enrutamiento completo:**
1. `.htaccess` captura `productos/edit?id=5` → `index.php?route=productos/edit&id=5`
2. `index.php` lee `$_GET['route'] = 'productos/edit'`
3. Se define `BASE_URL`
4. Regex de API se evalua primero (no matchea en este caso)
5. Switch llega a `case 'productos/edit'` → `$productoController->edit()`
6. El controlador lee `$_GET['id']` para cargar el producto

**Lineas:** 107

---

#### `controllers/ProductoController.php` — Controlador de productos

El archivo con mas cambios de toda la sesion. Paso de 186 lineas a 483 lineas.

##### Metodos nuevos agregados

- **`redirigirSiNoCsrf()`** (linea 49-56) — Valida el token CSRF recibido contra
  el de sesion usando `Csrf::validar()`. Si es invalido, establece mensaje de
  error y redirige a `productos`. Protege `store()`, `update()`, `delete()`.

- **`registrarLog(string $accion, ?string $detalles)`** (linea 64-73) — Instancia
  `LogModel` y registra en bitacora usando los datos del admin en sesion
  (`$_SESSION['admin']['id']` y `$_SESSION['admin']['username']`). Usado tras
  cada operacion CRUD exitosa.

- **`procesarImagen(?array $file, ?string $imagenActual)`** (linea 85-124) —
  Maneja la subida de imagenes con validacion completa:
  1. Si no hay archivo o `$file['error'] !== UPLOAD_ERR_OK`, retorna la imagen
     actual (o cadena vacia). Permite crear/editar producto sin imagen.
  2. Crea `views/img/productos/` recursivamente con permisos 0775 si no existe.
  3. Valida extension contra lista blanca: `jpg, jpeg, png, gif, webp`.
  4. Valida tamano maximo: 2MB (`2 * 1024 * 1024` bytes).
  5. Si hay imagen anterior, la elimina del disco con `unlink()`.
  6. Genera nombre unico via `uniqid('img_')` + extension para evitar colisiones.
  7. Mueve el archivo temporal con `move_uploaded_file()`.
   8. Llama a `redimensionarImagen()` para escalar y convertir a cuadrado (ver abajo).
  9. Retorna el nombre del archivo, o la imagen anterior si algo falla.

- **`redimensionarImagen(string $ruta, string $extension)`** (lineas 138-208) —
  Redimensiona la imagen a maximo 800px y la convierte en cuadrada usando GD.
  El proposito es evitar que el CSS `object-fit: cover` recorte el producto
  real; al estar centrado en un cuadrado con barras de relleno, el CSS recorta
  las barras, no el producto. El metodo no retorna valor (`void`), modifica
  el archivo en disco.

  **Paso 1 — Carga y dimension**
  1. `extension_loaded('gd')` — Si GD no esta disponible, sale sin error.
  2. `getimagesize($ruta)` — Obtiene ancho y alto originales.
  3. `$escala = ($w > $max || $h > $max)` — Booleano: ¿necesita escalar?
  4. Calcula `$nw` y `$nh`: si necesita escala, aplica `$ratio = 800 / max($w, $h)`
     para que el lado mayor mida 800px. Si no, mantiene dimensiones originales.
     Ej: 4000×3000 → 800×600. Ej: 600×800 (ya <=800) → 600×800.
  5. `imagecreatetruecolor($nw, $nh)` — Lienzo GD con las dimensiones calculadas.
  6. Si PNG/GIF/WEBP: `imagealphablending + imagesavealpha` — preserva transparencia.
  7. `match → imagecreatefromjpeg/png/gif/webp` — Recurso GD desde el archivo.
  8. `imagecopyresampled()` — Remuestrea manteniendo relacion de aspecto.
  9. `imagedestroy($origen)` — Libera la fuente original.

  **Paso 2 — Conversion a cuadrado (NUEVO en esta iteracion)**
  10. `if ($nw !== $nh)` — Solo actua si no es cuadrado. Si ya es cuadrado,
      salta este bloque y guarda directamente.
  11. `$lado = max($nw, $nh)` — El lado del cuadrado sera la dimension mayor.
      Ej: 800×600 → lado=800. Ej: 400×800 → lado=800.
  12. `imagecreatetruecolor($lado, $lado)` — Lienzo cuadrado nuevo.
  13. Relleno del fondo:
      - PNG/GIF/WEBP: `imagecolorallocatealpha(0,0,0,127)` → negro 100% transparente.
        Con `imagealphablending + imagesavealpha` activados, el fondo queda invisible.
      - JPEG: `imagecolorallocate(255,255,255)` → blanco #FFFFFF. JPEG no
        soporta transparencia.
  14. `imagefill($cuadrado, 0, 0, $relleno)` — Pinta todo el cuadrado con el color.
  15. `$x = (int)(($lado - $nw) / 2)` — Offset horizontal para centrar. Ej: (800-600)/2=100.
  16. `$y = (int)(($lado - $nh) / 2)` — Offset vertical para centrar. Ej: (800-400)/2=200.
  17. `imagecopy()` — Copia la imagen redimensionada en la posicion centrada
      del cuadrado. Las areas no cubiertas quedan con el color de relleno.
  18. `imagedestroy($imagen)` + `$imagen = $cuadrado` — Reemplaza la imagen
      redimensionada por el cuadrado con relleno.

  **Paso 3 — Guardado**
  19. `match → imagejpeg/png/gif/webp` — Guarda en disco. JPEG/WEBP a 85% calidad.
  20. `imagedestroy($imagen)` — Libera el ultimo recurso.

  **Ejemplos de transformacion:**

  | Original | Tras redimension | ¿Cuadrado? | Resultado final |
  |---|---|---|---|
  | 4000×3000 (paisaje) | 800×600 | No | 800×800, barras blancas arriba/abajo, imagen centrada |
  | 1000×3000 (retrato) | 267×800 | No | 800×800, barras blancas izquierda/derecha, imagen centrada |
  | 500×500 (ya cuadrado) | 500×500 | Si | 500×500, sin cambios |
  | 300×200 (pequeño) | 300×200 | No | 300×300, barras blancas, centrado |
  | 2000×2000 (cuadrado grande) | 800×800 | Si | 800×800, sin barras |

  **Relacion con el CSS**: Las 3 clases definidas en `header.php` usan
  `object-fit: cover` con `object-position: center`. Al ser la imagen un cuadrado
  perfecto, el `cover` recorta las barras de relleno (blancas o transparentes),
  pero nunca el producto real que esta centrado. Esto resuelve el problema
  reportado donde imagenes verticales mostraban solo la franja central.

  **No interactua con**: vistas (el CSS no cambia), modelos (solo recibe ruta
  y extension), index.php. Solo es invocada por `procesarImagen()` dentro del
  mismo `ProductoController`.

##### Metodos existentes modificados

- **`store()`** (linea 221-300) — Flujo de validaciones en orden:
  1. `verificarSesion()` — Solo admin autenticado.
  2. `redirigirSiNoCsrf()` — Token CSRF valido.
  3. Campos obligatorios: los 6 campos no pueden estar vacios.
  4. Tipos numericos: `is_numeric()` en precios y existencia.
  5. No negativos en precios: `$precioCompra < 0 || $precioVenta < 0`.
  6. Existencia >= 0: `$existencia < 0`.
  7. **Validacion de negocio**: `$precioVenta >= $precioCompra` — el precio
     de venta no puede ser menor que el costo.
  8. SKU unico: `$this->productoModel->existeSku($data['sku'])`.
  9. Procesar imagen via `procesarImagen()`.
  10. Registrar en bitacora si la creacion fue exitosa.

- **`update()`** (linea 330-406) — Mismas validaciones que `store()` mas:
  - Verifica `$id > 0`.
  - Verifica que el producto exista (`$productoActual`).
  - `existeSku()` recibe `$id` como `$excludeId` para ignorar el producto actual
    y no detectar su propio SKU como duplicado.
  - `procesarImagen()` recibe `$productoActual['imagen']` como imagen previa
    para que la funcion sepa cual archivo eliminar si se sube uno nuevo.

- **`delete()`** (linea 412-443) — Se agregaron:
  - `redirigirSiNoCsrf()` — Un atacante no puede forzar eliminacion.
  - Verificacion de ID y existencia del producto.
  - Eliminacion fisica del archivo de imagen del disco con `unlink()` antes
    de borrar el registro de la BD.
  - `registrarLog()` si la eliminacion fue exitosa.

- **`index()`** (linea 193-204) — Se agrego paginacion:
  ```php
  $page = max(1, (int)($_GET['page'] ?? 1));
  $perPage = 10;
  $productos = $this->productoModel->obtenerTodos($page, $perPage);
  $total = $this->productoModel->contarTodos();
  $totalPages = max(1, (int)ceil($total / $perPage));
  ```

- **`bitacora()`** (linea 452-463) — Nuevo metodo publico. Muestra la bitacora
  paginada con `$perPage = 20`.

**DocBlocks agregados:** Clase, propiedad `$productoModel`, y los 12 metodos
(incluyendo `redimensionarImagen`).

**Lineas:** 503 (de 186 originales)

---

#### `controllers/AuthController.php` — Controlador de autenticacion

**Modificado `login()`:**

- **CSRF** (linea 21-25): Al inicio del metodo se valida `$_POST['csrf_token']`
  contra `Csrf::validar()`. Si falla, redirige al login con mensaje de error.
  Proposito: evitar que un atacante envie formularios falsos desde otro dominio.

- **Bitacora** (linea 46-52): Tras autenticar correctamente, `LogModel::registrar()`
  guarda "Inicio de sesion" con los datos del admin (`$usuario['id']`,
  `$usuario['username']`). Proposito: auditoria de accesos al sistema.

**Modificado `logout()`:**

- **Bitacora** (linea 70-77): Antes de `session_destroy()`, registra "Cierre de
  sesion" en la bitacora.

- **Verificacion de sesion** (linea 70): `if (isset($_SESSION['admin']))` evita
  errores si se llama a logout sin estar autenticado (ej. sesion expirada).

**Flujo completo de login:**
```
POST /auth/login (con csrf_token)
  → CSRF valido?
    NO → redirige a login con error
  → Campos vacios?
    SI → redirige a login con error
  → Usuario existe en BD?
    NO → redirige a login con error "Credenciales incorrectas"
  → password_verify() correcto?
    NO → redirige a login con error "Credenciales incorrectas"
  → SI:
    1. Guarda $_SESSION['admin'] = [id, username, nombre_completo]
    2. $log->registrar(...) → bitacora
    3. Redirige a productos con mensaje de bienvenida
```

**Lineas:** 104

---

#### `controllers/PublicController.php` — Controlador publico

**Modificado `catalogo()`:**

Antes cargaba todos los productos sin paginacion. Si habia 500 productos,
los 500 se cargaban en una sola pagina.

Ahora se agrego paginacion con `$perPage = 9`:
```php
$page = max(1, (int)($_GET['page'] ?? 1));
$productos = $productoModel->buscarProducto($termino, $page, $perPage);
$total = $productoModel->contarBusqueda($termino);
$totalPages = max(1, (int)ceil($total / $perPage));
```

`$perPage = 9` porque el catalogo muestra 3 columnas en desktop — se ven 3 filas.
`max(1, ...)` asegura que la pagina nunca sea menor a 1. `contarBusqueda()` retorna
el total de coincidencias para calcular `$totalPages`.

**DocBlock agregado:** Clase (`@package Controllers`, `@author`, `@version`).

**Lineas:** 31

---

#### `models/ProductoModel.php` — Modelo de productos

##### Metodos nuevos agregados

- **`contarTodos()`** — `SELECT COUNT(*) as total FROM productos`. Retorna entero.
  Usado por el controlador para calcular `totalPages` en paginacion.

- **`contarBusqueda(string $termino)`** — `SELECT COUNT(*) ... WHERE nombre LIKE
  :termino OR descripcion LIKE :termino`. Si el termino esta vacio, delega en
  `contarTodos()`. Retorna entero.

- **`existeSku(string $sku, ?int $excludeId)`** — `SELECT COUNT(*) FROM productos
  WHERE sku = :sku AND id != :id`. Verifica si un SKU ya existe en la BD.
  `$excludeId` es opcional: cuando se edita un producto, se excluye su propio ID
  para permitir mantener el mismo SKU sin que se detecte como duplicado.

##### Metodos existentes modificados

- **`obtenerTodos()`** — Agregados parametros `$page` y `$perPage`. Calcula
  `$offset` y aplica `LIMIT :limit OFFSET :offset` a la consulta SQL.

- **`buscarProducto()`** — Agregados parametros `$page` y `$perPage`. Si el
  termino de busqueda esta vacio, delega en `obtenerTodos()`. Si no, aplica
  el mismo LIMIT/OFFSET a la consulta con `LIKE`.

- **`crear()`** — Agregada la columna `imagen` al INSERT:
  `INSERT INTO productos (sku, nombre, ..., imagen) VALUES (:sku, :nombre, ..., :imagen)`

- **`actualizar()`** — Agregada la columna `imagen` al SET:
  `UPDATE productos SET sku = :sku, ..., imagen = :imagen WHERE id = :id`

**DocBlocks agregados:** Clase, propiedad `$conexion`, y los 9 metodos publicos
con `@param`/`@return`.

**Lineas:** 278

---

#### `models/UsuarioModel.php` — Modelo de usuarios

**Agregado:** DocBlocks completos:
- Clase: `@package Models`, `@author Tienda MVC`, `@version 1.0.0`
- Propiedad `$conexion`: `@var PDO` con descripcion
- Metodo `buscarPorUsername()`: `@param string $username`, `@return array|null`
  con descripcion detallada

**Lineas:** 49

---

#### `views/layouts/header.php` — Layout: cabecera

Modificaciones aplicadas al archivo que sirve de plantilla base para todas las paginas.

- **Navbar condicional** (linea 22-27): Si `$_SESSION['admin']` existe, muestra
  botones "Admin" y "Cerrar sesion". Si no, muestra "Administrador". Esto mejora
  la experiencia de usuario mostrando solo lo relevante.

- **Sticky footer** (lineas 13, 16, 32): Tres cambios coordinados:
  - `html,body{height:100%}` en el CSS — asegura que el body ocupe todo el viewport.
  - `<body class="d-flex flex-column min-vh-100">` — convierte el body en un
    contenedor flex vertical con altura minima del 100% del viewport.
  - `<div class="container mt-4 flex-grow-1">` — el contenedor de contenido se
    expande (`flex-grow: 1`) para ocupar todo el espacio disponible, empujando
    el footer al fondo de la pantalla en paginas con poco contenido.

- **CSS de imagenes** (lineas 10-12): Tres clases reutilizables:
  - `.img-thumb-admin` — Miniatura de tabla: 60×60px, `object-fit: cover` con
    `object-position: center` para recorte centrado, `display: block` + `margin: 0 auto`
    para centrar horizontalmente, `border-radius: 4px` para esquinas suaves.
  - `.img-preview-edit` — Preview en edicion: 150×150px, `object-fit: contain`
    para ver la imagen completa sin recortes, `background: #f8f9fa` como fondo
    gris para imagenes con transparencia, centrada.
  - `.img-card-catalog` — Tarjeta del catalogo: `width: 100%; height: 200px`,
    `object-fit: contain` + `object-position: center` para mostrar la imagen
    completa dentro de la tarjeta sin recortes, `background: #f8f9fa` como fondo
    gris para las barras laterales cuando la imagen no llena el ancho.

- **Bug corregido:** La alerta de error usaba `alert-success` (verde). Se cambio
  a `alert-danger` (rojo) para coherencia semantica.

- **Enlaces:** Todos usan `BASE_URL` para funcionar independientemente de la
  carpeta de instalacion.

**Lineas:** 43

---

#### `views/layouts/footer.php` — Layout: pie de pagina

**Reemplazado completamente.** Antes contenia solo:
```html
</div>
</body>
</html>
```

Ahora contiene un footer Bootstrap de 3 columnas:
- **Columna 1** (`col-md-4`): Nombre "Tienda MVC" y descripcion "POO + PDO + Namespaces + MVC".
- **Columna 2** (`col-md-4 text-md-center`): Enlaces a Catalogo y Admin con
  `list-inline` (horizontal), `text-decoration-none` (sin subrayado).
- **Columna 3** (`col-md-4 text-md-end`): Copyright con año dinamico `date('Y')`
  y texto "Todos los derechos reservados".

Diseno: `bg-dark text-light py-4 mt-5` — fondo oscuro coherente con el navbar,
padding vertical, margen superior. Responsivo: columnas apiladas en movil, en fila
en `md+`.

**Lineas:** 32

---

#### `views/auth/login.php` — Formulario de login

- Form action: `index.php?route=auth/login` → `<?= BASE_URL ?>auth/login` (ruta amigable).
- Agregado: `<?= Csrf::campo(); ?>` como primer campo del formulario. El token
  oculto viaja con el POST y es validado en `AuthController::login()`.

**Lineas:** 30

---

#### `views/productos/index.php` — Listado de productos (admin)

- **Imagenes**: Ruta `views/img/productos/` y clase `img-thumb-admin` para
  miniatura centrada de 60×60px.
- **Bitacora**: Boton "Bitacora" en la barra de herramientas.
- **CSRF**: `<?= Csrf::campo(); ?>` en el formulario de eliminacion.
- **Paginacion**: Navegacion Bootstrap condicional (`if $totalPages > 1`)
  con botones Anterior, numeros de pagina, Siguiente. Pagina activa resaltada
  con `active`. Paginas limite con `disabled`.
- **Bug corregido**: `$producto('id')` (invocaba como funcion) → `$producto['id']`
  (acceso a array).
- **Enlaces**: Todos usan `BASE_URL`.

**Lineas:** 78

---

#### `views/productos/create.php` — Formulario de creacion de producto

- Form action: `<?= BASE_URL ?>productos/store`.
- `enctype="multipart/form-data"` — requerido para subida de archivos.
- `<?= Csrf::campo(); ?>` — token CSRF.
- Campo `input type="file" name="imagen"` con `accept="image/jpeg,image/png,image/gif,image/webp"`.
- Enlaces con `BASE_URL`.

**Lineas:** 48

---

#### `views/productos/edit.php` — Formulario de edicion de producto

**Bugs corregidos:**
- Form action: `index.php?route=productos/store` → `<?= BASE_URL ?>productos/update`.
- Variables: `$productos` (plural, no definido) → `$producto` (singular, definido
  por el controlador en `edit()`).
- Faltaba `input type="hidden" name="id"` con el ID del producto — necesario para
  que `update()` sepa cual producto modificar.

**Modificado:**
- `enctype="multipart/form-data"` para subida de archivos.
- `<?= Csrf::campo(); ?>` para proteccion.
- Preview de imagen actual con clase `img-preview-edit` (150×150, `object-fit: contain`).
- Mensaje "Imagen actual. Sube una nueva para reemplazarla." debajo del preview.
- Campo file con `accept` para reemplazar la imagen.
- Enlaces con `BASE_URL`.

**Lineas:** 57

---

#### `views/public/catalogo.php` — Catalogo publico

- **Imagenes**: Clase `img-card-catalog` (`width: 100%; height: 200px; object-fit: contain;
  object-position: center; background: #f8f9fa`). Ruta `views/img/productos/`.
- **Paginacion**: Navegacion Bootstrap condicional. Los enlaces mantienen el
  termino de busqueda via `urlencode($termino)` para que al cambiar de pagina
  no se pierda el filtro.
- **Form action**: `<?= BASE_URL ?>catalogo` (ruta amigable, sin `index.php?route=`).
- **Bug visual previo**: El texto de existencia mostraba simbolo `$` y `number_format`
  incorrecto — antes era `$<?= number_format((int)$producto['existencia']); ?>` que
  formateaba 10 como `$10`. Corregido a `<?= number_format((int)$producto['existencia']); ?>`.

**Lineas:** 65

---

### ARCHIVOS ELIMINADOS

---

#### `uploads/` (directorio completo)

Movido a `views/img/productos/`. Razon: mantener las imagenes dentro de la estructura
de vistas del MVC es mas coherente con la arquitectura. Las rutas de acceso publico
se mantienen igual porque estan dentro del document root.

#### `README.txt`

Reemplazado por `README.md` con formato Markdown, estructura mejorada y contenido
actualizado que refleja todas las funcionalidades implementadas.

#### `example.htaccess`

Archivo vacio original. El `.htaccess` real contiene ahora las reglas de reescritura.

---

### BUGS CORREGIDOS

---

1. **`config/Database.php:17`** — DSN mal formado
   - `host=($this->host)` usaba parentesis literales en vez de llaves de interpolacion.
   - Causaba `PDOException: could not find driver` porque `(localhost)` no es un host valido.
   - Correccion: `host={$this->host}` (interpolacion correcta).

2. **`index.php:60`** (version original) — Error de sintaxis en switch
   - `default;` con punto y coma en vez de dos puntos. PHP interpreta `default;`
     como una sentencia vacia, no como una etiqueta de case.
   - Correccion: `default:`.

3. **`views/productos/index.php:34`** — Invocacion como funcion en vez de array
   - `<?= (int)$producto('id'); ?>` — el parentesis hace que PHP intente invocar
     `$producto` como funcion callable.
   - Correccion: `<?= (int)$producto['id']; ?>`.

4. **`views/productos/edit.php:5`** — Action apuntaba a `store` en vez de `update`
   - El formulario de edicion enviaba POST a `productos/store`. Como `store()`
     no espera un `id`, creaba un producto duplicado en vez de actualizar.
   - Correccion: `action="<?= BASE_URL ?>productos/update"`.

5. **`views/productos/edit.php`** — Variable `$productos` no definida
   - El controlador `edit()` asigna `$producto` (singular). La vista usaba
     `$productos` (plural), que no existia.
   - Correccion: todos los accesos cambiados a `$producto['campo']`.

6. **`views/layouts/header.php:29`** — Alerta de error con clase incorrecta
   - `alert-success` (verde) para mensajes de error. Semanticamente incorrecto.
   - Correccion: `alert-danger` (rojo).

7. **`views/layouts/header.php` + `footer.php`** — Estructura HTML con divs no balanceados
   - El header abria `<div class="container mt-4">`, mostraba alerts, y lo
     CERRABA con `</div>`. El footer tenia otro `</div>` extra sin apertura
     correspondiente. El contenido de las paginas quedaba FUERA del container.
   - Correccion: el container se abre en header y se cierra en footer,
     envolviendo correctamente todo el contenido de cada pagina.

8. **`index.php:44-93`** — Pagina en blanco al fallar autenticacion (y rutas POST)
   - *Sintomas*: Login con credenciales incorrectas → pagina en blanco.
   - *Diagnostico*: `header('Location: login')` (relativa) → navegador resuelve
     como `/ejemplo/auth/login` (misma URL, GET) → `case 'auth/login'` solo
     maneja POST → sin `else` → switch no ejecuta nada → HTML vacio.
   - *Solucion*: Bloques `else` en 4 rutas POST. `auth/login` GET muestra el
     formulario. `store/update/delete` GET redirigen a `productos` con `BASE_URL`.
   - *Alternativa descartada*: Cambiar redirecciones en controladores era mas invasivo.

9. **`views/public/catalogo.php:33`** — Simbolo $ incorrecto en existencia
   - Mostraba `$<?= number_format(...)` → "Existencia: $10" en vez de "Existencia: 10".
   - La existencia no es un precio, no debe llevar simbolo de moneda.
    - Correccion: removido el `$`.

10. **`views/layouts/header.php:12` — Pestañeo y recorte en imagenes del catalogo**
    - *Sintomas*: Las imagenes del catalogo mostraban un pestañeo al cargar
      (se veian completas por un instante y luego saltaban a recortadas). Ademas,
      aunque las barras de relleno del cuadrado GD protegian parcialmente el
      producto, en contenedores landscape como la tarjeta de catalogo (~350×200px)
      el `object-fit: cover` seguia recortando parte del producto porque las
      barras eran mas finas que el recorte necesario.
    - *Diagnostico*: `object-fit: cover` escala toda la imagen (producto + barras
      de relleno) para cubrir el contenedor. En un contenedor 350×200, un cuadrado
      800×800 escala a 350×350 y solo se muestran 200px de alto → recorte de 75px
      arriba y abajo. Si las barras ocupan solo 50px, los 25px restantes se
      recortan del producto. El pestañeo ocurre porque el navegador pinta la imagen
      sin CSS primero (completa) y luego aplica `object-fit` (recortada).
    - *Solucion*: Cambiar `.img-card-catalog` de `cover` a `contain`. Como GD
      ahora convierte todas las imagenes a cuadradas, `contain` escala
      uniformemente al alto de la tarjeta (200×200), mostrando el producto
      completo y dejando barras grises laterales uniformes. Agregado
      `background: #f8f9fa` como fondo de las barras laterales.
    - *Relacion con redimensionarImagen()*: El metodo GD garantiza imagenes
      cuadradas. Sin ese prerequisito, `contain` dejaba espacios irregulares
      que se veian mal. Ahora los espacios son simetricos y predecibles.
    - *Lineas*: 1 linea CSS modificada en `header.php`.

---

### DOCUMENTACION AGREGADA (DocBlocks)

Los siguientes 11 archivos PHP recibieron DocBlocks completos en español,
siguiendo el estandar PHPDoc con estilo Mintlify (descripciones concisas):

| Archivo | `@package` | Clase documentada | `@var` propiedades | Metodos con `@param`/`@return` |
|---|---|---|---|---|
| `config/Database.php` | `Config` | `Database` | 5 | `connect()` |
| `config/Autoload.php` | `Config` | _(closure)_ | — | — |
| `controllers/AuthController.php` | `Controllers` | `AuthController` | — | `showLogin()`, `login()`, `logout()` |
| `controllers/ProductoController.php` | `Controllers` | `ProductoController` | 1 (`$productoModel`) | 12 metodos |
| `controllers/PublicController.php` | `Controllers` | `PublicController` | — | `catalogo()` |
| `controllers/ApiController.php` | `Controllers` | `ApiController` | 1 (`$productoModel`) | `jsonResponse()`, `productos()`, `productoPorId()` |
| `helpers/Csrf.php` | `Helpers` | `Csrf` | — | `generar()`, `campo()`, `validar()` |
| `models/ProductoModel.php` | `Models` | `ProductoModel` | 1 (`$conexion`) | 9 metodos |
| `models/UsuarioModel.php` | `Models` | `UsuarioModel` | 1 (`$conexion`) | `buscarPorUsername()` |
| `models/LogModel.php` | `Models` | `LogModel` | 1 (`$conexion`) | `registrar()`, `obtenerTodos()`, `contarTodos()` |
| `index.php` | _(Front Controller)_ | — | — | — |

Cada DocBlock de clase incluye: descripcion "Clase que...", `@package`,
`@author Tienda MVC`, `@version 1.0.0`.

Cada propiedad: `@var tipo` en linea separada con descripcion previa.

Cada metodo: descripcion del proposito y flujo, `@param tipo $nombre Descripcion.`,
`@return tipo Descripcion del retorno.`

---

### ESTRUCTURA FINAL DEL PROYECTO

```
ejemplo/
├── config/
│   ├── Autoload.php
│   └── Database.php
├── controllers/
│   ├── ApiController.php
│   ├── AuthController.php
│   ├── ProductoController.php
│   └── PublicController.php
├── helpers/
│   └── Csrf.php
├── models/
│   ├── LogModel.php
│   ├── ProductoModel.php
│   └── UsuarioModel.php
├── views/
│   ├── img/
│   │   └── productos/
│   ├── auth/
│   │   └── login.php
│   ├── layouts/
│   │   ├── footer.php
│   │   └── header.php
│   ├── productos/
│   │   ├── bitacora.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── index.php
│   └── public/
│       └── catalogo.php
├── .htaccess
├── CHANGELOG.md
├── database.sql
├── index.php
└── README.md
```
