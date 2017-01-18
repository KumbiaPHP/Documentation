# ActiveRecord

Es la principal clase para la administración y funcionamiento de modelos.
ActiveRecord es una implementación de este patrón de programación y esta muy
influenciada por la funcionalidad de su análoga en Ruby disponible en Rails.
ActiveRecord proporciona la capa objeto-relacional que sigue rigurosamente el
estándar ORM: Tablas en Clases, Registros en Objetos, y Campos en Atributos.
Facilita el entendimiento del código asociado a base de datos y encapsula la
lógica especifica haciendo más fácil de usar para el programador.

KumbiaPHP usa POO (Programación orientada a objetos), así que ActiveRecord es
una clase que ya lleva métodos listos para usar. Estos métodos facilitan al
usuario el manejo de las tablas de las bases de datos; entre ellos están los
siguientes: find(), find_first(), save(), update(), etc.

Ejemplo con KumbiaPHP 0.9

```php
<?php
//KumbiaPHP 0.9
$cliente = Load::model('cliente'); 
$cliente->nit = "808111827-2"; 
$cliente->razon_social = "EMPRESA DE TELECOMUNICACIONES XYZ";
$cliente->save(); 
```

Ejemplo con KumbiaPHP 1.0
```php
<?php
//KumbiaPHP 1.0
$cliente = new Cliente(); 
$cliente->nit = "808111827-2"; 
$cliente->razon_social = "EMPRESA DE TELECOMUNICACIONES XYZ";
$cliente->save(); 
``` 
 
### Ventajas del ActiveRecord

 * Se trabajan las entidades del Modelo mas Naturalmente como objetos.
 * Las acciones como Insertar, Consultar, Actualizar, Borrar, etc. de una entidad del Modelo están encapsuladas así que se reduce el código y se hace mas fácil de mantener.
 * Código más fácil de Entender y Mantener
 * Reducción del uso del SQL en un 80%, con lo que se logra un alto porcentaje de independencia del motor de base de datos.
 * Menos "detalles", más práctico y util
 * ActiveRecord protege en un gran porcentaje de ataques de SQL inyection que puedan llegar a sufrir tus aplicaciones escapando caracteres que puedan facilitar estos ataques.

### Crear un Modelo ActiveRecord en KumbiaPHP Framework

Lo primero es crear un archivo en el directorio models con el mismo nombre de
la tabla en la base de datos. Por ejemplo: models/clientes.php Luego
creamos una clase con el nombre de la tabla extendiendo alguna de las clases
para modelos.

Ejemplo:

```php
<?php 
class Cliente extends ActiveRecord { 
} 
``` 
 
Si lo que se desea es crear un modelo de una clase que tiene nombre compuesto
por ejemplo la clase Tipo de Cliente, por convención en nuestra base de datos
esta tabla debe llamarse: tipo_de_cliente y el archivo:
models/tipo_de_cliente.php y el código de este modelo es el siguiente:

```php
<?php 
class TipoDeCliente extends ActiveRecord { 
} 
 ```
 
### Columnas y Atributos

Objetos ActiveRecord corresponden a registros en una tabla de una base de
datos. Los objetos poseen atributos que corresponden a los campos en estas
tablas. La clase ActiveRecord automáticamente obtiene la definición de los
campos de las tablas y los convierte en atributos de la clase asociada. A esto
es lo que nos referíamos con mapeo objeto relacional.

Miremos la tabla Álbum:

```sql
CREATE TABLE album (
    id INTEGER NOT NULL AUTO_INCREMENT, 
    nombre VARCHAR(100) NOT NULL, 
    fecha DATE NOT NULL, 
    valor DECIMAL(12,2) NOT NULL, 
    artista_id INTEGER NOT NULL, 
    estado CHAR(1), 
    PRIMARY KEY(id)
)
```
 
Podemos crear un modelo ActiveRecord que mapee esta tabla:

```php
<?php 
class Album extends ActiveRecord { 
} 
```
 
Una instancia de esta clase sera un objeto con los atributos de la tabla
album:

Ejemplo con KumbiaPHP 0.9

```php
<?php
//KumbiaPHP 0.9
$album = Load::model('album'); 
$album->id = 2; 
$album->nombre = "Going Under"; 
$album->save(); 
 ```

Ejemplo con KumbiaPHP 1.0
```php
<?php 
 //KumbiaPHP 1.0
$album = new Album(); 
$album->id = 2; 
$album->nombre = "Going Under"; 
$album->save(); 
```
 
### Llaves Primarias y el uso de IDs

