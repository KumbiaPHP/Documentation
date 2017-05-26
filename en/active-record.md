# ActiveRecord

It is the main class for the Administration and operation of models. ActiveRecord is an implementation of this programming pattern and is heavily influenced by the functionality of its analogue in Ruby available on Rails. ActiveRecord provides an object-relational layer that strictly follows the standard ORM: tables in classes, objects records, and fields in attributes. Facilitates the understanding of the code associated with the database and encapsulates the logic specified making it easier to use for the programmer.

KumbiaPHP uses OOP (Object-oriented programming), so ActiveRecord is a class with ready-to-use methods. These methods make it easier for the user to manage tables in databases; Among them are the next:

Example with KumbiaPHP 0.9

```php
<?php
//KumbiaPHP 0.9
$customer = Load::model('customer'); 
$customer->nit = "808111827-2"; 
$customer->social_name = "Bussines XYZ";
$customer->save(); 
```

Example with KumbiaPHP 1.0

```php
<?php
//KumbiaPHP 0.9
$customer = new Customer(); 
$customer->nit = "808111827-2"; 
$customer->razon_social = "EMPRESA DE TELECOMUNICACIONES XYZ";
$customer->save(); 
```

### Advantages of ActiveRecord

- The entities of the Model are most naturally worked as objects.
- Actions such as inserting, consult, update, delete, etc. of an entity of the model are encapsulated so the code is reduced and becomes more easy to maintain.
- The code it's much more easy to learn and keep
- The use of SQL has a 80% reduction, which achieves a high percentage of independence of the database engine.
- without details unnecessary, the code is more practical and useful
- "ActiveRecord" protec in a huge percent of SQL injections attacks that your apps can suffer, limited the letters that make it's.

### How to Create an ActiveRecord in KumbiaPHP Framework?

The first thing is create a file in the directory "models" with the same name of the table in the database. For example: models/customers.php then create a class extended of some class for models.

Example:

```php
<?php 
class Customers extends ActiveRecord { 
} 
```

If you wanna make a model of a class has a compound name, for example the class Type Of Customer, for convention in our datebase it's must have a table called: type_of_customer and in the file: models/type_of_customer.php has the following code in the model:

```php
<?php 
class TypeOfCustomers extends ActiveRecord { 
} 


### Columns and Attributes

Objects ActiveRecord correspond to a register in a table of a 
database. The objects have attributes that correspond to a 
fields in it's tables. The class ActiveRecord obtain automatically 
the definition of the fields of the tables and make convert it 
in attributes of the class associated. This is we referred with the concept of object relational mapping.

Take a look into Album table: 
```sql 
CREATE TABLE album (     
id INTEGER NOT NULL AUTO_INCREMENT,     
name VARCHAR(100) NOT NULL,     
published_date DATE NOT NULL,     
price DECIMAL(12,2) NOT NULL,     
artist_id INTEGER NOT NULL,     
status CHAR(1),     
PRIMARY KEY(id)
 )
```

We can create an ActiveRecord model that maps this table:

```php
<?php 
class Album extends ActiveRecord { 
} 
```

An instance of this class will be an object with the attributes of the table album:

Example with KumbiaPHP 0.9

```php
```php
<?php
//KumbiaPHP 0.9
$album = Load::model('album'); 
$album->id = 2; 
$album->name = "Going Under"; 
$album->save(); 
 ```

Example with KumbiaPHP 1.0
```php
<?php 
 //KumbiaPHP 1.0
$album = new Album(); 
$album->id = 2; 
$album->name = "Going Under"; 
$album->save(); 
```

### Primary keys and the use of IDs

The examples shown in KumbiaPHP always works a column called id as primary key of our tables. Maybe, this is not practical every time for your seem, maybe at moment to create the customers table, the column of id would an excellent choice, but in case of change this value for another value you can found problems with the replicated data in another relations (taxes is a good example), and much more problems related the nature of the data struct. KumbiaPHP propose the use of ids has primary key with it is possible to automate many queries and provide one way to refer unequivocally to an special register without depend of the nature their attribute. Users of Rails can feel good with this features.

This feature can also to KumbiaPHP understand the entity–relationship model reading the name of the attributes of the tables. For example in the table of the previous example the convention affirms that id column is the primary key in this table but also tells that there is a foreign key to the artist table in it's field id.

