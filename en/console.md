# The console

## Intro

The console, is a tool for command line of KumbiaPHP, allowing to perform automated task in the scope of your app. In this way KumbiaPHP includes the following consoles: Cache, Model and Controller.

Each console is composed of a set of commands, each command can receive sequences arguments and named arguments. To indicate a named argument is must use the prefix "\--" to the argument.

## How to use the console?

For use of the console must be executed the dispatcher console of KumbiaPHP in a terminal, placed in the directory "app" of the application and execute the instruction according the following format:

`php .../../core/console/kumbia.php [console] [command] [arg] [\--arg_name] = value`

* * *

If not specified the command to run, then run the console command "main".

It is also possible to explicitly indicate the path to the app in the application directory using the named "path" argument.

Examples:

`php .../../core/console/kumbia.php cache clean --driver=sqlite`

`php kumbia.php cache clean --driver=sqlite --path="/ var/www/app"`

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

### php .../../core/console/kumbia.php cache clean

* * *

#### remove \[id\] \[group\]

Removes an element from the cache.

Sequential arguments:

- id: id element in the cache.
- group: name of group to which belongs the element, specifying no value, then use the 'default' group.

Named arguments:

- driver: driver cache corresponding to the cache cleaning (nixfile, file, sqlite, APC).

Example:

`php ../../core/console/kumbia.php cache remove viewclient my_views`

* * *

### Model

It allows you to manipulate the application models.

#### create [model]

Create a model using as a base the template located at "core/console/generators/model.php".

Sequential arguments:

- model: model name in smallcase.

Example:

`php ../../core/console/kumbia.php model create simple_auth`

* * *

#### delete [model]

Delete a model.

Sequential arguments:

- model: model name in smallcase.

Example:

`php ../../core/console/kumbia.php model delete simple_auth`

* * *

### Controller

It allows you to manipulate the application controllers.

#### create [controller]

Create a controller using as a basis the located in the 'core/console/generators/controller.php' template.

Sequential arguments:

- controller: controller name in smallcase.

Example:

`php ../../core/console/kumbia.php controller create product_sales`

* * *

#### delete [controller]

Delete controller.

Sequential arguments:

- controller: controller name in smallcase.

Example:

`php ../../core/console/kumbia.php controller delete product_sales`

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
- Classes Load, Config and useful; they are loaded automatically to the console.
- The constants APP_PATH, CORE_PATH and PRODUCTION; they are defined for the console environment. 

Example:

Consider a part of the code, the cache console, whose functionality was explained in the previous section.

    & Lt;? Php
    
    Load :: lib ('cache');
    
    Class CacheConsole
    
    {
    
        Public function clean ($ params, $ group = FALSE)
    
        {
    
            // get the cache driver
    
            If (isset ($ params ['driver'])) {
    
                $ Cache = Cache :: driver ($ params ['driver']);
    
            } Else {
    
                $ Cache = Cache :: driver ()
    
            }
    
            // clear the cache
    
            If ($ cache-> clean ($ group)) {
    
                If ($ group) {
    
                    Echo "-> The group $ group has been cleaned, PHP_EOL;
    
                    } Else {
    
                    Echo "-> The cache has been cleared", PHP_EOL;
    
                    }
    
            } Else {
    
                Throw new KumbiaException ('Unable to delete content');
    
            }
    
        }
    
    }
    
    

### Console::input

This method of the Console class, allows you to read an input from the terminal, characterized by trying to read the entry until it is valid.

`Console::input($message, $values = null)`

$message (string): message to be displayed when this method requests an entry.

$values (array): conjunto de valores válidos para la entrada.

Example:

`$answer = Console:input ('Continue?', array ('s ', 'n'));`

* * *