# ActiveRecord

This is the main class for managing and operating models. ActiveRecord is an implementation of this programming pattern and is heavily influenced by its counterpart in Ruby on Rails. ActiveRecord provides an object-relational layer that follows the ORM standard: tables become classes, records become objects, and fields become attributes. It makes database-related code easier to understand and encapsulates the specified logic so that it is easier for programmers to use.

KumbiaPHP uses OOP (object-oriented programming), so ActiveRecord is a class with ready-to-use methods. These methods make it easier to manage database tables, including the following:

Example:

```php
<?php
// KumbiaPHP 1.0
$client = new Client();
$client->idcode = "808111827-2";
$client->name = "XYZ COMMUNICATIONS COMPANY";
$client->save(); //it creates a new record
```

### Advantages of ActiveRecord

* Model entities can be handled naturally as objects.
* Actions such as inserting, querying, updating, and deleting a model entity are encapsulated, reducing the amount of code and making it easier to maintain.
* The code is easier to understand and maintain.
* SQL usage is reduced by approximately 80%, providing a high degree of independence from the database engine.
* With fewer unnecessary details, the code is more practical and useful.
* ActiveRecord protects applications against a large proportion of SQL injection attacks by escaping characters that could facilitate them.

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

Remember that the file must always return the `$databases` array at the end.

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

Here, **new** is the name of the configuration for the super server.

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

The following is a reference of the methods provided by the ActiveRecord class and their respective functionality. They are organized alphabetically.

### Queries

Methods for querying records:

#### distinct()

This method performs a distinct query on the entity. From an SQL perspective, it works like `select unique field`. Its purpose is to return an array containing the unique values of the field specified as a parameter.

Syntax

```php
distinct([string $atributo_entidad], [ "conditions: …" ], [ "order: …" ], ["limit: …" ], [ "columns: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "offset: …" ])
```

Example:

```php
$unicos = (new Usuario)->distinct("estado");
# array('A', 'I', 'N')  
```

The `conditions`, `order`, and `limit` parameters work in the same way as they do in `find` and allow you to modify the query and its returned values.

#### find_all_by_sql(string $sql)

This method performs a query using SQL. It returns an array of objects of the same class, populated with the values from the records. It should not be used frequently because ActiveRecord eliminates much of the need for SQL, but it is useful when a more specific query is required.

Example:

```php
$usuarios = (new Usuario)->find_all_by_sql( "select * from usuarios where codigo not in (select codigo from ingreso)");
```

This example queries all users with a special `where` clause. The queried users must not be present in the `ingreso` entity.

#### find_by_sql(string $sql)

This method performs a query using SQL and returns an object representing the result. It should not be used frequently because ActiveRecord eliminates much of the need for SQL, but it is useful when a more specific query is required.

Example:

```php
$usuario = (new Usuario)->find_by_sql( "select * from usuarios where codigo not in (select codigo from ingreso) limit 1" );  
```

This example queries the first user with a special `where` clause. The queried user must not be present in the `ingreso` entity.

#### find_first()

Syntax

```php
find_first([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ],[ "columns: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "distinct: …" ], [ "offset: …" ] )  
```

The `find_first` method returns the first record in an entity, or the first occurrence matching the specified search or sort criteria. All parameters are optional and their order is not significant. When called without parameters, it returns the first record inserted into the entity. This method is very flexible and can be used in many ways:

Example:

```php
$usuario = (new Usuario)->find_first( "conditions: estado='A'", "order: fecha desc");
```

This example searches for the first record whose status is equal to `"A"`, sorted in descending order. The result is loaded into the `$usuario` variable. It returns an instance of the same ActiveRecord object on success or `false` otherwise.

With `find_first`, you can search for a specific record by its ID:

```php
$usuario = (new Usuario)->find_first(123);
```

This retrieves record 123 and likewise returns an instance of the same ActiveRecord object on success or `false` otherwise. KumbiaPHP generates a warning when the search criteria for `find_first` return more than one record. You can force it to return only one record with the `limit` parameter:

```php
$usuario = (new Usuario)->find_first( "conditions: estado='A'", "limit: 1" );
```

To query only some of the entity's attributes, use the `columns` parameter:

```php
$usuario = (new Usuario)->find_first( "columns: nombre, estado");
```

When the first parameter is a string, ActiveRecord assumes that it contains the search conditions for `find_first`:

```php
$usuario = (new Usuario)->find_first( "estado='A'" );
```

Therefore, the following two statements produce the same result:

```php
$usuario = (new Usuario)->find_first( "id='123'" );
```

```php
$usuario = (new Usuario)->find_first(123);
```

#### find()

Syntax

```php
find([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ], [ "columns: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "distinct: …" ], [ "offset: …" ])
```

The `find` method is ActiveRecord's primary search method. It returns all records in an entity or the set of occurrences matching the search criteria. All parameters are optional and their order is not significant; they may be combined or omitted as needed. When called without parameters, it returns all records in the entity.

Remember to include a space after the colon (`:`) in each parameter.

Example:

```php
$usuarios = (new Usuario)->find( "conditions: estado='A'", "order: fecha desc");
```

This example searches for all records whose status is equal to `"A"`, ordered in descending order. The result is an array of objects of the same class, populated with the record values. If no records are found, it returns an empty array.

With `find`, you can search for a specific record by its ID:

```php
$usuario = (new Usuario)->find(123);
```

This retrieves record 123 and likewise returns an instance of the same ActiveRecord object on success or `false` otherwise. Because this is a single record, the method does not return an array; if the record exists, its values are loaded into the same variable.

To limit the number of returned records, use the `limit` parameter:

```php
$usuarios = (new Usuario)->find("conditions: estado='A'", 'limit: 5', 'offset: 1');
```

To query only some of the entity's attributes, use the `columns` parameter:

```php
$usuarios = (new Usuario)->find("columns: nombre, estado");
```

When the first parameter is a string, ActiveRecord assumes that it contains the search conditions for `find`:

```php
$usuarios = (new Usuario)->find( "estado='A'");
```

You can use the `count` property to determine how many records were returned by the search.

Note: It is not necessary to use `find('id: $id')`; you can use `find($id)` directly.

The following is an example of using aggregate and grouping functions with **find**; the same approach also applies to **find_first**.

```php
$resumen = (new Factura)->find("columns: agencia_origen, agencia_destino, count(*) as num_facturas", "group: agencia_origen, agencia_destino", "having: count(*) > 5");
```

#### select_one(string $select_query)

This method allows you to execute queries such as database-engine functions when you know that they return a single record.

```php
$current_time = (new Usuario)->select_one( "current_time");
```

In this example, the method is used to obtain the current server time returned by MySQL.

#### select_one(string $select_query) (static)

This method allows you to execute queries such as database-engine functions when you know that they return a single record. It can be called statically, so an ActiveRecord instance is not required.

```php
$current_time = ActiveRecord::select_one( "current_time");
```

In this example, the method is called statically to obtain the current server time returned by MySQL.

#### exists()

This method checks whether a record exists in the database by its ID or a condition.

```php
$usuario = new Usuario();

$usuario->id  = 3;

if ($usuario->exists()){
  // The user with ID 3 exists.
}

(new Usuario)->exists( "nombre='Juan Perez'")
  (new Usuario)->exists(2); // A Usuario with ID 2?
```

#### find_all_by()

This method searches by a field.

```php
$resultado = (new Producto)->find_all_by( 'categoria', 'Insumos');
```

#### find_by__field_()

This method searches by using the attribute name as part of the method name. It returns a single record.

```php
$resultado = (new Producto)->find_by_categoria('Insumos');
```

#### find_all_by__field_()

This method searches by using the attribute name as part of the method name. It returns all records that match the search.

```php
$resultado = (new Producto)->find_all_by_categoria("Insumos");
```

### Counts and sums

#### count()

Counts the entity's records with or without an additional condition. It emulates the SQL `count` aggregate function and accepts the same parameters as `find`.

```php
$numero_registros = (new Cliente)->count();
$numero_registros = (new Cliente)->count("ciudad = 'BOGOTA'");
```

#### sum()

Calculates the sum of the numeric values of an entity attribute. It emulates the SQL `sum` aggregate function and accepts the same parameters as `find`.

```php
$suma = (new Producto)->sum("precio");
$suma = (new Producto)->sum("precio", "conditions: estado = 'A'");
```

#### count_by_sql()

Counts the entity's records using SQL.

```php
$numero = (new Producto)->count_by_sql("select count(precio) from producto, factura  where factura.codigo = 1124 \
    and factura.codigo_producto = producto.codigo_producto");
```

### Averages, maximum, and minimum

#### average()

Calculates the average of the numeric values of an entity attribute. It emulates the SQL `avg` aggregate function and accepts the same parameters as `find`.

