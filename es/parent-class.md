#  7 Clases padre

##  7.1 AppController

##  7.2 ActiveRecord

Es la principal clase para la administracion y funcionamiento de modelos.
ActiveRecord  es una implementacion de este patron de programacion y esta muy
influenciada por la funcionalidad de su analoga en Ruby disponible en Rails.
ActiveRecord  proporciona la capa objeto-relacional que sigue rigurosamente el
estandar ORM: Tablas en Clases, Registros en Objetos, y Campos en Atributos.
Facilita el entendimiento del codigo asociado a base de datos y encapsula la
logica especifica haciendola mas facil de usar para el programador.

<?php  
$cliente = Load:: model ( 'cliente' );  
$cliente -> nit  = "808111827-2" ;  
$cliente -> razon_social  = "EMPRESA DE TELECOMUNICACIONES XYZ"  
$cliente -> save ();  
  
---  
  
###  7.2.1.         Ventajas del ActiveRecord

  * Se trabajan las entidades del Modelo mas Naturalmente como objetos.
  * Las acciones como Insertar, Consultar, Actualizar, Borrar, etc. de una entidad del Modelo estan encapsuladas asi que se reduce el codigo y se hace mas facil de mantener.
  * Codigo mas facil de Entender y Mantener
  * Reduccion del uso del SQL en un 80%, con lo que se logra un alto porcentaje de independencia del motor de base de datos.
  * Menos "detalles" mas practicidad y utilidad
  * ActiveRecord protege en un gran porcentaje de ataques de SQL inyection que puedan llegar a sufrir tus aplicaciones escapando caracteres que puedan facilitar estos ataques.

###  7.2.2.         Crear un Modelo en Kumbia PHP Framework

Lo primero es crear un archivo en el directorio models con el mismo nombre de
la relacion en la base de datos. Por ejemplo: models/clientes.php  Luego
creamos una clase con el nombre de la tabla extendiendo alguna de las clases
para modelos.

Ejemplo:

<?php  
class  Cliente extends  ActiveRecord {  
}  
  
---  
  
Si lo que se desea es crear un modelo de una clase que tiene nombre compuesto
por ejemplo la clase Tipo de Cliente , por convencion en nuestra base de datos
esta tabla debe llamarse: tipo_de_cliente  y el archivo:
models/tipo_de_cliente.php y el codigo de ese modelo el siguiente:

<?php  
class  TipoDeCliente extends  ActiveRecord {  
}  
  
---  
  
###  7.2.3.         Columnas y Atributos

Objetos ActiveRecord  corresponden a registros en una tabla de una base de
datos. Los objetos poseen atributos que corresponden a los campos en estas
tablas. La clase ActiveRecord  automaticamente obtiene la definicion de los
campos de las tablas y los convierte en atributos de la clase asociada. A esto
es lo que nos referiamos con mapeo objeto relacional.

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
$album-> id  = 2;  
$album-> nombre  = "Going Under";  
$album-> save ();  
  
---  
  
O con...

<?php  

  
Load:: models ( 'album' );  
  
$album = new  Album();  
$album-> id  = 2;  
$album-> nombre  = "Going Under";  
$album-> save ();  
  
---  
  
###  7.2.4.        Llaves Primarias y el uso de IDs

En los ejemplos mostrados de KumbiaPHP siempre se trabaja una columna llamada
id como llave primaria de nuestras tablas. Tal vez, esto no siempre es
practico a su parecer, de pronto al crear la tabla clientes la columna de
numero de identificacion seria una excelente eleccion, pero en caso de cambiar
este valor por otro tendria problemas con el dato que este replicado en otras
relaciones (ejemplo facturas), ademas de esto tendria que validar otras cosas
relacionadas con su naturaleza. KumbiaPHP propone el uso de ids como llaves
primarias con esto se automatiza muchas tareas de consulta y proporciona una
forma de referirse univocamente a un registro en especial sin depender de la
naturaleza de un atributo especifico. Usuarios de Rails se sentiran
familiarizados con esta caracteristica.

Esta particularidad tambien permite a KumbiaPHP entender el modelo entidad
relacion leyendo los nombres de los atributos de las tablas. Por ejemplo en la
tabla album del ejemplo anterior la convencion nos dice que id es la llave
primaria de esta tabla pero ademas nos dice que hay una llave foranea a la
tabla artista en su campo id.

