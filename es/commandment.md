#Recomendaciones Kumbiónicas
Esta sección tiene como objetivo presentarle al desarrollador recién llegado consejos y atajos que le serán de utilidad al momento de usar KumbiaPHP framework en su quehacer cotidiano.

La intención es ayudar al desarrollador a lograr un exitoso lanzamiento de su aplicación, en el menor tiempo y con el menor esfuerzo posible.

##Recomendación de arquitectura o diseño
KumbiaPHP es un framework que te da bastante espacio para expresarte como desarrollador, pero por eso queremos darte algunos consejos que harán tu ciclo de trabajo más eficiente.

###MVC en resumen
En primer lugar, un modelo es una clase que abstrae una tabla de la base de datos (o varias, o una vista) para que puedas consultar y/o manipular su contenido sin tener que escrbir SQL para todo.

Una vista es un archivo de presentación de contenido HTML, ya sea como elemento informativo o para requerir interacción del usuario vía enlaces o formularios.

Un controlador debería ser sólo el pegamento entre lo que las vistas solicitan, y lo que los modelos pueden entregar como elementos de dato.

Y entonces, una buena aplicación "kumbiera" o en cualquier otro framework es aquella que tiene modelos que hacen el trabajo de la lógica del negocio, cálculos y ese tipo de cosas con datos, controladores que hacen peticiones y vistas que muentran contenido de datos solicitados por los controladores a los modelos.

En resumen: **controladores delgados, modelos gordos**.

##Convenciones relativas a la base de datos
Esta primera sección tiene que ver con la forma en la que el desarrollador define sus objetos de datos, atributos y restricciones de integridad en su motor de base de datos.

###Nombres para objetos de datos
Una buena práctica de los "kumbieros" tiene relación con el nombrado de las tablas de la base de datos. Como KumbiaPHP es un framework que utiliza OOP (programación orientada a objetos), la primera recomendación es usar nombres en singular y en minúscula para nombrar cada una de las tablas (tal como si fueran nombres de clases).

Por ejemplo, en un sitio de comercio existen productos,  usuarios, compras, proveedores, etc. Siguiendo la recomendación, los nombres de tabla deberían ser: producto, usuario, compra y proveedor.

Cuando se tiene datos que se relacionan en cardinalidad muchos a muchos (por ejemplo un jugador puede pertenecer a muchos equipos en el tiempo, y un equipo puede tener muchos jugadores), la recomendación es crear la tabla de relación usando ambos nombres en orden alfabético, separados por un guión bajo (underscore, _ ) En el ejemplo se tendría como nombre de tabla de relación equipo_jugador.

### Atributos de las tablas
#### Atributos clave
Una convención de muchos frameworks para el nombrado del atributo clave es usar una columna llamada id, que sea de tipo numérico (sin decimales) y que sea auto_incremental.

A modo de ejemplo, la tabla usuario puede definirse similar a como se muestra a continuación:
```sql
 CREATE TABLE usuario (
   id int not null primary key auto_increment,
   nombre varchar(80) not null,
   email varchar(300) not null,
   clave varchar(40) not null,
   creado_at datetime not null,
   actualizado_in datetime not null
);

   ```
Con esta convención sobre el atributo clave el desarrollador siempre tendrá un identificador único sobre el cual referirte a la tupla (registro, o fila), ya sea para manipular o consultar su contenido.

#### Claves foráneas
Las claves foráneas también tienen una convención que es común en muchos frameworks (y también en KumbiaPHP). El atributo clave debe llamarse como el nombre de la tabla de origen, seguido de un guión bajo (undersore), y finalmente la palabra id. En el ejemplo de la tienda de comercio, un producto es provisto por un único proveedor, así que la tabla producto debe contener un campo foráneo que referencie a la tabla proveedor. Así la definición de la tabla productos podría verse como la siguiente figura:

```sql
CREATE TABLE producto (
  id bigint not null primary key auto_increment,
  nombre varchar(80) not null,
  descripcion tinytext not null,
  costo bigint not null,
  precio bigint not null,
  proveedor_id int not null,
  creado_at datetime not null,
  actualizado_in datetime not null,
  constraint fk_proveedor_a_producto
  foreign key (proveedor_id)
  references proveedor (id)
);
```


La tabla proveedor prodía parecerse a la siguiente definición:
```sql
CREATE TABLE proveedor (
  id int not null primary key auto_increment,
  nombre varchar(80) not null,
  direccion tinytext not null,
  contacto tinytext not null,
  creado_at datetime not null,
  actualizado_in datetime not null
);
```

El caso del ejemplo de la relación muchos a muchos entre jugador y equipo podría tener un esquema de creación sql como el que sigue:
```sql
CREATE TABLE equipo_jugador (
  id bigint not null primary key auto_increment,
  equipo_id int not null,
  jugador_id int not null,
  creado_at datetime not null,
  actualizado_in datetime not null,
  constraint fk_equipo_a_equipo_jugador
  foreign key (equipo_id) references equipo (id),
  constraint fk_jugador_a_equipo_jugador
  foreign key (jugadir_id) references jugador (id)
);
```

