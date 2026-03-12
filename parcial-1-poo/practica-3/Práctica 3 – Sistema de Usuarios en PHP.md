Práctica 3 – Sistema de Usuarios en PHP

Descripción del sistema
Este sistema crea diferentes tipos de usuarios utilizando Programación Orientada a Objetos en PHP.  
Se manejan usuarios de tipo **Admin** y **Alumno**, con validación de correo y manejo de excepciones.

Explicación del flujo de clases
-Usuario (clase base)**: contiene los atributos `nombre` y `correo`, con validación de correo en el constructor.  
-Admin (hereda de Usuario)**: agrega el método `getRol()` que retorna `"Administrador"`.  
-Alumno (hereda de Usuario)**: agrega atributo `matricula` y métodos `getMatricula()` y `getRol()` que retorna `"Alumno"`.

El flujo es: se crean objetos de cada clase y se usan sus métodos para mostrar información de cada usuario.

Evidencia del manejo de errores
Cuando se intenta crear un usuario con correo inválido, se lanza una excepción y se captura con `try/catch`, mostrando un mensaje controlado como:
