# El Controlador

En KumbiaPHP Framework, la capa del controlador, contiene el código que une
la lógica de negocio con la presentación. Está dividida en varios componentes
que se utilizan para diversos propósitos:
  
  * Las acciones verifican la integridad de las peticiones y preparan los datos 
requeridos por la capa de presentación.
  * Las clases Input y Session dan acceso a los parámetros de la petición y a 
los datos persistentes del usuario. Se utilizan muy a menudo en la capa del 
controlador.
  * Los filtros son trozos de código ejecutados para cada petición, antes y/o 
después de un controlador incluso antes y/o después de una acción. Por ejemplo, 
los filtros de seguridad y validación son comúnmente utilizados en aplicaciones
web.

Este capítulo describe todos estos componentes. Para una página básica, es
probable que solo necesites escribir algunas lineas de código en la clase de
la acción, y eso es todo. Los otros componentes del controlador solamente se
utilizan en situaciones específicas.
 
## Las Acciones

Las acciones son la parte fundamental en la aplicación, puesto que contienen
el flujo en que la aplicación actuará ante ciertas peticiones. Las acciones
utilizan el modelo y definen variables para la vista. Cuando se realiza una
petición web en una aplicación KumbiaPHP, la URL define una acción y los
parámetros de la petición. Ver sección [KumbiaPHP y sus URLs](first-app.md#kumbiaphp-y-sus-urls)

Las acciones son métodos de una clase controladora llamada ClassController que
hereda de la clase AppController y pueden o no ser agrupadas en módulos.

### Las acciones y las vistas

Cada vez que se ejecuta una acción, KumbiaPHP busca entonces una vista (view)
con el mismo nombre de la acción. Este comportamiento se ha definido por
defecto. Normalmente las peticiones deben dar una respuesta al cliente que la
ha solicitado, entonces si tenemos una acción llamada *saludo()* debe
existir una vista asociada a esta acción llamada *saludo.phtml*. Habrá un
capítulo más extenso dedicado a la explicación de las vistas en KumbiaPHP.

### Obtener valores desde una acción

Las URLs de KumbiaPHP están caracterizadas por tener varias partes, cada una
de ellas con una función conocida. Para obtener desde un controlador los
valores que vienen en la URL podemos usar algunas propiedades definidas en el
controlador.

Tomemos la URL:

http://www.example.com/noticias/ver/12/
   
  
  * El Controlador: noticias
  * La accion: ver
  * Parametros: 12
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
  
Es importante notar la relación que guardan los parámetros enviados por URL
con la acción. En este sentido KumbiaPHP tiene una característica, que hace
seguro el proceso de ejecutar las acciones y es que se limita el envío de
parámetros tal como se define en la método (acción). Lo que indica que todos
los parámetros enviados por URL son argumentos que recibe la acción. Ver sección [KumbiaPHP y sus URLs](first-app.md#kumbiaphp-y-sus-urls)

En el ejemplo anterior se definió en la acción *ver($id)* un sólo parámetro,
esto quiere decir que si no se envía ese parámetro o se intentan enviar más
parámetros adicionales KumbiaPHP lanza una excepción (en producción muestra
un error 404). Este comportamiento es por defecto en el framework y se puede
cambiar para determinados escenarios según el propósito de nuestra aplicación
para la ejecución de una acción.

Tomando el ejemplo «Hola Mundo» ponga en práctica lo antes explicado y lo hará
enviando parámetros adicionales al método hola($nombre) el cual sólo recibe un
parámetro (el nombre) http://localhost/kumbiaphp/saludo/hola/CaChi/adici
onal, en la figura 3.1 vera la excepción generada por KumbiaPHP.

![](../images/image13.png)

Figura 3.1: Excepción de número de parámetros erróneos.

Siguiendo en el mismo ejemplo imaginemos que requerimos que la ejecución de la
acción *hola()* obvie la cantidad de parámetros enviados por URL, para esto
solo tenemos que indicarle a KumbiaPHP mediante el atributo $limit_params  que
descarte el número de parámetros que se pasan por URL.

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
  
Cuando tiene el valor FALSE como se explico antes, descarta la cantidad de
parámetros de la acción. Ingresa a la siguiente URL [http://localhost/kumbiaph
p/saludo/hola/CaChi/param2/param3/] y verá como ya no esta la excepción
de la figura 3.1 y puede ver la vista de la acción como muestra la figura 3.2.

![](../images/image03.png)

Figura 3.2: Descartando la cantidad de parámetros de la acción.

## Convenciones y Creación de un Controlador

### Convenciones

Los controladores en KumbiaPHP deben llevar las siguientes convenciones y
características:

El archivo debe ser creado solo en el directorio *app/controllers/*. El archivo
debe tener el nombre del controlador y la terminación *_controller.php*, por
ejemplo *saludo_controller.php*.

El archivo debe contener la clase controladora con el mismo nombre del archivo
en notación **CamelCase**. Retomando el ejemplo anterior el nombre de la clase
controladora sera SaludoController.

### Creación de un Controlador

Ahora ponemos en práctica lo visto anteriormente y crearemos un controlador
(controller) llamado saludo.

```php
<?php
/** 
 * Controller Saludo
 */ 
class SaludoController extends AppController {
}
```
  
###  Clase AppController

Es importante recordar que KumbiaPHP es un framework MVC y POO. En este
sentido existe AppController y es la super clase de los controladores, todos
deben heredar (extends) de esta clase para tener las propiedades (atributos) y
métodos que facilitan la interacción entre la capa del modelo y presentación.

La clase AppController esta definida en *app/libs/app_controller.php*  es una
clase muy sencilla de usar y es clave dentro del MVC.

### Acciones y Controladores por defecto

## Filtros

Los controladores en KumbiaPHP poseen unos métodos útiles que permiten
realizar comprobaciones antes y después de ejecutar un controlador y una
acción, los filtros pueden ser entendidos como un mecanismo de seguridad en los
cuales se puede cambiar el procesamiento de la petición según se requiera (por
ejemplo verificar si un usuarios se encuentra autenticado en el sistema).

KumbiaPHP corre los filtros en un orden lógico, para manipular comprobaciones,
a nivel de toda la aplicación o bien en particularidades de un controlador.

### Filtros de Controladores

Los filtros de controladores se ejecutan antes y después de un controlador son
útiles para comprobaciones a nivel de aplicación, como por ejemplo verificar
el modulo que se esta intentando acceder, sesiones de usuarios, etc.
Igualmente se puede usar para proteger nuestro controlador de información
inadecuada.

Los filtros son métodos los cuales sobrescribimos (característica POO) para
darle el comportamiento deseado.

#### initialize()

KumbiaPHP llama al método *initialize()*  antes de ejecutar el controlador y se
encuentra definido para ser usado en la clase AppController. [Ver sección AppController](controller.md#clase-appcontroller).

####  finalize()

KumbiaPHP llama al método *finalize()* después de ejecutar el controlador y se
encuentra definido para ser usado en la clase AppController. [Ver sección AppController](controller.md#clase-appcontroller).

###  Filtros de Acciones

Los filtros de acciones se ejecutan antes y después de una acción son útiles
para comprobaciones a nivel de controller, como por ejemplo verificar que una
petición es asíncrona, cambiar tipos de respuesta, etc. Igualmente se puede
usar para proteger nuestra acción de información inadecuada que sea enviada a
ellos.

####  before_filter()

KumbiaPHP llama al método *before_filter()* antes de ejecutar la acción del
controlador y es útil para verificar si una petición es asíncrona entre otros.

####  after_filter()

KumbiaPHP llama al método *after_filter()* después de ejecutar la acción del
controlador y es útil para cambiar valores de sesión entre otros.