### Conventions in ActiveRecord

ActiveRecord has a series of conventions that serve to bring the possibilities to assume different qualities and relate the data model. Conventions are the following:

**id**

If ActiveRecord finds a field called id, ActiveRecord will take that's the primary key of entity, that it's auto incremental and numerical.

**table_id**

The finished fields in *_id* indicate foreign relationships to other tables, thus can be easily defined relations between the entities in the model:

A field called *customers_id* in a table indicates that exist another table called customers and this have a field called id that is related to it.

**field_at**

The finished fields in *_at* indicate that are date and has the extra functionality that can obtain the value of current date insertion.

*field_at* is a date field.

**field_in**

The finished fields in *_in* indicate that are date and has the extra functionality that can obtain the value of current date update.

*field_in* is a date field.

**Note:** The fields *_at* and *_in* must be of date type (DATE o DATETIME) in the database engine is using.

## ActiveRecord API

Then will see a method reference of the ActiveRecord class and its respective functionality. These are organized alphabetically.

### Querys

Methods to query registries:

#### distinct ()

This method execute a distinction query in the entity, working the same as a "unique select field", in SQL. The goal is return an array with the unique values of the specified field as parameter.

Syntax

```php
distinct([string $attribute_entity], [ "conditions: …" ], [ "order: …" ], ["limit: …" ], [ "column: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "offset: …" ])
```

Example

```php
$uniques = (new Users)->distinct("state");
# array('A','I','N')  
```

The conditions parameters, order and limit work identically to in the find method and enable you modify the shape or the same return values returned by this.

#### find\_all\_by\_sql (string $sql)

This method allows us to do a query using SQL and the returned result is an array of objects of the same class with the values of this register. The main idea is that the use of this method it's gonna be more unnecessary in our applications, since ActiveRecord take out the necessity of use the main SQL, but there are moments when it is necessary to be more specific and have to use this method.

Example

```php
$users = (new User)->find_all_by_sql( "select * from users where code not in (select code from income)")
```

In this example we consulted all the users with a special sentence WHERE. The idea is that consulted users may no be in the entity income.

#### find\_by\_sql (string $sql)

This method allow us make a query across a SQL sentence and the result return is a object that represent the found result. The main idea is that the use of this method it's gonna be more unnecessary in our applications, since ActiveRecord take out the necessity of use the main SQL, but there are moments when it is necessary to be more specific and have to use this method.

Example

```php
$user = (new User)->find_by_sql( "select * from users where code not in (select code from income) limit 1" );  
```

This example queries the first user with a sentence where special. The idea is that the user accessed is not in the State income.

#### find\_first (string $sql)

Syntax

```php
find_first([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ],[ "columns: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "distinct: …" ], [ "offset: …" ] )  
```

The "find\_first" method returns the first record of a entity or the first occurrence according to search or sorting criteria. The parameter are all optional and your order is not relevant, when invoked without parameter returns the first record inserted in the entity. This method is very flexible and can be used in many ways:

Example

```php
$user = (new Users)->find_first( "conditions: state='A'", "order: date desc");
```

In this example we are looking for the first record whose status is equal to "a" and odered descending, the result of this is charged to the variable $user. Returns a instance of the same ActiveRecord object in case of success or false otherwise.

Whit the method find_first we can search for a record in particular from his id in this way:

```php
$usuario = (new Usuario)->find_first(123);
```

We get the record 123 and also returns an instance of ActiveRecord object on success, or false otherwise. KumbiaPHP generates a warning when the criteria of search for find_first returned more than one record, for this we can force to returned to only one, using the limit parameter, in this way:

```php
$user = (new User)->find_first("conditions: state = 'A'"."limit: 1");
```

When we want to consult, only some of the attributes of the entity, we can use the columns parameter:

```php
$user = (new User)->find_first( "columns: name, state");
```

When we specify the first parameter of string type, ActiveRecord will assume that they are the conditions of query for find_first method:

```php
$user = (new User)->find_first("state='A'");
```

In this way we can also deduct these 2 sentences return the same result:

```php
$user = (new User) ->find_first("id='123'");
```

```php
$user = (new User) ->find_first(123);
```

#### find()

Syntax

