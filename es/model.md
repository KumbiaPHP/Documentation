#  Modelos

En los Modelos reside la lógica de negocio (o de la aplicación).
Equivocadamente, mucha gente cree que los modelos son solo para trabajar con
las bases de datos.

Los modelos puedes ser de muchos tipos:

  * Crear miniaturas de imágenes
  * Consumir y usar webservices
  * Crear pasarelas Scaffold de pago
  * Usar LDAP
  * Enviar mails o consultar servidores de correo
  * Interactuar con el sistema de ficheros local o vía FTP, o cualquier otro protocolo
  * etc etc

##  ActiveRecord

##  Ejemplo sin ActiveRecord

##  Como usar los modelos

Los Modelos representan la lógica de la aplicación, y son parte fundamental
para el momento que se desarrolla una aplicación, un buen uso de estos nos
proporciona un gran poder al momento que se necesita escalar, mantener y
reusar código en una aplicación.

Por lo general un mal uso de los modelos es sólo dejar el archivo con la
declaración de la clase y generar toda la lógica en el controlador. Esta
práctica trae como consecuencia que en primer lugar el controlador sea
difícilmente entendible por alguien que intente agregar y/o modificar algo en
esa funcionalidad, en segundo lugar lo poco que puedes rehusar el código en
otros controladores. Eso conlleva a repetir código que hace lo mismo en
otro controlador.

Partiendo de este principio, los controladores NO  deberían contener ningún
tipo de lógica, sólo se encargan de atender las peticiones del usuarios y
solicitar dicha información a los modelos. Con esto garantizamos un buen uso
del [MVC](http://www.google.com/url?q=http%3A%2F%2Fes.wikipedia.org%2Fwiki%2FM
odelo_Vista_Controlador&sa=D&sntz=1&usg=AFQjCNFo6Rn8nbUjHG5f8Qqa__2nYwMDjg) .

###  El Modelo extiende el ActiveRecord

KumbiaPHP usa POO (Programación orientada a objetos), así que ActiveRecord es
una clase que ya lleva métodos listos para usar. Estos métodos facilitan al
usuario el manejo de las tablas de las bases de datos; entre ellos están los
siguientes: find, find_first, save, update, etc.

El Modelo extiende la clase ActiveRecord para que el usuario pueda añadir sus
propios métodos, y así encapsular la lógica.

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

distinct([string $atributo_entidad], [ "conditions: …" ], [ "order: …" ], [
"limit: …" ], [ "column: …" ])

---  

Ejemplo

$unicos = (new Usuario)-> distinct ( "estado" )
# array('A', 'I', 'N')  

---  

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

