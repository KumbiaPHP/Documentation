# My first app with KumbiaPHP

After you are ready with the KumbiaPHP installation, you can see the welcome page. Now it is time to create your first Hello World application. The goal is that you understand the basic components of the MVC (Model-View-Controller) architecture.

## Hello KumbiaPHP!

Now write the famous "Hello World!" but with a small change: say "Hello KumbiaPHP!". Thinking about this, remember the MVC model, according to this, KumbiaPHP should accept a petition, seeking driver and, in this, an action that serves the request. Then, KumbiaPHP uses that information to find the view associated with the request.

## Controller

Now add content to the controller app/controllers/controller/saludo_controller.php

```php
<?php
/** 
 * Controller Saludo
 */
class SaludoController extends AppController {
    public function hola() {

    }
}
 ```

En el código tenemos la definición de la class *SaludoController*, note que
también esta el sufijo *Controller* al final de la declaración de la clase, esto
la identifica como una clase controladora, y esta hereda (extends) de la
superclase *AppController*, con lo que adquiere las propiedades de una clase
controladora, además existe el método hola().

# The view to see the output that sends the controller, it is necessary create the view associated with the action. First, create a directory with the same name of our driver (in this case must be called greeting), and inside it are all views associated with the actions that need to display some information. In our example we call an action called Hello; Therefore, we create a file called * app/views/saludo/hola.phtml*. Once this file is created, add you a little content: "'html < h1 > Hello KumbiaPHP! < / h1 >
```

Then try to access the following URL: http://localhost/kumbiaphp/saludo/hola/ and the result must be as shown Figure 2.2.

![](../images/image06.png) Figure 2.2: View contents of hello.phtml

## KumbiaPHP and URLs

Para entender el funcionamiento del framework es importante entender sus URLs, la figura 2.3 muestra una URL típica en KumbiaPHP.

![](../images/image08.png) Figura 2.3: URL en KumbiaPHP

En KumbiaPHP no existen las extensiones .php esto porque en primera instancia hay reescritura de URLs y además cuenta con un front-controller encargado de recibir todas las peticiones (mas adelante se explicara en detalle).

Any other information passed by URL is taken as the parameter of the action, with regard to our application as shown in Figure 2.4.

![](../images/image05.png) Figure 2.4: URL with parameters

Esto es útil para evitar que tener estar enviando parámetros GET de la forma ?var=valor&var2=valor2 (esto es, de la forma tradicional como se viene utilizando PHP), la cual revela información sobre la arquitectura de software que se dispone en el servidor. Además, hacen que nuestra URL se vea mal y fea para SEO.

## Add more content

Agregaremos algo de contenido dinámico a nuestro proyecto, para que no sea tan aburrido. Mostraremos la hora y la fecha, usando la función date() .

Cambiamos un poco el controlador *app/controllers/saludo_controller.php*

```php
<?php
/**
 * Controller Saludo
 */ 
class SaludoController extends AppController {
    /** 
     * metodo para saludar
     */
    public function hola() { 
       $this->fecha = date("Y-m-d H:i");
   }
}
```

KumbiaPHP implementa las variables de instancia lo que significa que todos atributos (públicos) definidos en el controller, pasara automáticamente a la vista, en el código anterior tenemos el atributo $this->fecha este pasara a la vista como una variable llamada $fecha .

En la vista que se creó en la sección 2.1.3.3 y agregamos.

```php
<h1>¡Hola KumbiaPHP!</h1>
<?php echo $fecha ?>
```

Ahora, si volvemos a http://localhost/kumbiaphp/saludo/hola/, obtendremos la hora y fecha del momento en que se haga la petición, como se muestra en la figura 2.5.

![](../images/image02.png) Figura 2.5: Hora y fecha de petición

Para agregarle calidez al asunto, le preguntaremos al usuario su nombre vía parámetro 2.1.3.4, volvemos a editar el controlador *saludo_controller.php*

```php
<?php
/** 
 * Controller Saludo
 */ 
class SaludoController extends AppController
{
    /** 
     * método para saludar
     * @param string $nombre
     */ 
    public function hola($nombre)
   {
       $this->fecha = date("Y-m-d H:i");
       $this->nombre = $nombre;
   }
}
```

Editamos la vista *app/views/saludo/hola.phtml*

```php
<h1>Hola <?php echo $nombre ?> , ¡Que lindo es utilizar KumbiaPHP!
¿cierto?</h1>
<?php echo $fecha ?> 
```

Si ahora entramos a *http://localhost/kumbiaphp/saludo/CaChi/* , nos mostrara en el navegador web el saludo junto con el nombre colocado y la fecha actual, como se muestra en la figura 2.6.

![](../images/image09.png) Figura 2.6: Saludando al usuario

## Repeating history

Ahora vamos otra acción llamada adios() y como su nombre indica haremos el proceso inverso a saludar, es decir despedir a los usuarios.

```php
<?php
/** 
 * Controller Saludo
 */ 
class SaludoController extends AppController {
    /** 
     * método para saludar
     * @param string $nombre
     */ 
    public function hola($nombre) {
       $this->fecha = date("Y-m-d H:i");
       $this->nombre = $nombre;
   }
    /** 
     * método para despedir
     */ 
    public function adios() {

    }
}
```

Add a new view to present the contents of the action goodbye() and if we recall what was explained in the section 2.1.3.3 we should create a view *app/views/saludo/adios.phtml* with the following contents.

```php
<h1>Ops! se ha ido :( </h1>
<?php echo Html::link('saludo/hola/CaChi/', 'Volver a saludar') ?>
```

Si ingresa al siguiente enlace *http://localhost/kumbiaphp/saludo/adios/* se vera un nuevo texto, y un vinculo a la acción hola(), como se muestra en la figura 2.7.

![](../images/image04.png) Figura 2.7: Vista de adiós al usuario.

Html: link (), is one of the many helper offering KumbiaPHP to facilitate at the time of scheduled hearings. We could write the HTML code directly, by placing *[back to say hello](kumbiaphp/saludo/hola/CaChi/)*, but this can lead to a problem, imagine you would rename his project in kumbiaphp demo, we would have to modify all the links, KumbiaPHP helpers solve these problems.

To write the code of our "Hello KumbiaPHP!" don't need but a controller and a view. We don't need models, since we are not working with information from a database or other type of more complex information processing.

Nos ubicamos en el directorio */path/to/kumbiaphp/app/controllers/*. Aquí están nuestros controladores (Para más detalles, lee la documentación sobre el directorio app). Para crear un controlador, es importante tener en cuenta las convenciones de nombre que utiliza el Framework. Llamaremos a nuestro controlador *saludo_controller.php*. Note the suffix *_controller.php* this is part of the Naming Convention, and makes that KumbiaPHP identifies this file as a driver.