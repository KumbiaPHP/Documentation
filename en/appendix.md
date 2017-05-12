# Appendices

## Integration of jQuery and KumbiaPHP

KumbiaPHP provides integration with the JavaScript Framework jQuery

### KDebug

KDebug is a new object incorporated to the integration plugins at KumbiaPHP/JQuery that allows a debugging of the code in development time. With just one parameter you can use a log that allow see in console (while available, if not it using alert) allowing a better control of the execution.

It's not necessary, but will be helpful if you work with tools like Firebug in Mozilla Firefox o some browser that use the WebKit console, like Google Chrome.

## Application in production

TODO

## Partials de paginación

Como complemento para el paginado de ActiveRecord, a través de vistas parciales se implementan los tipos de pacciona mas comunes. Estos se ubican en el directorio "core/views/partials/paginators" listos para ser usados. Son completamente configurables vía CSS. Por supuesto, podéis crear vuestros propios partials para paginar en las vistas.

### Classic

Vista de paginado clásica.

![](../images/image07.jpg)

Final result

Configuration parameters:

page: object obtained from paginator.

show: number of pages to be shown in the paginator. Default 10.

url: url para la accion que efectúa la pacciona, por defecto "module/controller/page/" y se envía por parámetro el número de página.

```php
View::partial('paginators/classic', false, array ( 'page' => $page, 'show' => 8, 'url' => 'usuario/lista'));
```

* * *

### Digg

View paging style digg.

Configuration parameters:

page: object obtained from paginator.

show: número de páginas que muestra el paginador, por defecto 10.

url: url para la accion que efectúa la pacciona , por defecto "module/controller/page/" y se envía por parámetro el número de página.

```php
View::partial('paginators/digg', false, array('page' => $page, 'show' => 8, 'url' => 'usuario/lista'));
```

* * *

### Extended

![](../images/image00.jpg)

Resultado Final

Vista de paginación extendida.

Parámetros de configuración:

page: objeto obtenido al invocar al paginador.

url: url para la accion que efectúa la pacciona , por defecto "module/controller/page/" y se envía por parámetro el número de página.

```php
View::partial('paginators/extended', false, array('page' => $page, 'url' => 'usuario/lista'));
```

* * *

### Punbb

Vista de paginación estilo punbb.

Parámetros de configuración:

page: objeto obtenido al invocar al paginador.

show: número de páginas que muestra el paginador, por defecto 10.

url: url para la acción que efectúa la paginación, por defecto "module/controller/page/" y se envia por parámetro el número de página.

```php
View::partial('paginators/punbb', false, array('page' => $page, 'show' => 8, 'url' => 'usuario/lista'));
```

* * *

### Simple

![](../images/image11.jpg)

Resultado Final

Vista de paginación simple.

Parámetros de configuración:

page: objeto obtenido al invocar al paginador.

url: url para la acción que efectua la paginación , por defecto "module/controller/page/" y se envía por parámetro el número de página.

```php
View::partial('paginators/simple', false, array('page' => $page, 'url' => 'usuario/lista'));
```

* * *

### Ejemplo de uso

Supongamos que queremos paginar una lista de usuarios.

Para el modelo Usuario en models/usuario.php:

```php
<?php  
class Usuario extends ActiveRecord
{  
  /**  
    * Muestra los usuarios de cinco en cinco utilizando paginador
    *
    * @param int $page
    * @return object
    **/
  public function ver($page=1)
  {
      return $this->paginate("page: $page", 'per_page: 5');
  }
}

```

Para el controlador UsuarioController en controllers/usuario_controller.php:

```php
<?php  
//Load::models('usuario'); //Necesario en versiones < 1.0

class UsuarioController extends AppController
{
  /**
    * Acción de paginado
    *
    * @param int $page
    **/
  public function page($page=1)
  {
      $this->page = (new Usuario)->ver($page);
  }
}

```

Y en la vista views/usuario/page.phtml

```php
<table>
<tr>
<th>Id</th>
<th>Nombre</th>
</tr>
<?php foreach($page->items as $p) : ?>
<tr>
<td><?= $p->id ?></td>
<td><?= $p->nombre ?></td>
</tr>
<?php endforeach ?>
</table>

<?php  View::partial('paginators/classic', false, ['page' => $page]) ?>
```

* * *

* * *

## Auth

* * *

## Beta1 a Beta2

* * *

## Deprecated

## Métodos y clases que se usaban en versiones anteriores y que aun

funcionan. Pero que quedan desaconsejadas y que no funcionarán en el futuro (próxima beta o versión final):

Posiblemente habrá 2 versiones:

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

| 0.5                             | beta1                           | beta2 v0.9                         | v1.0                               |
| ------------------------------- | ------------------------------- | ---------------------------------- | ---------------------------------- |
| public function init()          | protected function initialize() | protected function initialize()    | protected function initialize()    |
| public function finalize()      |                                 | protected function finalize()      | protected function finalize()      |
| public function before_filter() |                                 | protected function before_filter() | protected function before_filter() |
| public function after_filter()  |                                 | protected function after_filter()  | protected function after_filter()  |

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