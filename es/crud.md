# CRUD

## Introducción

Este ejemplo, permite de manera sencilla conocer y entender la
implementación de un CRUD (Create, Read, Update y Delete en inglés) sin la
necesidad de un Scaffold y un manejo correcto del MVC en KumbiaPHP.

## Configurando database.ini

Configurar el archivo [databases.ini](http://wiki.kumbiaphp.com/KumbiaPHP_Framework_Versi%C3%B3n_1.0_Spirit#databases.ini) ,
con los datos y motor de Base de Datos a utilizar.

## Modelo

Crear el Modelo dado por la definición de una tabla en la BD, 
para efecto del ejemplo creamos la siguiente tabla.

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

class Menus extends ActiveRecord
{
    /**
      * Retorna los menús para ser paginados
      *
      * @param int $page  [requerido] página a visualizar
      * @param int $ppage [opcional] por defecto 20 por página
      */
    public function getMenus($page, $ppage=20)
    {
        return $this->paginate("page: $page", "per_page: $ppage", 'order: id desc');
    }
}

```  
  
## Controller

El controlador es encargado de atender las peticiones del cliente (ej.
browser) y a su vez de darle una respuesta. En este controller vamos a definir
todas las operaciones CRUD que necesitamos.

[app]/controllers/menus_controller.php:

```php
<?php  
/**  
* Carga del modelo Menus...   
*/   
// Load::models( 'menus' );// Necesario en versiones < 0.9 
  
class MenusController extends AppController
{
    /**
     * Obtiene una lista para paginar los menús
     *
     * @param int $page [opcional]
     */
    public function index($page = 1)
    {
         $this->listMenus = (new Menus)->getMenus($page);
    }
 
    /**
     * Crea un Registro
     */
    public function create()
    {
        /**
         * Se verifica si el usuario envío el form (submit) y si además
         * dentro del array POST existe uno llamado "menus"
         * el cual aplica la autocarga de objeto para guardar los
         * datos enviado por POST utilizando autocarga de objeto
         */
        if (Input::hasPost('menus')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $menu = new Menus(Input::post('menus'));
            //En caso que falle la operación de guardar
            if ($menu->create()) {
                Flash::valid('Operación exitosa');
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                return;
            }
 
            Flash::error('Falló Operación');
        }
    }
 
    /**
     * Edita un Registro
     *
     * @param int $id (requerido)
     */
    public function edit($id)
    {
        $menu = new Menus();
 
        //se verifica si se ha enviado el formulario (submit)
        if (Input::hasPost('menus')) {
 
            if ($menu->update(Input::post('menus'))) {
                 Flash::valid('Operación exitosa');
                //enrutando por defecto al index del controller
                return Redirect::to();
            }
            Flash::error('Falló Operación');
            return;
        }

        //Aplicando la autocarga de objeto, para comenzar la edición
        $this->menus = $menu->find_by_id((int) $id);
 
    }
 
    /**
     * Eliminar un menú
     *
     * @param int $id (requerido)
     */
    public function del($id)
    {
        if ((new Menus)->delete((int) $id)) {
                Flash::valid('Operación exitosa');
        } else {
                Flash::error('Falló Operación');
        }

        //enrutando por defecto al index del controller
        return Redirect::to();
    }
}

``` 
  
## Vistas

Agregamos las vistas...

[app]/views/menus/index.phtml
```php
<div class="content">
  <?php View::content() ?> 
  <h3>Menús</h3>
  <ul>
  <?php foreach($listMenus->items as $item) : ?> 
  <li>
      <?= Html::linkAction("edit/$item->id/", 'Editar') ?> 
      <?= Html::linkAction("del/$item->id/", 'Borrar') ?> 
      <strong><?= $item->nombre ?> - <?= $item->titulo ?></strong>
  </li>
  <?php endforeach ?>
  </ul>
  
   // ejemplo manual de paginado, existen partials listos en formato digg, clasic,...
  <?php if($listMenus->prev) echo Html::linkAction("index/$listMenus->prev/", '<< Anterior |') ?> 
  <?php if($listMenus->next) echo Html::linkAction("index/$listMenus->next/", 'Proximo >>') ?> 
</div>
```  
  
[app]/views/menus/create.phtml

```php
<?php View::content() ?>
<h3>Crear menú<h3>

<?= Form::open(); // por defecto llama a la misma url ?> 

      <label>Nombre
      <?= Form::text('menus.nombre') ?></label>

      <label>Titulo
      <?= Form::text('menus.titulo') ?></label>

      <?= Form::submit('Agregar') ?> 

<?= Form::close() ?> 
```
[app]/views/menus/edit.phtml
```php 
<?php View::content() ?> 
<h3>Editar menú<h3>
<?= Form::open(); // por defecto llama a la misma url ?>
  <label>Nombre <?= Form::text('menus.nombre') ?></label>
  <label>Titulo <?= Form::text('menus.titulo') ?></label>
  <?= Form::hidden('menus.id') ?> 
  <?= Form::submit('Actualizar') ?> 
<?= Form::close() ?>
```  
  
  
##  Probando el CRUD

Ahora sólo resta probar todo el código que hemos generado, en este punto es
importante conocer el comportamiento de las [URL's en KumbiaPHP](http://wiki.kumbiaphp.com/Hola_Mundo_KumbiaPHP_Framework#KumbiaPHP_URLS) .

  * index es la acción para listar http://localhost/menus/index/
NOTA: index/ se puede pasar de forma implícita o no.  KumbiaPHP en caso que no
se le pase una accion, buscara por defecto un index, es decir si colocamos:
http://localhost/menus/
  * create crea un menú en la Base de Datos http://localhost/menus/create/
  * Las acciones del y edit a ambas se debe entrar desde el index, ya que reciben el parámetros a editar o borrar según el caso.