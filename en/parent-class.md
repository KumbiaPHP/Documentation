# Parent classes

## AppController

## ActiveRecord

It is the main class for the Administration and operation of models. ActiveRecord is an implementation of this programming pattern and is heavily influenced by the functionality of its analog avaiable in Ruby on Rails. ActiveRecord provides object-relational layer that strictly follows the standard ORM: tables in classes, objects records, and fields in attributes. Facilitates the understanding of the code associated with the database and encapsulates the logic specified making it easier to use for the programmer.

<?php  
$cliente = Load:: model ( 'cliente' );  
$cliente -> nit = "808111827-2" ; $cliente -> razon_social = "EMPRESA DE TELECOMUNICACIONES XYZ" $cliente -> save (); \--- ### Ventajas del ActiveRecord * Se trabajan las entidades del Modelo mas Naturalmente como objetos. * Las acciones como Insertar, Consultar, Actualizar, Borrar, etc. de una entidad del Modelo están encapsuladas así que se reduce el código y se hace mas fácil de mantener. * Código más fácil de Entender y Mantener * Reducción del uso del SQL en un 80%, con lo que se logra un alto porcentaje de independencia del motor de base de datos. * Menos "detalles", más práctico y util * ActiveRecord protege en un gran porcentaje de ataques de SQL inyection que puedan llegar a sufrir tus aplicaciones escapando caracteres que puedan facilitar estos ataques. ### Crear un Modelo en Kumbia PHP Framework Lo primero es crear un archivo en el directorio models con el mismo nombre de la relación en la base de datos. Por ejemplo: models/clientes.php Luego creamos una clase con el nombre de la tabla extendiendo alguna de las clases para modelos. Ejemplo: 

<?php  
class  Cliente extends  ActiveRecord {  
}  
  
---  
  
Si lo que se desea es crear un modelo de una clase que tiene nombre compuesto
por ejemplo la clase Tipo de Cliente , por convención en nuestra base de datos
esta tabla debe llamarse: tipo_de_cliente  y el archivo:
models/tipo_de_cliente.php y el código de este modelo es el siguiente:

<?php  
class  TipoDeCliente extends  ActiveRecord {  
}  
  
---  
  
### Columnas y Atributos

Objetos ActiveRecord  corresponden a registros en una tabla de una base de
datos. Los objetos poseen atributos que corresponden a los campos en estas
tablas. La clase ActiveRecord  automáticamente obtiene la definición de los
campos de las tablas y los convierte en atributos de la clase asociada. A esto
es lo que nos referíamos con mapeo objeto relacional.

Miremos la tabla Álbum:

CREATE TABLE album (

id INTEGER NOT NULL AUTO_INCREMENT,  
nombre VARCHAR(100) NOT NULL,  
fecha DATE NOT NULL,  
valor DECIMAL(12,2) NOT NULL,  
artista_id INTEGER NOT NULL,  
estado CHAR(1),  
PRIMARY KEY(id)

)  
  
---  
  
Podemos crear un ActiveRecord  que mapee esta tabla:

<?php  
class  Album extends  ActiveRecord {  
}  
  
---  
  
Una instancia de esta clase sera un objeto con los atributos de la tabla
album:

<?php  
  
$album = Load:: model ( 'album' );  
$album-> id = 2; $album-> nombre = "Going Under"; $album-> save (); \--- O con... 

<?php  

  
Load:: models ( 'album' );  
  
