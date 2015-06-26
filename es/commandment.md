#Recomendaciones Kumbiónicas
Esta sección tiene como objetivo presentarle consejos y atajos al desarrollador recién llegado, los que serán de utilidad al momento de usar KumbiaPHP framework en su quehacer cotidiano.

La intención es ayudarle a lograr un exitoso lanzamiento de su aplicación, en el menor tiempo y con el menor esfuerzo posible.

Este documento cubre los siguientes aspectos:
+ Recomendaciones de diseño de la aplicación
+ Convenciones para bases de datos
+ Recomendaciones sobre escritura de código
+ Convenciones sobre clases ORM
+ Convenciones para controladores
+ Convenciones para vistas


##Recomendación de diseño de la aplicación
KumbiaPHP es un framework que le da bastante espacio para expresarse como desarrollador. Por lo mismo es que se ha concentrado en este documento los consejos que harán su ciclo de trabajo más eficiente.

###Breve resumen de MVC
MVC es el acrónimo de una arquitectura para el desarrollo de aplicaciones que divide la misma en tres componentes: Modelos, Vistas y Controladores.

Cada uno de los componentes cumple un rol fundamental dentro de la arquitectura, por lo que es necesario que el desarrollador conozca las funcionalidades de cada uno de ellos.

**El modelo** es el componente (normalmente traducido en clases) que le permite gestionar la lógica de negocio de su aplicación. En este sentido, estos pueden proveer métodos para la edición y consumo de información desde un origen de datos, encargarse de la gestión de notificaciones por correo, manipulación del sistema de archivos entre otros tantos quehaceres que tengan relación con el sentido de su aplicación. La mayor parte del tiempo se crean clases de modelo para abstraer operaciones sobre orígenes de datos (por ejemplo con ActiveRecord o LiteRecord).

**Una vista** es un elemento de presentación de contenido, el que puede ser de cualquier tipo: texto, html, json, xml, excel, pdf, imágenes, streaming, música, entre otros. Las vistas son los elementos consumibles de la aplicación, así como también los encargados de interactuar con los usuarios (humanos o electrónicos)

**Un controlador** debería ser sólo el pegamento entre lo que las vistas solicitan, y lo que los modelos pueden entregar según sea su naturaleza (datos, notificaciones de correo, acceso a archivos, etc.)

Y entonces, una buena aplicación "kumbiera" o en cualquier otro framework es aquella que *tiene modelos que hacen el trabajo de lógica del negocio ( cálculos, gestión de datos, de archivos, de recursos), controladores que hacen peticiones y vistas que muentran contenido de los elementos solicitados por los controladores a los modelos*.

*Una práctica favorable es mantener los controladores con el mínimo código necesario (controladores flacos), y modelos que encapsulan la lógica del negocio (modelos gordos)*

Con lo anterior cerramos la sección de recomendaciones de diseño de la aplicación. Acto seguido podrá encontrar consejos relacionados con la creación de entidades, atributos, claves, entre otros (elementos de base de datos)



##Convenciones para base de datos
Esta sección tiene que ver con la forma en la que el desarrollador define sus objetos de datos, atributos y restricciones de integridad en su motor de base de datos.

###Nombres para objetos de datos
Una buena práctica de los "kumbieros" tiene relación con el nombrado de las tablas de la base de datos. Como KumbiaPHP es un framework que utiliza OOP (programación orientada a objetos), la primera recomendación es usar nombres en singular y en minúscula para nombrar cada una de las tablas (tal como si fueran nombres de clases).

Por ejemplo, en un sitio de comercio existen productos, usuarios, compras, proveedores, etc. Siguiendo la recomendación, los nombres de tabla deberían ser: producto, usuario, compra y proveedor.

Cuando se tiene datos que se relacionan en cardinalidad muchos a muchos (por ejemplo un jugador puede pertenecer a muchos equipos en el tiempo, y un equipo puede tener muchos jugadores), la recomendación es crear la tabla de relación usando ambos nombres en orden alfabético, separados por un guión bajo (underscore, _ ) En el ejemplo se tendría como nombre de tabla de relación equipo_jugador.

