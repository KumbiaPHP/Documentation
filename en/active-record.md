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
$user = (new User)->find_first(123);
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

It is called just before the process of storing, when using the methods **save()** or **update()** in a model. You can cancel the action if this method return the word 'cancel'.

```php
public function before_save() {            
    $rs = $this->find_first("idnumber = $this->idnumber");
    if($rs) {
        Flash::warning("Exist a user whit that id number");
        return 'cancel';
    }                
}
```

#### before\_update

It's called just before the update process when is used the save or update methods in a model. You can cancel this action if this method return the word 'cancel'. The same code of the before\_save() is used for before\_update.

#### before\_create

It's called just before the insertion process when is used the save or create method in a model. You can cancel this action if this method return the word 'cancel'.

#### after\_update

It's called just after the update process when is used the save or update method in a model.

#### after\_create

It's called just after the update process when is used the save or create method in a model.

#### after\_save

It is called just after the update/insertion process when the is called the save, update or create method in a model.

#### before\_delete

It is called just before the deletion process when the delete method is called in a model. You can cancel this action if this method return the word 'cancel'.

#### after\_delete

It is called just after the deletion process when the delete method is called in a model.

### Associations

#### Introduction

Many applications work with multiples tables in a database and usually there are relationships between these tables. For example, a city can be home to many customer, but a client only has a city. In a database schema, these relationships are linked using primary and foreign keys.

ActiveRecord work with the following convention: the foreign key has the name of the table and ends in "\_id", thus: city\_id, this is a relation to the city to your primary key table id.

So, knowing this, would like that instead of saying:

```php
$city_id = $customer->city_id;
$city = $City->find($city_id);
echo $city->name;
```

It would be better:

```php
echo $customer->getCity()->name;
```

Much of the magic that has ActiveRecord is this, as it becomes the foreign keys in judgments of high level, easy to understand and work.

#### Belongs (belongs\_to)

This type of relationship is done with the method "belongs\_to", this foreign key is located in the table of the model where the method is invoked. Corresponds to a relationship one by one in the model entity relationship.

belongs\_to($relation)

$relation (string): name of the relationship.

**Named parameters:**

model: name of the type of model that must return the query of the relationship. By default is considered a model that correspond to the name of the relationship. Example: If $relation='car\_flight', then model=CarFlight

fk: name of the foreign key that relates. By default is the name of the relationship with the suffix "\_id". Example: If $relation ='car\_flight', then fk = car_flight\_id.

**Examples of use:**

```php
$this->belongs_to('person');
$this->belongs_to('seller', 'model: Person');
$this->belongs_to('functionary', 'model: Person', 'fk: person_id');
```

**In the book model:**

```php
class Book extends ActiveRecord {
    public function initialize() {
        $this->belongs_to('person');
    }
}
```

#### It has a (has\_one)

This type of relationship is done with the method "has\_one", in this foreign key is located in the table of the model that you want to associate. Correspond to a relationship one by one in the model entity relationship.

has\_one($relation)

$relation (string): name of the relationship.

**Named parameters:**

model: Name of the type of model that must return the query of the relationship. By default is considered a model that correspond to the name of the relationship. Example: If $relation='car\_flight', then model=CarFlight

fk: name of the foreign key that relates. By default is the name of the relationship with the suffix "\_id". Example: If $relation ='car\_flight', then fk = car_flight\_id.

**Examples of use:**

```php
$this->has_one('person');
$this->has_one('seller', 'model: Person');
$this->has_one('functionary', 'model: Person', 'fk: staff_id');

```

In the person model:

```php
class Person extends ActiveRecord {
    public function initialize() {
        $this->has_one('personal_data');
    }
}
```

#### It has many (has\_many)

This type of relationship is done with the method "has\_many", in this foreign key is located in the table of the model that you want to associate. Correspond to a relationship one by many in the model entity relationship.

has\_many ($relation)

$relation (string): name of the relationship.

**Named parameters:**

model: Name of the type of model that must return the query of the relationship. By default is considered a model that correspond to the name of the relationship. Example: If $relation='car\_flight', then model=CarFlight

fk: name of the foreign key that relates. By default is the name of the relationship with the suffix "\_id". Example: If $relation ='car\_flight', then fk = car_flight\_id.

**Examples of use:**

```php
$this->has_many('person');
$this->has_many('seller', 'model: Person');
$this->has_many('functionary', 'model: Person', 'fk: staff_id');

```

In the person model:

```php
class Person extends ActiveRecord {
    public function initialize() {
        $this->has_one('personal_data');
    }
}
```

#### It has and belongs to many (has\_and\_belongs\_to\_many)

This type of relationship is done with the "has\_and\_belongs\_to\_many" method, this occurs through a table that takes care of linking the two models. Corresponds to a relationship many-to-many model entity relationship. This type of relationship has the disadvantage that is not supported in the field of multiple connections of ActiveRecord, to get it to work with multiple connections, can emulate through two relations has\_many to the table model that relates.

has\_and\_belongs\_to\_many($relation)

$relation (string): name of the relationship.

**Named parameters:**

model: Name of the type of model that must return the query of the relationship. By default is considered a model that correspond to the name of the relationship. Example: If $relation='car\_flight', then model=CarFlight