###  7.2.5.         Convenciones en ActiveRecord

ActiveRecord posee una serie de convenciones que le sirven para asumir
distintas cualidades y relacionar un modelo de datos. Las convenciones son las
siguientes:

id

Si ActiveRecord encuentra un campo llamado id , ActiveRecord asumira que se
trata de la llave primaria de la entidad y que es autonumerica.

tabla_id

Los campos terminados en _id  indican relaciones foraneas a otras tablas, de
esta forma se puede definir facilmente las relaciones entre las entidades del
modelo:

Un campo llamado clientes_id  en una tabla indica que existe otra tabla
llamada clientes y esta contiene un campo id que es foranea a este.

campo_at

Los campos terminados en _at  indican que son fechas y posee la funcionalidad
extra que obtienen el valor de fecha actual en una insercion

created_at  es un campo fecha

campo_in

Los campos terminados en _in  indican que son fechas y posee la funcionalidad
extra que obtienen el valor de fecha actual en una actualizacion

modified_in  es un campo fecha

NOTA: Los campos _at  y _in  deben ser de tipo fecha (date) en la RDBMS que se
este utilizando.

##  View

...

#  8 Libs de KumbiaPHP

Kumbiaphp lleva clases listas para usar, pero recordad que podeis crearos
vuestras propias clases para reutilizarlas en vuestros proyectos.Tambien
podeis usar clases externas a KumbiaPHP, como se explica en el proximo
capitulo.

##  Cache

Un cache es un conjunto de datos duplicados de otros originales, con la
propiedad de que los datos originales son costosos de acceder, normalmente en
tiempo, respecto a la copia en la cache.

El cache de datos esta implementado en KumbiaPHP utilizando los patrones de
diseño factory y singleton. Para hacer uso de la cache es necesario tener
permisos de escritura en el directorio "cache" (solamente en el caso de los
manejadores "sqlite" y "file").

Cada cache es controlada por un manejador de cache. El sistema de cache de
KumbiaPHP actualmente posee los siguientes manejadores:

  * APC : utiliza Alternative PHP Cache.
  * file : cache en archivos, estos se almacenan en el directorio cache y compatible con todos los sistemas operativos.
  * nixfile : cache en archivos, estos se almacenan en el directorio cache y compatible solo con sistemas operativos *nix (linux, freebsd, entre otros). Esta cache es mas rapida que la cache «file».
  * sqlite : cache utilizando base de datos SqLite y esta se ubica en el directorio cache.
  * memsqlite : cache utilizando base de datos SqLite y los datos persisten en memoria durante la ejecucion de la peticion web.

Para obtener un manejador de cache se debe utilizar el metodo «driver» que
proporciona la clase Cache.

###  driver($driver=null)

Este metodo permite obtener un manejador de cache especifico (APC, file,
nixfile, sqlite, memsqlite). Si no se indica, se obtiene el manejador de cache
por defecto indicado en el config.ini.

<?php  
// cache por defecto  
$data = Cache:: driver ()-> get ( 'data' );  
  
// manejador para memcache  
$data_memcache = Cache:: driver ( 'memcache' )-> get ( 'data' );  
  
// manejador para cache con APC  
$data_apc = Cache:: driver ( 'APC' )-> get ( 'data' );  
?>  
  
---  
  
###  get($id, $group='default')

Permite obtener un valor almacenado en la cache; es necesario especificar el
parametro $id  con el "id" correspondiente al valor en cache, tomando de
manera predeterminada el grupo "default".

###  save($value, $lifetime=null, $id=false, $group='default')

Permite guardar un valor en la cache, el tiempo de vida del valor en cache se
debe especificar utilizando el formato de la funcion [strtotime](http://www.go
ogle.com/url?q=http%3A%2F%2Fphp.net%2Fmanual%2Fes%2Ffunction.strtotime.php&sa=
D&sntz=1&usg=AFQjCNH8Gfguulpd1VXJunl_FfDbd4Mc8w)  de php.

Al omitir parametros al invocar el metodo save se comporta de la manera
siguiente:

  * Si no se especifica $lifetime , entonces se cachea por tiempo indefinido.
  * Si no se especifica $id y  $group , entonces se toma los indicados al invocar por ultima vez el metodo get .

<?php

$data = Cache::driver()->get('saludo');

if(!$data) {

    Cache::driver()->save('Hola', '+1 day');

}

