# Controller

KumbiaPHP Framework, the controller layer, contains the code that connects the business with the presentation logic. It is divided into various components that are used for different purposes:

- The front controller (front controller) is the only entry point to application. Load the configuration and determines the action to execute.
- The actions verify the integrity of petitions and prepare data required by layer of presentation.
- Input and Session classes provide access to the parameters of the request and the user's persistent data. They used very often in the controller layer.
- Filters are pieces of code that are executed for every request, before or after a controller even before or after an action. For example, security and validation filters are commonly used in web applications.

This chapter describes all these components. For a basic page, likely only need to write some lines of code in the action class, and that's it. The other components of the controller only used in specific situations.

## Front Controller

All web request are handled by a only front controller (Front Controller), that is point of single entry of all application.

When the front controller receives the request, used the routing system of KumbiaPHP to associate the name of a controller and the action often URL written by the client (user or other application).

Let's see next URL, this call script index.php (that is the front controller) and will be understood as as called to action.

http:://localhost/kumbiaphp/mycontroller/myaction/

Because rewriting URL never is made a called of form explicit to the index.php, only placed the controller, actions and parameters. Internally by the rewriting rules URL is called the front controller. See section, Why is importan the mod-rewrite?

### Gutting the Front Controller

The Front Controller of KumbiaPHP is responsible of dispatching requests, that implies something more than detect the action that is executed. In fact, run the code common to all actions, including:

  1. Defines the constants of the core of the application (APP_PATH, CORE_PATH and PUBLIC_PATH).
  2. Load and initializes the core class of the framework (bootstrap).
  3. Load the configuration (Config).
  4. It decodes the URL of the request to determine the action to execute and the parameters of the request (Router).
  5. If the action does not exist, redirect to the action of the 404 error (Router).
  6. Active filters (for example, if the request needs authentication) (Router).
  7. Execute the filters, first pass (before). (Router)
  8. Execute the action (Router).
  9. Execute the filters, second pass (after) (Router).
 10. Execute the view and shows the response (View).

Great features, this is the process of the front controller, this is all is needs to know about this component which is essential of the KumbiaPHP MVC architecture.

### Front Controller by default

