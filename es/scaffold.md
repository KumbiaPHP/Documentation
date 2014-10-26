#  6 Scaffold

##  Introduccion

Para empezar es importante saber, que el Scaffold se utilizo hasta la version
estable de Kumbiaphp 0.5 y que al salir la version de Kumbiaphp 1.0 Spirit
beta 1 se dejo a un lado, hasta crear uno nuevo mas configurable y mantenible.

Viendo la necesidad y las facilidades que el Scaffold proporciona al apoyo de
aplicaciones, el equipo de desarrollo de Kumbiaphp vuelve a incorporar un
nuevo para su version KumbiaPHP beta 2, mejorando y simplificando el desempeño
del Scaffold para el Framework y que sin duda aporta a un gran avance en
cualquier desarrollo de aplicacion para usuarios iniciados en el uso de
Kumbiaphp y usuarios avanzados, entregando para todos una gama alta de
posibilidades.

##  Concepto

Scaffold es un metodo de meta-programacion para construir aplicaciones de
software que soportan bases de datos. Esta es una nueva tecnica soportada por
algunos frameworks del tipo MVC (Modelo-Vista-Controlador), donde el
programador debe escribir una especificacion que escriba como debe ser usada
la aplicacion de bases de datos. El compilador luego usara esta para generar
un codigo que pueda usar la aplicacion para leer, crear, actualizar y borrar
entradas de la base de datos (algo conocido como CRUD o ABM), tratando de
poner plantillas como un andamio Scaffold) en la cual construir una aplicacion
mas potente.

Scaffolding es la evolucion de codigos genereadores de bases de datos desde
ambientes mas desarrollados, como ser CASE Generator de Oracle y otros tantos
servidores 4GL para servicios al Cliente. Scaffolding se hizo popular gracias
al framework "Ruby on Rails", que ha sido adaptado a otros frameworks,
incluyendo Django, Monorail, KumbiaPHP framework entre otros.

Tomado de: [Scaffolding Kumbiaphp](http://www.google.com/url?q=http%3A%2F%2Fwi
ki.kumbiaphp.com%2FScaffolding&sa=D&sntz=1&usg=AFQjCNF7nZ0tDO_67b3jkf_GpSdGae1
qsA)

##  Objetivo

Crear un CRUD 100% Funcional con tan solo 2 lineas de codigo en mi controller.

KumbiaPHP tomara como por arte de magia, los parametros indicados en mi TABLA
y armara todo el CRUD.

##  Primeros Pasos

Para realizar nuestro primer Scaffold, vamos a utilizar el mismo modelo que
trabajamos en el [CRUD para KumbiaPHP Beta2](http://www.google.com/url?q=http%
3A%2F%2Fwiki.kumbiaphp.com%2FBeta2_CRUD_en_KumbiaPHP_Framework&sa=D&sntz=1&usg
=AFQjCNHge4lK8sUvkHneMSUSVC2OZEvvcw) , y que tiene por nombre menus.

Modelo

Crear el modelo, como de costumbre apuntando siempre a la clase ActiveRecord.

[app]/models/menus.php:

<?php  
class  Menus extends  ActiveRecord{  
  
}  
  
---  
  
##  Controlador

Crear el Controlador en este ejemplo, NO apuntaremos a la clase AppController
y SI a la clase ScaffoldController.

[app]/controllers/menus_controller.php:

<?php  
class  MenusController extends  ScaffoldController{  
  public  $model = 'menus' ;  
}  
  
---  
  
Aqui terminan nuestros primeros pasos. No es necesario NADA MÁS. Tendremos por
arte de magia un CRUD 100% Funcional.

##  Ventajas

  1. Podremos ir cargando nuestros primeros registros en la BD
  2. Pruebas al insertar registros
  3. Avance progresivo, ya que podremos ir sustituyendo las vistas del Scaffold por mis propias vistas.

##  Desventaja

  1. El Scaffold no es para hacer sistemas, si no para ayudar al principio de una aplicacion.

##  Views para el scaffold

Por defecto usa los de views/_shared/scaffolds/kumbia/... Uno puede crear los
suyos dentro de scaffolds views/_shared/scaffolds/foo/... y en el controller
ademas del atributo $model añade; public $scaffold = 'foo';

Asi usara los views de scaffolds/foo/...

Mas importante es todavia, que uno puede crear sus views como siempre. es
decir, si creas el controller MiController y creas el view en
views/mi/editar.phtml (por ejemplo) usara primero el view, si no existe usara
el de scaffolds. Asi uno cambia los views a su gusto donde quiera y
progresivamente.