Cuando el desarrollador ha definido sus objetos de datos (tablas), atributos y restricciones de integridad referencial, lo ideal es seguir con la definición de las clases del ORM que se harán cargo de la gestión de las tablas y sus datos.


*Nota de libertad*

>Como desarrollador tienes el poder de decidir si usas esta recomendación de nombrado de tablas o no. Para KumbiaPHP no es una transgresión si usas otros nombres de tabla, o si acaso usas prefijos. La recomendación anterior está ligada a la una práctica usual respecto del nombre de la clsae del ORM, con tal que no tengas que reescribir cuestiones que funcionan de manera predeterminada. KumbiaPHP enlaza el nombre de clase ORM con el nombre de archivo php y sin más espera una correlación entre este último y un nombre de tabla en la base de datos (sin la extensión claramente)



##Recomendaciones sobre escritura de código
**Esta es una recomendación de gran utilidad**. Es ideal mantener un cierto estándard de códificación al momento de escribir las aplicaciones. Los "kumbieros" te sugerimos la lectura del siguiente artículo que va directo en apoyo a tus labores de desarrollo:
[Estándares de codificación en PHP.](http://www.codejobs.biz/es/blog/2013/02/19/estandares-de-codificacion-en-php-psr0-psr1-psr2-y-psr3#sthash.QGpAA00m.dpbs)


##Convenciones sobre clases ORM
Asumiendo que el desarrollador ha creado las tablas en singular, entonces la creación de los archivos de modelo debería ser sencilla para él.

La recomendación de los "kumbieros" es nombrar el archivo de clase con el mismo nombre de la tabla en la base de datos.

Siguiendo el ejemplo de la tabla producto, debería existir un modelo llamado producto.php dentro de la carpeta app/models. Nótese que el nombre del archivo php es también el nombre en singular y en minúscula de la tabla.

La definición de clase dentro del archivo php debería verse más o menos como se presenta a continuación*:

```php
<?php
  class Producto extends ActRecord
  {

  }
```

*Nota: Se ha usado herencia sobre ActRecord que es parte de los nuevos componentes de acceso a datos con los que estará provisto KumbiaPHP. Se puede ver cómo instalar dichos componentes en el repositorio [KumbiaPHP/ActiveRecord](https://github.com/KumbiaPHP/ActiveRecord)*

Para el caso de ejemplo de la tabla de relación entre equipo y jugador, el nombre del archivo de modelo sigue la misma recomendación anterior, es decir, el nombre de la tabla en singular y minúsculas: equipo_jugador.php. La definición de clase cambia un poco, y debe verse como sigue:

```php
<?php
  class EquipoJugador extends LiteRecord
  {

  }
```

Como regla, cuando un nombre de tabla es compuesto (usa separador de guión bajo), cada segmento debe iniciar con la primera letra en mayúscula y como un sólo nombre.

En el ejemplo de comercio, la tabla compra tiene una tabla asociada que se llama compra_detalle. El archivo de clase para el modelo asociado será compra_detalle.php (en app/models), y la definición de clase será similar a la de equipo_jugador.php:
```php
<?php
  class CompraDetalle extends ActRecord
  {

  }
```

##Convenciones para controladores
Los controladores no necesariamente tienen reglas fijas de nombre. No hay correlación de carga de elementos entre el nombre del controller y otras clases, dado que el core de KumbiaPHP genera autoload bajo demanda para las clases de modelos, ayudantes (helpers), y librerías.

De todos modos, es una buena práctica "kumbiera" nombrar los controladores con **el mismo nombre de la tabla en plural**. Por consiguiente, el nombre de archivo para el controlador que gestiona los proveedores debería ser proveedores_controller.php (ubicado en app/controllers/). Un ejemplo de controlador básico debería ir de forma similar a como se ve la siguiente figura:

```php
<?php
  class ProveedoresController extends AppController
  {
    public function index()
    {
      $this->proveedores = Proveedor::all();
    }

    public function show($id)
    {
      $this->proveedor = Proveedor($id);
    }

    public function edit($id)
    {
      if (Input::hasPost('proveedor')) {
        if ((new Proveedor)->update(Input::post('proveedor'))) {
          Flash::valid('Proveedor actualizado exitosamente!');
          return Redirect::to(); //ir a index
        }
      }
      $this->proveedor = Proveedor($id);
    }
  }
```

*Nota de libertad*

>Como ya se mencionó con anterioridad, el nombre de los controladores no liga autocarga de modelos, así que le recomendamos que use los nombres de controlador para definir claramente la estructura de su aplicación web, y de igual manera lo haga con las vistas.

##Convenciones para vistas
Las vistas son los archivos de presentación de nuestros datos y contenidos. KumbiaPHP usa de forma predeterminada archivos con extensión phtml. Las vistas, de manera predeterminada, deben corresponder con **el nombre del método que ha sido creado en el controlador**. En el caso de nuestro ejemplo para el controllador que gestiona los proveedores el desarrollador debería crearuna carpeta llamada **app/views/proveedor**, y en ella debería alojar tres archivos llamados **index.phtml**, **show.phtml** y **edit.phtml**.