fk: name of the foreign key that relates. By default is the name of the relationship with the suffix "\_id". Example: If $relation ='car\_flight', then fk = car_flight\_id.

key: name of the field that will contain the value of the primary key in the intermediate table that containing fields of the relationship. By default it is the name of the model that will interact with the suffix "\_id".

through: table through which it establishes the relationship many-to-many. By default it is formed by the name of the table from the model that has the table name longer and as a "\_" prefix and the name of the table from the other model.

**Examples of use:**

```php
$this->has_and_belongs_to_many('person');
$this->has_and_belongs_to_many('charge', 'model: Charge', 'fk: id_charge', 'key: id_person', 'through: carge_person');
```

**In the person model:**

```php
class Person extends ActiveRecord {
    public function initialize() {
        $this->has_and_belongs_to_many('charge');
    }
}
```

### Pagers

There are two function responsible for the pagination:

#### Paginate

It is capable of pagination of arrays or models, it take the following parameters:

For array:

**$s** : array to page.

**page**: page number.

**per\_page**: number of items per page.

**Example:**

```php
$page = paginate($s, 'per_page: 5', 'page: 1');
```

For model:

**$s**: string with name of model or ActiveRecord object.

**page**: page number.

**per\_page**: number of items per page.

It also receives all the parameters that can be used in the "find" method of ActiveRecord.

**Examples:**

```php
$page = paginate('user', 'NOT login=”admin”', 'order: login ASC', 'per_page: 5', 'page: 1');
$page = paginate($this->User, 'NOT login=”admin”', 'order: login ASC', 'per_page: 5', 'page: 1');

```

#### Paginate\_by\_sql

Performs paging through an sql query. It takes the following parameters:

**$model**: string name of model or ActiveRecord object.

**$sql**: sql query string.

**Example:**

```php
$page = paginate_by_sql('user', 'SELECT * FROM user WHERE nombre LIKE “%carl%” ', 'per_page: 5', 'page: 1');
```

Both type of pagers returning a object "page", this "page" is create from stdClass, that contains the following attributes:

**Next**: next page number, if there is no page following it is "false".

**Prev**: previous page number, if there is no page above it is "false".

**current**: current page number.

**total**: number of pages total.

**items**: array of paginated items.

#### Paging in ActiveRecord

ActiveRecord already brings integrated paginate and paginate\_by\_sql methods, they behave like paginate and paginate\_by\_sql, but is not necessary to pass the model to paging since by default they take the model invoked.

**Example:**

```php
$page = $this->User->paginate('per_page: 5', 'page: 1');
```

#### Full example of use of the pager:

We have a user table with its corresponding User model, then we create a controller which paginate a list of user and also allow search by name, will take advantage of the persistence of controller data to make a paging immune to sql injection.

In the *user_controller.php* controller:

```php
class UserController extends ApplicationController {
  private $_per_page = 7;
  /**
  * Form of search
  **/
  public function search() {
    $this->nullify('page', 'conditions');
  }
  /**
  * Paginator
  **/
  public function list($page='') {
    /**
    * When run the search for first time
    **/
    if(Input::hasPost('user')) {
      $user = Input::post('user');
      if($user['name']) {
        $this->conditions = “ name LIKE '%{$user['name']}%' ”;
      }
      /**
      * Paginator with or without options
      **/
      if(isset($this->conditions) && $this->conditions) {
        $this->page = $this->User->paginate($this->conditions, “per_page: $this>_per_page”, 'page: 1');
      } else {
        $this->page = $this->User->paginate(“per_page: $this>_per_page”, 'page: 1');
      }
    } elseif($page='next' && isset($this->page) && $this->page->next) {
       /**
       * Paginator of next page
       **/
      if(isset($this->conditions) && $this->conditions) {
        $this->page = $this->User->paginate($this->conditions, “per_page: $this>_per_page”, “page: {$this->page->next}”);
      } else {
         $this->page = $this->User->paginate(“per_page: $this->_per_page”, “page: {$this->page->next}”);
      }
    } elseif($page='prev' && isset($this->page) && $this->page->prev) {
      /**
      * Paginator of preview page
      **/
      if(isset($this->conditions) && $this->conditions) {
        $this->page = $this->User->paginate($this->conditions, “per_page: $this->_per_page”, “page: {$this->page->prev}”);
    } else {
       $this->page = $this->User->paginate(“per_page: $this->_per_page”, “page: {$this->page->prev}”);
    }
  }
 }
}
```

In the view of *search.pthml*

```php
<?= Form::open('user/list') ?>
<?= Form::text('user.name') ?>
<?= Form::submit('Query') ?>
<?= Form::close() ?>

```

In the view of *list.phtml*

```php
<table>
    <tr>
        <th>id</th>
        <th>name</th>
    </tr>
    <?php foreach($page->items as $p): ?>
    <tr>
        <td><?= $p->id ?></td>
        <td><?= h($p->name) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<?php if($page->prev) echo Html::linkAction('list/prev', 'Preview') ?>
<?php if($page->next) echo ' | ' . Html::linkAction('list/next', 'Next') ?>
```