Front controller by default, called index.php and located in the directory *public /* project, is a simple script, such as the following:

```php
<? php error_reporting (E_ALL ^ E_STRICT); define('PRODUCTION', TRUE); define ('START_TIME', too (1)); define ('APP_PATH', dirname (dirname (__FILE__)). '/ app /'); define ('CORE_PATH', dirname (dirname (APP_PATH)). '/core/' );
if  ($_SERVER[ 'QUERY_STRING' ]) {
    define ( 'PUBLIC_PATH' , substr ( urldecode ($_SERVER[ 'REQUEST_URI' ]), 0, - strlen ($_SERVER[ 'QUERY_STRING' ]) + 6));
} else  {
  define ( 'PUBLIC_PATH' , $_SERVER[ 'REQUEST_URI' ]);
}
$url = isset ($_GET[ '_url' ]) ? $_GET[ '_url' ] : '/' ;
require  CORE_PATH . 'kumbia/bootstrap.php' ;
```

The definition of the constants corresponds to the first step described in the previous section. After Front controller includes the bootstrap.php of application, dealing with the steps 2 to 5. Internally the core KumbiaPHP with its component Router and View running all the subsequent steps.

All constants are values default KumbiaPHP installation in a local environment.

### KumbiaPHP constants

Each constant is a specific objective in order to provide greater flexibility when creating paths (paths) in the framework.

#### APP_PATH

Constant containing the absolute path to the directory where the application (app) is, for example:

```php
echo APP_PATH; 
the output is: /var/www/kumbiaphp/default/app / 
```

With this constant it is possible to use it to include files that is under the directory tree of the application, for example if you want to include a file that is in the app / directory libs / test.php the way to do it.

```php
include_once APP_PATH.'libs/test.php' ;
```

#### CORE_PATH

Constant that contains the absolute path to the directory where you will find the core of KumbiaPHP. For example:

```php
echo CORE_PATH;
//la salida es: /var/www/kumbiaphp/core/
```

Para incluir archivos que se encuentre bajo este árbol de directorios, es el mismo procedimiento que se explicó para la constante APP_PATH.

#### PUBLIC_PATH

Constante que contiene la URL para el navegador (browser) y apunta al directorio *public/* para enlazar imágenes, CSS, JavaScript y todo lo que sea ruta para el navegador.

```php
//Genera un link que ira al 
//controller: controller y action: action
<a href=" <?php echo PUBLIC_PATH ?>controller/action/" title="Mi Link">Mi
Link</a>

//Enlaza una imagen que esta en public/img/imagen.jpg
<img src="<?php echo PUBLIC_PATH ?>img/imagen.jpg" alt="Una Imagen" />

//Enlaza el archivo CSS en public/css/style.css
<link rel="stylesheet" type="text/css" href=" <?php echo PUBLIC_PATH ?>
css/style.css"/>
```

## The actions

Las acciones son la parte fundamental en la aplicación, puesto que contienen el flujo en que la aplicación actuará ante ciertas peticiones. Las acciones utilizan el modelo y definen variables para la vista. Cuando se realiza una petición web en una aplicación KumbiaPHP, la URL define una acción y los parámetros de la petición. Ver sección [KumbiaPHP y sus URLs](first-app.md#kumbiaphp-y-sus-urls)

Las acciones son métodos de una clase controladora llamada ClassController que hereda de la clase AppController y pueden o no ser agrupadas en módulos.

### Actions and views

Cada vez que se ejecuta una acción, KumbiaPHP busca entonces una vista (view) con el mismo nombre de la acción. Este comportamiento se ha definido por defecto. Normalmente las peticiones deben dar una respuesta al cliente que la ha solicitado, entonces si tenemos una acción llamada *saludo()* debe existir una vista asociada a esta acción llamada *saludo.phtml*. Habrá un capítulo más extenso dedicado a la explicación de las vistas en KumbiaPHP.

### Get values from an action

Las URLs de KumbiaPHP están caracterizadas por tener varias partes, cada una de ellas con una función conocida. Para obtener desde un controlador los valores que vienen en la URL podemos usar algunas propiedades definidas en el controlador.

Tomemos la URL:

http://www.example.com/noticias/ver/12/

- Controller: News
- Action: show
- Parameters: 12

```php
<?php
/** 
 * Controller Noticia
 */ 
class NoticiasController extends AppController{
    /** 
     * método para ver la noticia
     * @param int $id
     */ 
    public function ver($id){
        echo $this->controller_name;//noticias   
        echo $this->action_name;//ver   
        //Un array con todos los parámetros enviados a la acción   
        var_dump($this-> parameters);   
   }
}
```

Es importante notar la relación que guardan los parámetros enviados por URL con la acción. En este sentido KumbiaPHP tiene una característica, que hace seguro el proceso de ejecutar las acciones y es que se limita el envío de parámetros tal como se define en la método (acción). Lo que indica que todos los parámetros enviados por URL son argumentos que recibe la acción. Ver sección [KumbiaPHP y sus URLs](first-app.md#kumbiaphp-y-sus-urls)

En el ejemplo anterior se definió en la acción *ver($id)* un sólo parámetro, esto quiere decir que si no se envía ese parámetro o se intentan enviar más parámetros adicionales KumbiaPHP lanza una excepción (en producción muestra un error 404). Este comportamiento es por defecto en el framework y se puede cambiar para determinados escenarios según el propósito de nuestra aplicación para la ejecución de una acción.

Tomando el ejemplo «Hola Mundo» ponga en práctica lo antes explicado y lo hará enviando parámetros adicionales al método hola($nombre) el cual sólo recibe un parámetro (el nombre) http://localhost/kumbiaphp/saludo/hola/CaChi/adici onal, en la figura 3.1 vera la excepción generada por KumbiaPHP.

![](../images/image13.png)

Figura 3.1: Excepción de número de parámetros erróneos.

Siguiendo en el mismo ejemplo imaginemos que requerimos que la ejecución de la acción *hola()* obvie la cantidad de parámetros enviados por URL, para esto solo tenemos que indicarle a KumbiaPHP mediante el atributo $limit_params que descarte el número de parámetros que se pasan por URL.

```php
<?php
/** 
 * Controller Saludo
 */ 
