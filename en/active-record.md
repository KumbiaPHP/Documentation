# ActiveRecord

This is the main class for administration and operation of models. ActiveRecord is an implementation of this programming pattern and is heavily influenced by the functionality of its analog available in Ruby on Rails. ActiveRecord provides an object-relational layer that strictly follows the standard ORM: tables in classes, objects in records, and fields in attributes. Facilitates the understanding of code associated with the database and encapsulates the logic specified making it easier to use for the programmer.

KumbiaPHP uses OOP (Object-oriented programming), so ActiveRecord is a class with ready-to-use methods. These methods make it easier for the user to manage tables in databases; Among them are the next:

Example:

```php
<?php
//KumbiaPHP 1.0
$client = new Client();
$client->idcode = "808111827-2";
$client->name = "XYZ COMMUNICATIONS COMPANY";
$client->save(); //it creates a new record
```

### Advantages of ActiveRecord

* The entities of the Model are most naturally worked as objects.
* Actions such as inserting, consult, update, delete, etc. of an entity of the model are encapsulated so the code is reduced and becomes more easy to maintain.
* Easiest Code to Understand and Maintain
* Reduction in the use of instructions of SQL by 80%, which achieves a high percentage of independence from the database engine.
* without details unnecessary, the code is more practical and useful
* "ActiveRecord" protec in a huge percent of SQL injections attacks that your apps can suffer, limited the letters that make it's.

### Configuring Database Connection

