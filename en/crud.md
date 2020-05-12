# CRUD

## Introduction

This example allows easy understanding of the implementation of a CRUD (Create, Read, Update and Delete) without the need of a Scaffold, doing a correct handling of the MVC in KumbiaPHP.

## Configuración de conexión a la base de datos

Configurar el archivo [databases.ini o databases.php](active-record.md#configurando-conexión-a-la-base-de-datos) , con los datos y motor de base de datos a utilizar.

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
* Load of model Menus...   
*/   
// Load::models( 'menus' );// Necessary for versions < 0.9 

class MenusController extends AppController
{
    /**
     * Obtain a list for pagination of menus
     *
     * @param int $page [opcional]
     */
    public function index($page = 1)
    {
         $this->listMenus = (new Menus)->getMenus($page);
    }

    /**
     * Make a record
     */
    public function create()
    {
        /**
         * Verify if the user send the form(submit) and if also
         * inner of array POST exist a variable called "menus"
         * that which applies for the auto load  of object for save the
         * date send for POST using auto load of object
         */
        if (Input::hasPost('menus')) {
            /**
             * the data of form is sent to model for construct and ActiveRecord collect 
             * this data and associate to the corresponding field when it's use the convention
             * model.field
             */
            $menu = new Menus(Input::post('menus'));
            //In case that the operation fail
            if ($menu->create()) {
                Flash::valid('Success');
                //Delete the POST, if don't wanna that it can be seen in the form
                Input::delete();
                return;
            }

            Flash::error('Operation Fail');
        }
    }

    /**
     * Edit a record
     *
     * @param int $id (required)
     */
    public function edit($id)
    {
        $menu = new Menus();

        //verify if the post as send data (submit)
        if (Input::hasPost('menus')) {

            if ($menu->update(Input::post('menus'))) {
                 Flash::valid(Success');
                //redirect por default to the index of controller
                return Redirect::to();
            }
            Flash::error('Operation Fail');
            return;
        }

        //Applied the auto load of object, for start the edition
        $this->menus = $menu->find_by_id((int) $id);

    }

    /**
     * Delete a menu
     *
     * @param int $id (require)
     */
    public function del($id)
    {
        if ((new Menus)->delete((int) $id)) {
                Flash::valid('Success');
        } else {
                Flash::error('Operation fail');
        }

        //redirect to the index of controller
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