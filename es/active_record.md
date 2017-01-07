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

```
<?php
//KumbiaPHP 0.9
$cliente = Load::model('cliente'); 
$cliente->nit = "808111827-2" ; 
$cliente->razon_social = "EMPRESA DE TELECOMUNICACIONES XYZ";
$cliente->save(); 
```

Ejemplo con KumbiaPHP 1.0
```
<?php
//KumbiaPHP 1.0
$cliente = new Cliente(); 
$cliente->nit = "808111827-2" ; 
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

####  find_all_by_sql (string $sql)

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

####  find_by_sql (string $sql)

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

####  find_first (string $sql)

Sintaxis
```php
find_first([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ],[ "columns: …" ])  
```  

El método "find_first" devuelve el primer registro de una entidad o la primera
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
una advertencia cuando los criterios de búsqueda para find_first devuelven más
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

####  find ()

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

#### select_one (string $select_query)

Este método nos permite hacer ciertas consultas como ejecutar funciones en el
motor de base de datos sabiendo que éstas devuelven un único registro.

```php
$current_time = (new Usuario)->select_one( "current_time");
```  

En el ejemplo, queremos saber la hora actual del servidor devuelta desde MySQL,
podemos usar este método para esto.

####  select_one(string $select_query) (static)

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

####  find_all_by()

Este método nos permite realizar una búsqueda por algún campo

```php
$resultado = (new Producto)->find_all_by( 'categoria', 'Insumos');
``` 

####  find_by_*campo*()

Este método nos permite realizar una búsqueda usando el nombre del atributo
como nombre de método. Devuelve un único registro.

```php
$resultado = (new Producto)->find_by_categoria('Insumos');
``` 

####  find_all_by_*campo*()

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

####  count_by_sql()

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

#### update_all()
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

#### delete_all()
Elimina uno o más registros a partir de los atributos y condiciones indicadas.
Retorna boolean.

```php
(new Producto)->delete_all( " precio >= 99.99 " );

(new Producto)->delete_all( " estado = 'C' " );
```

### Validaciones

### Transacciones

### Otros métodos

### Callbacks ActiveRecord

### Asociaciones

### Paginadores