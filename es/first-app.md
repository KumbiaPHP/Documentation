#Mi Primera Aplicación con KumbiaPHP

Luego que explicamos los pasos para configurar KumbiaPHP y ver su pantalla de
bienvenida, se viene hacer el primer ejemplo el cual tiene como objetivo
entender elementos basicos al momento de utilizar el framework que servira
para entender la arquitectura MVC (Modelo-Vista-Controlador).

## Hola, KumbiaPHP!

Ahora escribiremos el famoso "Hola, Mundo!" pero con un pequeño cambio:
Diremos "Hola, KumbiaPHP!". Pensando en esto, recordemos el modelo MVC, segun
esto, KumbiaPHP deberia aceptar una peticion, que buscaria en controlador y,
en este, una accion que atenderia la peticion. Luego, KumbiaPHP utilizara esta
informacion de controlador y accion para buscar la vista asociada a la
peticion.


## El Controlador

Ahora agregamos contenido al controlador app/controllers/saludo_controller.php
```php
<?php  
/**  
 * Controller Saludo   
 */   
class  SaludoController extends  AppController {  
    public   function  hola() {

    }   
}  
 ```

 
En el codigo tenemos la definicion de la class SaludoController , Notese que
tambien esta el sufijo Controller al final de la declaracion de la clase, esto
la identifica como una clase controladora, y esta hereda (extends) de la
superclase AppController , con lo que adquiere las propiedades de una clase
controladora, ademas existe el metodo hola() .

## La Vista

Para poder ver la salida que envia el controlador, es necesario crear la vista
asociada a la accion. Primero, creamos un directorio con el mismo nombre de
nuestro controlador (en este caso deberia llamarse saludo), y dentro de este
estaran todas las vistas asociadas a las acciones que necesiten mostrar alguna
informacion. En nuestro ejemplo llamamos a una accion llamada hola; por lo
tanto, creamos un archivo llamado app/views/saludo/hola.phtml . Una vez creado
este archivo, le agregamos un poco de contenido:

```html
  <h1>Hola, KumbiaPHP!</h1>  
```
  
A continuacion se prueba al acceder a la siguiente URL: http://localhost/ kum
biaphp/saludo/hola/ y el resultado debe ser como muestra la figura 2.2.

![](images/image06.png)
Figura 2.2: Contenido de la vista hola.phtml

## KumbiaPHP y sus URLs

Para entender el funcionamiento del framework es importante entender sus URLs,
la figura 2.3 muestra una URL tipica en KumbiaPHP.

![](images/image08.png)
Figura 2.3: URL en KumbiaPHP

En KumbiaPHP no existen las extensiones .php esto porque en primera instancia
hay reescritura de URLs y ademas cuenta con un front-controller encargado de
recibir todas las peticiones (mas adelante se explicara en detalle).

Cualquier otra informacion pasada por URL es tomada como parametro de la
accion, a proposito de nuestra aplicacion como muestra la figura 2.4.

![](images/image05.png)
Figura 2.4: URL con parametros

Esto es util para evitar que tener estar enviando parametros GET de la forma
?var=valor&var2=valor2 (esto es, de la forma tradicional como se viene
utilizando PHP), la cual revela informacion sobre la arquitectura de software
que se dispone en el servidor. Ademas, hacen que nuestra URL se vea mal.

## Agregando mas contenido

Agregaremos algo de contenido dinamico a nuestro proyecto, para que no sea tan
aburrido. Mostraremos la hora y la fecha, usando la funcion date() .

Cambiamos un poco el controlador app/controllers/saludo_controller.php

```php
<?php  
/**  
 * Controller Saludo   
 */   
class  SaludoController extends  AppController {  
    /**   
     * metodo para saludar   
     */   
    public   function  hola() {   
       $this-> fecha  = date ( "Y-m-d H:i" );   
   }  
}  
```
  
KumbiaPHP implementa las variables de instancia lo que significa que todos
atributos definidos en el controller, pasara automaticamente a la vista, en el
codigo anterior tenemos el atributo $this->fecha  este pasara a la vista como
una variable llamada $fecha .