$usuarios = (new Usuario)->find_all_by_sql( "select * from
usuarios where codigo not in (select codigo from ingreso)" )

---  

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

$usuario = (new Usuario)->find_by_sql( "select * from usuarios
where codigo not in (select codigo from ingreso) limit 1" );  

---  

Este ejemplo consulta el primer usuario con una sentencia where especial.
La idea es que el usuario consultado no se encuentre en la entidad ingreso.

####  find_first (string $sql)

Sintaxis

find_first([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …" ],
[ "columns: …" ])  

---  

El método "find_first" devuelve el primer registro de una entidad o la primera
ocurrencia de acuerdo a unos criterios de búsqueda u ordenamiento. Los
parámetros son todos opcionales y su orden no es relevante, cuando se invoca
sin parámetros devuelve el primer registro insertado en la entidad. Este
método es muy flexible y puede ser usado de muchas formas:

Ejemplo

$usuario = (new Usuario)->find_first( "conditions: estado='A' "
, "order: fecha desc" );

---  

En este ejemplo buscamos el primer registro cuyo estado sea igual a "A" y
ordenado descendentemente, el resultado de este, se carga a la variable
$usuarios. Devuelve una instancia del mismo objeto ActiveRecord en
caso de éxito o false en caso contrario.

Con el método find_first podemos buscar un registro en particular a partir de
su id de esta forma:

$usuario = (new Usuario)->find_first(123);

---  

Obtenemos el registro 123 e igualmente devuelve una instancia del mismo
objeto ActiveRecord en caso de éxito, o false en caso contrario. Kumbia genera
una advertencia cuando los criterios de búsqueda para find_first devuelven más
de un registro, para esto podemos forzar que se devuelva solamente uno,
mediante el parámetro limit, de esta forma:

$usuario = (new Usuario)->find_first( "conditions: estado='A' "
, "limit: 1" );

---  

Cuando queremos consultar, sólo algunos de los atributos de la entidad, podemos
utilizar el parámetro columns:

$usuario = (new Usuario)->find_first( "columns: nombre, estado");

---  

Cuando especificamos el primer parámetro de tipo string, ActiveRecord asumirá
que son las condiciones de búsqueda para find_first:

$usuario = (new Usuario)->find_first( "estado='A'" );

---  

De esta forma podemos también deducir que estas 2 sentencias arrojarían el
mismo resultado:

$usuario = (new Usuario)->find_first( "id='123'" );

---  

$usuario = (new Usuario)->find_first(123);

---  

####  find ()

Sintaxis

find([integer $id], [ "conditions: …" ], [ "order: …" ], [ "limit: …], ["
columns: … "])

---  

El método "find" es el principal método de búsqueda de ActiveRecord, devuelve
todas los registros de una entidad o el conjunto de ocurrencias de acuerdo a
unos criterios de búsqueda. Los parámetros son todos opcionales y su orden no
es relevante, incluso pueden ser combinados u omitidos si es necesario. Cuando
se invoca sin parámetros devuelve todos los registros en la entidad.

No hay que olvidarse de incluir un espacio después de los dos puntos (:) en
cada parámetro.

Ejemplo

$usuarios = (new Usuario)->find( "conditions: estado='A'" ,
"order: fecha desc" );

---  

En este ejemplo buscamos todos los registros cuyo estado sea igual a "A" y
devuelva estos ordenados descendentemente, el resultado de este es un array de
objetos de la misma clase con los valores de los registros cargados en ellos.
En caso de no hayan registros devuelve un array vacío.

Con el método find podemos buscar un registro en particular a partir de su id
de esta forma:

$usuario = (new Usuario)->find(123);

---  

Obtenemos el registro 123 e igualmente devuelve una instancia del mismo
objeto ActiveRecord en caso de éxito, o false en caso contrario. Como es un
solo registro no devuelve un array, sino que los valores de este se cargan en
la misma variable si existe el registro.

Para limitar el número de registros devueltos, podemos usar el parámetro limit:

$usuarios = (new Usuario)->find( "conditions: estado='A'" ,
'limit: 5', 'offset: 1' );

---  

Cuando queremos consultar sólo algunos de los atributos de la entidad podemos
utilizar el parámetro columns :

$usuarios = (new Usuario)->find("columns: nombre, estado" );

---  

Cuando especificamos el primer parámetro de tipo string, ActiveRecord asume
que son las condiciones de búsqueda para find:

$usuarios = (new Usuario)->find( "estado='A'" );

---  

Se puede utilizar la propiedad count para saber cuántos registros fueron
devueltos en la búsqueda.

Nota: No es necesario usar find('id: $id'), se puede usar directamente
find($id)

#### select_one (string $select_query)

Este método nos permite hacer ciertas consultas como ejecutar funciones en el
motor de base de datos sabiendo que éstas devuelven un único registro.

$current_time = (new Usuario)->select_one( "current_time" );

---  

En el ejemplo, queremos saber la hora actual del servidor devuelta desde MySQL,
podemos usar este método para esto.

####  select_one(string $select_query) (static)

Este método nos permite hacer ciertas consultas como ejecutar funciones en el
motor de base de datos, sabiendo que estas devuelven un solo registro. Este
método se puede llamar de forma estática, esto significa que no es necesario
que haya una instancia de ActiveRecord para hacer el llamado.

$current_time = ActiveRecord::select_one( "current_time" )

---  

En el ejemplo, queremos saber la hora actual del servidor devuelta desde MySQL,
podemos usar este método para esto.

####  exists()

Este método nos permite verificar si el registro existe o no en la base de
datos mediante su id o una condición.

$usuario = new Usuario();

$usuario->id  = 3;

if ($usuario->exists()){
  //El usuario con id igual a 3 si existe
}

(new Usuario)->exists( "nombre='Juan Perez'" )
(new Usuario)->exists(2); // Un Usuario con id->2?

---  

####  find_all_by()

Este método nos permite realizar una búsqueda por algún campo

$resultado = (new Producto)->find_all_by( 'categoria' ,
'Insumos' );

---  

####  find_by_*campo*()

Este método nos permite realizar una búsqueda usando el nombre del atributo
como nombre de método. Devuelve un único registro.

$resultado = (new Producto)->find_by_categoria ( 'Insumos' );

---  

####  find_all_by_*campo*()

Este método nos permite realizar una búsqueda el nombre del atributo como
nombre de método. Devuelve todos los registros que coincidan con
la búsqueda.

$resultado = (new Producto)->find_all_by_categoria ( "Insumos"
);

---  

###  Conteos y sumatorias

####  count()

Realiza un conteo sobre los registros de la entidad con o sin alguna condición
adicional. Emula la función de agrupamiento count.

$numero_registros = (new Cliente)->count();
$numero_registros = (new Cliente)->count( "ciudad = 'BOGOTA'");

---  

#### sum()

Realiza una sumatoria sobre los valores numéricos del atributo de alguna
entidad, emula la función de agrupamiento sum en el lenguaje SQL.

$suma = (new Producto)->sum( "precio" );
$suma = (new Producto)->sum( "precio" , "conditions: estado = 'A'" );

---  

####  count_by_sql()

Realiza una sumatoria utilizando lenguaje SQL.

$numero = (new Producto)->count_by_sql( "select count(precio)
from producto, factura  where factura.codigo = 1124 \
 and factura.codigo_producto = producto.codigo_producto" );

---  

### Promedios, máximo y mínimo

#### average()

Realiza el cálculo del promedio sobre los valores numéricos del atributo de
alguna entidad, emula la función de agrupamiento avg en el lenguaje SQL.

$promedio = (new Producto)->average( "precio" );
$promedio = (new Producto)->average( "precio" , "conditions: estado = 'A'" );

#### maximum()

Realiza el cálculo del valor máximo sobre los valores del atributo de alguna
entidad, emula la función de agrupamiento max en el lenguaje SQL.

$max = (new Producto)->maximum( "precio" );
$max = (new Producto)->maximum( "fecha_compra" , "conditions: estado = 'A'" );


### Creación, actualización y borrado de registros

#### create()
Crea un registro a partir de los datos indicados en el modelo. Retorna boolean.

$data = array ( "nombre" => "Cereal", "precio" => 9.99, "estado" => "A" );
$exito = (new Producto)->create( $data );

$producto = new Producto();
$producto->nombre = "Cereal";
$producto->precio = 9.99;
$producto->estado = "A";
$exito = $producto->create();


#### save()
Actualiza o crea un registro a partir de los datos indicados en el modelo.
Crea el registro cuando el elemento a guardar no existe (o cuando no se indica
el atributo de clave primaria. Actualiza cuando el registro existe).
Retorna boolean.

$data = array ( "nombre" => "Cereal", "precio" => 9.99, "estado" => "A" );
$exito = (new Producto)->save( $data );

$producto = (new Producto)->find(123);
$producto->precio = 4.99;
$producto->estado = "A";
$exito = $producto->save();

#### update()
Actualiza un registro a partir de los datos indicados en el modelo. Retorna
boolean.

$data = array ( "nombre" => "Cereal Integral", "precio" => 8.99, "estado" => "A",
                "id" => 123 );
$exito = (new Producto)->update( $data );

$producto = (new Producto)->find( 123 );
$producto->estado = "C";
$producto->update();

#### update_all()
Actualiza uno o más valores dentro de uno o más registros a partir de los
atributos y condiciones indicadas.

(new Producto)->update_all( "precio = precio * 1.2" );
Actualiza el atributo precio aumentándolo en un 20% para todos los registros
de la entidad producto.


(new Producto)->update_all( "precio = precio * 1.2",
"estado = 'A'", "limit: 100" );
Actualiza el atributo precio aumentándolo en un 20% para 100 registros
de la entidad producto donde el atributo estado es 'A'.

(new Producto)->update_all( "precio = 0, estado='C'",
"estado = 'B'");
Actualiza el atributo precio aumentándolo en un 20% y estado todos registros
de la entidad producto donde el atributo estado es 'B'.

#### delete()
Elimina uno o más registros a partir de los atributos y condiciones indicadas.
Retorna boolean.

$producto = (new Producto)->find(123);
$exito = $producto->delete();

(new Producto)->delete(123); //elimina el registro por su ID

$exito = (new Producto)->delete("estado='A'");


#### delete_all()
Elimina uno o más registros a partir de los atributos y condiciones indicadas.
Retorna boolean.

(new Producto)->delete_all( " precio >= 99.99 " );

(new Producto)->delete_all( " estado = 'C' " );

### Validaciones

### Transacciones

### Otros métodos

### Callbacks ActiveRecord

### Asociaciones

### Paginadores

* * *