### Atributos de las tablas
#### Atributos clave
Una convención de muchos frameworks para el nombrado del atributo clave es usar una columna llamada id, que sea de tipo numérico (sin decimales) y que sea auto_incremental (serial, identity, autonumérico).

A modo de ejemplo, usando MySQL o MariaDB, la tabla usuario puede definirse como se muestra a continuación:
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

Con esta convención sobre el atributo clave el desarrollador siempre tendrá un identificador único sobre el cual referirse a la tupla (registro, o fila), ya sea para manipular o consultar su contenido.

#### Claves foráneas
Las claves foráneas también tienen una convención que es común en muchos frameworks (y obviamente en KumbiaPHP). El atributo clave debe llamarse como el nombre de la tabla de origen, seguido del sufijo "_id" (sin comillas). En el ejemplo de la tienda de comercio, un producto es adquirido a un único proveedor, por lo que la tabla producto debe contener un campo foráneo que referencie a la tabla proveedor. Así la definición de la tabla productos podrá verse como:

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


La tabla proveedor tendrá, como ejemplo, la siguiente definición:
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


El caso del ejemplo de la relación muchos a muchos entre jugador y equipo se podrá tener un esquema de ejemplo como el que sigue:
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

#### Atributos de fecha automáticos
El ORM de KumbiaPHP gestiona automáticamente ciertos atributos para referirse a la fecha de creación de una tupla (registro, fila), y a la fecha de la última actualización de dicho elemento. Para que las tuplas de las tablas puedan administrar esos valores de fecha existen dos sufijos que son especiales para ese tipo de campos: "_at" e "_in". El sufijo "_at" (sin comillas) sirve para referirse a la fecha/hora de creación de un registro. En los ejemplos de tablas anteriores, existe el atributo "creado_at". Por otro lado, el sufijo "_in", permite mantener la fecha/hora de la última actualización de la tupla. En las tablas de ejemplo encontrará "actualizado_in".


Cuando el desarrollador ya ha definido sus objetos de datos (tablas), atributos y restricciones de integridad referencial, lo ideal es seguir con la definición de las clases modelo que gestionarán el acceso y manipulación de los datos. Se recomienda usar modelos que hereden de algún tipo de ORM. En KumbiaPHP existe ActiveRecord y LiteRecord.


*Nota de libertad*

>El desarrollador tiene el poder de decidir si usa esta recomendación de nombrado de tablas. En KumbiaPHP no es una transgresión usar otros nombres para definir dichos elementos. En sí, se entrega este consejo para seguir una práctica usual respecto del nombre de la clase del ORM, y de ese modo optimizar el tiempo de desarrollo en cuestiones importantes, y no en escribir consultas o gestionar el estado de las conexiones.
Cuando se usa modelos que heredan de algún ORM KumbiaPHP enlaza el nombre de clase con el nombre de archivo php y sin más espera una correlación entre este último y la tabla en la base de datos (sin la extensión claramente)