En los ejemplos mostrados de KumbiaPHP siempre se trabaja una columna llamada
id como llave primaria de nuestras tablas. Tal vez, esto no siempre es
practico a su parecer, de pronto al crear la tabla clientes la columna de
numero de identificación seria una excelente elección, pero en caso de cambiar
este valor por otro tendría problemas con el dato que este replicado en otras
relaciones (ejemplo facturas), además de esto tendría que validar otras cosas
relacionadas con su naturaleza. KumbiaPHP propone el uso de ids como llaves
primarias con esto se automatiza muchas tareas de consulta y proporciona una
forma de referirse unívocamente a un registro en especial sin depender de la
naturaleza de un atributo especifico. Usuarios de Rails se sentirán
familiarizados con esta característica.

Esta particularidad también permite a KumbiaPHP entender el modelo entidad
relación leyendo los nombres de los atributos de las tablas. Por ejemplo en la
tabla album del ejemplo anterior la convención nos dice que id es la llave
primaria de esta tabla pero además nos dice que hay una llave foránea a la
tabla artista en su campo id.

### Convenciones en ActiveRecord

ActiveRecord posee una serie de convenciones que le sirven para asumir
distintas cualidades y relacionar un modelo de datos. Las convenciones son las
siguientes:

**id**

Si ActiveRecord encuentra un campo llamado id, ActiveRecord asumira que se
trata de la llave primaria de la entidad y que es auto-numérica.

**tabla_id**

Los campos terminados en *_id* indican relaciones foráneas a otras tablas, de
esta forma se puede definir fácilmente las relaciones entre las entidades del
modelo:

Un campo llamado *clientes_id* en una tabla indica que existe otra tabla
llamada clientes y esta contiene un campo id que es foránea a este.

**campo_at**

Los campos terminados en *_at* indican que son fechas y posee la funcionalidad
extra que obtienen el valor de fecha actual en una inserción.

*created_at* es un campo fecha

**campo_in**

Los campos terminados en *_in* indican que son fechas y posee la funcionalidad
extra que obtienen el valor de fecha actual en una actualización.

*modified_in* es un campo fecha

**Nota:** Los campos *_at* y *_in* deben ser de tipo fecha (DATE o DATETIME) en el motor de base de datos que se
este utilizando.

##  ActiveRecord API

A continuación veremos una referencia de los métodos que posee la clase
ActiveRecord y su funcionalidad respectiva. Éstos se encuentran organizados
alfabéticamente:

###  Consultas

Métodos para hacer consulta de registros:

####  distinct ()

Este método ejecuta una consulta de distinción única en la entidad, funciona
igual que un "select unique campo" viéndolo desde la perspectiva del SQL. El
objetivo es devolver un array con los valores únicos del campo especificado
como parámetro.

Sintaxis
```php
distinct([string $atributo_entidad], [ "conditions: …" ], [ "order: …" ], ["limit: …" ], [ "column: …" ])
```

Ejemplo
```php
$unicos = (new Usuario)->distinct("estado");
# array('A', 'I', 'N')  
``` 

Los parámetros conditions, order y limit funcionan idénticamente que en el
método find y permiten modificar la forma o los mismos valores de retorno
devueltos por esta.

####  find\_all\_by\_sql (string $sql)

Este método nos permite hacer una consulta por medio de un SQL y el resultado
devuelto es un array de objetos de la misma clase con los valores de los
registros en estos. La idea es que el uso de este método sea tan común
en nuestras aplicaciones, ya que ActiveRecord se encarga de eliminar el uso del
SQL en gran porcentaje, pero hay momentos en que es necesario que seamos más
específicos y tengamos que recurrir a su uso.

Ejemplo
```php
$usuarios = (new Usuario)->find_all_by_sql( "select * from usuarios where codigo not in (select codigo from ingreso)")
``` 

En este ejemplo consultamos todos los usuarios con una sentencia where
especial. La idea es que los usuarios consultados no pueden estar en la
entidad ingreso.

####  find\_by\_sql (string $sql)

Este método nos permite hacer una consulta por medio de un SQL y el resultado
devuelto es un objeto que representa el resultado encontrado. La idea es que
el uso de este método no sea tan común en nuestras aplicaciones, ya que
ActiveRecord se encarga de eliminar el uso del SQL en gran porcentaje, pero
hay momentos en que es necesario que seamos mas específicos y tengamos que
recurrir al uso de este.

Ejemplo
```php
$usuario = (new Usuario)->find_by_sql( "select * from usuarios where codigo not in (select codigo from ingreso) limit 1" );  
```  

Este ejemplo consulta el primer usuario con una sentencia where especial.
La idea es que el usuario consultado no se encuentre en la entidad ingreso.

