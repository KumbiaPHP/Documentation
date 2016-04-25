# Appendices

## Integration of jQuery and KumbiaPHP

KumbiaPHP provides integration with the JavaScript Framework jQuery

### KDebug

Kdebug is a new object JIT debugger incoroporated to the integration plugins at KumbiaPHP. With just one parameter you can see the log attached to the console (if available, otherwise fallback to alert() message) and allows you a better control of the app flow.

While it's not necessary, will be helpful if you work with tools like Firebug in Mozilla or any other WebKit based browser.

## CRUD

### Intro

This example allows easy understanding of the implementation of a CRUD (Create, Read, Update and Delete) without the need of a Scaffold, doing a correct handling of the MVC in KumbiaPHP.

The CRUD of the beta1 still works like on the beta2, but we don't recommend it's use. In the 1.0 version both ways are available. The 1.2 version will not include deprecated content. If you need to use it anyway, stick to version 1.0 or update your code.

### Configuring database.ini

Configure the databases.ini with data and the db engine to be used.

### Model

Crear el Modelo el cual esta viene dado por la definicion de una tabla en la BD, para efecto del ejemplo creamos la siguiente tabla.

```sql
CREATE TABLE menus (id int not null auto_increment, name varchar (100) unique, title varchar (100) not null, primary key (id))  
```

Now we define the model that controls DB interaction.

[app]/models/menus.php:

```php
<?php  class Menus extends ActiveRecord  {    /**       * Returns menu to be paginated        *        */     public function getMenus($page, $ppage=20)    {        return $this-> paginate ( "page: $page" , "per_page: $ppage" , 'order: id desc' );     }  }  
```

### Controller

The controller handles client requests and replies (ie, a browser). In this controller we must define all the CRUD actions/functions we need.

[app]/controllers/menus_controller.php:

```php
<?php  /**  * Load model Menus...   
*/   
Load:: models ( 'menus' );// Not needed in v1.0

class  MenusController extends  AppController {  
  /**  
    * Obtains a list to paginate menus   
    */   
  public   function  index($page=1)  
  {  
      $menu = new  Menus();   
      $this-> listMenus  = $menu-> getMenus ($page);   
  }  

  /**  
    * Creates a entry
    */   
  public   function  create ()  
  {  
      /**   
        * Verifies that a form has been submited and looks for a   
        * array item called "menu" to autoload object to store data   
        * sent throuh POST automatically.
        */   
      if (Input:: hasPost ( 'menus' )){   
          /**   
            * We sent form data to model through constructor 
            * and  ActiveRecord receives them the associates
            * data and form labels if you followed the "model.label"
            * convention.
            */   
          $menu = new  Menus(Input:: post ( 'menus' ));   
          // Ensure that data is saved
          if (!$menu-> save ()){   
              Flash:: error ( 'Operation failed' );   
          } else {   
              Flash:: valid ( 'Done' );   
              // Delete POST data to clean the form. Optional.   
              Input:: delete ();   
          }   
      }   
  }  

  /**  
    * Edit an entry
    *   
    * @param int $id (required)   
    */   
  public   function  edit($id)  
  {  
      $menu = new  Menus();   

      // Verify that a form has been submitted
      if (Input:: hasPost ( 'menus' )){   

          if (!$menu-> update (Input:: post ( 'menus' ))){   
              Flash:: error ( 'Operation failed' );   
          } else  {   
              Flash:: valid ( 'Done' );   
              // Routing to index controller  
              return  Router:: redirect ();   
          }   
      } else  {   
          // Using object autoloading to start editing the menus   
          $this-> menus  = $menu-> find ((int)$id);   
      }   
  }  

  /**  
    * Delete a menu entry
    *   
    * @param int $id (required)   
    */   
  public   function  del($id)  
  {  
      $menu = new  Menus();   
      if  (!$menu-> delete ((int)$id)) {   
              Flash:: error ( 'Operation failed' );   
      } else {   
              Flash:: valid ( 'Done' );   
      }   

      // Routing to index controller   
      return  Router:: redirect ();   
  }  
}  
```

