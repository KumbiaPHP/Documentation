# Model, view, controller (MVC)

## What is MVC?

En 1979, Trygve Reenskaug desarrollo una arquitectura para desarrollar aplicaciones interactivas. En este diseño existen tres partes: modelos, vistas y controladores. El modelo MVC permite hacer la separación de las capas de interfaz, modelo y lógica de control de esta. La programación por capas, es un estilo de programación en la que el objetivo primordial es la separación de la lógica de negocios del diseño de presentación, un ejemplo básico de esto es separar la capa de datos de la capa de presentación al usuario.

La ventaja principal de este estilo, es que el desarrollo se puede llevar a cabo en varios niveles y en caso de algún cambio solo se ataca al nivel requerido sin tener que revisar entre código mezclado. Además permite distribuir el trabajo de creación de una aplicación por niveles, de este modo, cada grupo de trabajo esta totalmente abstraído del resto de niveles, simplemente es necesario conocer la API (Interfaz de Aplicación) que existe entre niveles. La división en capas reduce la complejidad, facilita la reutilización y acelera el proceso de ensamblar o desensamblar alguna capa, o sustituirla por otra distinta (pero con la misma responsabilidad).

En una aplicación Web una petición se realiza usando HTTP y es enviado al controlador. El controlador puede interactuar de muchas formas con el modelo, luego el primero llama a la respectiva vista la cual obtiene el estado del modelo que es enviado desde el controlador y lo muestra al usuario.

## How KumbiaPHP apply the MVC?

KumbiaPHP Framework aprovecha los mejores patrones de programación orientada a la Web en especial el patrón MVC (Modelos, Vistas, Controladores). A continuación se describe el funcionamiento general de este paradigma en KumbiaPHP.

El objetivo de este patrón es el realizar y mantener la separación entre la lógica de nuestra aplicación, los datos y la presentación. Esta separación tiene algunas ventajas importantes, como poder identificar mas fácilmente en que capa se esta produciendo un problema con solo conocer su naturaleza. Podemos crear varias presentaciones sin necesidad de escribir varias veces la misma lógica de aplicación. Cada parte funciona independiente y cualquier cambio centraliza el efecto sobre las demás, así que podemos estar seguros que una modificación en un componente no afecta las tareas en cualquier parte de la aplicación.

## Additional information

The basis of KumbiaPHP is the MVC and OOP, a traditional design pattern that works in three layers:

- **Modelos:** Representan la información sobre la cual la aplicación opera, su lógica de negocio.
- **Vistas:** Visualizan el modelo usando paginas Web e interactuando con los usuarios (en principio) de estas, una vista puede estar representada por cualquier formato salida, nos referimos a un xml, pdf, json, svg, png, etc. todo esto son vistas.
- **Controladores:** Responden a acciones de usuario e invocan cambios en las vistas o en los modelos según sea necesario.

En KumbiaPHP los controladores están separados en partes, llamadas front controller y en un conjunto de acciones. Cada acción sabe como reaccionar ante un determinado tipo de petición.

Las vistas están separadas en templates, views y partials.

El modelo ofrece una capa de abstracción de la base de datos, además da funcionalidad agregada a datos de sesión y validación de integridad relacional. Este modelo ayuda a separar el trabajo en lógica de negocios (Modelos) y la presentación (Vistas).

Por ejemplo, si usted tiene una aplicación que corra tanto en equipos de escritorio y en dispositivos móviles entonces podría crear dos vistas diferentes compartiendo las mismas acciones en el controlador y la lógica del modelo. El controlador ayuda a ocultar los detalles de protocolo utilizados en la petición (HTTP, modo consola, etc.) para el modelo y la vista.

Finalmente, el modelo abstrae la lógica de datos, que hace a los modelos independientes de las vistas. La implementación de este modelo es muy liviana mediante pequeñas convenciones se puede lograr mucho poder y funcionalidad.

## Caso practico (CAMBIAR EJEMPLO)

Para entender mejor, veamos un ejemplo de como una arquitectura MVC trabaja para añadir al carrito. Primero, el usuario interactúa con la interfaz seleccionando un producto y presionando un botón, esto probablemente valida un formulario y envía una petición al servidor.

  1. El Front Controller recibe la notificación de una acción de usuario, y luego de ejecutar algunas tareas (enrutamiento, seguridad, etc.), entiende que debe ejecutar la acción de agregar en el controlador.
  2. La acción de agregar accede al modelo y actualiza el objeto del carrito en la sesión de usuario.
  3. Si la modificación es almacenada correctamente, la acción prepara el contenido que sera devuelto en la respuesta - confirmación de la adición y una lista completa de los productos que están actualmente en el carrito. La vista ensambla la respuesta de la acción en el cuerpo de la aplicación para producir la pagina del carrito de compras.
  4. Finalmente es transferida al servidor Web que la envía al usuario, quien puede leerla e interactuara con ella de nuevo.