####  find\_first (string $sql)

Sintaxis
```php
find_first([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ],[ "columns: …" ])  
```  

El método "find\_first" devuelve el primer registro de una entidad o la primera
ocurrencia de acuerdo a unos criterios de búsqueda u ordenamiento. Los
parámetros son todos opcionales y su orden no es relevante, cuando se invoca
sin parámetros devuelve el primer registro insertado en la entidad. Este
método es muy flexible y puede ser usado de muchas formas:

Ejemplo

```php
$usuario = (new Usuario)->find_first( "conditions: estado='A'", "order: fecha desc");
``` 

En este ejemplo buscamos el primer registro cuyo estado sea igual a "A" y
ordenado descendentemente, el resultado de este, se carga a la variable
$usuarios. Devuelve una instancia del mismo objeto ActiveRecord en
caso de éxito o false en caso contrario.

Con el método find_first podemos buscar un registro en particular a partir de
su id de esta forma:

```php
$usuario = (new Usuario)->find_first(123);
``` 

Obtenemos el registro 123 e igualmente devuelve una instancia del mismo
objeto ActiveRecord en caso de éxito, o false en caso contrario. KumbiaPHP genera
una advertencia cuando los criterios de búsqueda para find\_first devuelven más
de un registro, para esto podemos forzar que se devuelva solamente uno,
mediante el parámetro limit, de esta forma:

```php
$usuario = (new Usuario)->find_first( "conditions: estado='A'", "limit: 1" );
``` 

Cuando queremos consultar, sólo algunos de los atributos de la entidad, podemos
utilizar el parámetro columns:

```php
$usuario = (new Usuario)->find_first( "columns: nombre, estado");
``` 

Cuando especificamos el primer parámetro de tipo string, ActiveRecord asumirá
que son las condiciones de búsqueda para find_first:

```php
$usuario = (new Usuario)->find_first( "estado='A'" );
```  

De esta forma podemos también deducir que estas 2 sentencias arrojarían el
mismo resultado:

```php
$usuario = (new Usuario)->find_first( "id='123'" );
```

```php
$usuario = (new Usuario)->find_first(123);
```  

####  find()

Sintaxis
```php
find([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …], ["columns: … "])
```

El método "find" es el principal método de búsqueda de ActiveRecord, devuelve
todas los registros de una entidad o el conjunto de ocurrencias de acuerdo a
unos criterios de búsqueda. Los parámetros son todos opcionales y su orden no
es relevante, incluso pueden ser combinados u omitidos si es necesario. Cuando
se invoca sin parámetros devuelve todos los registros en la entidad.

No hay que olvidarse de incluir un espacio después de los dos puntos (:) en
cada parámetro.

Ejemplo

```php
$usuarios = (new Usuario)->find( "conditions: estado='A'", "order: fecha desc");
```

En este ejemplo buscamos todos los registros cuyo estado sea igual a "A" y
devuelva estos ordenados descendentemente, el resultado de este es un array de
objetos de la misma clase con los valores de los registros cargados en ellos.
En caso de no hayan registros devuelve un array vacío.

Con el método find podemos buscar un registro en particular a partir de su id
de esta forma:

```php
$usuario = (new Usuario)->find(123);
``` 

Obtenemos el registro 123 e igualmente devuelve una instancia del mismo
objeto ActiveRecord en caso de éxito, o false en caso contrario. Como es un
solo registro no devuelve un array, sino que los valores de este se cargan en
la misma variable si existe el registro.

Para limitar el número de registros devueltos, podemos usar el parámetro limit:

```php
$usuarios = (new Usuario)->find("conditions: estado='A'", 'limit: 5', 'offset: 1');
``` 

Cuando queremos consultar sólo algunos de los atributos de la entidad podemos
utilizar el parámetro columns :

```php
$usuarios = (new Usuario)->find("columns: nombre, estado");
``` 

Cuando especificamos el primer parámetro de tipo string, ActiveRecord asume
que son las condiciones de búsqueda para find:

```php
$usuarios = (new Usuario)->find( "estado='A'");
```

Se puede utilizar la propiedad count para saber cuántos registros fueron
devueltos en la búsqueda.

Nota: No es necesario usar find('id: $id'), se puede usar directamente
find($id)

#### select\_one (string $select_query)

Este método nos permite hacer ciertas consultas como ejecutar funciones en el
motor de base de datos sabiendo que éstas devuelven un único registro.

```php
$current_time = (new Usuario)->select_one( "current_time");
```  

En el ejemplo, queremos saber la hora actual del servidor devuelta desde MySQL,
podemos usar este método para esto.