### Views

We add the views...

[app]/views/menus/index.phtml

```php
<div class="content">    <?php echo View:: content (); ?>    <h3>Menus</h3>    <ul>    <?php foreach ($listMenus-> items as $item) : ?>    <li>        <?php echo Html:: linkAction ( "edit/$item->id/" , 'Editar' ) ?>         <?php echo Html:: linkAction ( "del/$item->id/" , 'Borrar' ) ?>         <strong> <?php echo $item-> nombre ?> - <?php echo $item-> titulo ?> </strong>     </li>    <?php endforeach ; ?>    </ul>     // Manual paginator example. There are a few defined style paginators like digg, clasic, etc ...  
  <?php   if ($listMenus-> prev ) echo  Html:: linkAction (
"index/$listMenus->prev/" , '<< Previous |' ); ?>  
  <?php   if ($listMenus-> next ) echo  Html:: linkAction (
"index/$listMenus->next/" , 'Next >>' ); ?>  
</div>  
```

[app]/views/menus/create.phtml

```php
<?php  View:: content (); ?>  
<h3>Crear menu<h3>  

<?php   echo  Form:: open (); // By default loads same url ?>  

      <label>Name   
      <?php echo  Form:: text ( 'menus.name' ) ?> </label>   

      <label>Title  
      <?php   echo  Form:: text ( 'menus.title' ) ?> </label>   

      <?php   echo  Form:: submit ( 'Add' ) ?>   

<?php   echo  Form:: close () ?>  
```

[app]/views/menus/edit.phtml

```php
<?php  View:: content (); ?>  
<h3>Editar menu<h3>  
<?php   echo  Form:: open (); // By default loads same url  ?>  
  <label>Name  <?php   echo  Form:: text ( 'menus.name' ) ?> </label>   
  <label>Title  <?php   echo  Form:: text ( 'menus.title' ) ?> </label>   
  <?php   echo  Form:: hidden ( 'menus.id' ) ?>   
  <?php   echo  Form:: submit ( 'Update' ) ?>   
<?php   echo  Form:: close () ?>  
```

### Testing the CRUD