$album = new  Album();  
$album-> id = 2; $album-> nombre = "Going Under"; $album-> save (); \--- ### Llaves Primarias y el uso de IDs En los ejemplos mostrados de KumbiaPHP siempre se trabaja una columna llamada id como llave primaria de nuestras tablas. Tal vez, esto no siempre es practico a su parecer, de pronto al crear la tabla clientes la columna de numero de identificación seria una excelente elección, pero en caso de cambiar este valor por otro tendría problemas con el dato que este replicado en otras relaciones (ejemplo facturas), además de esto tendría que validar otras cosas relacionadas con su naturaleza. KumbiaPHP propone el uso de ids como llaves primarias con esto se automatiza muchas tareas de consulta y proporciona una forma de referirse unívocamente a un registro en especial sin depender de la naturaleza de un atributo especifico. Usuarios de Rails se sentirán familiarizados con esta característica. Esta particularidad también permite a KumbiaPHP entender el modelo entidad relación leyendo los nombres de los atributos de las tablas. Por ejemplo en la tabla album del ejemplo anterior la convención nos dice que id es la llave primaria de esta tabla pero además nos dice que hay una llave foránea a la tabla artista en su campo id. ### Convenciones en ActiveRecord ActiveRecord posee una serie de convenciones que le sirven para asumir distintas cualidades y relacionar un modelo de datos. Las convenciones son las siguientes: id Si ActiveRecord encuentra un campo llamado id , ActiveRecord asumira que se trata de la llave primaria de la entidad y que es auto-numérica. tabla_id Los campos terminados en _id indican relaciones foráneas a otras tablas, de esta forma se puede definir fácilmente las relaciones entre las entidades del modelo: Un campo llamado clientes_id en una tabla indica que existe otra tabla llamada clientes y esta contiene un campo id que es foránea a este. campo_at Los campos terminados en _at indican que son fechas y posee la funcionalidad extra que obtienen el valor de fecha actual en una inserción created_at es un campo fecha campo_in Los campos terminados en _in indican que son fechas y posee la funcionalidad extra que obtienen el valor de fecha actual en una actualización modified_in es un campo fecha NOTA: Los campos _at y _in deben ser de tipo fecha (date) en la RDBMS que se este utilizando. ## View ... # Libs de KumbiaPHP Kumbiaphp lleva clases listas para usar, pero recordad que podéis crearos vuestras propias clases para reutilizarlas en vuestros proyectos.También podéis usar clases externas a KumbiaPHP, como se explica en el próximo capítulo. ## Cache Un cache es un conjunto de datos duplicados de otros originales, con la propiedad de que los datos originales son costosos de acceder, normalmente en tiempo, respecto a la copia en la cache. El cache de datos esta implementado en KumbiaPHP utilizando los patrones de diseño factory y singleton. Para hacer uso de la cache es necesario tener permisos de escritura en el directorio "cache" (solamente en el caso de los manejadores "sqlite" y "file"). Cada cache es controlada por un manejador de cache. El sistema de cache de KumbiaPHP actualmente posee los siguientes manejadores: * APC : utiliza Alternative PHP Cache. * file : cache en archivos, estos se almacenan en el directorio cache y compatible con todos los sistemas operativos. * nixfile : cache en archivos, estos se almacenan en el directorio cache y compatible solo con sistemas operativos *nix (linux, freebsd, entre otros). Esta cache es mas rapida que la cache «file». * sqlite : cache utilizando base de datos SqLite y esta se ubica en el directorio cache. Para obtener un manejador de cache se debe utilizar el método «driver» que proporciona la clase Cache. ### driver($driver=null) Este método permite obtener un manejador de cache especifico (APC, file, nixfile, sqlite, memsqlite). Si no se indica, se obtiene el manejador de cache por defecto indicado en el config.ini. 

<?php  
// cache por defecto  
$data = Cache:: driver ()-> get ( 'data' ); // manejador para memcache $data_memcache = Cache:: driver ( 'memcache' )-> get ( 'data' ); // manejador para cache con APC $data_apc = Cache:: driver ( 'APC' )-> get ( 'data' ); \--- ### get($id, $group='default') Permite obtener un valor almacenado en la cache; es necesario especificar el parámetro $id con el "id" correspondiente al valor en cache, tomando de manera predeterminada el grupo "default". ### save($value, $lifetime=null, $id=false, $group='default') Permite guardar un valor en la cache, el tiempo de vida del valor en cache se debe especificar utilizando el formato de la funcion \[strtotime\](http://www.go ogle.com/url?q=http%3A%2F%2Fphp.net%2Fmanual%2Fes%2Ffunction.strtotime.php&sa= D&sntz=1&usg=AFQjCNH8Gfguulpd1VXJunl_FfDbd4Mc8w) de php. Al omitir parámetros al invocar el método save se comporta de la manera siguiente: * Si no se especifica $lifetime , entonces se cachea por tiempo indefinido. * Si no se especifica $id y $group , entonces se toma los indicados al invocar por última vez el método get . 

<?php