####  select\_one(string $select_query) (static)

Este método nos permite hacer ciertas consultas como ejecutar funciones en el
motor de base de datos, sabiendo que estas devuelven un solo registro. Este
método se puede llamar de forma estática, esto significa que no es necesario
que haya una instancia de ActiveRecord para hacer el llamado.

```php
$current_time = ActiveRecord::select_one( "current_time");
``` 

En el ejemplo, queremos saber la hora actual del servidor devuelta desde MySQL,
podemos usar este método para esto.

####  exists()

Este método nos permite verificar si el registro existe o no en la base de
datos mediante su id o una condición.

```php
$usuario = new Usuario();

$usuario->id  = 3;

if ($usuario->exists()){
  //El usuario con id igual a 3 si existe
}

(new Usuario)->exists( "nombre='Juan Perez'")
(new Usuario)->exists(2); // Un Usuario con id->2?
``` 

####  find\_all\_by()

Este método nos permite realizar una búsqueda por algún campo

```php
$resultado = (new Producto)->find_all_by( 'categoria', 'Insumos');
``` 

####  find\_by\__campo_()

Este método nos permite realizar una búsqueda usando el nombre del atributo
como nombre de método. Devuelve un único registro.

```php
$resultado = (new Producto)->find_by_categoria('Insumos');
``` 

####  find\_all\_by\__campo_()

Este método nos permite realizar una búsqueda el nombre del atributo como
nombre de método. Devuelve todos los registros que coincidan con
la búsqueda.

```php
$resultado = (new Producto)->find_all_by_categoria("Insumos");
```  

###  Conteos y sumatorias

####  count()

Realiza un conteo sobre los registros de la entidad con o sin alguna condición
adicional. Emula la función de agrupamiento count.

```php
$numero_registros = (new Cliente)->count();
$numero_registros = (new Cliente)->count("ciudad = 'BOGOTA'");
```  

#### sum()

Realiza una sumatoria sobre los valores numéricos del atributo de alguna
entidad, emula la función de agrupamiento sum en el lenguaje SQL.

```php
$suma = (new Producto)->sum("precio");
$suma = (new Producto)->sum("precio", "conditions: estado = 'A'");
```  

####  count\_by\_sql()

Realiza una sumatoria utilizando lenguaje SQL.

```php
$numero = (new Producto)->count_by_sql("select count(precio) from producto, factura  where factura.codigo = 1124 \
    and factura.codigo_producto = producto.codigo_producto");
```

### Promedios, máximo y mínimo

#### average()

Realiza el cálculo del promedio sobre los valores numéricos del atributo de
alguna entidad, emula la función de agrupamiento avg en el lenguaje SQL.

```php
$promedio = (new Producto)->average("precio");
$promedio = (new Producto)->average("precio", "conditions: estado = 'A'");
```

#### maximum()

Realiza el cálculo del valor máximo sobre los valores del atributo de alguna
entidad, emula la función de agrupamiento max en el lenguaje SQL.

```php
$max = (new Producto)->maximum("precio");
$max = (new Producto)->maximum("fecha_compra", "conditions: estado = 'A'");
```

#### minimum()

Realiza el cálculo del valor mínimo sobre los valores del atributo de alguna
entidad, emula la función de agrupamiento min en el lenguaje SQL.

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
Actualiza o crea un registro a partir de los datos indicados en el modelo.
Crea el registro cuando el elemento a guardar no existe o cuando no se indica
el atributo de clave primaria. Actualiza cuando el registro existe. Retorna boolean.

```php
$data = array ("nombre" => "Cereal", "precio" => 9.99, "estado" => "A" );
$exito = (new Producto)->save( $data );

$producto = (new Producto)->find(123);
$producto->precio = 4.99;
$producto->estado = "A";
$exito = $producto->save();
```

#### update()
Actualiza un registro a partir de los datos indicados en el modelo. Retorna
boolean.

```php
$data = array ("nombre" => "Cereal Integral", "precio" => 8.99, "estado" => "A", "id" => 123);
$exito = (new Producto)->update( $data );

$producto = (new Producto)->find( 123 );
$producto->estado = "C";
$producto->update();
```

#### update\_all()
Actualiza uno o más valores dentro de uno o más registros a partir de los
atributos y condiciones indicadas.

Ejemplos:

```php
(new Producto)->update_all("precio = precio * 1.2");
```
Actualiza el atributo precio aumentándolo en un 20% para todos los registros
de la entidad producto.


```php
(new Producto)->update_all("precio = precio * 1.2", "estado = 'A'", "limit: 100");
```