class SaludoController extends AppController {
    /** 
     * Limita la cantidad correcta de
     * parámetros de una acción 
     */ 
    public $limit_params = FALSE;
   ... métodos ...
}
```

Cuando tiene el valor FALSE como se explico antes, descarta la cantidad de parámetros de la acción. Ingresa a la siguiente URL [http://localhost/kumbiaph p/saludo/hola/CaChi/param2/param3/] y verá como ya no esta la excepción de la figura 3.1 y puede ver la vista de la acción como muestra la figura 3.2.

![](../images/image03.png)

Figura 3.2: Descartando la cantidad de parámetros de la acción.

## Controller conventions and creation

### Conventions

Los controladores en KumbiaPHP deben llevar las siguientes convenciones y características:

El archivo debe ser creado solo en el directorio *app/controllers/*. El archivo debe tener el nombre del controlador y la terminación *_controller.php*, por ejemplo *saludo_controller.php*.

El archivo debe contener la clase controladora con el mismo nombre del archivo en notación **CamelCase**. Retomando el ejemplo anterior el nombre de la clase controladora sera SaludoController.

### Controller creation

Ahora ponemos en práctica lo visto anteriormente y crearemos un controlador (controller) llamado saludo.

```php
<?php
/** 
 * Controller Saludo
 */ 
class SaludoController extends AppController {
}
```

### Class AppController

Es importante recordar que KumbiaPHP es un framework MVC y POO. En este sentido existe AppController y es la super clase de los controladores, todos deben heredar (extends) de esta clase para tener las propiedades (atributos) y métodos que facilitan la interacción entre la capa del modelo y presentación.

La clase AppController esta definida en *app/libs/app_controller.php* es una clase muy sencilla de usar y es clave dentro del MVC.

### Actions and controllers by default

## Filters

Los controladores en KumbiaPHP poseen unos métodos útiles que permiten realizar comprobaciones antes y después de ejecutar un controlador y una acción, los filtros pueden ser entendidos como un mecanismo de seguridad en los cuales se puede cambiar el procesamiento de la petición según se requiera (por ejemplo verificar si un usuarios se encuentra autenticado en el sistema).

KumbiaPHP corre los filtros en un orden lógico, para manipular comprobaciones, a nivel de toda la aplicación o bien en particularidades de un controlador.

### Controllers filters

Los filtros de controladores se ejecutan antes y después de un controlador son útiles para comprobaciones a nivel de aplicación, como por ejemplo verificar el modulo que se esta intentando acceder, sesiones de usuarios, etc. Igualmente se puede usar para proteger nuestro controlador de información inadecuada.

Los filtros son métodos los cuales sobrescribimos (característica POO) para darle el comportamiento deseado.

#### initialize()

KumbiaPHP llama al método *initialize()* antes de ejecutar el controlador y se encuentra definido para ser usado en la clase AppController. [Ver sección AppController](controller.md#clase-appcontroller).

#### finalize()

KumbiaPHP llama al método *finalize()* después de ejecutar el controlador y se encuentra definido para ser usado en la clase AppController. [Ver sección AppController](controller.md#clase-appcontroller).

### Action filters

Los filtros de acciones se ejecutan antes y después de una acción son útiles para comprobaciones a nivel de controller, como por ejemplo verificar que una petición es asíncrona, cambiar tipos de respuesta, etc. Igualmente se puede usar para proteger nuestra acción de información inadecuada que sea enviada a ellos.

#### before_filter()

KumbiaPHP llama al método *before_filter()* antes de ejecutar la acción del controlador y es útil para verificar si una petición es asíncrona entre otros.

#### after_filter()

KumbiaPHP llama al método *after_filter()* después de ejecutar la acción del controlador y es útil para cambiar valores de sesión entre otros.