##Recomendaciones sobre escritura de código
**Esta es una recomendación de gran utilidad**. Es ideal apegarse a una norma de códificación al momento de escribir las aplicaciones. Los "kumbieros" le sugieren la lectura del siguiente artículo que va directo en apoyo a sus labores de desarrollo individual, y aún más en el trabajo colectivo:
[Estándares de codificación en PHP.](http://www.codejobs.biz/es/blog/2013/02/19/estandares-de-codificacion-en-php-psr0-psr1-psr2-y-psr3#sthash.QGpAA00m.dpbs)


##Convenciones sobre clases ORM
Asumiendo que el desarrollador ha creado las tablas en singular, entonces la creación de los archivos de modelo será una tarea sencilla.

La recomendación de los "kumbieros" es nombrar el archivo de clase con el mismo nombre de la tabla en la base de datos.

Siguiendo el ejemplo de la tabla producto, debería existir un archivo de modelo llamado producto.php dentro de la carpeta app/models. Nótese que el nombre del archivo php es también el nombre en singular y en minúscula de la tabla.

La definición de clase dentro del archivo php debe verse inicialmente como se presenta a continuación:

```php
<?php
  class Producto extends ActRecord
  {

  }
```

*Nota: Se ha usado herencia sobre ActRecord que es parte de los nuevos componentes de acceso a datos con los que estará provisto KumbiaPHP. Se puede ver cómo instalar dichos componentes en el repositorio [KumbiaPHP/ActiveRecord](https://github.com/KumbiaPHP/ActiveRecord)*


Para el caso de ejemplo de la tabla de relación entre equipo y jugador, el nombre del archivo de modelo sigue la misma recomendación anterior, es decir, el nombre de la tabla en singular y minúsculas: equipo_jugador.php. La definición de clase debe verse como sigue:

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
Los controladores no necesariamente tienen reglas fijas de nombre. No hay correlación de carga de elementos entre el nombre del controller y otras clases, dado que el core de KumbiaPHP genera autoload bajo demanda para los modelos, ayudantes (helpers), y librerías (vendors).

De todos modos, es una buena práctica "kumbiera" nombrar los controladores con **el mismo nombre del modelo, pero en plural**. Por consiguiente, el nombre de archivo para el controlador que gestiona los proveedores debería ser proveedores_controller.php (ubicado en app/controllers/). Un ejemplo de controlador que gestiona datos (CRUD) debería ser similar a la siguiente figura:

```php
<?php
  class ProveedoresController extends AppController
  {
    public function index()
    {
      $this->proveedores = Proveedor::all();
    }

    public function ver($id)
    {
      $this->proveedor = Proveedor($id);
    }

    public function agregar()
    {
      if (Input::hasPost('proveedor')) {
        if ((new Proveedor)->create(Input::post('proveedor'))) {
          Flash::valid('Proveedor creado exitosamente!');
          Input::delete('proveedor');
        }
      }
    }

    public function editar($id)
    {
      if (Input::hasPost('proveedor')) {
        if ((new Proveedor)->update(Input::post('proveedor'))) {
          Flash::valid('Proveedor actualizado exitosamente!');
        }
      }
      $this->proveedor = Proveedor($id);
    }

    public function eliminar($id)
    {
      if (new Proveedor)->delete($id)) {
        Flash::valid('Proveedor eliminado exitosamente!');
      } else {
        Flash::error('Proveedor no pudo ser eliminado!');
      }
      return Redirect::to(); //predeterminadamente a la acción index
    }
  }
```

*Nota de libertad*

>Como ya se mencionó con anterioridad, el nombre de los controladores no liga autocarga de modelos, así que le recomendamos que use los nombres de controlador para definir claramente la estructura de su aplicación web, y de igual manera lo haga con las vistas.


##Convenciones para vistas
Las vistas son los archivos de presentación de las solicitudes que se realizar a los modelos por intermedio de los controladores. KumbiaPHP usa de forma predeterminada archivos con extensión phtml para las vistas que entregan HTML. Los archivos de las vistas deben corresponder con **el nombre del método/acción que ha sido creado en el controlador**. En el caso del ejemplo para el controlador que gestiona los proveedores el desarrollador debe crear una carpeta llamada **app/views/proveedores**, y en ella alojar los archivos llamados **index.phtml**, **ver.phtml**, **agregar.phtml**, y **editar.phtml**. Note que la acción eliminar no tiene vista porque al ejecutarse la petición, hará redirección a la vista predeterminada (index). De todos modos, puede existir vista de eliminar si el desarrollador lo estima conveniente, con la intención de mostrar primero el elemento a quitar, y en él incluir un botón o enlace que confirme la eliminación por el usuario.


##Palabras al cierre
Hasta aquí llega este pequeño documento de apoyo a los nuevos desarrolladores que se integran al trabajo con KumbiaPHP Framework. Esperamos que usted pueda encontrar en KumbiaPHP un compañero fiel a la hora de plantear sus soluciones web. Ante cualquier tipo de dudas le recomendamos leer la documentación oficial, revisar la wiki, comunicarse en el grupo de google, o visitar el canal de IRC. Estos datos de referencia puede encontrarlos directamente en el sitio web del framework: [www.kumbiaphp.com](http://www.kumbiaphp.com). Si desea contribuir en cualquiera de las labores puede dirigirse al sitio del proyecto alojado en github: (https://github.com/KumbiaPHP). **Todas las manos son bienvenidas**.

Le deseamos un feliz descubrimiento y que pueda hacer buen uso del trabajo de nuestros desarrolladores, documentadores, expositores, y la comunidad en su totalidad.
