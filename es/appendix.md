#  Apendices

##  Integracion de jQuery y KumbiaPHP

KumbiaPHP provee de una integracion con el Framework de DOM en JavaScript,
jQuery

###  KDebug

KDebug es un nuevo objeto incorporado al plugins de integracion
KumbiaPHP/jQuery que permite una depuracion del codigo en tiempo de
desarrollo. Con solo un parametro se puede aplicar un log que permite ver en
consola ( mientras esta este disponible, sino usara alert) que permite un
mejor control de la ejecuccion.

No es necesario pero si recomendable usar Firebug  si se trabaja en Mozilla
Firefox o algun navegador que use la consola de WebKit como Google Chrome.

##  CRUD

###  Introducción

Este ejemplo nos permitira de manera sencilla conocer y entender la
implementacion de un CRUD (Create, Read, Update y Delete en ingles) sin la
necesidad de un Scaffold (StandardForm) y un manejo correcto del MVC en
KumbiaPHP.

El CRUD de la beta1 sigue funcionando igual en la beta2, pero queda
desaconsejado. En la version 1.0 se podra usar de las 2 maneras. Y la 1.2 que
saldra junto a la 1.0 solo se usara lo nuevo y se eliminara lo desaconsejado.

###  Configurando database.ini

Configurar el archivo [databases.ini](http://wiki.kumbiaphp.com/KumbiaPHP_Framework_Versi%C3%B3n_1.0_Spirit#databases.ini) ,
con los datos y motor de Base de Datos a utilizar.

###  Modelo

Crear el Modelo el cual esta viene dado por la definicion de una tabla en la
BD, para efecto del ejemplo creamos la siguiente tabla.

```sql
CREATE TABLE menus
(
id           int            unique not null auto_increment,
nombre       varchar(100),
titulo       varchar(100)   not null,
primary key(id)
)  
```  
  
Vamos ahora a definir el modelo el cual nos permite interactuar con la BD.

[app]/models/menus.php:

```php
<?php  
class  Menus extends  ActiveRecord  
{  
  /**  
     * Retorna los menu para ser paginados   
     *   
     */   
  public   function  getMenus($page, $ppage=20)  
  {  
      return  $this-> paginate ( "page: $page" , "per_page: $ppage" , 'order: id desc' );   
  }  
}  
```  
  
###  Controller

El controlador es encargado de atender las peticiones del cliente (ej.
browser) y a su vez de darle una respuesta. En este controller vamos a definir
todas las operaciones CRUD que necesitamos.

[app]/controllers/menus_controller.php:

```php
<?php  
/**  
* Carga del modelo Menus...   
*/   
Load:: models ( 'menus' );  
  
class  MenusController extends  AppController {  
  /**  
    * Obtiene una lista para paginar los menus   
    */   
  public   function  index($page=1)  
  {  
      $menu = new  Menus();   
      $this-> listMenus  = $menu-> getMenus ($page);   
  }  
  
  /**  
    * Crea un Registro   
    */   
  public   function  create ()  
  {  
      /**   
        * Se verifica si el usuario envio el form (submit) y si ademas   
        * dentro del array POST existe uno llamado "menus"   
        * el cual aplica la autocarga de objeto para guardar los   
        * datos enviado por POST utilizando autocarga de objeto   
        */   
      if (Input:: hasPost ( 'menus' )){   
          /**   
            * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos   
            * y los asocia al campo correspondiente siempre y cuando se utilice la convencion   
            * model.campo   
            */   
          $menu = new  Menus(Input:: post ( 'menus' ));   
          //En caso que falle la operacion de guardar   
          if (!$menu-> save ()){   
              Flash:: error ( 'Fallo Operacion' );   
          } else {   
              Flash:: valid ( 'Operacion exitosa' );   
              //Eliminamos el POST, si no queremos que se vean en el form   
              Input:: delete ();   
          }   
      }   
  }  
  
  /**  
    * Edita un Registro   
    *   
    * @param int $id (requerido)   
    */   
  public   function  edit($id)  
  {  
      $menu = new  Menus();   
  
      //se verifica si se ha enviado el formulario (submit)   
      if (Input:: hasPost ( 'menus' )){   
  
          if (!$menu-> update (Input:: post ( 'menus' ))){   
              Flash:: error ( 'Fallo Operacion' );   
          } else  {   
              Flash:: valid ( 'Operacion exitosa' );   
              //enrutando por defecto al index del controller   
              return  Router:: redirect ();   
          }   
      } else  {   
          //Aplicando la autocarga de objeto, para comenzar la edicion   
          $this-> menus  = $menu-> find ((int)$id);   
      }   
  }  
  
  /**  
    * Eliminar un menu   
    *   
    * @param int $id (requerido)   
    */   
  public   function  del($id)  
  {  
      $menu = new  Menus();   
      if  (!$menu-> delete ((int)$id)) {   
              Flash:: error ( 'Fallo Operacion' );   
      } else {   
              Flash:: valid ( 'Operacion exitosa' );   
      }   
  
      //enrutando por defecto al index del controller   
      return  Router:: redirect ();   
  }  
}  
``` 
  
###  Vistas

Agregamos las vistas...

[app]/views/menus/index.phtml
```php
<div class="content">  
  <?php   echo  View:: content (); ?>  
  <h3>Menus</h3>  
  <ul>  
  <?php   foreach  ($listMenus-> items   as  $item) : ?>  
  <li>  
      <?php   echo  Html:: linkAction ( "edit/$item->id/" , 'Editar' ) ?>   
      <?php   echo  Html:: linkAction ( "del/$item->id/" , 'Borrar' ) ?>   
      <strong> <?php   echo  $item-> nombre   ?>  - <?php   echo  $item-> titulo   ?> </strong>   
  </li>  
  <?php   endforeach ; ?>  
  </ul>  
  
   // ejemplo manual de paginador, hay partial listos en formato digg,
clasic,....  
  <?php   if ($listMenus-> prev ) echo  Html:: linkAction (
"index/$listMenus->prev/" , '<< Anterior |' ); ?>  
  <?php   if ($listMenus-> next ) echo  Html:: linkAction (
"index/$listMenus->next/" , 'Proximo >>' ); ?>  
</div>  
```  
  
[app]/views/menus/create.phtml

```php
<?php  View:: content (); ?>  
<h3>Crear menu<h3>  
  
<?php   echo  Form:: open (); // por defecto llama a la misma url ?>  
  
      <label>Nombre   
      <?php echo  Form:: text ( 'menus.nombre' ) ?> </label>   
  
      <label>Titulo   
      <?php   echo  Form:: text ( 'menus.titulo' ) ?> </label>   
  
      <?php   echo  Form:: submit ( 'Agregar' ) ?>   
  
<?php   echo  Form:: close () ?>  
```

```php 
[app]/views/menus/edit.phtml

<?php  View:: content (); ?>  
<h3>Editar menu<h3>  
<?php   echo  Form:: open (); // por defecto llama a la misma url ?>  
  <label>Nombre  <?php   echo  Form:: text ( 'menus.nombre' ) ?> </label>   
  <label>Titulo  <?php   echo  Form:: text ( 'menus.titulo' ) ?> </label>   
  <?php   echo  Form:: hidden ( 'menus.id' ) ?>   
  <?php   echo  Form:: submit ( 'Actualizar' ) ?>   
<?php   echo  Form:: close () ?>  
```  
  
  
###  Probando el CRUD

Ahora solo resta probar todo el codigo que hemos generado, en este punto es
importante conocer el comportamiento de las [URL's en KumbiaPHP](http://wiki.kumbiaphp.com/Hola_Mundo_KumbiaPHP_Framework#KumbiaPHP_URLS) .

  * index es la accion para listar http://localhost/menus/index/
NOTA: index/ se puede pasar de forma implicita o no.  KumbiaPHP en caso que no
se le pase una accion, buscara por defecto un index, es decir si colocamos:
http://localhost/menus/
  * create crea un menu en la Base de Datos http://localhost/menus/create/
  * Las acciones del y edit a ambas se debe entrar desde el index, ya que reciben el parametros a editar o borrar segun el caso.

##  Aplicacion en producción

TODO

##  Partials de paginacion

Como complemento para el paginador de ActiveRecord, a traves de vistas
parciales se implementan los tipos de paginacion mas comunes. Estos se ubican
en el directorio "core/views/partials/paginators" listos para ser usados. Son
completamente configurables via CSS. Por supuesto, podeis crear vuestros
propios partials para paginar en las vistas.

###  Classic

Vista de paginacion clasica.

![](images/image07.jpg)

Resultado Final

Parametros de configuracion:

page:  objeto obtenido al invocar al paginador.

show:  numero de paginas que se mostraran en el paginador, por defecto 10.

url:  url para la accion que efectua la paginacion, por defecto
"module/controller/page/" y se envia por parametro el numero de pagina.

View :: partial ( 'paginators/classic' ,  false ,   array ( 'page'   =>
$page ,   'show'   =>   8 ,   'url'   =>   'usuario/lista' ));  
  
---  
  
###  Digg

Vista de paginacion estilo digg.

Parametros de configuracion:

page: objeto obtenido al invocar al paginador.

show: numero de paginas  que se mostraran  en el paginador, por defecto 10.

url: url para la accion  que efectua  la paginacion , por defecto
"module/controller/page/" y se envia  por parametro el numero de pagina.

View :: partial ( 'paginators/digg' ,  false ,   array ( 'page'   =>   $page ,
'show'   =>   8 ,   'url'   =>   'usuario/lista' ));  
  
---  
  
###  Extended

![](images/image00.jpg)

Resultado Final

Vista de paginacion extendida.

Parametros de configuracion:

page:  objeto obtenido al invocar al paginador.

url:  url para la accion  que efectua  la paginacion , por defecto
"module/controller/page/" y se envia  por parametro el numero de pagina.

View :: partial ( 'paginators/extended' ,  false ,   array ( 'page'   =>
$page ,   'url'   =>   'usuario/lista' ));  
  
---  
  
###  Punbb

Vista de paginacion estilo punbb.

Parametros de configuracion:

page:  objeto obtenido al invocar al paginador.

show:  numero de paginas  que se mostraran  en el paginador, por defecto 10.

url:  url para la accion  que efectua  la paginacion , por defecto
"module/controller/page/" y se envia  por parametro  el numero de pagina.

View :: partial ( 'paginators/punbb' ,  false ,   array ( 'page'   =>   $page
,   'show'   =>   8 ,   'url'   =>   'usuario/lista' ));  
  
---  
  
###  Simple

![](images/image11.jpg)

Resultado Final

Vista de paginacion simple.

Parametros de configuracion:

page:  objeto obtenido al invocar al paginador.

url:  url para la accion  que efectua  la paginacion , por defecto
"module/controller/page/" y se envia  por parametro el numero de pagina.

View :: partial ( 'paginators/simple' ,  false ,   array ( 'page'   =>   $page
,   'url'   =>   'usuario/lista' ));  
  
---  
  
###  Ejemplo de uso

Supongamos que queremos paginar una lista de usuarios.

Para el modelo Usuario en models/usuario.php:
```php
<?php  
class  Usuario extends  ActiveRecord  
{  
  /**  
    * Muestra los usuarios de cinco en cinco utilizando paginador   
    *   
    * @param int $page   
    * @return object   
    **/   
  public   function  ver($page=1)  
  {  
      return  $this-> paginate ( "page: $page" , 'per_page: 5' );   
  }  
}  
?>  
```  
  
Para el controlador UsuarioController en controllers/usuario_controller.php:

```php
<?php  
Load:: models ( 'usuario' );  
  
class  UsuarioController extends  AppController  
{  
  
  /**  
    * Accion de paginacion   
    *   
    * @param int $page   
    **/   
  public   function  page($page=1)  
  {  
      $Usuario = new  Usuario();   
      $this-> page  = $Usuario-> ver ($page);   
  }  
}  
?>  
```
  
Y en la vista views/usuario/page.phtml

<table>  
<tr>  
<th>Id</th>  
<th>Nombre</th>  
</tr>  
<?php   foreach ($page-> items   as  $p): ?>  
<tr>  
<td> <?php   echo  $p-> id ; ?> </td>  
<td> <?php   echo  $p-> nombre ; ?> </td>  
</tr>  
<?php   endforeach ; ?>  
</table>  
  
<?php  View:: partial ( 'paginators/classic' , false , array ( 'page'  =>
$page)); ?>  
  
---  
  
* * *

##  Auth

* * *

##  Beta1 a Beta2

* * *

##  Deprecated

##  Metodos y clases que se usaban en versiones anteriores y que aun
funcionan. Pero que quedan desaconsejadas y que no funcionaran en el futuro
(proxima beta o version final):

Posiblemente habra 2 versiones:

beta2 con lo deprecated para facilitar migracion

beta2.2 sin lo deprecated mas limpia y rapida, para empezar nuevas apps

Flash::success() ahora Flash::valid()

Flash::notice() ahora Flash::info()

ApplicationController  ahora AppController (con sus respectivos cambios de
metodos)

….

Usar $this->response = 'view' o View::response('view') para no mostrar el
template.

Ahora View::template(NULL) el View::response() solo se usa para elegir
formatos de vista alternativos.

###  Lista de cambios entre versiones: si no se especifica beta1 es que es
compatible en ambos casos

Application

ControllerBase 0.5  => ApplicationController beta1 => AppController beta2

public function init 0.5  => protected function initialize beta2

render_view 0.5  => View::select beta2

Models

public $mode 0.5  => public $database beta1 y beta2

Callbacks

public function initialize 0.5  => protected function initialize beta2

public function finalize 0.5  => protected function finalize beta2

public function before_filter 0.5  => protected function before_filter beta2

public function after_filter 0.5  => protected function after_filter beta2

boot.ini se elimina en beta2

kumbia / mail / libchart 0.5  => se elimina los prefijos beta1

extensions 0.5  => libs beta1

Input::

$this->has_post 0.5  => Input::hasPost beta2

$this->has_get 0.5  => Input::hasGet beta2

$this->has_request 0.5  => Input::hasRequest beta2

$this->post 0.5  => 'Input::post beta2

$this->get 0.5  => 'Input::get beta2

$this->request 0.5  => 'Input::request beta2

View::

$this->cache 0.5  => View::cache beta2

$this->render 0.5  => 'View::select beta2

$this->set_response 0.5  => View::response beta2

content() 0.5  => View::content() beta2

render_partial 0.5  => View::partial beta2

Router::

$this->route_to 0.5  => 'Router::route_to beta1 y beta2

$this->redirect 0.5  => Router::redirect beta2

Html::

img_tag 0.5  => 'Html::img beta2

link_to 0.5  => 'Html::link beta2

link_to_action 0.5  => 'Html::linkAction beta2

stylesheet_link_tags 0.5  => 'Html::includeCss beta2

Ajax::

form_remote_tag 0.5  => 'Ajax::form beta2

link_to_remote 0.5  => 'Ajax::link beta2

Form::

end_form_tag 0.5  => 'Form::close beta2

form_tag 0.5  => 'Form::open beta2

input_field_tag 0.5 ' => 'Form::input beta2

text_field_tag 0.5  => 'Form::text beta2

password_field_tag 0.5  => 'Form::pass beta2

textarea_tag 0.5  => 'Form::textarea beta2

hidden_field_tag 0.5  => 'Form::hidden beta2

select_tag 0.5  => 'Form::select beta2

file_field_tag 0.5  => 'Form::file beta2

button_tag 0.5  => 'Form::button beta2

submit_image_tag 0.5  => 'Form::submitImage beta2

submit_tag 0.5  => 'Form::submit beta2

checkbox_field_tag 0.5  => 'Form::check beta2

radio_field_tag 0.5  => 'Form::radio beta2

Tag::

javascript_include_tag 0.5  => 'Tag::js beta2

stylesheet_link_tag 0.5  => 'Tag::css beta2

###  Cambio en las rutas entre versiones:

# 0.5 => 1.0 beta1

                    '/apps/default' => '/app',

                    '/apps' => '',

                    '/app/controllers/application.php' => '/app/application.php',

                    '/app/views/layouts' => '/app/views/templates',

                    '/app/views/index.phtml' => '/app/views/templates/default.phtml',

                    '/app/views/not_found.phtml' => '/app/views/errors/404.phtml',

                    '/app/views/bienvenida.phtml' => '/app/views/pages/index.phtml',

                    '/app/helpers' => '/app/extensions/helpers',

                    '/app/models/base/model_base.php' => '/app/model_base.php',

                    '/app/models/base/' => '',

                    '/cache' => '/app/cache',

                    '/config' => '/app/config',

                    '/docs' => '/app/docs',

                    '/logs' => '/app/logs',

                    '/scripts' => '/app/scripts',

                    '/test' => '/app/test',

# 1.0 beta1 => 1.0 beta2

                …

Cambiados:

Session::isset_data() ahora Session::has()

Session::unset_data() ahora Session::delete()

* * *

##  Glosario

CRUD = Create Read Update Delete ( Crear Leer Actualizar Borrar )

ABM

MVC = Model View Controller ( Modelo Vista Controlador )

HTML = HyperText Markup Language ( Lenguaje de Marcado de HiperTexto )

SQL = Structured Query Language   ( Lenguaje de Consulta Estructurado   )
