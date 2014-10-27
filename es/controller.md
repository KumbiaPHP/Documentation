#El Controlador

En KumbiaPHP Framework, la capa del controlador, contiene el codigo que liga
la lógica de negocio con la presentación. Está dividida en varios componentes
que se utilizan para diversos propositos:

  * El controlador frontal (front controller) es el unico punto de entrada a la aplicacion. Carga la configuracion y determina la accion a ejecutarse.
  * Las acciones verifican la integridad de las peticiones y preparan los datos requeridos por la capa de presentacion.
  * Las clases Input y Session dan acceso a los parametros de la peticion y a los datos persistentes del usuario. Se utilizan muy a menudo en la capa del controlador.
  * Los filtros son trozos de codigo ejecutados para cada peticion, antes y/o despues de un controlador incluso antes y/o despues de una accion. Por ejemplo, los filtros de seguridad y validacion son comunmente utilizados en aplicaciones web.

Este capitulo describe todos estos componentes. Para una pagina basica, es
probable que solo necesites escribir algunas lineas de codigo en la clase de
la accion, y eso es todo. Los otros componentes del controlador solamente se
utilizan en situaciones especificas.

## Controlador Frontal

Todas las peticiones web son manejadas por un solo Controlador Frontal (front
controller), que es el punto de entrada unico de toda la aplicacion.

Cuando el front controller recibe la peticion, utiliza el sistema de
enrutamiento de KumbiaPHP para asociar el nombre de un controlador y el de la
accion mediante la URL escrita por el cliente (usuario u otra aplicacion).

Veamos la siguiente URL, esta llama al script index.php  (que es el front
controller) y sera entendido como llamada a una accion.

http://localhost/kumbiaphp/micontroller/miaccion/   
  
Debido a la reescritura de URL nunca se hace un llamado de forma explicita al
index.php , solo se coloca el controlador, accion y parametros. Internamente
por las reglas reescritura de URL es llamado el front controller. Ver seccion
¿por que es importante el Mod-Rewrite?

### Destripando el Front Controller

El front controller de KumbiaPHP se encarga de despachar las peticiones, lo
que implica algo mas que detectar la accion que se ejecuta. De hecho, ejecuta
el codigo comun a todas las acciones, incluyendo:

  1. Define las constantes del nucleo de la aplicacion(APP_PATH,CORE_PATH y PUBLIC_PATH).
  2. Carga e inicializa las clases del nucleo del framework (bootstrap).
  3. Carga la configuracion (Config).
  4. Decodifica la URL de la peticion para determinar la accion a ejecutar y los parametros de la peticion (Router).
  5. Si la accion no existe, redireccionara a la accion del error 404 ( Router ).
  6. Activa los filtros (por ejemplo, si la peticion necesita autenticacion) ( Router ).
  7. Ejecuta los filtros, primera pasada (before). ( Router )
  8. Ejecuta la accion ( Router ).
  9. Ejecuta los filtros, segunda pasada (after) ( Router ).
  10. Ejecuta la vista y muestra la respuesta (View).

En grande rasgos este es el proceso del front controller, esto es todo que
necesitas saber sobre este componente el cual es imprescindible de la
arquitectura MVC dentro de KumbiaPHP

### Front Controller por defecto

El front controller por defecto, llamado index.php  y ubicado en el directorio
public/ del proyecto, es un simple script, como el siguiente:

```php
<?php
error_reporting ( E_ALL  ^ E_STRICT);  
//define('PRODUCTION', TRUE);    
define ( 'START_TIME' , microtime (1));  
define ( 'APP_PATH' , dirname ( dirname ( __FILE__ )) . '/app/' );  
define ( 'CORE_PATH' , dirname ( dirname (APP_PATH)) . '/core/' );  
if  ($_SERVER[ 'QUERY_STRING' ]) {  
    define ( 'PUBLIC_PATH' , substr ( urldecode ($_SERVER[ 'REQUEST_URI' ]), 0, - strlen ($_SERVER[ 'QUERY_STRING' ]) + 6));   
} else  {  
  define ( 'PUBLIC_PATH' , $_SERVER[ 'REQUEST_URI' ]);  
}  
$url = isset ($_GET[ '_url' ]) ? $_GET[ '_url' ] : '/' ;    
require  CORE_PATH . 'kumbia/bootstrap.php' ;  
```  
  
La definicion de las constantes corresponde al primer paso descrito en la
seccion anterior. Despues el controlador frontal incluye el bootstrap.php  de
la aplicacion, que se ocupa de los pasos 2 a 5. Internamente el core de
KumbiaPHP con sus componente Router   y View ejecutan todos los pasos
subsiguientes.

Todas las constantes son valores por defecto de la instalacion de KumbiaPHP en
un ambiente local.