```php
find([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ], [ "columns: …" ], [ "join: …" ], [ "group: …" ], [ "having: …" ], [ "distinct: …" ], [ "offset: …" ])
```

The "find" method is the main method of search of ActiveRecord, return all the record of a entity o the set of occurrences according the search criteria. The parameters are all optional and they order is not relevant, even can be combined or omitted if is necessary. When invoke without parameters return all the records in the entity.

Is important not forget to include a space after the colon (:) in each parameter.

Example

```php
$user = (new User)->find("conditions: state='A'", "order: date desc");
```

In this example search all the records whose state as equal to "A" and return this ordered descending, the result of this is an array of objects of the same class with the values of the records uploaded in them. If there are no records returns an empty array.

With the method find we can search the record from the particular id in this way:

```php
$user = (new User)->find(123);
```

In this case we obtain the record 123 and return a instance of the same ActiveRecord object on success, or false otherwise. As it is a single record does not return array, instead it the values of this are loaded into the same variable if the record exists.

For limit the number of record returned, you can use the limit parameter:

```php
$user = (new User)->find("conditions: state='A', 'limit: 5', 'offeset: 1');
```

When we want query only some of the attributes of the entity, we can also use the parameter columns:

```php
$user = (new User)->find("columns: name, state");
```

When we specify the first parameter of string type, ActiveRecord assume that it is the conditions of search for find:

```php
$user = (new User)->find("state='A'");
```

It's possible use the property count for know how many records were returned in the search.

Note: it is not necessary use the find('id: $id'), it's posible use directly find($id)