```php
$promedio = (new Producto)->average("precio");
$promedio = (new Producto)->average("precio", "conditions: estado = 'A'");
```

#### maximum()

Calculates the maximum value of an entity attribute. It emulates the SQL `max` aggregate function and accepts the same parameters as `find`.

```php
$max = (new Producto)->maximum("precio");
$max = (new Producto)->maximum("fecha_compra", "conditions: estado = 'A'");
```

#### minimum()

Calculates the minimum value of an entity attribute. It emulates the SQL `min` aggregate function and accepts the same parameters as `find`.

```php
$min = (new Producto)->minimum("precio");
$min = (new Producto)->minimum("fecha_compra", "conditions: estado = 'A'");
```

### Creating, updating, and deleting records

#### create()

Creates a record from the data provided to the model. Returns a boolean.

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

Updates or creates a record from the data provided to the model. It creates the record when the item to save does not exist or when the primary-key attribute is not provided. It updates the record when it already exists. Returns a boolean.

```php
$data = array ("nombre" => "Cereal", "precio" => 9.99, "estado" => "A" );
$exito = (new Producto)->save( $data );

$producto = (new Producto)->find(123);
$producto->precio = 4.99;
$producto->estado = "A";
$exito = $producto->save();
```

#### update()

Updates a record from the data provided to the model. Returns a boolean.

```php
$data = array ("nombre" => "Cereal Integral", "precio" => 8.99, "estado" => "A", "id" => 123);
$exito = (new Producto)->update( $data );

$producto = (new Producto)->find( 123 );
$producto->estado = "C";
$producto->update();
```

#### update_all()

Updates one or more values in one or more records according to the specified attributes and conditions.

Examples:

```php
(new Producto)->update_all("precio = precio * 1.2");
```

Increases the `precio` attribute by 20% for every record in the `producto` entity.

```php
(new Producto)->update_all("precio = precio * 1.2", "estado = 'A'", "limit: 100");
```

Increases the `precio` attribute by 20% for 100 records in the `producto` entity where the `estado` attribute is `A`.

```php
(new Producto)->update_all( "precio = 0, estado='C'", "estado = 'B'");
```

Sets the `precio` attribute to 0 and `estado` to `C` for every record in the `producto` entity where `estado` is `B`.

#### delete()

Deletes one or more records according to the specified attributes and conditions. Returns a boolean.

```php
$producto = (new Producto)->find(123);
$exito = $producto->delete();

(new Producto)->delete(123); // deletes the record by its ID

$exito = (new Producto)->delete("estado='A'");
```

#### delete_all()

Deletes one or more records according to the specified attributes and conditions. Returns a boolean.

```php
(new Producto)->delete_all( " precio >= 99.99 " );

(new Producto)->delete_all( " estado = 'C' " );
```

### Validations

#### validates_presence_of

When this method is called from an ActiveRecord class constructor, it requires the fields defined in the list to be present. Fields marked as `not_null` in the table are validated automatically.

```php
<?php
 class Clientes extends ActiveRecord {
   protected function initialize(){
    $this->validates_presence_of("cedula");
   }
 }

```

#### validates_length_of

When this method is called from an ActiveRecord class constructor, it requires the length of the fields defined in the list to be validated.

The `minimum` parameter validates that the value being inserted or updated is not shorter than the specified length. The `maximum` parameter validates that the value is not longer than the specified length. The `too_short` parameter specifies the custom message that ActiveRecord displays when the value is too short, and `too_long` specifies the message displayed when it is too long.

```php
<?php
class Clientes extends ActiveRecord {

  protected function initialize(){
   $this->validates_length_of("nombre", "minimum: 15", "too_short: The name must contain at least 15 characters");
   $this->validates_length_of("nombre", "maximum: 40", "too_long: The name must contain at most 40 characters");
   $this->validates_length_of("nombre", "in: 15:40",
       "too_short: The name must contain at least 15 characters",
       "too_long: The name must contain at most 40 characters"
   );
  }
}
```

#### validates_numericality_of

Validates that specific attributes have a numeric value before insertion or update.

```php
<?php
 class Productos extends ActiveRecord {

   protected function initialize(){
    $this->validates_numericality_of("precio");
   }

 }
```

#### validates_email_in

Validates that specific attributes have a valid email format before insertion or update.

```php
<?php
 class Clientes extends ActiveRecord {

   protected function initialize(){
    $this->validates_email_in("correo");
   }

 }
```

#### validates_uniqueness_of

Validates that specific attributes have a unique value before insertion or update.

