# Scaffold

##  Introducción

Para empezar es importante saber, que el Scaffold se utilizó hasta la versión estable de Kumbiaphp 0.5 y que al salir la versión de Kumbiaphp 1.0 Spirit beta 1 se dejó a un lado, hasta crear uno nuevo más configurable y mantenible.

Viendo la necesidad y las facilidades que el Scaffold proporciona al apoyo de aplicaciones, el equipo de desarrollo de Kumbiaphp vuelve a incorporar uno nuevo para su versión KumbiaPHP beta 2, mejorando y simplificando el desempeño del Scaffold para el Framework y que sin duda aporta a un gran avance en cualquier desarrollo de aplicación para usuarios iniciados en el uso de Kumbiaphp y usuarios avanzados, entregando para todos una gama alta de posibilidades.

##  Concepto

Scaffold es un método de meta-programación para construir aplicaciones de
software que soportan bases de datos. Esta es una técnica soportada por algunos frameworks del tipo MVC (Modelo-Vista-Controlador), donde el programador debe escribir una especificación que describa cómo debe ser usada la aplicación de bases de datos. El compilador luego usará ésta para generar código capaz de gestionar acciones de lectura, creación, actualización y borrado de registros en la base de datos (esto se conoce como CRUD o ABM). Para la visualización de los contenidos cargará plantillas como un andamio (Scaffold).

Scaffolding es la evolución de códigos generadores de bases de datos desde ambientes más desarrollados, como por ejemplo CASE Generator de Oracle. Scaffolding se hizo popular gracias al framework "Ruby on Rails", por lo que dicha técnica ha sido adaptada a otros frameworks, incluyendo Django, Monorail, KumbiaPHP framework entre otros.

##  Objetivo

Crear un CRUD 100% Funcional con tan sólo 2 lineas de código en mi controller.

KumbiaPHP infiere los atributos de la TABLA y arma todo el CRUD.

##  Primeros Pasos

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
---  

##  Controlador

Al crear el Controlador en este ejemplo, NO apuntaremos a la clase AppController, SINO a la clase ScaffoldController.

[app]/controllers/menus_controller.php:

```php
<?php

class  MenusController extends  ScaffoldController
{  
  public  $model = 'menus' ;  
}

```
---  

Aquí terminan nuestros primeros pasos. No es necesario NADA MÁS. Tendremos por arte de magia un CRUD 100% Funcional.

##  Ventajas

  1. Podremos ir cargando nuestros primeros registros en la BD
  2. Pruebas al insertar registros
  3. Avance progresivo, ya que podremos ir sustituyendo las vistas del Scaffold por vistas propias.

##  Desventaja

  1. El Scaffold no es para hacer sistemas, si no para ayudar al principio de una aplicación.

##  Views para el scaffold

Por defecto usa los de views/_shared/scaffolds/kumbia/... Uno puede crear los suyos dentro de scaffolds views/_shared/scaffolds/foo/... Entonces en el controller, además del atributo $model, se añade el atributo public $scaffold = 'foo';

Así usará los views de scaffolds/foo/...

Más importante es todavía, que uno puede crear sus views como siempre. es
decir, si creas el controller MiController y creas el view en
views/mi/editar.phtml (por ejemplo) usará primero el view, si no existe usa el de scaffolds. Así es posible cambiar los views según la necesidad y de forma progresiva.
