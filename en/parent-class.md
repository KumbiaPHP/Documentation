# Parent classes

## AppController

## View

...

# Libs of KumbiaPHP

Kumbiaphp have ready-to-use classes, but remember that you can create your own classes to reuse them in your projects. You can also use external KumbiaPHP classes, as explained in the next chapter.

## Cache

A cache is a set of duplicate data of other originals, with the property that the original data are costly to access, usually in time, with respect to the copy in the cache.

The cache data is implemented in KumbiaPHP using factory and singleton design patterns. To make use of the cache, it is necessary to have write permissions in the "cache" directory (only in the case of the handlers "sqlite" and "file").

Each cache is controlled by a cache handler. The system cache KumbiaPHP has currently the following handlers:

* APC: use Alternative PHP Cache.
* file: cache files, these are stored in the directory cache and compatible with all operating systems.
* nixfile: cache files, these are stored in the directory cache and compatible only with operating systems \*nix (linux, freebsd, and others). This cache is more fast cache «file».
* sqlite: cache using SqLite database and this is located in the cache directory.

To obtain a cache handler you must use the method «driver» which provides the Cache class.

### driver($driver=null)

This method allows to obtain a cache handler specific (APC, file, nixfile, sqlite, memsqlite). If not indicated, gets cache handler by default indicated in the config.ini.

<?php  
// cache por defecto  
$data = Cache:: driver ()-> get ( 'data' ); // manejador para memcache $data_memcache = Cache:: driver ( 'memcache' )-> get ( 'data' ); // manejador para cache con APC $data_apc = Cache:: driver ( 'APC' )-> get ( 'data' ); \--- ### get($id, $group='default') Permite obtener un valor almacenado en la cache; es necesario especificar el parámetro $id con el "id" correspondiente al valor en cache, tomando de manera predeterminada el grupo "default". ### save($value, $lifetime=null, $id=false, $group='default') Permite guardar un valor en la cache, el tiempo de vida del valor en cache se debe especificar utilizando el formato de la funcion \[strtotime\](http://www.go ogle.com/url?q=http%3A%2F%2Fphp.net%2Fmanual%2Fes%2Ffunction.strtotime.php&sa= D&sntz=1&usg=AFQjCNH8Gfguulpd1VXJunl_FfDbd4Mc8w) de php. Al omitir parámetros al invocar el método save se comporta de la manera siguiente: * Si no se especifica $lifetime , entonces se cachea por tiempo indefinido. * Si no se especifica $id y $group , entonces se toma los indicados al invocar por última vez el método get . 

<?php

$data = Cache::driver()->get('saludo'); if(!$data) { Cache::driver()->save('Hola', '+1 day'); } echo $data; \--- ### start ($lifetime, $id, $group='default') Muestra buffer de salida cacheado, o en caso contrario inicia cacheo de buffer de salida hasta que se invoque el método end. Este método se utiliza frecuentemente para cachear un fragmento de vista. 

<?php if(Cache::driver()->start('+1 day', 'saludo')): ?> 

    Hello <? php echo $usuario? > <? php Cache:driver()-> end()? >
    

<?php endif; ?>

* * *

### end ($save = true)

End caching output buffer indicating if it should be kept or not in the cache.

* * *

## Logger