Actualiza el atributo precio aumentándolo en un 20% para 100 registros
de la entidad producto donde el atributo estado es 'A'.

```php
(new Producto)->update_all( "precio = 0, estado='C'", "estado = 'B'");
```

Actualiza el atributo precio aumentándolo en un 20% y estado todos registros
de la entidad producto donde el atributo estado es 'B'.


#### delete()
Elimina uno o más registros a partir de los atributos y condiciones indicadas.
Retorna boolean.

```php
$producto = (new Producto)->find(123);
$exito = $producto->delete();

(new Producto)->delete(123); //elimina el registro por su ID

$exito = (new Producto)->delete("estado='A'");
```

#### delete\_all()
Elimina uno o más registros a partir de los atributos y condiciones indicadas.
Retorna boolean.

```php
(new Producto)->delete_all( " precio >= 99.99 " );

(new Producto)->delete_all( " estado = 'C' " );
```

### Validaciones

#### validates\_presence\_of

Cuando este método es llamado desde el constructor de una clase ActiveRecord, obliga a que se valide la presencia de los campos definidos en la lista. Los campos marcados como not\_null en la tabla son automáticamente validados.

```php
<?php
 class Clientes extends ActiveRecord {
   protected function initialize{
    $this->validates_presence_of("cedula");
   }
 }

```

#### validates\_length\_of

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

#### validates\_numericality\_of

Valida que ciertos atributos tengan un valor numérico antes de insertar ó actualizar.

```php
<?php
 class Productos extends ActiveRecord {
 
   protected function initialize{
    $this->validates_numericality_of("precio");
   }
 
 }
```

#### validates\_email\_in

Valida que ciertos atributos tengan un formato de e-mail correcto antes de insertar o actualizar.

```php
<?php
 class Clientes extends ActiveRecord {
 
   protected function initialize(){
    $this->validates_email_in("correo");
   }
 
 }
```

#### validates\_uniqueness\_of

Valida que ciertos atributos tengan un valor único antes de insertar o actualizar.

```php
<?php
 class Clientes extends ActiveRecord {
 
   protected function initialize{
    $this->validates_uniqueness_of("cedula");
   }
 
 }
```

#### validates\_date\_in

Valida que ciertos atributos tengan un formato de fecha acorde al indicado en config/config.ini antes de insertar o actualizar.

```php
<?php
 class Registro extends ActiveRecord {
 
   protected function initialize(){
         $this->validates_date_in("fecha_registro");
   }
 }
```

#### validates\_format\_of

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

Ejemplo

```php
$Usuarios = new Usuarios();
$Usuarios->commit();
```

#### begin()

Este método nos permite crear una transacción en el motor de base de datos, si este lo permite. Devuelve true en caso de éxito y false en caso contrario.

Ejemplo

```php
$Usuarios = new Usuarios();
$Usuarios->begin();
```

#### rollback()

Este método nos permite anular una transacción iniciada por el método begin en el motor de base de datos, sí este lo permite. Devuelve true en caso de éxito y false en caso contrario.

Ejemplo

```php
$Usuarios = new Usuarios();
$Usuarios->rollback();
```

**Nota:** Las tablas deben tener el motor de almacenamiento \[InnoDB\][1](http://es.wikipedia.org/wiki/InnoDB)

###Otros métodos

#### sql (string $sql)

Esta función nos permite ejecutar sentencias SQL directamente en el motor de base de datos. La idea es que el uso de este método no debería ser común en nuestras aplicaciones ya que ActiveRecord se encarga de eliminar el uso del SQL en gran porcentaje, pero hay momentos en que es necesario que seamos más específicos y tengamos que recurrir al uso de éste.

###Callbacks

#### Introducción

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

#### before\_validation

Es llamado justo antes de realizar el proceso de validación por parte de Kumbia. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### before\_validation\_on\_create

Es llamado justo antes de realizar el proceso de validación por parte de Kumbia, sólo cuando se realiza un proceso de inserción en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### before\_validation\_on\_update

Es llamado justo antes de realizar el proceso de validación por parte de Kumbia, sólo cuando se realiza un proceso de actualización en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after\_validation\_on\_create

Es llamado justo después de realizar el proceso de validación por parte de Kumbia, sólo cuando se realiza un proceso de inserción en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after\_validation\_on\_update

Es llamado justo después de realizar el proceso de validación por parte de Kumbia, sólo cuando se realiza un proceso de actualización en un modelo. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### after\_validation

Es llamado justo después de realizar el proceso de validación por parte de Kumbia. Se puede cancelar la acción que se esté realizando si este método devuelve la palabra 'cancel'.

#### before\_save

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