echo $data;

?>  
  
---  
  
###  start ($lifetime, $id, $group='default')

Muestra buffer de salida cacheado, o en caso contrario inicia cacheo de buffer
de salida hasta que se invoque el metodo end. Este metodo se utiliza
frecuentemente para cachear un fragmento de vista.

<?php if(Cache::driver()->start('+1 day', 'saludo')): ?>

    Hola <?php echo $usuario ?>

    <?php Cache::driver()->end() ?>

<?php endif; ?>  
  
---  
  
###  end ($save=true)

Termina cacheo de buffer de salida indicando si se debe guardar o no en la
cache.

* * *

##  Logger

La clase Logger para el manejo de [Log](http://www.google.com/url?q=http%3A%2F
%2Fes.wikipedia.org%2Fwiki%2FLog_\(registro\)&sa=D&sntz=1&usg=AFQjCNGft16YEbrl
ayLoKbZFpNDBDXgXAA)  fue reescrita de forma estatica, esto quiere decir ya no
es necesario crear una instancia de la clase Logger. Esta clase dispone de una
variedad de metodos para manejar distintos tipos de Log.

<?php  Logger:: error ( 'Mensaje de Error' ) ?>  
  
---  
  
La salida de la instruccion anterior sera lo siguiente:

[Thu, 05 Feb 09 15:19:39 -0500][ERROR] Mensaje de Error

Por defecto los archivos log tienen el siguiente nombre logDDMMYYY.txt este
nombre puede ser cambiado si asi lo deseamos a traves de un parametro
adicional al metodo.

<?php  Logger:: error ( 'Mensaje de Error' , 'mi_log' ) ?>  
  
---  
  
Se puede apreciar el segundo parametro ahora el archivo tendra como nombre
mi_log.txt

###  Logger::warning ($msg);

###  Logger::error ($msg)

###  Logger::debug ($msg)

###  Logger::alert ($msg)

###  Logger::critical ($msg)

###  Logger::notice ($msg)

###  Logger::info ($msg)

###  Logger::emergence ($msg)

###  Logger::custom ($type='CUSTOM', $msg)

* * *

##  Flash

Flash es un helper muy util en Kumbia que permite hacer la salida de mensajes
de error, advertencia, informativos y exito de forma estandar.

###  Flash::error($text)

Permite enviar un mensaje de error al usuario. Por defecto es un mensaje de
letras color rojo y fondo color rosa pero estos pueden ser alterados en la
clase css en public /css/style.css llamada error.

Flash::error("Ha ocurrido un error");  
  
---  
  
###  Flash::valid($text)

Permite enviar un mensaje de exito al usuario. Por defecto es un mensaje de
letras color verdes y fondo color verde pastel pero estos pueden ser alterados
en la clase css en public/css/style.css  llamada valid .

Flash::valid("Se realizo el proceso correctamente");  
  
---  
  
###  Flash::info($text)

Permite enviar un mensaje de informacion al usuario. Por defecto es un mensaje
de letras color azules y fondo color azul pastel; pero estos pueden ser
alterados en la clase css en public/css/style.css  llamada info .

Flash::info("No hay resultados en la busqueda");  
  
---  
  
###  Flash::warning($text)

Permite enviar un mensaje de advertencia al usuario. Por defecto es un mensaje
de letras color azules y fondo color azul pastel pero estos pueden ser
alterados en la clase css en public/css/style.css  llamada warning .

Flash::warning("Advertencia: No ha iniciado sesion en el sistema");  
  
---  
  
###  Flash::show($name, $text)

...

* * *

##  Session

La clase Session es para facilitar  el manejo de la sessiones.

###  Session::set($index, $value, $namespace='default')

Crear o especifica el valor para un indice de la sesion actual.

<?php  Session:: set ( 'usuario' , 'Administrador' ); ?>  
  
---  
  
###  Session::get($index, $namespace='default')

Obtener el valor para un indice de la sesion actual.

<?php  
Session:: get ( 'usuario' ); //retorna 'Administrador'  
?>  
  
---  
  
###  Session::delete($index, $namespace='default')

Elimina el valor para un indice de la sesion actual.

<?php  Session:: delete ( 'usuario' ); ?>  
  
---  
  
###  Session::has($index, $namespace='default')

Verifica que este definido el indice en la sesion actual.