The Logger class for handling \[Log\] (http://www.google.com/url?q=http%3A%2F %2Fes.wikipedia.org%2Fwiki%2FLog_\(registro\) & sa = D & sntz = 1 & usg = AFQjCNGft16YEbrl ayLoKbZFpNDBDXgXAA) was rewritten statically, this means no longer necessary to create an instance of the Logger class. This class offers a variety of methods to handle different types of Log.

<?php  Logger:: error ( 'Mensaje de Error' ) ?>

* * *

The previous statement will output the following:

\[Thu, 05 Feb 09 15:19:39-0500\]\[ERROR\] Error message

By default the log files have the name logDDMMYYY.txt this name can be changed if we so wish it through an additional parameter to the method.

<?php  Logger:: error ( 'Mensaje de Error' , 'mi_log' ) ?>

* * *

You can see the second parameter now the file will be named mi_log.txt

### Logger:warning ($msg);

### Logger:error ($msg)

### Logger:debug ($msg)

### Logger:alert ($msg)

### Logger: critical ($msg)

### Logger:notice ($msg)

### Logger:info ($msg)

### Logger::emergence ($msg)

### Logger::custom ($type = 'CUSTOM', $msg)

* * *

## Flash

Flash is a very useful helper in Kumbia that makes the messages of error, warning, informational and success output as standard.

### Flash::error ($text)

— Send an error message to the user. Default is a message of letters red and pink background but these can be altered in the cascading style sheet class in public /css/style.css called error.

Flash::error ("an error occurred");

* * *

### Flash::valid ($text)

It allows to send a success message to the user. Default is a lyrics color message green and pastel green color background but these can be altered in the cascading style sheet class in public/css/style.css called valid.

Flash::valid("Se realizo el proceso correctamente");

* * *

### Flash::info($text)

It allows you to send information to the user. Default is a message of letters color blue and blue pastel-coloured background; but these can be altered in the cascading style sheet class in public/css/style.css called info.

Flash::info("No hay resultados en la busqueda");

* * *

### Flash::warning($text)

It allows to send a warning message to the user. Default is a message of letters color blue and pastel blue color background but these can be altered in the cascading style sheet class in public/css/style.css called warning.

Flash::warning("Advertencia: No ha iniciado sesión en el sistema");

* * *

### Flash::show($name, $text)

...

* * *

## Session

The Session class is to facilitate handling of the session.

### Session:set($index,_$value,_$namespace='default')

Create or specify the value for an index of the current session.

<?php  Session:: set ( 'usuario' , 'Administrador' ); ?>

* * *

### Session: get ($index, $namespace ='default ')

Get the value for an index of the current session.

<?php  
Session:: get ( 'usuario' ); //retorna 'Administrador'  
?>

* * *

### Session:delete($index,_$namespace='default')

Deletes the value for an index of the current session.

<?php  Session:: delete ( 'usuario' ); ?>

* * *

### Session:has($index,_$namespace='default')

Verify that this set the rate at the current session.

<?php  
Session:: has ( 'id_usuario' ); //retorna false.  
?>

* * *

Note: $namespace is a single space in which may contain the session variables, avoiding collisions with variable names.

## Load

Class load allows the loading of libraries in KumbiaPHP.

### Load::coreLib ($lib)

It allows to load a KumbiaPHP core library.

<?php

// Carga la librería cache

Load::coreLib('cache');


  
---  
  
###  Load::lib($lib)

Permite cargar una librería de aplicación. Las librerías de aplicación se
ubican en el directorio "app/libs".

<?php

// Carga el archivo app/libs/split.php

Load::lib('split');


  
---  
  
En caso de que no exista la librería intenta cargar una del núcleo con el
nombre indicado.

<?php

/* Carga el archivo "app/libs/auth2.php" si existe, en caso contrario, cargara
la librería del núcleo auth2 */

Load::lib('auth2');


  
---  
  
Para agrupar librerías debes colocarlas en un subdirectorio y anteceder el
nombre del directorio en la ruta al momento de cargarla.

<?php

// Carga el archivo app/libs/controllers/auth_controller.php

Load::lib('controllers/auth_controller.php');


  
---  
  
###  Load::model($model)

Carga e instancia el modelo indicado. Retorna la instancia del modelo.

<?php

// Carga e instancia el modelo usuario.php

$usuario = Load::model('usuario');


  
---  
  
Para agrupar modelos debes colocarlos en un subdirectorio y anteceder el
nombre del directorio en la ruta al momento de cargarlo.

<?php

// Carga e instancia el modelo 'partes_vehiculo/motor.php"

$motor = Load::model('partes_vehiculo/motor.php');


  
---  
  
##  Auth2

Esta clase permite manejar autenticación de usuarios, con este fin se utilizan
adaptadores para tipos especializados de autenticación.

###  Solicitando un adaptador

Para solicitar un adaptador se hace uso del método estático "factory", dicho
método recibe como argumento el tipo de adaptador a utilizar. En caso de no
indicarse el tipo de adaptador se utiliza el adaptador predeterminado.

Ejemplo:

<?php

$auth = Auth2::factory('model');


  
---  
  
Los siguientes adaptadores se encuentran implementados:

  * Model : permite tomar como fuente de datos un modelo ActiveRecord. Debe indicarse en el argumento de factory "model".

###  Adaptador predeterminado

El adaptador predeterminado es "model", sin embargo esto se puede modificar
utilizando el método estático setDefault .

$adapter (string): nombre de adaptador

setDefault($adapter)

Ejemplo:

Auth2::setDefault('model');
  
---  
  
###  Como trabaja la autenticacion

El método identify  verifica si existe una sesión autenticada previa, en caso
contrario toma de $_POST el usuario y clave de acceso, y verifica el usuario y
la clave encriptada contra la fuente de datos. De manera predeterminada la
clave es encriptada utilizando md5.

Para poder efectuar la autenticación debe existir una variable $_POST['mode']
cuyo valor debe ser "auth".

El formulario para autenticación debe tener la siguiente estructura básica:

<?php echo Form::open() ?>

    <input name="mode" type="hidden" value="auth">
    
    <label for="login">Usuario:</label>
    
    <?php echo Form::text('login') ?>
    
    <label for="password">Clave:</label>
    
    <?php echo Form::pass('password') ?>
    

<?php echo Form::close() ?>

* * *

Default Auth2 takes the "login" field for the user name and the password 'password' field.

To be able to start a user session and perform the authentication you must invoke the identify method, however depending on the adapter type, it is necessary to specify certain configuration settings.

### Adapter Model

This adapter allows you to use authentication based on a model which inherits from the ActiveRecord class, verifying authentication at the database data.

#### setModel()

Sets the ActiveRecord model that is used as a data source. By default the model that is used as a data source is 'users'.

$model (string): model name in lowercase

setModel ($model)

Example:

$auth->setModel ('user');

* * *

#### identify()

Performs the authentication. If there is already an active user session or user data are correct, then the identification is satisfactory.

return true or false

identify()

Ejemplo:

$valid = $auth->identify();

* * *

#### logout()

Termina la sesion de usuario.

logout()

Example:

$auth->logout();

* * *

#### setFields()

Sets the fields of the model that are loaded into session using the Session:set method. By default load the field 'id'.

$fields (array): arreglo de campos

setFields($fields)

Example:

$auth->setFields (array ('id', 'user'));

* * *

#### setSessionNamespace()

Establece un namespace para los campos que se cargan en sesión.

$namespace (string): namespace de sesión

setSessionNamespace($namespace)

Example:

$auth->setSessionNamespace ('auth');

* * *

#### isValid()

Check if there is an authenticated user session.

return true or false

isValid()

Example:

$valid = $auth->isValid();

* * *

#### getError()

Gets the error message.

return string

getError()

Example:

if(!$auth->identify()) flash:error ($auth->getError());

* * *

#### setAlgos()

Sets the user password encryption method.

$algos (string): method of encryption, the name matches the php hash function.

setAlgos ($algos)

Example:

$auth->setAlgos ('md5');

* * *

#### setKey()

Sets the key to identifying whether a session authenticated, this key takes a Boolean value of "true" when the authenticated session is valid, assigned by using the Session:set method.

$key (string): clave de sesión

setKey($key)

Ejemplo:

$auth->setKey('usuario_logged');

* * *

#### setCheckSession()

Indica que no se inicie sesión desde un navegador distinto con la misma IP.

$check (boolean): indicador

setCheckSession($check)

Ejemplo:

$auth->setCheckSession(true);

* * *

#### setPass()

Assigns the name of field for the key field. This field must correspond with the data base and the form field. Default is "password".

$field (string): name of field that receives by POST.

setPass($field)

Example:

$auth->setPass('key');

* * *

#### setLogin()

Assigns the name of the field for the user name field. This field must correspond with the data base and the form field. Default is "login".

$field (string): nombre de campo que recibe por POST.

setLogin($field)

Ejemplo:

$auth->setLogin('usuario');

* * *

#### Obtener los campos cargados en sesión

Los campos se obtienen por medio del método Session::get .

$id = Session::get('id');

* * *

Si se ha especificado un namespace de sesión, entonces debe indicarlo al invocar el método.

$id = Session::get('id', 'mi_namespace');

* * *

#### Ejemplo

La vista:

app/views/acceso/login.phtml

<?php echo Form::open() ?>

    <input name="mode" type="hidden" value="auth">
    
    <label for="login">Usuario:</label>
    
    <?php echo Form::text('login') ?>
    
    <label for="password">Clave:</label>
    
    <?php echo Form::pass('password') ?>
    

<?php echo Form::close() ?>

* * *

Controller:

app/controllers/auth_controller.php

<?php

class AuthController extends AppController

{

    public function login()

    {

        // Si se loguea se redirecciona al modulo de cliente

        if(Load::model('usuario')->login()) { Router::toAction('usuario/panel'); } } public function logout() { // Termina la sesion Load::model('usuario')->logout(); Router::toAction('login'); } } ?> 

* * *

To validate this authenticated the user, just add the following code in any controller action or method before_filter:

if(!Load::model('user')->logged()) {

    Router:toAction('auth/login');
    
    
    return false;
    

}

* * *

Model:

app/models/usuario.php

<? php

The auth2 library loading

Load: lib ('auth2');

class user extends ActiveRecord

{

    / * * Log * * / public function login() {/ / Gets the adapter $auth = Auth2:factory('model');}      Model to be used for $auth - > setModel ('user');      if($auth->identify()) return true;        Flash:error($auth->getError());      return false;  } / * * End * * / public function logout() {Auth2:factory('model') - > logout();}  } / * * Check if this authenticated user * @return boolean * / public function logged() {return Auth2:factory('model') - > isValid();}  }
    

}