We can see an example for **find** using the functions of summary and grouping (it's possible also to **find_first**)

```php
$ressumen = (new Invoice)->find("columns: agency_origin, agency_destiny, count(*) as num_invoices", group: agency_origin, agency_destiny", "having: count(*) > 5");
```

#### select\_one (string $select_query)

This method allows us to make certain queries as execute functions in the database engine knowing that these return a single record.

```php
$current_time = (new User)->select_onde("current_time");
```

In the example, we want to know the current time of the server returned from MySQL, you can use this method for this.

#### select\_one(string $select_query) (static)

This method allows us to make certain queries as execute functions in the date base engine, knowing that these return a single record. This method can be called statically, meaning that this is not necessary that exist a instance of ActiveRecord to make the call.

```php
$current_time = ActiveRecord::select_one("current_time");
```

In the example, we want to know the current time returned from the MySQL server, we can use this method for this.

#### exist()

This method, allows us verify if the record exist or not in the data base by using your id or a condition.

```php
$user = new User();

$user->id  = 3;

if ($user->exists()){
  //The user with the id equal to 3 exist
}

(new User)->exists( "name='Mike Amigorena'")
(new User)->exists(2); // Exists a user with id->2?
```

#### find\_all\_by()

This method allows us to search by some field.

```php
$result = (new Product)->find_all_by( 'category', 'supplies');
```

#### find\_by\__campo_()

This method allows us to make a search using the name of attribute as name of method. Return a single record.

```php
$result = (new Product)->find_by_category('Supplies');
```

#### find\_all\_by\__campo_()

This method allows us make a search with the name of attribute as method name. Returns all the record that match the search.

```php
$result = (new Product)->find_all_by_category("Supplies");
```

### Counts and Totals

#### count()

Performs a count on the records of the entity with or without any additional conditions. It emulates the function of grouping count. It's possible use the same parameters to the find method.

```php
$num_of_records = (new Customers)->count();
$num_of_records = (new Customers)->count("City = 'Bs As'");
```

#### sum()

Performs a summation on the numeric values of the attribute of a entity, it emulates the function of grouping sum in the SQL syntax. It's possible use the same parameters as find method.

```php
$sum = (new Product)->sum("price");
$sum = (new Product)->sum("price", "conditions: state = 'A'");
```

#### count\_by\_sql()

Make a sum using SQL language.

```php
$num = (new Product)->count_by_sql("select count(price) from product, taxes  where taxes.code = 1124 \
    and taxes.code_product = product.code_product");
```

### Averages, maximum and minimum

#### average()

Perform the calculation of the average on the numerical values of the attribute of an entity, it emulates the function of grouping avg in SQL language. You can use the same parameters to find.

```php
$average = (new Product)->average("price");
$average = (new Product)->average("price", "conditions: state = 'A'");
```

#### maximum()

This method performs the calculation of the maximum value on the values of the attribute of an entity, this emulate the function of grouping max in the SQL language. Its can be used for the same parameters that find.

```php
$max = (new Product)->maximum("price");
$max = (new Product)->maximum("date_buy", "conditions: state = 'A'");
```

#### minimum()

Performs the calculation of the minimum value on the values of the attribute of a some entity, that emulates the function of SQL language min. It's can be used the same parameters of the find method.

```php
$min = (new Product)->minimum("price");
$min = (new Product)->minimum("date_buy", "conditions: state = 'A'");
```

### Create, update, and deletion of records

#### create()

Create a record from the data given in the model. Returns boolean.

```php
$data = array ( "name" => "Cereal", "price" => 9.99, "state" => "A" );
$exito = (new Product)->create( $data );

$product = new Producto();
$product->name = "Cereal";
$product->price = 9.99;
$product->state = "A";
$succes = $product->create();
 

```

#### save()

Update o creates a record from the data given in the model. Make a registration when the item to save does not exist or when the primary key attribute is not indicated. Its updated when the record does exist. Return true or false.

```php
$data = array ("name" => "Cereal", "price" => 9.99, "state" => "A" );
$success = (new Product)->save( $data );

$product = (new Product)->find(123);
$product->price = 4.99;
$product->state = "A";
$success = $product->save();
 

```

#### update()

Update a record from the given data in the model. Returns true or false.

```php
$data = array ("name" => "Cereal Integral", "price" => 8.99, "state" => "A", "id" => 123);
$succes = (new Product)->update( $data );

$product = (new Product)->find( 123 );
$product->state = "C";
$product->update();
```

#### update\_all()

Update one or more values inside one or more records using the attributes and conditions indicated.

Examples:

```php
(new Product)->update_all("price = price * 1.2");
```

This update the attributes price increasing the 20% for all records in the product entity.

```php
(new Product)->update_all("price = price * 1.2", "state = 'A'", "limit: 100");
```

Update the attribute price increasing in a 20% for 100 records of the entity product where the state of attribute is 'A'.

```php
(new Product)->update_all( "price = 0, state='C'", "state = 'B'");
```

Actualiza el atributo precio aumentándolo en un 20% y estado todos registros de la entidad producto donde el atributo estado es 'B'.

#### delete()

Deletes one or more records from the attributes and conditions. It's return boolean.

```php
$product = (new Product)->find(123);
$success = $product->delete();

(new Product)->delete(123); //delete the records by ID

$success = (new Products)->delete("state='A'");
```

#### delete\_all()

Delete one or more records from of the attributes and conditions givens. It's Return boolean.

```php
(new Products)->delete_all( " price >= 99.99 " );

(new Products)->delete_all( " state = 'C' " );
```

### Validations

#### validates\_presence\_of

When this method is called from the constructor of ActiveRecord, it requires that you validate the presence of the fields defined in the list. The marked as not\_null fields in the table are automatically validated.

```php
<?php
 class Customers extends ActiveRecord {
   protected function initialize{
    $this->validates_presence_of("name");
   }
 }

```

#### validates\_length\_of

When this method is called from the constructor of a ActiveRecord class, its required that you validated the length of the fields defined in the list.

When this method is called from the constructor of a ActiveRecord class, is required that you validate the length of the fields defined in the list. The maximum parameter indicate that the value to insert/update may not be larger than indicated. The parameter too\_short indicates the custom message that ActiveRecord displayed when validation fails when it is smaller to too\_short and too\_long when it is too long.

```php
<?php
class Customers extends ActiveRecord {

  protected function initialize(){
   $this->validates_length_of("name", "minumum: 15", "too_short: The name must have at least 15 characters");
   $this->validates_length_of("name", "maximum: 40", "too_long: The name it's too large the maximum character is 40 ");
   $this->validates_length_of("name", "in: 15:40", 
      "too_short: The name must have at least 15 characters",
      "too_long: The name must have at maximum 40 characters"
   );
  }
}
```

#### validates\_numericality\_of

Validates some numeric inputs before insert this in the database.

```php
<?php
 class Products extends ActiveRecord {

   protected function initialize{
    $this->validates_numericality_of("price");
   }

 }
```

#### validates\_email\_in

It's validate that the input value has format of e-mail before insert or update in the entity.

```php
<?php
 class Customers extends ActiveRecord {

   protected function initialize(){
    $this->validates_email_in("email");
   }

 }
 
Context | Request Context

```

#### validates\_uniqueness\_of

This validate that some parameters has a unique values before insert or update.

```php
<?php
 class Customers extends ActiveRecord {

   protected function initialize{
    $this->validates_uniqueness_of("cedule");
   }

 }
```

#### validates\_date\_in

This validate that some parameters have a format date according to the format in config/config.ini before insert or update.

```php
<?php
 class Record extends ActiveRecord {

   protected function initialize(){
         $this->validates_date_in("date_record");
   }
 }
```

#### validates\_format\_of

This validate that some data has a special format using the regex before insert or update.

```php
<?php
 class Customers extends ActiveRecord {

   protected function initialize(){
    $this->validates_format_of("email", "^(+)@((?:[?a?z0?9]+\.)+[a?z]{2,})$");
   }

 }
```

### Transactions 

#### commit()

This method allows us to confirm a transaction initiated by the begin method on the database engine, if this permitting. Return true in success or false if not.

Example

```php
$Users = new Users();
$Users->commit();
```

#### begin()

This method allow us to create a transaction on the database engine, if this permitting. Return true in success or false if not.

Example

```php
$Users = new Users();
$Users->begin();
```

#### rollback()

This method allows us cancel a transaction initiated be the begin method on the database engine, if this permitting. Return true in success or false if not.

Example

```php
$Users = new Users();
$Users->rollback();
```

**Note:** The tables must have the \[InnoDB\] storage engine.[1](http://es.wikipedia.org/wiki/InnoDB) 

### Another methods

#### sql (string $sql)

This method allows us run SQL statements directly in the database engine. The main idea is that the use of this method it's gonna be more unnecessary in our applications, since ActiveRecord take out the necessity of use the main SQL, but there are moments when it is necessary to be more specific and have to use this method.

### Callbacks

#### Introduction

The ActiveRecords take the control of the lifecycle of objects created and read, monitoring when they are modified, stored or erased. Using callbacks (or methods), ActiveRecord allow us take the control in this supervision. We can write the code that can be invoked in any significant event in the life of a object. With the callbacks can performs complex validations, review the values that come and go from the database, and even prevent certain operations to finish. An example of these callbacks can be the validations in products that prevents that active products can be erased.

```php
<?php
class User extends ActiveRecord {

     public $before_delete = “not_erase_actives”;

     public function not_erase_actives(){
        if($this->state==’A’){
          Flash::error(‘It's not possible erase active products’);
          return ‘cancel’;
        }
     }

     public function after_delete(){
          Flash::success("A record has been erased $this->nombre");
     }

}
```

Then other callbacks that can be found in ActiveRecord. The order in which they are presented is in which are called if they are defined:

#### before\_validation

This callbacks are executed just before the process of validation by Kumbia. You can cancel the action taking place if this method returns the word cancel.

#### before\_validation\_on\_create

It's called just before the process of validation by Kumbia, only when performing a process of inclusion in a model. You can cancel the action if this method return cancel.

#### before\_validation\_on\_update

It's called just before to process the validation by Kumbia, only when it's a update model process. You can cancel the action if this method return cancel.

#### after\_validation\_on\_create

It's called just after of completing the process of validation by Kumbia, only when performing a process of insertion in a model. You can cancel the action if this method return cancel.

#### after\_validation\_on\_update

It's called just after that Kumbia completing the process of validation, only when performing an update process in a model. You can cancel the action if this method return the word 'cancel'.

#### after\_validation

It's called just after that Kumbia completing the process of validation. You can cancel the action if this method return the word 'cancel'.

#### before\_save

It is called just before the process of storing, using the methods **save()** or **update()** in a model. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

```php
public function before_save() {            
    $rs = $this->find_first("cedula = $this->cedula");
    if($rs) {
        Flash::warning("Ya existe un usuario registrado bajo esta cedula");
        return 'cancel';
    }                
}
```

#### before\_update

Es llamado justo antes de realizar el proceso de actualización cuando se llama el método save o update en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'. El mismo codigo del before\_save() para before\_update.

#### before\_create

Es llamado justo antes de realizar el proceso de inserción cuando se llama el método save o create en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after\_update

Es llamado justo después de realizar el proceso de actualización cuando se llama el método save o update en un modelo.

#### after\_create

Es llamado justo después de realizar el proceso de actualización cuando se llama el método save o create en un modelo.

#### after\_save

Es llamado justo después de realizar el proceso de actualización/inserción cuando se llama el método save, update ó create en un modelo.

#### before\_delete

Es llamado justo antes de realizar el proceso de borrado cuando se llama el método delete en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after\_delete

Es llamado justo después de realizar el proceso de borrado cuando se llama el método delete en un modelo.

### Asociaciones

#### Introducción

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

#### Pertenece (belongs\_to)

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

#### Tiene un (has\_one)

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

#### Tiene muchos (has\_many)

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

#### Tiene y pertenece a muchos (has\_and\_belongs\_to\_many)

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

#### Paginate\_by\_sql

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

#### Paginando en ActiveRecord

ActiveRecord ya trae integrado los métodos paginate y paginate\_by\_sql, se comportan igual que paginate y paginate\_by\_sql, sin embargo no es necesario pasar el modelo a paginar ya que por defecto toman el modelo que invoca.

**Ejemplo:**

```php
$page = $this->Usuario->paginate('per_page: 5', 'page: 1');
```

#### Ejemplo completo de uso del paginador:

Tenemos una tabla usuario con su correspondiente modelo Usuario, entonces creemos un controlador el cual pagine una lista de usuarios y asimismo permita buscar por nombre, aprovecharemos la persistencia de datos del controlador para hacer una paginación inmune a inyección sql.

En el controlador *usuario_controller.php*:

```php
class UsuarioController extends ApplicationController {
  private $_per_page = 7;
  /**
  * Formulario de busqueda
  **/
  public function buscar() {
    $this->nullify('page', 'conditions');
  }
  /**
  * Paginador
  **/
  public function lista($page='') {
    /**
    * Cuando se efectua la busqueda por primera vez
    **/
    if(Input::hasPost('usuario')) {
      $usuario = Input::post('usuario');
      if($usuario['nombre']) {
        $this->conditions = “ nombre LIKE '%{$usuario['nombre']}%' ”;
      }
      /**
      * Paginador con condiciones o sin condiciones
      **/
      if(isset($this->conditions) && $this->conditions) {
        $this->page = $this->Usuario->paginate($this->conditions, “per_page: $this>_per_page”, 'page: 1');
      } else {
        $this->page = $this->Usuario->paginate(“per_page: $this>_per_page”, 'page: 1');
      }
    } elseif($page='next' && isset($this->page) && $this->page->next) {
       /**
       * Paginador de pagina siguiente
       **/
      if(isset($this->conditions) && $this->conditions) {
        $this->page = $this->Usuario->paginate($this->conditions, “per_page: $this>_per_page”, “page: {$this->page->next}”);
      } else {
         $this->page = $this->Usuario->paginate(“per_page: $this->_per_page”, “page: {$this->page->next}”);
      }
    } elseif($page='prev' && isset($this->page) && $this->page->prev) {
      /**
      * Paginador de pagina anterior
      **/
      if(isset($this->conditions) && $this->conditions) {
        $this->page = $this->Usuario->paginate($this->conditions, “per_page: $this->_per_page”, “page: {$this->page->prev}”);
    } else {
       $this->page = $this->Usuario->paginate(“per_page: $this->_per_page”, “page: {$this->page->prev}”);
    }
  }
 }
}
```

En la vista *buscar.pthml*

```php
<?= Form::open('usuario/lista') ?>
<?= Form::text('usuario.nombre') ?>
<?= Form::submit('Consultar') ?>
<?= Form::close() ?>

```

En la vista *lista.phtml*

```php
<table>
    <tr>
        <th>id</th>
        <th>nombre</th>
    </tr>
    <?php foreach($page->items as $p): ?>
    <tr>
        <td><?= $p->id ?></td>
        <td><?= h($p->nombre) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<?php if($page->prev) echo Html::linkAction('lista/prev', 'Anterior') ?>
<?php if($page->next) echo ' | ' . Html::linkAction('lista/next', 'Siguiente') ?>
```