```php
<?php
 class Clientes extends ActiveRecord {

   protected function initialize(){
    $this->validates_uniqueness_of("cedula");
   }

 }
```

#### validates_date_in

Validates that specific attributes have a date format matching the one specified in `config/config.ini` before insertion or update.

```php
<?php
 class Registro extends ActiveRecord {

   protected function initialize(){
         $this->validates_date_in("fecha_registro");
   }
 }
```

#### validates_format_of

Validates that a field has a specific format according to a regular expression before insertion or update.

```php
<?php
 class Clientes extends ActiveRecord {

   protected function initialize(){
     $this->validates_format_of("email", "^[^@]+@((?:[a-z0-9]+\.)+[a-z]{2,})$");
   }

 }
```

### Transactions

#### commit()

This method commits a transaction started by `begin` in the database engine, if supported. It returns `true` on success and `false` otherwise.

Example:

```php
$Usuarios = new Usuarios();
$Usuarios->commit();
```

#### begin()

This method creates a transaction in the database engine, if supported. It returns `true` on success and `false` otherwise.

Example:

```php
$Usuarios = new Usuarios();
$Usuarios->begin();
```

#### rollback()

This method rolls back a transaction started by `begin` in the database engine, if supported. It returns `true` on success and `false` otherwise.

Example:

```php
$Usuarios = new Usuarios();
$Usuarios->rollback();
```

