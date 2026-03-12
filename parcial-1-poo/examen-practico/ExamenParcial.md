# Práctica 4 – Clases en PHP con herencia y manejo de excepciones

## Descripción

En esta práctica se creó un pequeño programa en PHP usando programación orientada a objetos.
Se utilizó una clase base llamada **Usuario** y dos clases que heredan de ella: **Admin** y **Alumno**.

El objetivo fue practicar herencia, validación de datos y manejo de errores usando excepciones.

## Estructura del programa

### Clase Usuario

Esta es la clase principal.
Tiene dos atributos: **nombre** y **correo**.

En el constructor se valida que el correo tenga un formato correcto.
Si el correo no es válido, el programa lanza una **Exception**.

También tiene dos métodos:

* `getNombre()` para obtener el nombre.
* `getCorreo()` para obtener el correo.

### Clase Admin

Esta clase hereda de **Usuario**.

Tiene un método llamado:

* `getRol()` que regresa el texto **"Administrador"**.

### Clase Alumno

Esta clase también hereda de **Usuario**.

Además de nombre y correo, tiene un atributo extra:

* **matricula**

Incluye estos métodos:

* `getMatricula()` para obtener la matrícula.
* `getRol()` que regresa **"Alumno"**.

## Archivo index.php

En este archivo se crean algunos objetos para probar el programa.

Se crean:

* Un **Admin** con datos válidos.
* Un **Alumno** con datos válidos.
* Un **Alumno con correo inválido** para probar la excepción.

Se usa **try/catch** para evitar que el programa se rompa cuando el correo no es válido y mostrar un mensaje de error controlado.

## Salida en pantalla

El programa muestra una tabla simple en HTML con la siguiente información:

Nombre | Correo | Rol | Matrícula

La matrícula solo aparece cuando el usuario es un alumno.

## Objetivo de la práctica

Practicar:

-Clases en PHP
-Herencia
-Validación de datos
-Uso de excepciones
-Mostrar información en HTML
