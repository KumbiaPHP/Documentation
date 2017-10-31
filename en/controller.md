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
 * Greeting Controller
 */ 
class GreetingController extends AppController {
    /** 
     * Limits the correct number 
     * of parameters of an action
     */ 
    public $limit_params = FALSE;
   ... methods...
}
```

When has the value FALSE, as explained earlier, discarded the number of parameters of the action. Enter the following URL [http://localhost/kumbiaphp/greetings/Hello/CaChi/param2/param3 /] and you will see as already is not the exception of Figure 3.1 and you can see the action view as shown in Figure 3.2.

![](../images/image03.png)

Figure 3.2: Discarding the number of parameters of the action.

## Controller conventions and creation

### Conventions

KumbiaPHP controllers must carry the following conventions and features:

The file should be created only in the directory *app/controllers/*. The file must have the name of the controller and the suffix *_controller.php*, for example *greeting_controller.php*.

The file should contain the controller class with the same name of the file into notation **CamelCase**. Returning to the example above the name of the controller class will be GreetingController.

### Controller creation

Now we practice as seen above and create a controller (controller) called Greeting.

```php
<?php
/** 
 * Greeting Controller
 */ 
class GreetingController extends AppController {
}
```

### Class AppController

It is important to remember that KumbiaPHP is a MVC and OOP framework. In this sense there is AppController and is the super class of controllers, all must inherit (extends) of this kind to have properties (attributes) and methods that facilitate interaction between the model and presentation layer.

This AppController class defined in *app/libs/app_controller.php* is a very simple class to use and is key in the MVC.

### Actions and controllers by default

## Filters

KumbiaPHP controllers possess a few useful methods that allow to perform checks before and after executing a controller and an action, filters can be understood as a security mechanism in which the processing of the request can be changed as required (for example to check if a user is authenticated on the system).

KumbiaPHP runs filters in a logical order, to handle checks at the level of the entire application or on particularities of controller.

### Controllers filters

Controllers filters are run before and after a driver are useful for checks at the application level, as for example check the module that is is trying to access, sessions of users, etc. It can also be used to protect our controller of inappropriate information.

Filters are methods which we overwrite (feature POO) to give you the desired behavior.

#### initialize()

KumbiaPHP call *initialize()* method before executing the controller and is defined to be used in the AppController class. [See section AppController](controller.md#clase-appcontroller).

#### finalize()

KumbiaPHP *finalize()* method called after executing the handler and is defined to be used in the AppController class. [See section AppController](controller.md#clase-appcontroller).

### Action filters

Action filters are executed before and after an action are useful for checks at the controller level, as for example to verify that a request is asynchronous, changing types of response, etc. It can also be used to protect our action of inadequate information which is sent to them.

#### before_filter()

KumbiaPHP *before_filter ()* method called before executing the action the controller, and is useful to check if a request is asynchronous among others.

#### after_filter()

KumbiaPHP *after_filter ()* method called after executing the action the controller, and is useful to change values of session among others.