Now it only remains to try all the code that we have generated, at this point it is important to know the behavior of the [URL's in KumbiaPHP](http://wiki.kumbiaphp.com/Hola_Mundo_KumbiaPHP_Framework#KumbiaPHP_URLS).

* index is the default action (ie, http://domain/menus/index/). Declaration of /index it's optional, because the controller would autoload /index if no other has been specified (ie, http://domain/menus/).
* "/create" creates a new menu in the database (http://domain/menus/create/)
* Edit and Delete actions are handled from the index in this example, because receives the data/ids to operate from the index.

## Application in production

TODO: Complete "Application in production"

## Partials for pagination

There are special partials made to enhance the pagination, using common known styles of paginators. Them are on the path "core/views/partials/paginators" and are ready to use. Are fully customizable using CSS and of course you can edit or create your own partials for paginators.

### Classic

Classic's file pagination view

![](../images/image07.jpg)

Final result

Configuration parameters:

page: object obtained from paginator.

show: number of pages to be shown in the pager. Default 10.

url: url para la accion que efectua la paginacion, por defecto "module/controller/page/" y se envia por parametro el numero de pagina.

`View :: partial ( 'paginators/classic' ,  false ,   array ( 'page'   =>
$page ,   'show'   =>   8 ,   'url'   =>   'usuario/lista' ));`

* * *

### Digg

Vista de paginación estilo digg.

Parámetros de configuración:

page: objeto obtenido al invocar al paginador.

show: número de páginas que muestra el paginador, por defecto 10.

url: url para la accion que efectua la paginacion , por defecto "module/controller/page/" y se envia por parametro el numero de pagina.

`View :: partial ( 'paginators/digg' ,  false ,   array ( 'page'   =>   $page ,
'show'   =>   8 ,   'url'   =>   'usuario/lista' ));`

* * *

### Extended

![](../images/image00.jpg)

Resultado Final

Vista de paginación extendida.

Parámetros de configuración:

page: objeto obtenido al invocar al paginador.

url: url para la accion que efectua la paginacion , por defecto "module/controller/page/" y se envia por parametro el numero de pagina.

`View :: partial ( 'paginators/extended' ,  false ,   array ( 'page'   =>
$page ,   'url'   =>   'usuario/lista' ));`

* * *

### Punbb

Vista de paginación estilo punbb.

Parámetros de configuración:

page: objeto obtenido al invocar al paginador.

show: número de páginas que muestra el paginador, por defecto 10.

url: url para la acción que efectua la paginación , por defecto "module/controller/page/" y se envia por parámetro el número de página.

`View :: partial ( 'paginators/punbb' ,  false ,   array ( 'page'   =>   $page
,   'show'   =>   8 ,   'url'   =>   'usuario/lista' ));`

* * *

### Simple

![](../images/image11.jpg)

Resultado Final

Vista de paginación simple.

Parámetros de configuración:

page: objeto obtenido al invocar al paginador.

url: url para la acción que efectua la paginación , por defecto "module/controller/page/" y se envia por parámetro el número de página.

`View :: partial ( 'paginators/simple' ,  false ,   array ( 'page'   =>   $page
,   'url'   =>   'usuario/lista' ));`

* * *

### Ejemplo de uso

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

```

Para el controlador UsuarioController en controllers/usuario_controller.php:

```php
<?php  
Load:: models ( 'usuario' ); //No es necesario en v1.0

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

```

Y en la vista views/usuario/page.phtml

<table>
  <tr>
    <th>
      Id
    </th>
    
    <th>
      Nombre
    </th>
  </tr>
  
  <?php   foreach ($page-> items as $p): ?> 
  
  <tr>
    <td>
      <?php   echo  $p-> id ; ?>
    </td>
    
    <td>
      <?php   echo  $p-> nombre ; ?>
    </td>
  </tr>
  
  <?php   endforeach ; ?>
</table>

<?php  View:: partial ( 'paginators/classic' , false , array ( 'page'  => $page)); ?> 

* * *

* * *

## Auth

* * *

## Beta1 a Beta2

* * *

## Deprecated

## Métodos y clases que se usaban en versiones anteriores y que aun

funcionan. Pero que quedan desaconsejadas y que no funcionarán en el futuro (próxima beta o version final):

Posiblemente habra 2 versiones:

0.9 = 100% compatible beta2, con lo deprecated para facilitar migración

1.0 = sin lo deprecated más limpia y rápida, para empezar nuevas apps

| 0.5 | beta1 | beta2 v0.9 | v1.0 |
| --- | ----- | ---------- | ---- |
|     |       |            |      |

Flash::success() ahora Flash::valid()

Flash::notice() ahora Flash::info()

ApplicationController ahora AppController (con sus respectivos cambios de metodos)

….

Usar $this->response = 'view' o View::response('view') para no mostrar el template.

Ahora View::template(NULL) el View::response() solo se usa para elegir formatos de vista alternativos.

### Lista de cambios entre versiones: si no se especifica beta1 es que es

compatible en ambos casos

#### Application

| 0.5                    | beta1                           | beta2 v0.9                      | v1.0                            |
| ---------------------- | ------------------------------- | ------------------------------- | ------------------------------- |
| ControllerBase         | ApplicationController           | AppController                   | AppController                   |
| public function init() | protected function initialize() | protected function initialize() | protected function initialize() |
| render_view()          | render_view()                   | View::select()                  | View::select()                  |

#### Models

| 0.5          | beta1            | beta2 v0.9       | v1.0             |
| ------------ | ---------------- | ---------------- | ---------------- |
| public $mode | public $database | public $database | public $database |

#### Callbacks

<table>
  <tr>
    <th>
      0.5
    </th>
    
    <th>
      beta1
    </th>
    
    <th>
      beta2 v0.9
    </th>
    
    <th>
      v1.0
    </th>
  </tr>
  
  <tr>
    <td>
      public function init()
    </td>
    
    <td>
      protected function initialize()
    </td>
    
    <td>
      protected function initialize()
    </td>
    
    <td>
      protected function initialize()
    </td>
  </tr>
  
  <tr>
    <td>
      public function finalize()
    </td>
    
    <td>
    </td>
    
    <td>
      protected function finalize()
    </td>
    
    <td>
      protected function finalize()
    </td>
  </tr>
  
  <tr>
    <td>
      public function before_filter()
    </td>
    
    <td>
    </td>
    
    <td>
      protected function before_filter()
    </td>
    
    <td>
      protected function before_filter()
    </td>
  </tr>
  
  <tr>
    <td>
      public function after_filter()
    </td>
    
    <td>
    </td>
    
    <td>
      protected function after_filter()
    </td>
    
    <td>
      protected function after_filter()
    </td>
  </tr>
</table>

boot.ini se elimina en beta2

kumbia / mail / libchart 0.5 => se elimina los prefijos beta1

extensions 0.5 => libs beta1

Input::

$this->has_post 0.5 => Input::hasPost beta2

$this->has_get 0.5 => Input::hasGet beta2

$this->has_request 0.5 => Input::hasRequest beta2

$this->post 0.5 => 'Input::post beta2

$this->get 0.5 => 'Input::get beta2

$this->request 0.5 => 'Input::request beta2

View::

$this->cache 0.5 => View::cache beta2

$this->render 0.5 => 'View::select beta2

$this->set_response 0.5 => View::response beta2

content() 0.5 => View::content() beta2

render_partial 0.5 => View::partial beta2

Router::

$this->route_to 0.5 => 'Router::route_to beta1 y beta2

$this->redirect 0.5 => Router::redirect beta2

Html::

img_tag 0.5 => 'Html::img beta2

link_to 0.5 => 'Html::link beta2

link_to_action 0.5 => 'Html::linkAction beta2

stylesheet_link_tags 0.5 => 'Html::includeCss beta2

Ajax::

form_remote_tag 0.5 => 'Ajax::form beta2

link_to_remote 0.5 => 'Ajax::link beta2

Form::

end_form_tag 0.5 => 'Form::close beta2

form_tag 0.5 => 'Form::open beta2

input_field_tag 0.5 ' => 'Form::input beta2

text_field_tag 0.5 => 'Form::text beta2

password_field_tag 0.5 => 'Form::pass beta2

textarea_tag 0.5 => 'Form::textarea beta2

hidden_field_tag 0.5 => 'Form::hidden beta2

select_tag 0.5 => 'Form::select beta2

file_field_tag 0.5 => 'Form::file beta2

button_tag 0.5 => 'Form::button beta2

submit_image_tag 0.5 => 'Form::submitImage beta2

submit_tag 0.5 => 'Form::submit beta2

checkbox_field_tag 0.5 => 'Form::check beta2

radio_field_tag 0.5 => 'Form::radio beta2

Tag::

javascript_include_tag 0.5 => 'Tag::js beta2

stylesheet_link_tag 0.5 => 'Tag::css beta2

### Cambio en las rutas entre versiones:

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

## Glosario

CRUD = Create Read Update Delete ( Crear Leer Actualizar Borrar )

ABM

MVC = Model View Controller ( Modelo Vista Controlador )

HTML = HyperText Markup Language ( Lenguaje de Marcado de HiperTexto )

SQL = Structured Query Language ( Lenguaje de Consulta Estructurado )