### Constantes de KumbiaPHP

Cada constante cumple un objetivo especifico con el fin de brindar mayor
flexibilidad al momento de crear rutas (paths) en el framework.

#### APP_PATH

Constante que contiene la ruta absoluta al directorio donde se encuentra la
aplicacion (app), por ejemplo:
```php
echo  APP_PATH; 
//la salida es: /var/www/kumbiaphp/default/app/ 
``` 
  
Con esta constante es posible utilizarla para incluir archivos que se
encuentre bajo el arbol de directorio de la aplicacion, por ejemplo si quiere
incluir un archivo que esta en el directorio app/libs/test.php  la forma de
hacerlo seria.

include_once  APP_PATH. 'libs/test.php' ;  
  
#### CORE_PATH

Constante que contiene la ruta absoluta al directorio donde se encuentra el
core de KumbiaPHP. por ejemplo:

```php
echo  CORE_PATH;  
//la salida es: /var/www/kumbiaphp/core/  
```  

  
Para incluir archivos, que se encuentre bajo este arbol de directorios, es el
mismo procedimiento que se explico para la constante APP_PATH.

#### PUBLIC_PATH

Constante que contiene la URL para el navegador (browser) y apunta al
directorio public/ para enlazar imagenes, CSS, JavaScript y todo lo que sea
ruta para browser.
```php
//Genera un link que ira al  
//controller: controller y action: action  
<a href=" <?php   echo  PUBLIC_PATH ?> controller/action/" title="Mi Link">Mi
Link</a>  
  
//Enlaza una imagen que esta en public/img/imagen.jpg  
<img src=" <?php   echo  PUBLIC_PATH ?> img/imagen.jpg" alt="Una Imagen" />  
  
//Enlaza el archivo CSS en public/css/style.css  
<link rel="stylesheet" type="text/css" href=" <?php   echo  PUBLIC_PATH ?>
css/style.css"/>  
```  
  
## Las Acciones

Las acciones son la parte fundamental en la aplicación, puesto que contienen
el flujo en que la aplicacion actuara ante ciertas peticiones. Las acciones
utilizan el modelo y definen variables para la vista. Cuando se realiza una
peticion web en una aplicacion KumbiaPHP, la URL define una accion y los
parametros de la peticion. Ver seccion 2.1.3.4

Las acciones son metodos de una clase controladora llamada ClassController que
hereda de la clase AppController y pueden o no ser agrupadas en modulos.

### Las acciones y las vistas

Cada vez que se ejecuta una accion KumbiaPHP buscara entonces una vista (view)
con el mismo nombre de la accion. Este comportamiento se ha definido por
defecto. Normalmente las peticiones deben dar una respuesta al cliente que la
ha solicitado, entonces si tenemos una accion llamada saludo()  deberia
existir una vista asociada a esta accion llamada saludo.phtml . Habra un
capitulo mas extenso dedicado a la explicacion de las vistas en KumbiaPHP.

### Obtener valores desde una acción

Las URLs de KumbiaPHP estan caracterizadas por tener varias partes, cada una
de ellas con una funcion conocida. Para obtener desde un controlador los
valores que vienen en la URL podemos usar algunas propiedades definidas en el
controlador.

Tomemos la URL:

http://www.dominio.com/noticias/ver/12/  
   
  
  * El Controlador:   noticias  
  * La accion:   ver  
  * Parametros:   12
```php
<?php  
/**  
 * Controller Noticia   
 */   
class  NoticiasController extends  AppController{  
    /**   
     * metodo para ver la noticia   
     * @param int $id   
     */   
    public   function  ver($id){   
        echo  $this-> controller_name ; //noticias   
        echo  $this-> action_name ; //ver   
        //Un array con todos los parametros enviados a la accion   
        var_dump ($this-> parameters );   
   }  
}  
```  
  
Es importante notar la relacion que guardan los parametros enviados por URL
con la accion. En este sentido KumbiaPHP tiene una caracteristica, que hace
seguro el proceso de ejecutar las acciones y es que se limita el envio de
parametros tal como se define en la metodo (accion). Lo que indica que todos
los parametros enviados por URL son argumentos que recibe la accion. ver
seccion 2.1.3.4

En el ejemplo anterior se definio en la accion ver($id) un solo parametro,
esto quiere decir que si no se envia ese parametro o se intentan enviar mas
parametros adicionales KumbiaPHP lanzara una exception (en produccion mostrara
un error 404). Este comportamiento es por defecto en el framework y se puede
cambiar para determinados escenarios segun el proposito de nuestra aplicacion
para la ejecucion de una accion.