**Note:** Tables must use the [InnoDB](https://en.wikipedia.org/wiki/InnoDB) storage engine.

### Other methods

#### sql(string $sql)

This function executes SQL statements directly in the database engine. It should not be used frequently because ActiveRecord eliminates much of the need for SQL, but it is useful when a more specific query is required.

### Callbacks

#### Introduction

ActiveRecord controls the life cycle of created and read objects, monitoring when they are modified, saved, or deleted. Using callbacks (or events), ActiveRecord lets you intervene in this monitoring. You can write code that is invoked at any significant event in an object's life. Callbacks can perform complex validation, inspect values moving to and from the database, and even prevent certain operations from completing. For example, a callback can prevent active products from being deleted.

```php
<?php
class User extends ActiveRecord {

     public $before_delete = "no_borrar_activos";

     public function no_borrar_activos(){
         if($this->estado == 'A'){
           Flash::error('Active products cannot be deleted');
           return 'cancel';
        }
     }

     public function after_delete(){
           Flash::success("User $this->nombre was deleted");
     }

}
```

The following callbacks are also available in ActiveRecord. They are listed in the order in which they are called when defined:

#### before_validation

Called immediately before Kumbia performs validation. The current action can be canceled when this method returns the word `cancel`.

#### before_validation_on_create

Called immediately before Kumbia performs validation, but only when a model record is being inserted. The current action can be canceled when this method returns the word `cancel`.

#### before_validation_on_update

Called immediately before Kumbia performs validation, but only when a model record is being updated. The current action can be canceled when this method returns the word `cancel`.

#### after_validation_on_create

Called immediately after Kumbia performs validation, but only when a model record is being inserted. The current action can be canceled when this method returns the word `cancel`.

#### after_validation_on_update

Called immediately after Kumbia performs validation, but only when a model record is being updated. The current action can be canceled when this method returns the word `cancel`.

#### after_validation

Called immediately after Kumbia performs validation. The current action can be canceled when this method returns the word `cancel`.

#### before_save

Called immediately before a model is saved through **save()**, and when it is edited or updated through **update()**. The current action can be canceled when this method returns the word `cancel`.

```php
public function before_save() {            
    $rs = $this->find_first("cedula = $this->cedula");
    if($rs) {
         Flash::warning("A user with this ID number is already registered");
        return 'cancel';
    }                
}
```

#### before_update

Called immediately before a model is updated when the `save` or `update` method is called. The current action can be canceled when this method returns the word `cancel`. The code is the same as for `before_save()`.

#### before_create

Called immediately before a model is inserted when the `save` or `create` method is called. The current action can be canceled when this method returns the word `cancel`.

#### after_update

Called immediately after a model is updated when the `save` or `update` method is called.

#### after_create

Called immediately after a model is inserted when the `save` or `create` method is called.

#### after_save

Called immediately after a model is updated or inserted when the `save`, `update`, or `create` method is called.

#### before_delete

Called immediately before a model is deleted when the `delete` method is called. The current action can be canceled when this method returns the word `cancel`.

#### after_delete

Called immediately after a model is deleted when the `delete` method is called.

### Associations

#### Introduction

Many applications use multiple database tables, and those tables usually have relationships. For example, a city can be home to many clients, while a client has only one city. In a database schema, these relationships are linked through primary and foreign keys.

ActiveRecord follows the convention that a foreign key is named after the table and ends in `id`; for example, `ciudad_id` relates to the `ciudad` table through its `id` primary key.

With this convention, instead of writing:

```php
$ciudad_id = $cliente->ciudad_id;
$ciudad = (new Ciudad)->find($ciudad_id);
echo $ciudad->nombre;
```

it would be better to write:

```php
echo $cliente->getCiudad()->nombre;
```

This is part of ActiveRecord's convenience: it turns foreign keys into high-level statements that are easier to understand and use.

#### Belongs to (belongs_to)

This relationship is defined with the `belongs_to` method. The foreign key is in the table of the model from which the method is called. It represents a one-to-one relationship in the entity-relationship model.

belongs\_to($relation)

$relation (string): relationship name.

**Named parameters:**

model: Type of model that the relationship query must return. By default, the model corresponding to the relationship name is used. For example, if `$relation='auto_volador'`, then `model=AutoVolador`.

fk: Foreign-key name used for the relationship. By default, the relationship name with the `_id` suffix is used. For example, if `$relation='auto_volador'`, then `fk=auto_volador_id`.

**Usage examples:**

```php
$this->belongs_to('persona');
$this->belongs_to('vendedor', 'model: Persona');
$this->belongs_to('funcionario', 'model: Persona', 'fk: persona_id');
```

**In the `Libro` model:**

```php
class Libro extends ActiveRecord {
    public function initialize() {
        $this->belongs_to('persona');
    }
}
```

#### Has one

This relationship is defined with the `has_one` method. The foreign key is in the table of the model being associated. It represents a one-to-one relationship in the entity-relationship model.

has\_one($relation)

$relation (string): relationship name.

**Named parameters:**

model: Type of model that the relationship query must return. By default, the model corresponding to the relationship name is used. For example, if `$relation='auto_volador'`, then `model=AutoVolador`.

fk: Foreign-key name used for the relationship. By default, the relationship name with the `_id` suffix is used. For example, if `$relation='auto_volador'`, then `fk=auto_volador_id`.

**Usage examples:**

```php
$this->has_one('persona');
$this->has_one('vendedor', 'model: Persona');
$this->has_one('funcionario', 'model: Persona', 'fk: personal_id');
```

In the `Persona` model:

```php
class Persona extends ActiveRecord {
    public function initialize() {
        $this->has_one('datos_personales');
    }
}
```

#### Has many

This relationship is defined with the `has_many` method. The foreign key is in the table of the model being associated. It represents a one-to-many relationship in the entity-relationship model.

has\_many($relation)

$relation (string): relationship name.

**Named parameters:**

model: Type of model that the relationship query must return. By default, the model corresponding to the relationship name is used. For example, if `$relation='auto_volador'`, then `model=AutoVolador`.

fk: Foreign-key name used for the relationship. By default, the relationship name with the `_id` suffix is used. For example, if `$relation='auto_volador'`, then `fk=auto_volador_id`.

**Usage examples:**

```php
$this->has_many('persona');
$this->has_many('vendedor', 'model: Persona');
$this->has_many('funcionario', 'model: Persona', 'fk: personal_id');
```

In the `Persona` model:

```php
class Persona extends ActiveRecord {
    public function initialize() {
        $this->has_many('libro');
    }
}
```

#### Has and belongs to many

This relationship is defined with the `has_and_belongs_to_many` method through a table that links the two models. It represents a many-to-many relationship in the entity-relationship model. A limitation is that this relationship is not supported across multiple ActiveRecord connections. To make it work with multiple connections, you can emulate it through two `has_many` relationships to the model represented by the linking table.

has\_and\_belongs\_to\_many($relation)

$relation (string): relationship name.

**Named parameters:**

model: Type of model that the relationship query must return. By default, the model corresponding to the relationship name is used. For example, if `$relation='auto_volador'`, then `model=AutoVolador`.

fk: Foreign-key name used for the relationship. By default, the relationship name with the `_id` suffix is used. For example, if `$relation='auto_volador'`, then `fk=auto_volador_id`.

key: Field that contains the primary-key value in the intermediate table containing the relationship fields. By default, it is the related model name with the `_id` suffix.

through: Table through which the many-to-many relationship is established. By default, it is formed from the name of the model table with the longer name, prefixed with `_`, followed by the other model table name.

**Usage examples:**

```php
$this->has_and_belongs_to_many('persona');
$this->has_and_belongs_to_many('cargos', 'model: Cargo', 'fk: id_cargo', 'key: id_persona', 'through: cargo_persona');
```

**In the `Persona` model:**

```php
class Persona extends ActiveRecord {
    public function initialize() {
        $this->has_and_belongs_to_many('cargo');
    }
}
```

### Paginators

Pagination is handled by two functions:

#### Paginate

This function can paginate arrays or models and accepts the following parameters.

For an array:

**$s**: array to paginate.

**page**: page number.

**per_page**: number of items per page.

**Example:**

```php
$page = paginate($s, 'per_page: 5', 'page: 1');
```

For a model:

**$s**: model name as a string or an ActiveRecord object.

**page**: page number.

**per_page**: number of items per page.

It also accepts all parameters that can be used with the ActiveRecord `find` method.

**Examples:**

```php
$page = paginate('usuario', 'NOT login="admin"', 'order: login ASC', 'per_page: 5', 'page: 1');
$page = paginate($this->Usuario, 'NOT login="admin"', 'order: login ASC', 'per_page: 5', 'page: 1');
```

#### Paginate_by_sql

Paginates through an SQL query. It accepts the following parameters:

**$model**: model name as a string or an ActiveRecord object.

**$sql**: SQL query as a string.

**Example:**

```php
$page = paginate_by_sql('usuario', 'SELECT * FROM usuario WHERE nombre LIKE "%emilio%" ', 'per_page: 5', 'page: 1');
```

Both paginators return a `page` object created from `stdClass`. It contains the following attributes:

**next**: next page number, or `false` when there is no next page.

**prev**: previous page number, or `false` when there is no previous page.

**current**: current page number.

**total**: total number of pages.

**items**: array of paginated items.

#### Paging in ActiveRecord

ActiveRecord also includes the `paginate` and `paginate_by_sql` methods. They behave like the standalone functions, but you do not need to pass the model to paginate because they use the calling model by default.

**Example:**

```php
$page = $this->Usuario->paginate('per_page: 5', 'page: 1');
```

#### Full example of use of the pager:

Suppose there is a `usuario` table with its corresponding `Usuario` model. The following controller paginates a list of users and allows searching by name. It uses controller data persistence to make pagination resistant to SQL injection.

The *usuario.php* model:

```php
<?php
class Usuario extends ActiveRecord {

}
```

In the *usuario_controller.php* controller:

```php
<?php

class UsuarioController extends AppController{

    public $page_title = 'Daily Backend Manager';

    private $_per_page = 10;

    /**
      * Search form
     * */
    public function index() {
        Input::delete();
    }

    /**
      * Paginator
     * */
    public function listar($page = '') {

        $usuario = new Usuario();
        /**
         * When the search is performed for the first time
         * */
        if (Input::hasPost('usuario')) {
            $data = Input::post('usuario');
            if ($data['nombre']) {
                $this->conditions = " nombre LIKE '%{$data['nombre']}%' ";
            }
            /**
             * Paginator with or without conditions
             * */
            if (isset($this->conditions) && $this->conditions) {
                $this->page = $usuario->paginate($this->conditions, "per_page: $this->_per_page", 'page: 1');
            } else {
                $this->page = $usuario->paginate("per_page: $this->_per_page", 'page: 1');
            }
        } elseif ($page === 'next' && isset($this->page) && $this->page->next) {
            /**
             * Paginator for the next page
             * */
            if (isset($this->conditions) && $this->conditions) {
                $this->page = $usuario->paginate($this->conditions, "per_page: $this->_per_page", "page: {$this->page->next}");
            } else {
                $this->page = $usuario->paginate("per_page: $this->_per_page", "page: {$this->page->next}");
            }
        } elseif ($page === 'prev' && isset($this->page) && $this->page->prev) {
            /**
             * Paginator for the previous page
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

In the *index.phtml* view:

```php
<?= Form::open('usuario/listar') ?>
<?= Form::text('usuario.nombre') ?>
<?= Form::submit('Search') ?>
<?= Form::close() ?>
```

In the *listar.phtml* view:

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
<?php if ($page->prev) echo Html::linkAction('listar/prev', 'Previous') ?>
<?php if ($page->next) echo ' | ' . Html::linkAction('listar/next', 'Next') ?>
```
