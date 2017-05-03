# CRUD

## Introduction

This example allows easy understanding of the implementation of a CRUD (Create, Read, Update and Delete) without the need of a Scaffold, doing a correct handling of the MVC in KumbiaPHP.

## Configuring database.ini

Configure the databases.ini with the data and the db engine to be used.

## Model

Create the Model that defines the table in the database, for complementing the example we create the follow table.

```sql
CREATE TABLE menus
(
id           int            unique not null auto_increment,
nombre       varchar(100),
titulo       varchar(100)   not null,
primary key(id)
)  
```

We will now define the model which allows us to interact with the database.

[app]/models/menus.php:

```php
<?php

class Menus extends ActiveRecord
{
    /**
      * Return the menus for pagination
      *
      * @param int $page  [required] page to see
      * @param int $ppage [optional] for default 20 for page
      */
    public function getMenus($page, $ppage=20)
    {
        return $this->paginate("page: $page", "per_page: $ppage", 'order: id desc');
    }
}

```

## Controller

The controller handles client requests and replies (ie, a browser). In this controller we must define all the CRUD actions/functions we need.

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

## Views

We add the views...

[app]/views/menus/index.phtml

```php
<div class="content">
  <?php View::content() ?> 
  <h3>Menus</h3>
  <ul>
  <?php foreach($listMenus->items as $item) : ?> 
  <li>
      <?= Html::linkAction("edit/$item->id/", 'Edit') ?> 
      <?= Html::linkAction("del/$item->id/", 'Delete') ?> 
      <strong><?= $item->nombre ?> - <?= $item->titulo ?></strong>
  </li>
  <?php endforeach ?>
  </ul>

   // Manual paginate example, exist partials ready in formats digg, clasic,...
  <?php if($listMenus->prev) echo Html::linkAction("index/$listMenus->prev/", '<< Previous |') ?> 
  <?php if($listMenus->next) echo Html::linkAction("index/$listMenus->next/", 'Next >>') ?> 
</div>
```

[app]/views/menus/create.phtml

```php
<?php View::content() ?>
<h3>Create menu<h3>

<?= Form::open(); // by default the same url ?> 

      <label>Nombre
      <?= Form::text('menus.nombre') ?></label>

      <label>Titulo
      <?= Form::text('menus.titulo') ?></label>

      <?= Form::submit('Add') ?> 

<?= Form::close() ?> 
```

[app]/views/menus/edit.phtml

```php
<?php View::content() ?> 
<h3>Edit menu<h3>
<?= Form::open(); // by default call the same url ?>
  <label>Name <?= Form::text('menus.nombre') ?></label>
  <label>Title <?= Form::text('menus.titulo') ?></label>
  <?= Form::hidden('menus.id') ?> 
  <?= Form::submit('Update') ?> 
<?= Form::close() ?>
```

## Testing the CRUD

Now it only remains to try all the code that we have generated, at this point it is important to know the behavior of the [URL's in KumbiaPHP](http://wiki.kumbiaphp.com/Hola_Mundo_KumbiaPHP_Framework#KumbiaPHP_URLS).

- index is the default action (ie, http://domain/menus/index/). Declaration of /index it's optional, because the controller would autoload /index if no other has been specified (ie, http://domain/menus/)
- Create creates a menu in the database http://localhost/menus/create/
- Edit and Delete actions are handled from the index in this example, because receives the data/ids to operate from the index.