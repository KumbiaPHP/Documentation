# Scaffold

## Introducción

To begin, it is important to know, that the Scaffold was used until the stable release 0.5 Kumbiaphp and that leaving Kumbiaphp version 1.0 Spirit beta 1 will leave aside, to create a new one more customizable and maintainable.

Viendo la necesidad y las facilidades que el Scaffold proporciona al apoyo de aplicaciones, el equipo de desarrollo de Kumbiaphp vuelve a incorporar un nuevo para su versión KumbiaPHP beta 2, mejorando y simplificando el desempeño del Scaffold para el Framework y que sin duda aporta a un gran avance en cualquier desarrollo de aplicación para usuarios iniciados en el uso de Kumbiaphp y usuarios avanzados, entregando para todos una gama alta de posibilidades.

## Concept

Scaffold es un método de meta-programación para construir aplicaciones de software que soportan bases de datos. Esta es una nueva técnica soportada por algunos frameworks del tipo MVC (Modelo-Vista-Controlador), donde el programador debe escribir una especificación que escriba como debe ser usada la aplicación de bases de datos. El compilador luego usara esta para generar un código que pueda usar la aplicación para leer, crear, actualizar y borrar entradas de la base de datos (algo conocido como CRUD o ABM), tratando de poner plantillas como un andamio Scaffold) en la cual construir una aplicación mas potente.

Scaffolding es la evolución de códigos generadores de bases de datos desde ambientes más desarrollados, como ser CASE Generator de Oracle y otros tantos servidores 4GL para servicios al Cliente. Scaffolding se hizo popular gracias al framework "Ruby on Rails", que ha sido adaptado a otros frameworks, incluyendo Django, Monorail, KumbiaPHP framework entre otros.

## Objective

Crear un CRUD 100% Funcional con tan solo 2 lineas de código en mi controller.

KumbiaPHP toma como por arte de magia, los parámetros indicados en mi TABLA y arma todo el CRUD.

## Getting Started

Para realizar nuestro primer Scaffold, vamos a utilizar el mismo modelo que trabajamos en el [CRUD para KumbiaPHP Beta2](http://wiki.kumbiaphp.com/Beta2_CRUD_en_KumbiaPHP_Framework) , y que tiene por nombre menus.

Modelo

Crear el modelo, como de costumbre apuntando siempre a la clase ActiveRecord.

[app]/models/menus.php:

```php
<?php  
class  Menus extends  ActiveRecord
{  

}

```

* * *

## Controller

Crear el Controlador en este ejemplo, NO apuntaremos a la clase AppController y SI a la clase ScaffoldController.

[app]/controllers/menus_controller.php:

```php
<?php

class  MenusController extends  ScaffoldController
{  
  public  $model = 'menus' ;  
}

```

* * *

Aquí terminan nuestros primeros pasos. No es necesario NADA MÁS. Tendremos por arte de magia un CRUD 100% Funcional.

## Advantages

  1. Podremos ir cargando nuestros primeros registros en la BD
  2. Pruebas al insertar registros
  3. Avance progresivo, ya que podremos ir sustituyendo las vistas del Scaffold por mis propias vistas.

## Disadvantage

  1. El Scaffold no es para hacer sistemas, si no para ayudar al principio de una aplicación.

## Views for the scaffold

Por defecto usa los de views/_shared/scaffolds/kumbia/... Uno puede crear los suyos dentro de scaffolds views/_shared/scaffolds/foo/... y en el controller además del atributo $model añade; public $scaffold = 'foo';

Asi usará los views de scaffolds/foo/...

Mas importante es todavía, que uno puede crear sus views como siempre. es decir, si creas el controller MiController y creas el view en views/mi/editar.phtml (por ejemplo) usara primero el view, si no existe usa el de scaffolds. Pudiendo uno cambiar los views a su gusto donde quiera y progresivamente.