<?php  
Session:: has ( 'id_usuario' ); //retorna false.  
?>  
  
---  
  
NOTA: $namespace es un espacio individual en el cual se pueden contener las
variables de sesion, permitiendo evitar colisiones con nombres de variables.

##  Load

                                                     

La clase load permite la carga de librerias en KumbiaPHP.

###  Load::coreLib($lib)

Permite cargar una libreria del nucleo de KumbiaPHP.

<?php

// Carga la libreria cache

Load::coreLib('cache');

?>  
  
---  
  
###  Load::lib($lib)

Permite cargar una libreria de aplicacion. Las librerias de aplicacion se
ubican en el directorio "app/libs".

<?php

// Carga el archivo app/libs/split.php

Load::lib('split');

?>  
  
---  
  
En caso de que no exista la libreria intenta cargar una del nucleo con el
nombre indicado.

<?php

/* Carga el archivo "app/libs/auth2.php" si existe, en caso contrario, cargara
la libreria del nucleo auth2 */

Load::lib('auth2');

?>  
  
---  
  
Para agrupar librerias debes colocarlas en un subdirectorio y anteceder el
nombre del directorio en la ruta al momento de cargarla.

<?php

// Carga el archivo app/libs/controllers/auth_controller.php

Load::lib('controllers/auth_controller.php');

?>  
  
---  
  
###  Load::model($model)

Carga e instancia el modelo indicado. Retorna la instancia del modelo.

<?php

// Carga e instancia el modelo usuario.php

$usuario = Load::model('usuario');

?>  
  
---  
  
Para agrupar modelos debes colocarlos en un subdirectorio y anteceder el
nombre del directorio en la ruta al momento de cargarlo.

<?php

// Carga e instancia el modelo 'partes_vehiculo/motor.php"

$motor = Load::model('partes_vehiculo/motor.php');

?>  
  
---  
  
##  Auth2

Esta clase permite manejar autenticacion de usuarios, con este fin se utilizan
adaptadores para tipos especializados de autenticacion.

###  Solicitando un adaptador

Para solicitar un adaptador se hace uso del metodo estatico "factory", dicho
metodo recibe como argumento el tipo de adaptador a utilizar. En caso de no
indicarse el tipo de adaptador se utiliza el adaptador predeterminado.

Ejemplo:

<?php

$auth = Auth2::factory('model');

?>  
  
---  
  
Los siguientes adaptadores se encuentran implementados:

  * Model : permite tomar como fuente de datos un modelo ActiveRecord. Debe indicarse en el argumento de factory "model".

###  Adaptador predeterminado

El adaptador predeterminado es "model", sin embargo esto se puede modificar
utilizando el metodo estatico setDefault .

$adapter (string): nombre de adaptador

setDefault($adapter)

Ejemplo:

Auth2::setDefault('model');  
  
---  
  
###  Como trabaja la autenticacion

El metodo identify  verifica si existe una sesion autenticada previa, en caso
contrario toma de $_POST el usuario y clave de acceso, y verifica el usuario y
la clave encriptada contra la fuente de datos. De manera predeterminada la
clave es encriptada utilizando  md5.

Para poder efectuar la autenticacion debe existir una variable $_POST['mode']
cuyo valor debe ser "auth".

El formulario para autenticacion debe tener la siguiente estructura basica:

<?php echo Form::open() ?>

    <input name="mode" type="hidden" value="auth">

    <label for="login">Usuario:</label>

    <?php echo Form::text('login') ?>

    <label for="password">Clave:</label>

    <?php echo Form::pass('password') ?>

<?php echo Form::close() ?>  
  
---  
  
De manera predeterminada Auth2 toma para el nombre de usuario el campo "login"
y para la clave el campo "password".

Para poder iniciar una sesion de usuario y realizar la autenticacion se debe
invocar el metodo identify , sin embargo dependiendo del tipo de adaptador, es
necesario especificar ciertos parametros de configuracion.

###  Adaptador Model

Este adaptador permite utilizar autenticacion en base a un modelo que herede
de la clase ActiveRecord , verificando los datos de autenticacion en la base
de datos.

####  setModel()

Establece el modelo ActiveRecord que se utilizara como fuente de datos. De
manera predeterminada el modelo que se utilizara como fuente de datos es
'users'.

$model (string): nombre de modelo en smallcase

setModel($model)

Ejemplo:

$auth->setModel('usuario');  
  
---  
  
####  identify()

Realiza la autenticacion. Si ya existe una sesion de usuario activa o los
datos de usuario son correctos, entonces la identificacion es satisfactoria.

return boolean

identify()

Ejemplo:

$valid = $auth->identify();  
  
---  
  
####  logout()

Termina la sesion de usuario.

logout()

Ejemplo:

$auth->logout();  
  
---  
  
####  setFields()

Establece los campos del modelo que se cargaran en sesion mediante el metodo
Session::set . De manera predeterminada se carga el campo "id".

$fields (array): arreglo de campos

setFields($fields)

Ejemplo:

$auth->setFields(array('id', 'usuario'));  
  
---  
  
####  setSessionNamespace()

Establece un namespace para los campos que se cargan en sesion.

$namespace (string): namespace de sesion

setSessionNamespace($namespace)

Ejemplo:

$auth->setSessionNamespace('auth');  
  
---  
  
####  isValid()

Verifica si existe una sesion de usuario autenticado.

return boolean

isValid()

Ejemplo:

$valid = $auth->isValid();  
  
---  
  
####  getError()

Obtiene el mensaje de error.

return string

getError()

Ejemplo:

if(!$auth->identify()) Flash::error($auth->getError());  
  
---  
  
####  setAlgos()

Establece el metodo de encriptacion de la clave de usuario.

$algos (string): metodo de encriptacion, el nombre coincide con la funcion
hash de php.

setAlgos($algos)

Ejemplo:

$auth->setAlgos('md5');  
  
---  
  
####  setKey()

Establece la clave para identificar si existe una sesion autenticada, dicha
clave toma un valor booleano "true" cuando la sesion autenticada es valida,
asignada mediante el metodo Session::set .

$key (string): clave de sesion

setKey($key)

Ejemplo:

$auth->setKey('usuario_logged');  
  
---  
  
####  setCheckSession()

Indica que no se inicie sesion desde browser distinto con la misma IP.

$check (boolean): indicador

setCheckSession($check)

Ejemplo:

$auth->setCheckSession(true);  
  
---  
  
####  setPass()

Asigna el nombre de campo para el campo de clave. Este campo debe corresponder
con el campo de la base de datos y del formulario. De manera predeterminada es
"password".

$field (string): nombre de campo que recibe por POST.

setPass($field)

Ejemplo:

$auth->setPass('clave');  
  
---  
  
####  setLogin()

Asigna el nombre de campo para el campo de nombre de usuario. Este campo debe
corresponder con el campo de la base de datos y del formulario. De manera
predeterminada es "login".

$field (string): nombre de campo que recibe por POST.

setLogin($field)

Ejemplo:

$auth->setLogin('usuario');  
  
---  
  
####  Obtener los campos cargados en sesion

Los campos se obtienen por medio del metodo Session::get .

$id = Session::get('id');  
  
---  
  
Si se ha especificado un namespace  de sesion, entonces debe indicarlo al
invocar el metodo.

$id = Session::get('id', 'mi_namespace');  
  
---  
  
####  Ejemplo

La vista:

app/views/acceso/login.phtml

<?php echo Form::open() ?>

    <input name="mode" type="hidden" value="auth">

    <label for="login">Usuario:</label>

    <?php echo Form::text('login') ?>

    <label for="password">Clave:</label>

    <?php echo Form::pass('password') ?>

<?php echo Form::close() ?>  
  
---  
  
El controlador:

app/controllers/auth_controller.php

<?php

class AuthController extends AppController

{

    public function login()

    {

        // Si se loguea se redirecciona al modulo de cliente

        if(Load::model('usuario')->login()) {

            Router::toAction('usuario/panel');

        }

    }

    public function logout()

    {

        // Termina la sesion

        Load::model('usuario')->logout();

        Router::toAction('login');

    }

}

?>  
  
---  
  
Para validar que el usuario este autenticado, basta con adicionar en cualquier
accion del controlador o en el metodo before_filter  el siguiente codigo:

if(!Load::model('usuario')->logged()) {

    Router::toAction('auth/login');

    return false;

}  
  
---  
  
El modelo:

app/models/usuario.php

<?php

// Carga de la libreria auth2

Load::lib('auth2');

class Usuario extends ActiveRecord

{

    /**

     * Iniciar sesion

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

     * Terminar sesion

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

?>  
  