En la vista que se creo en la seccion 2.1.3.3 y agregamos.

```php
<h1>Hola, KumbiaPHP!</h1>  
<?php   echo  $fecha ?>  
``` 
  
Ahora, si volvemos a http://localhost/kumbiaphp/saludo/hola/, obtendremos la hora
y fecha del momento en que se haga la peticion, como se muestra en la figura 2.5.

![](images/image02.png)
Figura 2.5: Hora y fecha de peticion

Para agregarle calidez al asunto, le preguntaremos al usuario su nombre
via parametro 2.1.3.4, volvemos a editar el controlador saludo_controller.php...

```php
<?php  
/**  
 * Controller Saludo   
 */   
class  SaludoController extends  AppController  
{  
    /**   
     * metodo para saludar   
     * @param string $nombre   
     */   
    public   function  hola($nombre)   
   {  
       $this-> fecha  = date ( "Y-m-d H:i" );   
       $this-> nombre  = $nombre;   
   }  
}  
```
  
Editamos la vista *app/views/saludo/hola.phtml*

```php
<h1>Hola <?php   echo  $nombre; ?> , ¡Que lindo es utilizar KumbiaPHP!
¿cierto?</h1>  
<?php   echo  $fecha ?> 
```
  
Si ahora entramos a http://localhost/kumbiaphp/saludo/CaChi/ , nos mostrara en el navegador web
el saludo junto con el nombre colocado y la fecha actual, como se muestra en
la figura 2.6.

![](images/image09.png)
Figura 2.6: Saludando al Usuario

## Repitiendo la Historia

Ahora vamos otra accion llamada adios()  y como su nombre indica haremos el
proceso inverso a saludar, es decir despedir a los usuarios.

```php
<?php  
/**  
 * Controller Saludo   
 */   
class  SaludoController extends  AppController {  
    /**   
     * metodo para saludar   
     * @param string $nombre   
     */   
    public   function  hola($nombre) {   
       $this-> fecha  = date ( "Y-m-d H:i" );   
       $this-> nombre  = $nombre;   
   }  
    /**   
     * metodo para despedir   
     */   
    public   function  adios() {

    }   
}  
```  
  
Agregamos una nueva vista para presentar el contenido de la accion adios()  y
si recordamos lo que se explico en la seccion 2.1.3.3 deberiamos crear una
vista app/views/saludo/adios.phtml  con el siguiente contenido.
```php
<h1>Ops! se ha ido :( </h1>  
<?php   echo  Html:: link ( 'saludo/hola/CaChi/' , 'Volver a Saludar' ); ?>  
```  
  
Si ingresa al siguiente enlace http://localhost/kumbiaphp/saludo/adios/ se vera un nuevo texto,
y un vinculo a la accion hola() , como se muestra en la figura 2.7.

![](images/image04.png)
Figura 2.7: Vista de adios al usuario.

Html::link() , es uno de los tantos helper que ofrece KumbiaPHP para facilitar
al momento de programar en las vistas. Podriamos escribir el codigo HTML
directamente, colocando <a href="kumbiaphp/saludo/hola/CaChi/">Volver a
Saludar</a> , pero esto puede conllevar a un problema, imagine que quisiera
cambiar de nombre a su proyecto de kumbiaphp a demo, tendriamos que modificar
todos los vinculos, los helpers de KumbiaPHP resuelven estos problemas.
 

Para escribir el codigo de nuestro "Hola, KumbiaPHP!" no necesitamos sino un
controlador y una vista. No necesitamos modelos, ya que no estamos trabajando
con informacion de una base de datos.

Nos ubicamos en el directorio /path/to/kumbiaphp/app/controllers/. Aqui
estaran nuestros controladores (Para mas detalles, lee la documentacion sobre
el directorio app). Para crear un controlador, es importante tener en cuenta
las convenciones de nombre que utiliza el Framework. llamaremos a nuestro
controlador saludo_controller.php . Notese el sufijo _controller.php esto
forma parte de la convencion de nombres, y hace que KumbiaPHP identifique ese
archivo como un controlador.
