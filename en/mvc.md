# Model, View, Controller (MVC)

## What MVC is?

In 1979, Trygve Reenskaug developed an architecture for creating interactive applications. In his design there are three components: models, views and controllers. The MVC model allows the separation of the application layers in interface, model and logic control. Programming in layers, is a style of programming where the primary goal is the separation of presentation design from the business logic. A basic example of this is separation of the data layer from the presentation layer (user interfase).

The main advantage of this style is that development can be performed at various levels and in the event of any change only attacking the required level without having to review between mixed code. In addition, it allows to distribute the development of an application by levels so each work group is totally abstracted from the rest of levels. It is simply necessary to know the API (Application Interface) that exists between levels. La división en capas reduce la complejidad, facilita la reutilización y acelera el proceso de ensamblar o desensamblar alguna capa, o sustituirla por otra distinta (pero con la misma responsabilidad).

En una aplicación Web una petición se realiza usando HTTP y es enviado al controlador. El controlador puede interactuar de muchas formas con el modelo, luego el primero llama a la respectiva vista la cual obtiene el estado del modelo que es enviado desde el controlador y lo muestra al usuario.

## ¿Cómo KumbiaPHP aplica el MVC?

KumbiaPHP Framework aprovecha los mejores patrones de programación orientada a la Web en especial el patrón MVC (Modelos, Vistas, Controladores). A continuación se describe el funcionamiento general de este paradigma en KumbiaPHP.

El objetivo de este patrón es el realizar y mantener la separación entre la lógica de nuestra aplicación, los datos y la presentación. Esta separación tiene algunas ventajas importantes, como poder identificar mas fácilmente en que capa se esta produciendo un problema con solo conocer su naturaleza. Podemos crear varias presentaciones sin necesidad de escribir varias veces la misma lógica de aplicación. Cada parte funciona independiente y cualquier cambio centraliza el efecto sobre las demás, así que podemos estar seguros que una modificación en un componente no afecta las tareas en cualquier parte de la aplicación.

## Additional information

The basis of KumbiaPHP is the MVC and OOP, a traditional design pattern that works in three layers:

- **Models:** They represent the information on which the application operates, its business logic.
- **Views:** They displayed the model using Web pages and interacts with users (in principle). A view can be represented by any format output, we refer to xml, pdf, json, svg, png, etc. A simple view of a controller action has a phtml extension. todo esto son vistas.
- **Controllers:** Respond to user actions (that is triggered in the views) and invoke changes in the views or models as needed.

En KumbiaPHP los controladores están separados en partes, llamadas front controller y en un conjunto de acciones. Cada acción sabe como reaccionar ante un determinado tipo de petición.

Las vistas están separadas en templates, views y partials.

El modelo ofrece una capa de abstracción de la base de datos, además da funcionalidad agregada a datos de sesión y validación de integridad relacional. Este modelo ayuda a separar el trabajo en lógica de negocios (Modelos) y la presentación (Vistas).

Por ejemplo, si usted tiene una aplicación que corra tanto en equipos de escritorio y en dispositivos móviles entonces podría crear dos vistas diferentes compartiendo las mismas acciones en el controlador y la lógica del modelo. El controlador ayuda a ocultar los detalles de protocolo utilizados en la petición (HTTP, modo consola, etc.) para el modelo y la vista.

Finalmente, el modelo abstrae la lógica de datos, que hace a los modelos independientes de las vistas. La implementación de este modelo es muy liviana mediante pequeñas convenciones se puede lograr mucho poder y funcionalidad.

## Caso práctico (CAMBIAR EJEMPLO)

Para entender mejor, veamos un ejemplo de como una arquitectura MVC trabaja para añadir al carrito. Primero, el usuario interactúa con la interfaz seleccionando un producto y presionando un botón, esto probablemente valida un formulario y envía una petición al servidor.

  1. El Front Controller recibe la notificación de una acción de usuario, y luego de ejecutar algunas tareas (enrutamiento, seguridad, etc.), entiende que debe ejecutar la acción de agregar en el controlador.
  2. La acción de agregar accede al modelo y actualiza el objeto del carrito en la sesión de usuario.
  3. Si la modificación es almacenada correctamente, la acción prepara el contenido que sera devuelto en la respuesta - confirmación de la adición y una lista completa de los productos que están actualmente en el carrito. La vista ensambla la respuesta de la acción en el cuerpo de la aplicación para producir la pagina del carrito de compras.
  4. Finalmente es transferida al servidor Web que la envía al usuario, quien puede leerla e interactuara con ella de nuevo.