To configure the database connection, use the file [default/app/config/databases.php](https://github.com/KumbiaPHP/KumbiaPHP/blob/master/default/app/config/databases.php).
The configuration in [databases.ini](http://wiki.kumbiaphp.com/KumbiaPHP_Framework_Versi%C3%B3n_1.0_Spirit#databases.ini)
still works, but it's discouraged because using a PHP file is much faster and can leverage caching.

**Note:** KumbiaPHP will first look for the `databases.php` file to load information. If this file doesn't exist, it
will attempt to obtain it from `databases.ini`. The same applies to other configuration files like `config.php` and
`routes.php`.

This file stores the configuration in an array and returns it for use by ActiveRecord. You can create as many
connections as needed, such as development, production, testing, etc. This is defined with the array's first key. For
example:

```php
<?php
return [
// Connection parameters for development
'development' => [
                // configuration array
                ],
// Connection parameters for production
'production' => [
                // configuration array
                ],
];
```

Here's an example of a development connection where the database server is on the same machine as the web server. By
default, it connects with the root user and the password "root". **Never use the root user in production**:

```php
<?php
return [
'development' => [   
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'name' => 'test',
    'type' => 'mysql',
    'charset' => 'utf8',
    //'dsn' => '',
    //'pdo' => 'On',
    ],
];
```

Explanation of each parameter:

* **Host:** IP or host name of the database
* **Username:** Username with database permissions (using the root user is not recommended)
* **Password:** Password for the database user
* **Name:** Name of the database
* **Type:** Type of database engine (mysql, pgsql, oracle, or sqlite)
* **Charset:** Character set for the connection, e.g., 'utf8'
* **Dsn:** Database connection string (Optional)
* **Pdo:** To enable PDO connections (On/Off)

Remember that the array `$databases` must always return at the end.

### Creating an ActiveRecord Model in KumbiaPHP Framework

The first step is to create a file in the models directory with the same name as the table in the database. For
instance, `models/client.php`. Then, create a class with the table name that extends one of the model classes.

Example:

```php
<?php
class Client extends ActiveRecord {
}
```

If you want to create a model for a table with a compound name, like the `ClientType` class, by convention in our
database this table should be named `client_type`, and the file should be `models/client_type.php`. The model code would
be:

```php
<?php
class ClientType extends ActiveRecord {
}
```

### Changing the Default Connection

By default, KumbiaPHP uses the connection configured under **development**. This can be changed in the file
[default/app/config/config.php](https://github.com/KumbiaPHP/KumbiaPHP/blob/master/default/app/config/config.php) by
modifying the **database** parameter, which will affect the entire application.

This change can also be made in each **model** inheriting from ActiveRecord by modifying the value of the protected
attribute **$database**. Here's an example using the following connection:

```php
<?php
return [
'new' => [   
    'host' => 'superserver',
    'username' => 'myusername',
    'password' => 'Y)vahu}UvM(jG]#UTa3zAU7',
    'name' => 'newdatabase',
    'type' => 'mysql',
    'charset' => 'utf8',
    //'dsn' => '',
    //'pdo' => 'On',
    ],
];
```

Now, if only the clients need to be fetched and stored on the new server, the code would look like this:

```php
<?php
class Client extends ActiveRecord {
    protected $database = 'new';
}
```

Where **new** is the name of the configuration for the super server.

### Changing the Mapped Table

As you may know, by convention, ActiveRecord maps a database table to the class name to build the object. Thus, if we
have the **Client** class, ActiveRecord expects to find a table named **client**, as in the previous example. But what
if the table has a different name for some reason? Let's suppose it's called **customers**, and you don't want to change
your class name. You should modify the protected attribute **$source**, as shown in the following example:

```php
<?php
class Client extends ActiveRecord {
    protected $source = 'customers';
}
```

With this change, ActiveRecord would map the **customers** table instead of the **client** table.

### Columns and Attributes

ActiveRecord objects correspond to records in a database table. These objects have attributes that correspond to fields
in the table. The ActiveRecord class automatically retrieves the field definitions from the table and converts them into
attributes of the associated class. This process is known as object-relational mapping.

Let's look at the Album table:

```sql
CREATE TABLE album (
    id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    value DECIMAL(12,2) NOT NULL,
    artist_id INTEGER NOT NULL,
    status CHAR(1),
    PRIMARY KEY(id)
)
```

We can create an ActiveRecord model that maps to this table:

```php
<?php
class Album extends ActiveRecord {
}
```

An instance of this class will be an object with the attributes of the album table:

Example:

```php
<?php
// KumbiaPHP 1.0
$album = new Album();
$album->id = 2;
$album->name = 'Going Under';
$album->date = '2017-01-01';
$album->value = 25;
$album->artist_id = 123;
$album->status = 'A';
$album->save();
```

### Primary Keys and the Use of IDs

In the KumbiaPHP examples, a column named `id` is always used as the primary key for our tables. You might think this
isn't always practical. For example, when creating the `clients` table, the identification number column would be a
good choice. However, if this value changes, there would be issues with data replicated across other relationships
(e.g., invoices). Moreover, you'd need to validate other related items due to the nature of this column. KumbiaPHP
advocates using IDs as primary keys, which automates many query tasks and provides a way to uniquely reference a
specific record without relying on the nature of a specific attribute. Rails users will be familiar with this feature.

This approach also allows KumbiaPHP to understand the entity-relationship model by reading the attribute names of the
tables. For instance, in the `album` table from the previous example, the convention tells us that `id` is the primary
key of this table. It also tells us that there's a foreign key to the `artist` table in its `id` field.

### ActiveRecord Conventions

ActiveRecord has a set of conventions that help it infer various properties and relate to a data model. The conventions
are as follows:

**id**

If ActiveRecord finds a field named `id`, it will assume it is the primary key of the entity and that it is
auto-incrementing.

**table_id**

Fields ending in `*_id*` indicate foreign relationships to other tables, thus defining the relationships between the
model's entities:

A field named `clients_id` in a table indicates that another table named `clients` exists and contains a field `id`
that acts as a foreign key to this field.

**field_at**

Fields ending in `*_at*` indicate dates and have the extra functionality of automatically receiving the current date
value when inserted.

*created_at* is a date field.

**field_in**

Fields ending in `*_in*` indicate dates and have the extra functionality of automatically receiving the current date
value when updated.

*modified_in* is a date field.

**Note:** Fields `*_at*` and `*_in*` should be of type date (DATE or DATETIME) in the database engine being used.

## ActiveRecord API

A continuación veremos una referencia de los métodos que posee la clase ActiveRecord y su funcionalidad respectiva. Éstos se encuentran organizados alfabéticamente:

### Consultas

Métodos para hacer consulta de registros:

#### distinct ()

Este método ejecuta una consulta de distinción única en la entidad, funciona igual que un "select unique campo" viéndolo desde la perspectiva del SQL. El objetivo es devolver un array con los valores únicos del campo especificado como parámetro.

Sintaxis

```php
distinct([string $atributo_entidad], [ "conditions: …" ], [ "order: …" ], ["limit: …" ], [ "column: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "offset: …" ])
```

Ejemplo:

```php
$unicos = (new Usuario)->distinct("estado");
# array('A', 'I', 'N')  
```

Los parámetros conditions, order y limit funcionan idénticamente que en el método find y permiten modificar la forma o los mismos valores de retorno devueltos por esta.

#### find_all_by_sql (string $sql)

Este método nos permite hacer una consulta por medio de un SQL y el resultado devuelto es un array de objetos de la misma clase con los valores de los registros en estos. La idea es que el uso de este método no sea tan común en nuestras aplicaciones, ya que ActiveRecord se encarga de eliminar el uso del SQL en gran porcentaje, pero hay momentos en que es necesario que seamos más específicos y tengamos que recurrir a su uso.

Ejemplo:

```php
$usuarios = (new Usuario)->find_all_by_sql( "select * from usuarios where codigo not in (select codigo from ingreso)")
```

En este ejemplo consultamos todos los usuarios con una sentencia where especial. La idea es que los usuarios consultados no pueden estar en la entidad ingreso.

#### find_by_sql (string $sql)

Este método nos permite hacer una consulta por medio de un SQL y el resultado devuelto es un objeto que representa el resultado encontrado. La idea es que el uso de este método no sea tan común en nuestras aplicaciones, ya que ActiveRecord se encarga de eliminar el uso del SQL en gran porcentaje, pero hay momentos en que es necesario que seamos mas específicos y tengamos que recurrir al uso de este.

Ejemplo:

```php
$usuario = (new Usuario)->find_by_sql( "select * from usuarios where codigo not in (select codigo from ingreso) limit 1" );  
```

Este ejemplo consulta el primer usuario con una sentencia where especial. La idea es que el usuario consultado no se encuentre en la entidad ingreso.

#### find_first (string $sql)

Sintaxis

```php
find_first([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ],[ "columns: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "distinct: …" ], [ "offset: …" ] )  
```

El método "find\_first" devuelve el primer registro de una entidad o la primera ocurrencia de acuerdo a unos criterios de búsqueda u ordenamiento. Los parámetros son todos opcionales y su orden no es relevante, cuando se invoca sin parámetros devuelve el primer registro insertado en la entidad. Este método es muy flexible y puede ser usado de muchas formas:

Ejemplo:

```php
$usuario = (new Usuario)->find_first( "conditions: estado='A'", "order: fecha desc");
```

En este ejemplo buscamos el primer registro cuyo estado sea igual a "A" y ordenado descendentemente, el resultado de este, se carga a la variable $usuarios. Devuelve una instancia del mismo objeto ActiveRecord en caso de éxito o false en caso contrario.

Con el método find_first podemos buscar un registro en particular a partir de su id de esta forma:

```php
$user = (new User)->find_first(123);
```

Obtenemos el registro 123 e igualmente devuelve una instancia del mismo objeto ActiveRecord en caso de éxito, o false en caso contrario. KumbiaPHP genera una advertencia cuando los criterios de búsqueda para find\_first devuelven más de un registro, para esto podemos forzar que se devuelva solamente uno, mediante el parámetro limit, de esta forma:

```php
$usuario = (new Usuario)->find_first( "conditions: estado='A'", "limit: 1" );
```

Cuando queremos consultar, sólo algunos de los atributos de la entidad, podemos utilizar el parámetro columns:

```php
$usuario = (new Usuario)->find_first( "columns: nombre, estado");
```

Cuando especificamos el primer parámetro de tipo string, ActiveRecord asumirá que son las condiciones de búsqueda para find_first:

```php
$usuario = (new Usuario)->find_first( "estado='A'" );
```

De esta forma podemos también deducir que estas 2 sentencias arrojarían el mismo resultado:

```php
$usuario = (new Usuario)->find_first( "id='123'" );
```

```php
$usuario = (new Usuario)->find_first(123);
```

#### find()

Sintaxis

```php
find([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ], [ "columns: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "distinct: …" ], [ "offset: …" ])
```

El método "find" es el principal método de búsqueda de ActiveRecord, devuelve todas los registros de una entidad o el conjunto de ocurrencias de acuerdo a unos criterios de búsqueda. Los parámetros son todos opcionales y su orden no es relevante, incluso pueden ser combinados u omitidos si es necesario. Cuando se invoca sin parámetros devuelve todos los registros en la entidad.

No hay que olvidarse de incluir un espacio después de los dos puntos (:) en cada parámetro.

Ejemplo:

```php
$usuarios = (new Usuario)->find( "conditions: estado='A'", "order: fecha desc");
```

En este ejemplo buscamos todos los registros cuyo estado sea igual a "A" y devuelva estos ordenados descendentemente, el resultado de este es un array de objetos de la misma clase con los valores de los registros cargados en ellos. En caso de no hayan registros devuelve un array vacío.

Con el método find podemos buscar un registro en particular a partir de su id de esta forma:

```php
$usuario = (new Usuario)->find(123);
```

Obtenemos el registro 123 e igualmente devuelve una instancia del mismo objeto ActiveRecord en caso de éxito, o false en caso contrario. Como es un solo registro no devuelve un array, sino que los valores de este se cargan en la misma variable si existe el registro.

Para limitar el número de registros devueltos, podemos usar el parámetro limit:

```php
$usuarios = (new Usuario)->find("conditions: estado='A'", 'limit: 5', 'offset: 1');
```

Cuando queremos consultar sólo algunos de los atributos de la entidad podemos utilizar el parámetro columns :

```php
$usuarios = (new Usuario)->find("columns: nombre, estado");
```

Cuando especificamos el primer parámetro de tipo string, ActiveRecord asume que son las condiciones de búsqueda para find:

```php
$usuarios = (new Usuario)->find( "estado='A'");
```

Se puede utilizar la propiedad count para saber cuántos registros fueron devueltos en la búsqueda.

Nota: No es necesario usar find('id: $id'), se puede usar directamente find($id)

Podemos ver un ejemplo para **find** usando funciones de resumen y agrupación (aplicables también a **find_first**)

```php
$resumen = (new Factura)->find("columns: agencia_origen, agencia_destino, count(*) as num_facturas", "group: agencia_origen, agencia_destino", "having: count(*) > 5");
```

#### select_one (string $select_query)

Este método nos permite hacer ciertas consultas como ejecutar funciones en el motor de base de datos sabiendo que éstas devuelven un único registro.

```php
$current_time = (new Usuario)->select_one( "current_time");
```

En el ejemplo, queremos saber la hora actual del servidor devuelta desde MySQL, podemos usar este método para esto.

#### select_one(string $select_query) (static)

Este método nos permite hacer ciertas consultas como ejecutar funciones en el motor de base de datos, sabiendo que estas devuelven un solo registro. Este método se puede llamar de forma estática, esto significa que no es necesario que haya una instancia de ActiveRecord para hacer el llamado.

```php
$current_time = ActiveRecord::select_one( "current_time");
```

En el ejemplo, queremos saber la hora actual del servidor devuelta desde MySQL, podemos usar este método para esto.

#### exists()

Este método nos permite verificar si el registro existe o no en la base de datos mediante su id o una condición.

```php
$usuario = new Usuario();

$usuario->id  = 3;

if ($usuario->exists()){
  //El usuario con id igual a 3 si existe
}

(new Usuario)->exists( "nombre='Juan Perez'")
(new Usuario)->exists(2); // Un Usuario con id->2?
```

#### find_all_by()

Este método nos permite realizar una búsqueda por algún campo

```php
$resultado = (new Producto)->find_all_by( 'categoria', 'Insumos');
```

#### find_by__campo_()

Este método nos permite realizar una búsqueda usando el nombre del atributo como nombre de método. Devuelve un único registro.

```php
$resultado = (new Producto)->find_by_categoria('Insumos');
```

#### find_all_by__campo_()

Este método nos permite realizar una búsqueda el nombre del atributo como nombre de método. Devuelve todos los registros que coincidan con la búsqueda.

```php
$resultado = (new Producto)->find_all_by_categoria("Insumos");
```

### Conteos y sumatorias

#### count()

Realiza un conteo sobre los registros de la entidad con o sin alguna condición adicional. Emula la función de agrupamiento count. Se puede usar los mismos parámetros que find.

```php
$numero_registros = (new Cliente)->count();
$numero_registros = (new Cliente)->count("ciudad = 'BOGOTA'");
```

#### sum()

Realiza una sumatoria sobre los valores numéricos del atributo de alguna entidad, emula la función de agrupamiento sum en el lenguaje SQL. Se puede usar los mismos parámetros que find.

```php
$suma = (new Producto)->sum("precio");
$suma = (new Producto)->sum("precio", "conditions: estado = 'A'");
```

#### count_by_sql()

Realiza un conteo sobre los registros de la entidad utilizando lenguaje SQL.

```php
$numero = (new Producto)->count_by_sql("select count(precio) from producto, factura  where factura.codigo = 1124 \
    and factura.codigo_producto = producto.codigo_producto");
```

### Promedios, máximo y mínimo

#### average()

Realiza el cálculo del promedio sobre los valores numéricos del atributo de alguna entidad, emula la función de agrupamiento avg en el lenguaje SQL. Se puede usar los mismos parámetros que find.

```php
$promedio = (new Producto)->average("precio");
$promedio = (new Producto)->average("precio", "conditions: estado = 'A'");
```

#### maximum()

Realiza el cálculo del valor máximo sobre los valores del atributo de alguna entidad, emula la función de agrupamiento max en el lenguaje SQL. Se puede usar los mismos parámetros que find.

```php
$max = (new Producto)->maximum("precio");
$max = (new Producto)->maximum("fecha_compra", "conditions: estado = 'A'");
```

#### minimum()

Realiza el cálculo del valor mínimo sobre los valores del atributo de alguna entidad, emula la función de agrupamiento min en el lenguaje SQL. Se puede usar los mismos parámetros que find.

```php
$min = (new Producto)->minimum("precio");
$min = (new Producto)->minimum("fecha_compra", "conditions: estado = 'A'");
```

### Creación, actualización y borrado de registros

#### create()

Crea un registro a partir de los datos indicados en el modelo. Retorna boolean.

```php
$data = array ( "nombre" => "Cereal", "precio" => 9.99, "estado" => "A" );
$exito = (new Producto)->create( $data );

$producto = new Producto();
$producto->nombre = "Cereal";
$producto->precio = 9.99;
$producto->estado = "A";
$exito = $producto->create();
```

#### save()

Actualiza o crea un registro a partir de los datos indicados en el modelo. Crea el registro cuando el elemento a guardar no existe o cuando no se indica el atributo de clave primaria. Actualiza cuando el registro existe. Retorna boolean.

```php
$data = array ("nombre" => "Cereal", "precio" => 9.99, "estado" => "A" );
$exito = (new Producto)->save( $data );

$producto = (new Producto)->find(123);
$producto->precio = 4.99;
$producto->estado = "A";
$exito = $producto->save();
```

#### update()

Actualiza un registro a partir de los datos indicados en el modelo. Retorna boolean.

```php
$data = array ("nombre" => "Cereal Integral", "precio" => 8.99, "estado" => "A", "id" => 123);
$exito = (new Producto)->update( $data );

$producto = (new Producto)->find( 123 );
$producto->estado = "C";
$producto->update();
```

#### update_all()

Actualiza uno o más valores dentro de uno o más registros a partir de los atributos y condiciones indicadas.

Ejemplos:

```php
(new Producto)->update_all("precio = precio * 1.2");
```

Actualiza el atributo precio aumentándolo en un 20% para todos los registros de la entidad producto.

```php
(new Producto)->update_all("precio = precio * 1.2", "estado = 'A'", "limit: 100");
```

Actualiza el atributo precio aumentándolo en un 20% para 100 registros de la entidad producto donde el atributo estado es 'A'.

```php
(new Producto)->update_all( "precio = 0, estado='C'", "estado = 'B'");
```

Actualiza el atributo precio a 0 y el estado a 'C' para todos los registros de la entidad producto donde el atributo estado es 'B'.

#### delete()

Elimina uno o más registros a partir de los atributos y condiciones indicadas. Retorna boolean.

```php
$producto = (new Producto)->find(123);
$exito = $producto->delete();

(new Producto)->delete(123); //elimina el registro por su ID

$exito = (new Producto)->delete("estado='A'");
```

#### delete_all()

Elimina uno o más registros a partir de los atributos y condiciones indicadas. Retorna boolean.

```php
(new Producto)->delete_all( " precio >= 99.99 " );

(new Producto)->delete_all( " estado = 'C' " );
```

### Validaciones

#### validates_presence_of

Cuando este método es llamado desde el constructor de una clase ActiveRecord, obliga a que se valide la presencia de los campos definidos en la lista. Los campos marcados como not\_null en la tabla son automáticamente validados.

```php
<?php
 class Clientes extends ActiveRecord {
   protected function initialize{
    $this->validates_presence_of("cedula");
   }
 }

```

#### validates_length_of

Cuando este método es llamado desde el constructor de una clase ActiveRecord, obliga a que se valide la longitud de los campos definidos en la lista.

El parámetro minimum indica que se debe validar que el valor a insertar o actualizar no sea menor de ese tamaño. El parámetro maximum indica que el valor a insertar/actualizar no puede ser mayor al indicado. El parámetro too\_short indica el mensaje personalizado que ActiveRecord mostrará en caso de que falle la validación cuando es menor y too\_long cuando es muy largo.

```php
<?php
class Clientes extends ActiveRecord {

  protected function initialize(){
   $this->validates_length_of("nombre", "minumum: 15", "too_short: El nombre debe tener al menos 15 caracteres");
   $this->validates_length_of("nombre", "maximum: 40", "too_long: El nombre debe tener maximo 40 caracteres");
   $this->validates_length_of("nombre", "in: 15:40",
      "too_short: El nombre debe tener al menos 15 caracteres",
      "too_long: El nombre debe tener maximo 40 caracteres"
   );
  }
}
```

#### validates_numericality_of

Valida que ciertos atributos tengan un valor numérico antes de insertar ó actualizar.

```php
<?php
 class Productos extends ActiveRecord {

   protected function initialize{
    $this->validates_numericality_of("precio");
   }

 }
```

#### validates_email_in

Valida que ciertos atributos tengan un formato de e-mail correcto antes de insertar o actualizar.

```php
<?php
 class Clientes extends ActiveRecord {

   protected function initialize(){
    $this->validates_email_in("correo");
   }

 }
```

#### validates_uniqueness_of

Valida que ciertos atributos tengan un valor único antes de insertar o actualizar.

```php
<?php
 class Clientes extends ActiveRecord {

   protected function initialize{
    $this->validates_uniqueness_of("cedula");
   }

 }
```

#### validates_date_in

Valida que ciertos atributos tengan un formato de fecha acorde al indicado en config/config.ini antes de insertar o actualizar.

```php
<?php
 class Registro extends ActiveRecord {

   protected function initialize(){
         $this->validates_date_in("fecha_registro");
   }
 }
```

#### validates_format_of

Valida que el campo tenga determinado formato según una expresión regular antes de insertar o actualizar.

```php
<?php
 class Clientes extends ActiveRecord {

   protected function initialize(){
    $this->validates_format_of("email", "^(+)@((?:[?a?z0?9]+\.)+[a?z]{2,})$");
   }

 }
```

### Transacciones

#### commit()

Este método nos permite confirmar una transacción iniciada por el método begin en el motor de base de datos, si este lo permite. Devuelve true en caso de éxito y false en caso contrario.

Ejemplo:

```php
$Usuarios = new Usuarios();
$Usuarios->commit();
```

#### begin()

Este método nos permite crear una transacción en el motor de base de datos, si este lo permite. Devuelve true en caso de éxito y false en caso contrario.

Ejemplo:

```php
$Usuarios = new Usuarios();
$Usuarios->begin();
```

#### rollback()

Este método nos permite anular una transacción iniciada por el método begin en el motor de base de datos, sí este lo permite. Devuelve true en caso de éxito y false en caso contrario.

Ejemplo:

```php
$Usuarios = new Usuarios();
$Usuarios->rollback();
```

**Nota:** Las tablas deben tener el motor de almacenamiento \[InnoDB\][1](http://es.wikipedia.org/wiki/InnoDB)

### Otros métodos

#### sql (string $sql)

Esta función nos permite ejecutar sentencias SQL directamente en el motor de base de datos. La idea es que el uso de este método no debería ser común en nuestras aplicaciones ya que ActiveRecord se encarga de eliminar el uso del SQL en gran porcentaje, pero hay momentos en que es necesario que seamos más específicos y tengamos que recurrir al uso de éste.

### Callbacks

#### Introduction

El ActiveRecord controla el ciclo de vida de los objetos creados y leídos, supervisando cuando se modifican, se almacenan o se borran. Usando callbacks (o eventos), el ActiveRecord nos permite intervenir en esta supervisión. Podemos escribir el código que pueda ser invocado en cualquier evento significativo en la vida de un objeto. Con los callbacks podemos realizar validación compleja, revisar los valores que vienen desde y hacia la base de datos, e incluso evitar que ciertas operaciones finalicen. Un ejemplo de estos callbacks puede ser una validación en productos que evita que productos ‘activos’ sean borrados.

```php
<?php
class User extends ActiveRecord {

     public $before_delete = “no_borrar_activos”;

     public function no_borrar_activos(){
        if($this->estado==’A’){
          Flash::error(‘No se puede borrar Productos Activos’);
          return ‘cancel’;
        }
     }

     public function after_delete(){
          Flash::success("Se borro el usuario $this->nombre");
     }

}
```

A continuación otros callbacks que podemos encontrar en ActiveRecord. El orden en el que son presentados es en el que se llaman si están definidos:

#### before_validation

Es llamado justo antes de realizar el proceso de validación por parte de Kumbia. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### before_validation_on_create

Es llamado justo antes de realizar el proceso de validación por parte de Kumbia, sólo cuando se realiza un proceso de inserción en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### before_validation_on_update

Es llamado justo antes de realizar el proceso de validación por parte de Kumbia, sólo cuando se realiza un proceso de actualización en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after_validation_on_create

Es llamado justo después de realizar el proceso de validación por parte de Kumbia, sólo cuando se realiza un proceso de inserción en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after_validation_on_update

Es llamado justo después de realizar el proceso de validación por parte de Kumbia, sólo cuando se realiza un proceso de actualización en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after_validation

Es llamado justo después de realizar el proceso de validación por parte de Kumbia. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### before_save

Es llamado justo antes de realizar el proceso de guardar, metodo **save()** y al momento de editar/actualizar, metodo **update()** en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

```php
public function before_save() {            
    $rs = $this->find_first("cedula = $this->cedula");
    if($rs) {
        Flash::warning("Ya existe un usuario registrado bajo esta cedula");
        return 'cancel';
    }                
}
```

#### before_update

Es llamado justo antes de realizar el proceso de actualización cuando se llama el método save o update en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'. El mismo codigo del before\_save() para before\_update.

#### before_create

Es llamado justo antes de realizar el proceso de inserción cuando se llama el método save o create en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after_update

Es llamado justo después de realizar el proceso de actualización cuando se llama el método save o update en un modelo.

#### after_create

Es llamado justo después de realizar el proceso de actualización cuando se llama el método save o create en un modelo.

#### after_save

Es llamado justo después de realizar el proceso de actualización/inserción cuando se llama el método save, update ó create en un modelo.

#### before_delete

Es llamado justo antes de realizar el proceso de borrado cuando se llama el método delete en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after_delete

Es llamado justo después de realizar el proceso de borrado cuando se llama el método delete en un modelo.

### Asociaciones

#### Introduction

Muchas aplicaciones trabajan con múltiples tablas en una base de datos y normalmente hay relaciones entre esas tablas. Por ejemplo, una ciudad puede ser el hogar de muchos clientes pero un cliente solo tiene una ciudad. En un esquema de base de datos, estas relaciones son enlazadas mediante el uso de llaves primarias y foráneas.

Como ActiveRecord trabaja con la convención: La llave foránea tiene el nombre de la tabla y termina en id, así: ciudad\_id, esto es una relación a la tabla ciudad a su llave primaria id.

Así que, sabiendo esto, quisiéramos que en vez de decir:

```php
$ciudad_id = $cliente->ciudad_id;
$ciudad = $Ciudad->find($ciudad_id);
echo $ciudad->nombre;
```

Mejor sería:

```php
echo $cliente->getCiudad()->nombre;
```

Gran parte de la magia que tiene ActiveRecord es esto, ya que convierte las llaves foráneas en sentencias de alto nivel, fáciles de comprender y de trabajar.

#### Belongs (belongs_to)

Este tipo de relación se efectúa con el método “belongs\_to”, en esta la llave foránea se encuentra en la tabla del modelo de donde se invoca el método. Corresponde a una relación uno a uno en el modelo entidad relación.

belongs\_to($relation)

$relation (string): nombre de la relación.

**Parámetros con nombre:**

model: Nombre del tipo de modelo que debe retornar la consulta de la relación. Por defecto se considera un modelo que corresponda al nombre de la relación. Ejemplo: Si $relation='auto\_volador', entonces model=AutoVolador

fk: nombre de la llave foránea mediante la cual se relaciona. Por defecto se considera el nombre de la relación con el sufijo “\_id”. Ejemplo: Si $relation='auto\_volador', entonces fk=auto\_volador\_id.

**Ejemplos de uso:**

```php
$this->belongs_to('persona');
$this->belongs_to('vendedor', 'model: Persona');
$this->belongs_to('funcionario', 'model: Persona', 'fk: persona_id');
```

**En el modelo Libro:**

```php
class Libro extends ActiveRecord {
    public function initialize() {
        $this->belongs_to('persona');
    }
}
```

#### Has_one

Este tipo de relación se efectúa con el método “has\_one”, en esta la llave foránea se encuentra en la tabla del modelo con el que se quiere asociar. Corresponde a una relación uno a uno en el modelo entidad relación.

has\_one($relation)

$relation (string): nombre de la relación.

**Parámetros con nombre:**

model: Nombre del tipo de modelo que debe retornar la consulta de la relación. Por defecto se considera un modelo que corresponda al nombre de la relación. Ejemplo: Si $relation='auto\_volador', entonces model=AutoVolador

fk: nombre de la llave foránea mediante la cual se relaciona. Por defecto se considera el nombre de la relación con el sufijo “\_id”. Ejemplo: Si $relation='auto\_volador', entonces fk=auto\_volador\_id.

**Ejemplos de uso:**

```php
$this->has_one('persona');
$this->has_one('vendedor', 'model: Persona');
$this->has_one('funcionario', 'model: Persona', 'fk: personal_id');
```

En el modelo Persona:

```php
class Persona extends ActiveRecord {
    public function initialize() {
        $this->has_one('datos_personales');
    }
}
```

#### Has_many

Este tipo de relación se efectúa con el método “has\_many”, en esta la llave foránea se encuentra en la tabla del modelo con el que se quiere asociar. Corresponde a una relación uno a muchos en el modelo entidad relación.

has\_many($relation)

$relation (string): nombre de la relación.

**Parámetros con nombre:**

model: Nombre del tipo de modelo que debe retornar la consulta de la relación. Por defecto se considera un modelo que corresponda al nombre de la relación. Ejemplo: Si $relation='auto\_volador', entonces model=AutoVolador

fk: nombre de la llave foránea mediante la cual se relaciona. Por defecto se considera el nombre de la relación con el sufijo “\_id”. Ejemplo: Si $relation='auto\_volador', entonces fk=auto\_volador\_id.

**Ejemplos de uso:**

```php
$this->has_many('persona');
$this->has_many('vendedor', 'model: Persona');
$this->has_many('funcionario', 'model: Persona', 'fk: personal_id');
```

En el modelo Persona:

```php
class Persona extends ActiveRecord {
    public function initialize() {
        $this->has_many('libro');
    }
}
```

#### Has_and_belongs_to_many

Este tipo de relación se efectúa con el método “has\_and\_belongs\_to\_many”, esta se efectúa a través de una tabla que se encarga de enlazar los dos modelos. Corresponde a una relación muchos a muchos en el modelo entidad relación. Este tipo de relación tiene la desventaja de que no es soportada en el ámbito de múltiples conexiones de ActiveRecord, para lograr que funcione con multiples conexiones, se puede emular a través de dos relaciones has\_many al modelo de la tabla que relaciona.

has\_and\_belongs\_to\_many($relation)

$relation (string): nombre de la relación.

**Parámetros con nombre:**

model: Nombre del tipo de modelo que debe retornar la consulta de la relación. Por defecto se considera un modelo que corresponda al nombre de la relación. Ejemplo: Si $relation='auto\_volador', entonces model=AutoVolador

fk: nombre de la llave foránea mediante la cual se relaciona. Por defecto se considera el nombre de la relación con el sufijo “\_id”. Ejemplo: Si $relation='auto\_volador', entonces fk=auto\_volador\_id.

key: nombre del campo que contendrá el valor de la llave primaria en la tabla intermedia que contendrá los campos de la relación. Por defecto corresponde al nombre del modelo con que se va a relacionar con el sufijo “\_id”.

through: tabla a través de la cual se establece la relación muchos a muchos. Por defecto se forma por el nombre de la tabla del modelo que tiene el nombre de tabla mas largo y como prefijo un “\_” y el nombre de la tabla del otro modelo.

**Ejemplos de uso:**

```php
$this->has_and_belongs_to_many('persona');
$this->has_and_belongs_to_many('cargos', 'model: Cargo', 'fk: id_cargo', 'key: id_persona', 'through: cargo_persona');
```

**En el modelo Persona:**

```php
class Persona extends ActiveRecord {
    public function initialize() {
        $this->has_and_belongs_to_many('cargo');
    }
}
```

### Paginadores

Para la paginación existen dos funciones encargadas de esto:

#### Paginate

Este es capaz de paginar arrays o modelos, recibe los siguientes parámetros:

Para array:

**$s** : array a paginar.

**page**: numero de página.

**per\_page**: cantidad de elementos por página.

**Ejemplo:**

```php
$page = paginate($s, 'per_page: 5', 'page: 1');
```

Para modelo:

**$s**: string con nombre de modelo u objeto ActiveRecord.

**page**: número de página.

**per\_page**: cantidad de elementos por página.

Asimismo recibe todos los parámetros que pueden utilizarse en el método “find” de ActiveRecord.

**Ejemplos:**

```php
$page = paginate('usuario', 'NOT login=”admin”', 'order: login ASC', 'per_page: 5', 'page: 1');
$page = paginate($this->Usuario, 'NOT login=”admin”', 'order: login ASC', 'per_page: 5', 'page: 1');
```

#### Paginate_by_sql

Efectúa paginación a través de una consulta sql. Recibe los siguientes parámetros:

**$model**: string nombre de modelo o objeto ActiveRecord.

**$sql**: string consulta sql.

**Ejemplo:**

```php
$page = paginate_by_sql('usuario', 'SELECT * FROM usuario WHERE nombre LIKE “%emilio%” ', 'per_page: 5', 'page: 1');
```

Ambos tipos de paginadores retornan un objeto “page”, este objeto “page” es creado a partir de stdClass, contiene los siguientes atributos:

**next**: número de página siguiente, si no hay pagina siguiente vale “false”.

**prev**: número de página anterior, si no hay pagina anterior vale “false”.

**current**: número de página actual.

**total**: número de paginas totales.

**items**: array de elementos paginados.

#### Paging in ActiveRecord

ActiveRecord ya trae integrado los métodos paginate y paginate\_by\_sql, se comportan igual que paginate y paginate\_by\_sql, sin embargo no es necesario pasar el modelo a paginar ya que por defecto toman el modelo que invoca.

**Ejemplo:**

```php
$page = $this->Usuario->paginate('per_page: 5', 'page: 1');
```

#### Full example of use of the pager:

Tenemos una tabla usuario con su correspondiente modelo Usuario, entonces creemos un controlador el cual pagine una lista de usuarios y asimismo permita buscar por nombre, aprovecharemos la persistencia de datos del controlador para hacer una paginación inmune a inyección sql.

El modelo *usuario.php*:

```php
<?php
class Usuario extends ActiveRecord {

}
```

En el controlador *usuario_controller.php*:

```php
<?php

class UsuarioController extends AppController{

    public $page_title = 'Daily Backend Manager';

    private $_per_page = 10;

    /**
     * Formulario de busqueda
     * */
    public function index() {
        Input::delete();
    }

    /**
     * Paginador
     * */
    public function listar($page = '') {

        $usuario = new Usuario();
        /**
         * Cuando se efectua la búsqueda por primera vez
         * */
        if (Input::hasPost('usuario')) {
            $data = Input::post('usuario');
            if ($data['nombre']) {
                $this->conditions = " nombre LIKE '%{$data['nombre']}%' ";
            }
            /**
             * Paginador con condiciones o sin condiciones
             * */
            if (isset($this->conditions) && $this->conditions) {
                $this->page = $usuario->paginate($this->conditions, "per_page: $this->_per_page", 'page: 1');
            } else {
                $this->page = $usuario->paginate("per_page: $this>_per_page", 'page: 1');
            }
        } elseif ($page = 'next' && isset($this->page) && $this->page->next) {
            /**
             * Paginador de pagina siguiente
             * */
            if (isset($this->conditions) && $this->conditions) {
                $this->page = $usuario->paginate($this->conditions, "per_page: $this>_per_page", "page: {$this->page->next}");
            } else {
                $this->page = $usuario->paginate("per_page: $this->_per_page", "page: {$this->page->next}");
            }
        } elseif ($page = 'prev' && isset($this->page) && $this->page->prev) {
            /**
             * Paginador de pagina anterior
             * */
            if (isset($this->conditions) && $this->conditions) {
                $this->page = $usuario->paginate($this->conditions, "per_page: $this->_per_page", "page: {$this->page->prev}");
            } else {
                $this->page = $usuario->paginate("per_page: $this->_per_page", "page: {$this->page->prev}");
            }
        }
    }
}
```

En la vista *index.pthml*

```php
<?= Form::open('usuario/listar') ?>
<?= Form::text('usuario.nombre') ?>
<?= Form::submit('Consultar') ?>
<?= Form::close() ?>
```

En la vista *listar.phtml*

```php
<table>
    <tr>
        <th>id</th>
        <th>nombre</th>
    </tr>
    <?php foreach ($page->items as $p): ?>
        <tr>
            <td><?= $p->id ?></td>
            <td><?=h($p->nombre) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<?php if ($page->prev) echo Html::linkAction('listar/prev', 'Anterior') ?>
<?php if ($page->next) echo ' | ' . Html::linkAction('listar/next', 'Siguiente') ?>
```