Tomando el ejemplo «Hola Mundo» ponga en practica lo antes explicado y lo hara
enviando parametros adicionales al metodo hola($nombre) el cual solo recibe un
solo parametro (el nombre) http://localhost/kumbiaphp/saludo/hola/CaChi/adici
onal, en la figura 3.1 vera la excepcion generada por KumbiaPHP.

![](images/image13.png)
Figura 3.1: Excepcion de Parametros erroneos.

Siguiendo en el mismo ejemplo imaginemos que requerimos que la ejecucion de la
accion hola()  obvie la cantidad de parametros enviados por URL, para esto
solo tenemos que indicarle a KumbiaPHP mediante el atributo $limit_params  que
descarte el numero de parametros que se pasan por URL.

```php
<?php  
/**  
 * Controller Saludo   
 */   
class  SaludoController extends  AppController {  
    /**   
     * Limita la cantidad correcta de   
     * parametros de una action   
     */   
    public  $limit_params = FALSE ;   
   ... metodos ...  
}  
``` 
  
Cuando tiene el valor FALSE como se explico antes, descarta la cantidad de
parametros de la accion. Ingresa a la siguiente URL [http://localhost/kumbiaph
p/saludo/hola/CaChi/param2/param3/] y vera como ya no esta la excepcion
de la figura 3.1 y podra ver la vista de la accion como muestra la figura 3.2.

![](images/image03.png)

Figura 3.2: Descartando la cantidad de parametros de la accion.

## Convenciones y Creacion de un Controlador

### Convenciones

Los controladores en KumbiaPHP deben llevar las siguientes convenciones y
caracteristicas:

El archivo debe creado solo en el directorio app/controllers/ . El archivo
debe tener el nombre del controlador y la terminacion _controller.php , por
ejemplo saludo_controller.php .

El archivo debe contener la clase controladora con el mismo nombre del archivo
en notacion CamelCase. Retomando el ejemplo anterior el nombre de la clase
controladora seria SaludoController.

```php
*/

public $limit_params = FALSE;

... metodos ...

}
```

### Creación de un Controlador

Ahora se pondra en practica lo visto anteriormente y crearemos un controlador
(controller) llamado saludo.

```php
<?php  
/**  
 * Controller Saludo   
 */   
class  SaludoController extends  AppController {  
}  
```  
  
###  Clase AppController

Es importante recordar que KumbiaPHP es un framework MVC y POO. En este
sentido existe AppController  y es la super clase de los controladores, todos
deben heredar (extends) de esta clase para tener las propiedades (atributos) y
metodos que facilitan la interaccion entre la capa del modelo y presentacion.

La clase AppController  esta definida en app/libs/app_controller.php  es una
clase muy sencilla de usar y es clave dentro del MVC.

### Acciones y Controladores por defecto

## Filtros

Los controladores en KumbiaPHP poseen unos metodos utiles que permiten
realizar comprobaciones antes y despues de ejecutar un controlador y una
accion, los filtros pueden ser entendido como un mecanismo de seguridad en los
cuales se puede cambiar el procesamiento de la peticion segun se requiera (por
ejemplo verificar si un usuarios se encuentra autenticado en el sistema).

KumbiaPHP corre los filtros en un orden logico, para manipular comprobaciones,
a nivel de toda la aplicacion o bien en particularidades de un controlador.

### Filtros de Controladores

Los filtros de controladores se ejecutan antes y despues de un controlador son
utiles para comprobaciones a nivel de aplicacion, como por ejemplo verificar
el modulo que se esta intentando acceder, sesiones de usuarios, etc.
Igualmente se puede usar para proteger nuestro controlador de informacion
inadecuada.

Los filtros son metodos los cuales sobreescribimos (caracteristica POO) para
darle el comportamiento deseado.

#### initialize()

KumbiaPHP llama al metodo initialize()  antes de ejecutar el controlador y se
encuentra definido para ser usado en la clase AppController (ver seccion
3.3.3).

####  3.4.1.2. finalize()

KumbiaPHP llama al metodo finalize()  despues de ejecutar el controlador y se
encuentra definido para ser usado en la clase AppController (ver seccion
3.3.3).

###  3.4.2. Filtros de Acciones

Los filtros de acciones se ejecutan antes y despues de una accion son utiles
para comprobaciones a nivel de controller, como por ejemplo verificar que una
peticion es asincrona, cambiar tipos de respuesta, etc. Igualmente se puede
usar para proteger nuestra accion de informacion inadecuada que sea enviada a
ellos.

####  3.4.2.1. before_filter()

KumbiaPHP llama al metodo before_filter()  antes de ejecutar la accion del
controlador y es util para verificar si una peticion es asincrona entre otros.

####  3.4.2.2. after_filter()

KumbiaPHP llama al metodo after_filter()  despues de ejecutar la accion del
controlador y es util para cambiar valores de sesion entre otros.