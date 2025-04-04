# Modelo, Vista, Controlador (MVC)

## ¿Qué es MVC?

En 1979, Trygve Reenskaug desarrolló una arquitectura para la creación de aplicaciones interactivas, compuesta por tres
partes: modelos, vistas y controladores. El modelo MVC permite separar la capa de interfaz, el modelo de datos y la
lógica de control. Este estilo de programación por capas ayuda a aislar la lógica de negocio de la presentación, lo
cual, por ejemplo, evita mezclar la capa de datos con la capa de presentación.

La principal ventaja de esta arquitectura es que el desarrollo se puede realizar en diferentes niveles, de manera que,
si se requiere un cambio, solo se modifica la capa correspondiente, sin necesidad de examinar código mezclado. Además,
facilita la distribución de tareas por niveles, de modo que cada equipo de trabajo se abstrae de los demás y solo
necesita conocer la interfaz (API) que conecta las capas. Esta separación reduce la complejidad, promueve la
reutilización y acelera el proceso de ensamblar, desensamblar o sustituir cualquier capa mientras mantenga la misma
responsabilidad.

En una aplicación web, la petición (generalmente vía HTTP) se envía al controlador. El controlador interactúa con el
modelo según sea necesario y luego invoca la vista correspondiente. Esta vista obtiene el estado del modelo a través del
controlador y lo muestra al usuario.

## ¿Cómo KumbiaPHP aplica el MVC?

KumbiaPHP Framework aprovecha los mejores patrones de programación orientada a la Web, en especial el patrón MVC
(Modelos, Vistas, Controladores). El objetivo es mantener separadas la lógica de la aplicación, los datos y la
presentación. Esta separación ofrece ventajas muy importantes, como aislar rápidamente un problema según la capa donde
se origine. Además, permite desarrollar múltiples formas de presentación sin duplicar la lógica de la aplicación. Cada
parte funciona de manera independiente, y cualquier modificación se concentra en su propio componente sin afectar a
otras partes de la aplicación.

## Más información

KumbiaPHP se basa en MVC y POO, un patrón de diseño clásico que funciona en tres capas:

- **Modelos:** Representan la información y la lógica de negocio de la aplicación.  
- **Vistas:** Se encargan de presentar la información al usuario (generalmente a través de páginas web), aunque pueden
  adoptar otros formatos como XML, PDF, JSON, etc.  
- **Controladores:** Responden a las acciones del usuario e invocan los cambios necesarios en los modelos o las vistas.

En KumbiaPHP, los controladores se dividen en un front controller y en acciones específicas que saben cómo responder
ante distintos tipos de peticiones. Las vistas se gestionan mediante templates, views y partials. El modelo proporciona
una capa de abstracción de la base de datos, además de gestionar datos de sesión y validaciones de integridad
relacional, separando la lógica de negocio (modelos) de la presentación (vistas).

Por ejemplo, supongamos que deseas presentar la misma información de dos formas distintas: una vista HTML para uso en
navegador y una vista que exporte los mismos datos en JSON (pensando en un servicio web o consumo por parte de otra
aplicación). Ambas vistas pueden reutilizar el mismo controlador y modelo, variando únicamente la forma en que presentan
la información. El controlador aísla la comunicación y los detalles del protocolo (HTTP, consola, etc.), mientras que el
modelo abstrae la lógica de datos, haciéndolo independiente de la vista. Gracias a pequeñas convenciones, se puede
obtener una gran potencia y flexibilidad.

## Caso práctico

Para comprender mejor cómo funciona la arquitectura MVC en una tarea concreta, veremos un ejemplo para añadir un
producto a un carrito de compras:

1. El Front Controller recibe la acción del usuario (por ejemplo, hacer clic en el botón “Agregar al carrito”) y, tras
  ejecutar algunas tareas (enrutamiento, seguridad, etc.), identifica que debe llamar a la acción `add` en el
  controlador.
2. La acción `add` accede al modelo y actualiza el objeto del carrito en la sesión del usuario.
3. Si se completa la modificación correctamente, la acción prepara los datos que se enviarán a la vista (confirmación de
  la adición y la lista completa de productos del carrito). La vista luego ensambla la respuesta, generando la página
  que muestra el carrito de compras.
4. Finalmente, la respuesta es transferida al servidor web, que la envía al usuario para que la lea y siga
  interactuando.

A continuación, se presenta un ejemplo de implementación que ilustra este proceso. Ten en cuenta que, en un caso real,
cada proyecto puede tener sus propias particularidades de lógica y organización de carpetas, pero la idea fundamental de
MVC se mantiene.

### Ejemplo de código con MVC en KumbiaPHP

#### Controlador: `controllers/cart_controller.php`
```php
<?php

/**
 * CartController
 *
 * This controller manages operations related to the shopping cart.
 */
class CartController extends AppController
{
    /**
     * Adds a product to the user's cart.
     *
     * @param int $productId The ID of the product to add.
     * @return void
     */
    public function add($productId)
    {
        // Load the product using the Product model
        $product = (new Product)->find_first($productId);
        
        // If product is found, add it to the cart
        if ($product) {
            // 'Cart' could be a model or a service handling cart operations
            Cart::addProduct($product);
            Flash::valid('Product added to cart successfully!');
        } else {
            Flash::error('Product not found!');
        }
        
        // Redirect or render the cart view
        Redirect::toAction('show');
    }

    /**
     * Shows the current status of the cart.
     *
     * @return void
     */
    public function show()
    {
        // Retrieve the cart contents from the Cart model or session
        $this->cartItems = Cart::getItems();
    }
}

```

#### Modelo: `models/cart.php`
```php
<?php

/**
 * Cart
 *
 * Manages product items within a user's cart, using the KumbiaPHP Session class.
 */
class Cart
{
    /**
     * Session namespace for storing cart data.
     */
    private const SESSION_NAMESPACE = 'cart';

    /**
     * Adds a product to the cart items array in the session.
     *
     * @param object $product Product object to be added.
     */
    public static function addProduct(Product $product): void
    {
        // Retrieve the existing cart array from the session
        $cart = Session::get('cart', self::SESSION_NAMESPACE) ?? [];

        // Append the new product data
        $cart[] = [
            'id'    => $product->id,
            'name'  => $product->name,
            'price' => $product->price
        ];

        // Store the updated cart back into the session
        Session::set('cart', $cart, self::SESSION_NAMESPACE);
    }

    /**
     * Retrieves all items from the cart stored in the session.
     *
     */
    public static function getItems(): array
    {

        // Get the cart items from the session
        return Session::get('cart', self::SESSION_NAMESPACE) ?? [];
    }
}

```

#### Vista: `views/cart/show.phtml`
```html
<!-- This view displays the items currently in the cart. -->
<h1>My Shopping Cart</h1>

<?php if (empty($cartItems)): ?>
  <p>Your cart is empty.</p>
  <?php return 1 ?>
<?php endif ?>

<ul>
    <?php foreach ($cartItems as $item): ?>
        <li>
            <?= $item['name'] ?> - $<?= number_format($item['price'], 2) ?>
        </li>
    <?php endforeach ?>
</ul>

```

En este ejemplo, cada capa (controlador, modelo y vista) cumple un rol definido:
- El **controlador** recibe la petición y decide qué acciones tomar (`add` o `show`).
- El **modelo** (en este caso, la clase `Cart`) encapsula la lógica de negocio para administrar los productos en el
  carrito.
- La **vista** (`views/cart/show.phtml`) se encarga de presentar la información de manera adecuada al usuario.

Así, se logra un código más ordenado, fácil de mantener y escalable.
