# The console

## Intro

The console is a tool for command line, allowing to perform automated within the scope of your app. In this sense KumbiaPHP includes the following consoles: Cache, Model and Controller.

Each console is composed of a set of commands, each command can receive sequential arguments and named arguments. To indicate a named argument is must precede the prefix "\--" to the argument.

## How to use the console

Para utilizar la consola debes ejecutar el despachador de comandos de consola de KumbiaPHP en un terminal, ubicarte en el directorio " app" de tu aplicacion y ejecutar la instruccion acorde al siguiente formato:

`php ../../core/console/kumbia.php [ consola ] [ comando ] [ arg ] [ \--arg_nom
] =valor`

* * *

Si no se especifica el comando ha ejecutar, entonces se ejecutará el comando " main " de la consola.

También es posible indicar la ruta al directorio app de la aplicación explícitamente por medio del argumento con nombre " path ".

Ejemplos:

`php ../../core/console/kumbia.php cache clean --driver=sqlite`

`php kumbia.php cache clean --driver=sqlite --path="/var/www/app"`

## KumbiaPHP consoles

### Cache

This console allows you to perform control over the cache of application.

#### clean \[group\] \[--driver\]

### Allows you to clean the cache.

### Sequential arguments:

- group: group name of cache items that will be deleted, if value is not specified, then clean all cache.

### Named arguments:

- driver: driver cache corresponding to the cache cleaning (nixfile, file, sqlite, APC), if not specified, then the cache manager taken default.

### Example:

### php ../../core/console/kumbia.php cache clean

* * *

#### remove \[id\] \[group\]

Removes an element from the cache.

Sequential arguments:

- i d: id de elemento en cache.
- group: name of group to which belongs the element, specifying no value, then use the 'default' group.

Named arguments:

- driver: driver cache corresponding to the cache cleaning (nixfile, file, sqlite, APC).

Example:

`php ../../core/console/kumbia.php cache remove vista1 mis_vistas`

* * *

### Model

It allows you to manipulate the application models.

#### create [model]

Create a model using as a base the template located at "core/console/generators/model.php".

Sequential arguments:

- model: model name in smallcase.

Example:

`php ../../core/console/kumbia.php model create venta_vehiculo`

* * *

#### delete [model]

Delete a model.

Sequential arguments:

- model: model name in smallcase.

Example:

`php ../../core/console/kumbia.php model delete venta_vehiculo`

* * *

### Controller

It allows you to manipulate the application controllers.

#### create [controller]

Create a controller using as a basis the located in the 'core/console/generators/controller.php' template.

Sequential arguments:

- controller: controller name in smallcase.

Example:

`php ../../core/console/kumbia.php controller create venta_vehiculo`

* * *

#### delete [controller]

Delete controller.

Sequential arguments:

- controller: controller name in smallcase.

Example:

`php ../../core/console/kumbia.php controller delete venta_vehiculo`

* * *

# #

## Developing your consoles

To develop your consoles you should consider the following:

- Consoles that you develop for your application should be located in the directory "app/extensions/console".
- The file should have the suffix "_console" as well as the class the "Console" suffix.
- Each console command is equivalent to a class method.
- Named arguments that are sent when you invoke a command are received in the first argument of the method corresponding to the command.
- Sequential arguments, which are sent to invoke a command, are received as arguments to the invoked method subsequent to the first argument.
- If he it is not specified the command to run, run by default the "main" method of the class.
- Classes Load, Config and Util are loaded automatically to the console.
- The constants APP_PATH, CORE_PATH and PRODUCTION; they are defined for the console environment. 

Example:

Consider a part of the code, the cache console, whose functionality was explained in the previous section.

    <?php
    
    Load::lib('cache');
    
    class CacheConsole
    
    {
    
        public function clean($params, $group = FALSE)
    
        {
    
            // obtiene el driver de cache
    
            if (isset($params['driver'])) {
    
                $cache = Cache::driver($params['driver']);
    
            } else {
    
                $cache = Cache::driver()    
    
            }
    
            // limpia la cache
    
            if ($cache->clean($group)) {
    
                if ($group) {
    
                    echo "-> Se ha limpiado el grupo $group", PHP_EOL;
    
                    } else {
    
                    echo "-> Se ha limpiado la cache", PHP_EOL;
    
                    }
    
            } else {
    
                throw new KumbiaException('No se ha logrado eliminar el contenido');
    
            }
    
        }
    
    }
    
    

### Console::input

Este método de la clase Console, permite leer una entrada desde el terminal, se caracteriza por intentar leer la entrada hasta que esta sea valida.

`Console::input($message, $values = null)`

$message (string): mensaje a mostrar al momento de solicitar la entrada.

$values (array): conjunto de valores validos para la entrada.

Ejemplo:

`$valor = Console::input('¿Desea continuar?', array('s', 'n'));`

* * *