$data = Cache::driver()->get('saludo'); if(!$data) { Cache::driver()->save('Hola', '+1 day'); } echo $data; \--- ### start ($lifetime, $id, $group='default') Muestra buffer de salida cacheado, o en caso contrario inicia cacheo de buffer de salida hasta que se invoque el método end. Este método se utiliza frecuentemente para cachear un fragmento de vista. 

<?php if(Cache::driver()->start('+1 day', 'saludo')): ?> 

    Hola <?php echo $usuario ?>
    
    <?php Cache::driver()->end() ?>
    

<?php endif; ?>

* * *

### end ($save=true)

End caching output buffer indicating if it should be kept or not in the cache.

* * *

## Logger

La clase Logger para el manejo de \[Log\](http://www.google.com/url?q=http%3A%2F %2Fes.wikipedia.org%2Fwiki%2FLog_\(registro\)&sa=D&sntz=1&usg=AFQjCNGft16YEbrl ayLoKbZFpNDBDXgXAA) fue reescrita de forma estática, esto quiere decir ya no es necesario crear una instancia de la clase Logger. Esta clase dispone de una variedad de métodos para manejar distintos tipos de Log.

<?php  Logger:: error ( 'Mensaje de Error' ) ?>

* * *

The previous statement will output the following:

\[Thu, 05 Feb 09 15:19:39-0500\]\[ERROR\] Error message

By default the log files have the name logDDMMYYY.txt this name can be changed if we so wish it through an additional parameter to the method.

<?php  Logger:: error ( 'Mensaje de Error' , 'mi_log' ) ?>

* * *

You can see the second parameter now the file will be named mi_log.txt

### Logger::warning ($msg);

### Logger::error ($msg)

### Logger::debug ($msg)

### Logger::alert ($msg)

### Logger::critical ($msg)

### Logger::notice ($msg)

### Logger::info ($msg)

### Logger::emergence ($msg)

### Logger::custom ($type='CUSTOM', $msg)

* * *

## Flash

Flash es un helper muy útil en Kumbia que permite hacer la salida de mensajes de error, advertencia, informativos y éxito de forma estándar.

### Flash::error($text)

Permite enviar un mensaje de error al usuario. Por defecto es un mensaje de letras color rojo y fondo color rosa pero estos pueden ser alterados en la clase css en public /css/style.css llamada error.

Flash::error("Ha ocurrido un error");

* * *

### Flash::valid($text)

Permite enviar un mensaje de éxito al usuario. Por defecto es un mensaje de letras color verdes y fondo color verde pastel pero estos pueden ser alterados en la clase css en public/css/style.css llamada valid .

Flash::valid("Se realizo el proceso correctamente");

* * *

### Flash::info($text)

Permite enviar un mensaje de información al usuario. Por defecto es un mensaje de letras color azules y fondo color azul pastel; pero estos pueden ser alterados en la clase css en public/css/style.css llamada info .

Flash::info("No hay resultados en la busqueda");

* * *

### Flash::warning($text)

Permite enviar un mensaje de advertencia al usuario. Por defecto es un mensaje de letras color azules y fondo color azul pastel pero estos pueden ser alterados en la clase css en public/css/style.css llamada warning .

Flash::warning("Advertencia: No ha iniciado sesión en el sistema");

* * *

### Flash::show($name, $text)

...

* * *

## Session

La clase Session es para facilitar el manejo de la sesiones.

### Session::set($index, $value, $namespace='default')

Crear o especifica el valor para un índice de la sesión actual.

<?php  Session:: set ( 'usuario' , 'Administrador' ); ?>

* * *

### Session::get($index, $namespace='default')

Obtener el valor para un índice de la sesión actual.

<?php  
Session:: get ( 'usuario' ); //retorna 'Administrador'  
?>

* * *

### Session::delete($index, $namespace='default')

Elimina el valor para un índice de la sesión actual.

<?php  Session:: delete ( 'usuario' ); ?>

* * *

### Session::has($index, $namespace='default')

Verifica que este definido el índice en la sesión actual.

<?php  
Session:: has ( 'id_usuario' ); //retorna false.  
?>

* * *

NOTA: $namespace es un espacio individual en el cual se pueden contener las variables de sesión, permitiendo evitar colisiones con nombres de variables.

## Load

La clase load permite la carga de librerías en KumbiaPHP.

### Load::coreLib($lib)

Permite cargar una librería del núcleo de KumbiaPHP.

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

De manera predeterminada Auth2 toma para el nombre de usuario el campo "login" y para la clave el campo "password".

Para poder iniciar una sesión de usuario y realizar la autenticación se debe invocar el método identify , sin embargo dependiendo del tipo de adaptador, es necesario especificar ciertos parámetros de configuración.

### Adaptador Model

Este adaptador permite utilizar autenticación en base a un modelo que herede de la clase ActiveRecord , verificando los datos de autenticación en la base de datos.

#### setModel()

Establece el modelo ActiveRecord que se utiliza como fuente de datos. De manera predeterminada el modelo que se utiliza como fuente de datos es 'users'.

$model (string): nombre de modelo en smallcase

setModel($model)

Ejemplo:

$auth->setModel('usuario');

* * *

#### identify()

Realiza la autenticación. Si ya existe una sesión de usuario activa o los datos de usuario son correctos, entonces la identificación es satisfactoria.

return boolean

identify()

Ejemplo:

$valid = $auth->identify();

* * *

#### logout()

Termina la sesion de usuario.

logout()

Ejemplo:

$auth->logout();

* * *

#### setFields()

Establece los campos del modelo que se cargaran en sesión mediante el método Session::set . De manera predeterminada se carga el campo "id".

$fields (array): arreglo de campos

setFields($fields)

Ejemplo:

$auth->setFields(array('id', 'usuario'));

* * *

#### setSessionNamespace()

Establece un namespace para los campos que se cargan en sesión.

$namespace (string): namespace de sesión

setSessionNamespace($namespace)

Ejemplo:

$auth->setSessionNamespace('auth');

* * *

#### isValid()

Verifica si existe una sesión de usuario autenticado.

return boolean

isValid()

Ejemplo:

$valid = $auth->isValid();

* * *

#### getError()

Obtiene el mensaje de error.

return string

getError()

Ejemplo:

if(!$auth->identify()) Flash::error($auth->getError());

* * *

#### setAlgos()

Establece el método de encriptación de la clave de usuario.

$algos (string): método de encriptación, el nombre coincide con la función hash de php.

setAlgos($algos)

Ejemplo:

$auth->setAlgos('md5');

* * *

#### setKey()

Establece la clave para identificar si existe una sesión autenticada, dicha clave toma un valor booleano "true" cuando la sesión autenticada es valida, asignada mediante el método Session::set .

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

Asigna el nombre de campo para el campo de clave. Este campo debe corresponder con el campo de la base de datos y del formulario. De manera predeterminada es "password".

$field (string): nombre de campo que recibe por POST.

setPass($field)

Ejemplo:

$auth->setPass('clave');

* * *

#### setLogin()

Asigna el nombre de campo para el campo de nombre de usuario. Este campo debe corresponder con el campo de la base de datos y del formulario. De manera predeterminada es "login".

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

El controlador:

app/controllers/auth_controller.php

<?php

class AuthController extends AppController

{

    public function login()

    {

        // Si se loguea se redirecciona al modulo de cliente

        if(Load::model('usuario')->login()) { Router::toAction('usuario/panel'); } } public function logout() { // Termina la sesion Load::model('usuario')->logout(); Router::toAction('login'); } } ?> 

* * *

Para validar que el usuario este autenticado, basta con adicionar en cualquier acción del controlador o en el método before_filter el siguiente código:

if(!Load::model('usuario')->logged()) {

    Router::toAction('auth/login');
    
    return false;
    

}

* * *

El modelo:

app/models/usuario.php

<?php

// Carga de la librería auth2

Load::lib('auth2');

class Usuario extends ActiveRecord

{

    /**
    
     * Iniciar sesión
    
     *
    
     */
    
    public function login()
    
    {
    
        // Obtiene el adaptador
    
        $auth = Auth2::factory('model');
    
        // Modelo que utilizara para consultar
    
        $auth->setModel('usuario');
    
        if($auth->identify()) return true;
    
    
    
        Flash::error($auth->getError());
    
        return false;
    
    }
    
    /**
    
     * Terminar sesión
    
     *
    
     */
    
    public function logout()
    
    {
    
        Auth2::factory('model')->logout();
    
    }
    
    /**
     * Verifica si el usuario esta autenticado
     *
     * @return boolean
     */
    
    public function logged()
    
    {
    
        return Auth2::factory('model')->isValid();
    
    }
    

}