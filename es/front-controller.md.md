# Controlador Frontal

Todas las peticiones web son manejadas por un solo Controlador Frontal (front
controller), que es el punto de entrada único de toda la aplicación.

Cuando el front controller recibe la petición, utiliza el sistema de
enrutamiento de KumbiaPHP para asociar el nombre de un controlador y el de la
acción mediante la URL escrita por el cliente (usuario u otra aplicación).

Veamos la siguiente URL, esta llama al script index.php  (que es el front
controller) y sera entendido como llamada a una acción.

http://localhost/kumbiaphp/micontroller/miaccion/   
  
Debido a la reescritura de URL nunca se hace un llamado de forma explicita al
index.php, solo se coloca el controlador, acción y parámetros. Internamente
por las reglas reescritura de URL es llamado el front controller. Ver sección
[¿Por qué es importante el Mod-Rewrite?](to-install.md#por-qu%C3%A9-es-importante-el-mod-rewrite)

## Destripando el Front Controller

El front controller de KumbiaPHP se encarga de despachar las peticiones, lo
que implica algo mas que detectar la acción que se ejecuta. De hecho, ejecuta
el código común a todas las acciones, incluyendo:

  1. Define las constantes del núcleo de la aplicación(APP_PATH, CORE_PATH y PUBLIC_PATH).
  2. Carga e inicializa las clases del núcleo del framework (bootstrap).
  3. Carga la configuración (Config).
  4. Decodifica la URL de la petición para determinar la acción a ejecutar y los parámetros de la petición (Router).
  5. Si la acción no existe, redirecciona a la acción del error 404 ( Router ).
  6. Activa los filtros (por ejemplo, si la petición necesita autenticación) ( Router ).
  7. Ejecuta los filtros, primera pasada (before). ( Router )
  8. Ejecuta la acción ( Router ).
  9. Ejecuta los filtros, segunda pasada (after) ( Router ).
  10. Ejecuta la vista y muestra la respuesta (View).

A grande rasgos, este es el proceso del front controller, esto es todo lo que
necesitas saber sobre este componente el cual es imprescindible de la
arquitectura MVC dentro de KumbiaPHP

## Front Controller por defecto

El front controller por defecto, llamado _index.php_  y ubicado en el directorio
_public/_ del proyecto, es un simple script PHP.```
  
La definición de las constantes corresponde al primer paso descrito en la
sección anterior. Después el controlador frontal incluye el bootstrap.php  de
la aplicación, que se ocupa de los pasos 2 a 5. Internamente el core de
KumbiaPHP con sus componente Router y View ejecutan todos los pasos
subsiguientes.

Todas las constantes son valores por defecto de la instalación de KumbiaPHP en
un ambiente local.

## Constantes de KumbiaPHP

Cada constante cumple un objetivo específico con el fin de brindar mayor
flexibilidad al momento de crear rutas (paths) en el framework.

### APP_PATH

Constante que contiene la ruta absoluta al directorio donde se encuentra la
aplicación (app), por ejemplo:

```php
echo APP_PATH; 
//la salida es: /var/www/kumbiaphp/default/app/ 
``` 
  
Con esta constante es posible utilizarla para incluir archivos que se
encuentre bajo el árbol de directorio de la aplicación, por ejemplo si quiere
incluir un archivo que esta en el directorio app/libs/test.php  la forma de
hacerlo seria.

```php
include_once APP_PATH.'libs/test.php' ;
```

### CORE_PATH

Constante que contiene la ruta absoluta al directorio donde se encuentra el
core de KumbiaPHP. por ejemplo:

```php
echo CORE_PATH;
//la salida es: /var/www/kumbiaphp/core/
```

Para incluir archivos que se encuentre bajo este árbol de directorios, es el
mismo procedimiento que se explicó para la constante APP_PATH.

### PUBLIC_PATH

Constante que contiene la URL para el navegador (browser) y apunta al
directorio *public/* para enlazar imágenes, CSS, JavaScript y todo lo que sea
ruta para el navegador.

```php
//Genera un link que ira al 
//controller: controller y action: action
<a href=" <?php echo PUBLIC_PATH ?>controller/action/" title="Mi Link">Mi Link</a>
  
//Enlaza una imagen que esta en public/img/imagen.jpg
<img src="<?php echo PUBLIC_PATH ?>img/imagen.jpg" alt="Una Imagen" />
  
//Enlaza el archivo CSS en public/css/style.css
<link rel="stylesheet" type="text/css" href=" <?php echo PUBLIC_PATH ?>
css/style.css"/>
```