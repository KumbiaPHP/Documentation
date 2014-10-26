#Modelo, Vista, Controlador (MVC)

## ¿Que es MVC?

En 1979, Trygve Reenskaug desarrollo una arquitectura para desarrollar
aplicaciones interactivas. En este diseño existian tres partes: modelos,
vistas y controladores. El modelo MVC permite hacer la separacion de las capas
de interfaz, modelo y logica de control de esta. La programacion por capas, es
un estilo de programacion en la que el objetivo primordial es la separacion de
la logica de negocios de la logica de diseño, un ejemplo basico de esto es
separar la capa de datos de la capa de presentacion al usuario.

La ventaja principal de este estilo, es que el desarrollo se puede llevar a
cabo en varios niveles y en caso de algun cambio solo se ataca al nivel
requerido sin tener que revisar entre codigo mezclado. Ademas permite
distribuir el trabajo de creacion de una aplicacion por niveles, de este modo,
cada grupo de trabajo esta totalmente abstraido del resto de niveles,
simplemente es necesario conocer la API (Interfaz de Aplicacion) que existe
entre niveles. La division en capas reduce la complejidad, facilita la
reutilizacion y acelera el proceso de ensamblar o desensamblar alguna capa, o
sustituirla por otra distinta (pero con la misma responsabilidad).

En una aplicacion Web una peticion se realiza usando HTTP y es enviado al
controlador. El controlador puede interactuar de muchas formas con el modelo,
luego el primero llama a la respectiva vista la cual obtiene el estado del
modelo que es enviado desde el controlador y lo muestra al usuario.

## ¿Como KumbiaPHP aplica el MVC?

KumbiaPHP Framework aprovecha los mejores patrones de programacion orientada a
la Web en especial el patron MVC (Modelos, Vistas, Controladores). A
continuacion se describe el funcionamiento general de este paradigma en
KumbiaPHP.

El objetivo de este patron es el realizar y mantener la separacion entre la
logica de nuestra aplicacion, los datos y la presentacion. Esta separacion
tiene algunas ventajas importantes, como poder identificar mas facilmente en
que capa se esta produciendo un problema con solo conocer su naturaleza.
Podemos crear varias presentaciones sin necesidad de escribir varias veces la
misma logica de aplicacion. Cada parte funciona independiente y cualquier
cambio centraliza el efecto sobre las demas, asi que podemos estar seguros que
una modificacion en un componente realizara bien las tareas en cualquier parte
de la aplicacion.

##Más información

La base de KumbiaPHP es el MVC y POO, un tradicional patron de diseño que
funciona en tres capas:

- **Modelos:**  Representan la informacion sobre la cual la aplicacion opera, su logica de negocio.
- **Vistas:**  Visualizan el modelo usando paginas Web e interactuando con los usuarios (en principio) de estas, una vista puede estar representada por cualquier formato salida, nos referimos a un xml, pdf, json, svg, png, etc. todo esto son vistas.
- **Controladores:**  Responden a acciones de usuario e invocan cambios en las vistas o en los modelos segun sea necesario.

En KumbiaPHP los controladores estan separados en partes, llamadas front
controller y en un conjunto de acciones. Cada accion sabe como reaccionar ante
un determinado tipo de peticion.

Las vistas estan separadas en templates, views y partials.

El modelo ofrece una capa de abstraccion de la base de datos, ademas da
funcionalidad agregada a datos de sesion y validacion de integridad
relacional. Este modelo ayuda a separar el trabajo en logica de negocios
(Modelos) y la presentacion (Vistas).

Por ejemplo, si usted tiene una aplicacion que corra tanto en equipos de
escritorio y en dispositivos moviles entonces podria crear dos vistas
diferentes compartiendo las mismas acciones en el controlador y la logica del
modelo. El controlador ayuda a ocultar los detalles de protocolo utilizados en
la peticion (HTTP, modo consola, etc.) para el modelo y la vista.

Finalmente, el modelo abstrae la logica de datos, que hace a los modelos
independientes de las vistas. La implementacion de este modelo es muy liviana
mediante pequeñas convenciones se puede lograr mucho poder y funcionalidad.

## Caso practico (CAMBIAR EJEMPLO)

Para entender mejor, veamos un ejemplo de como una arquitectura MVC trabaja
para añadir al carrito. Primero, el usuario interactua con la interfaz
seleccionando un producto y presionando un boton, esto probablemente valida un
formulario y envia una peticion al servidor.

  1. El Front Controller recibe la notificacion de una accion de usuario, y luego de ejecutar algunas tareas (enrutamiento, seguridad, etc.), entiende que debe ejecutar la accion de agregar en el controlador.
  2. La accion de agregar accede al modelo y actualiza el objeto del carrito en la sesion de usuario.
  3. Si la modificacion es almacenada correctamente, la accion prepara el contenido que sera devuelto en la respuesta - confirmacion de la adicion y una lista completa de los productos que estan actualmente en el carrito. La vista ensambla la respuesta de la accion en el cuerpo de la aplicacion para producir la pagina del carrito de compras.
  4. Finalmente es transferida al servidor Web que la envia al usuario, quien puede leerla e interactuara con ella de nuevo.