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
//the output is: /var/www/kumbiaphp/core/
```

To include files under this directory tree, it is the same procedure as that described for the constant APP_PATH.

#### PUBLIC_PATH

Constant that contains the URL for the browser (browser) and points to the directory *public/* to link images, style sheets, scripts and all that is path to the browser.

```php
//Creates that will go to
//controller: controller and action: action
<a href=" <?php echo PUBLIC_PATH ?>controller/action/" title="My Link">Mi
Link</a>

//Link an image that is in public/img/imagen.jpg
<img src="<?php echo PUBLIC_PATH ?>img/image.jpg" alt="An image" />

//Link a CSS file that is in public/css/style.css
<link rel="stylesheet" type="text/css" href=" <?php echo PUBLIC_PATH ?>
css/style.css"/>
```

## The actions

Actions are the main part in the application, since containing flow in which the application will act to certain requests. The actions use the model and defined variables to the view. When you make a web request on a KumbiaPHP application, the URL defines an action and the parameters of the request. See section [KumbiaPHP and their URLs](first-app.md#kumbiaphp-y-sus-urls)

Actions are methods of a controller class called ClassController that inherits from the AppController class and may or may not be grouped into modules.

### Actions and views

Whenever an action is executed, KumbiaPHP then seeks a view with the same name of the action. This behavior is defined by default. Normally requests must respond to the customer who has requested it, then if we have an action called *saludo()* there should be a view associated with this action called *saludo.phtml*. There will be more extensive chapter explaining the views on KumbiaPHP.

### Get values from an action

KumbiaPHP URLs are characterized by having several parts, each with a known function. To obtain from a controller values supplied in the URL we can use some properties defined in the controller.

Take the URL:

http://www.example.com/news/show/12/

- Controller: News
- Action: show
- Parameters: 12

```php
<?php
/** 
 * Controller News
 */ 
class NewsController extends AppController{
    /** 
     * Method to show the news
     * @param int $id
     */ 
    public function show($id){
        echo $this->controller_name;//news
        echo $this->action_name;//show 
        //A array with all parameters sent to the action
        var_dump($this->parameters);   
   }
}
```

Is important to note the relationship that saved the parameters sent by the URL with the action. In this sense KumbiaPHP has a characteristic, which makes sure the process to execute the actions and is limiting the sending of parameters as defined in the method (action). This indicates that all the submitted URL parameters are arguments that receives the action. See section [KumbiaPHP and their URLs](first-app.md#kumbiaphp-y-sus-urls)

In the example above is defined in the action *show($id)* an only parameter, this means that if not is sends that parameter or is trying to send more parameters additional KumbiaPHP launches an exception (in production shows an error 404). This behavior is by default in the framework and is can change for certain scenarios according to the purpose of our application for the execution of an action.

Taking the 'Hello world' example put into practice explained before and will do so by sending additional parameters to the method hello($name) which receives only one parameter (the name) http://localhost/kumbiaphp/greeting/hello/CaChi/additional, in Figure 3.1 will see that KumbiaPHP generated exception.

![](../images/image13.png)

Figure 3.1: Exception of number of erroneous parameters.

Following the same example imagine that we require that the execution of the action *hello()* disregard the amount of parameters sent by URL, for this will only have to indicate to KumbiaPHP using the $limit_params attribute that you discard the number of parameters that are passed by URL.

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