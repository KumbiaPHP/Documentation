# Model, View, Controller (MVC)

## What is MVC?

In 1979, Trygve Reenskaug developed an architecture for creating interactive applications composed of three parts: models, views, and controllers. The MVC pattern separates the interface, data model, and control logic. Layered programming aims to isolate business logic from presentation; for example, it keeps the data layer separate from the presentation layer.

The main advantage of this architecture is that development can take place at different levels. When a change is required, only the corresponding layer needs to be modified, without having to examine mixed code. It also makes it possible to distribute application development by layer, so that each team can work independently of the others and only needs to know the API (Application Programming Interface) that connects the layers. This separation reduces complexity, promotes reuse, and speeds up the process of assembling, disassembling, or replacing a layer while it retains the same responsibility.

In a web application, a request, usually sent over HTTP, is sent to the controller. The controller interacts with the model as needed and then invokes the corresponding view. The view obtains the model's state through the controller and displays it to the user.

## How does KumbiaPHP apply MVC?

The KumbiaPHP Framework uses established object-oriented programming patterns, especially the web MVC (Model, View, Controller) pattern. The following sections describe how this paradigm works in KumbiaPHP.

The goal of this pattern is to keep application logic, data, and presentation separate. This separation has important advantages: it makes it easier to identify the layer where a problem originates, allows multiple presentations to be created without duplicating application logic, and keeps each component independent. Changes remain concentrated in their own component and do not affect unrelated parts of the application.

## Additional information

KumbiaPHP is based on MVC and OOP, a classic design pattern that works in three layers:

- **Models:** Represent the information and business logic of the application.
- **Views:** Present information to the user, usually through web pages, although they can also use formats such as XML, PDF, JSON, SVG, or PNG. A simple view for a controller action uses the `.phtml` extension.
- **Controllers:** Respond to user actions and invoke the changes required in the models or views.

In KumbiaPHP, controllers are divided into a front controller and specific actions. Each action knows how to respond to a particular type of request. Views are managed through templates, views, and partials. The model provides an abstraction layer over the database, as well as session-data management and relational-integrity validation, helping to separate business logic from presentation.

For example, suppose that an application must present the same information in two different ways: an HTML view for a browser and a view that exports the same data as JSON for a web service or another application. Both views can reuse the same controller and model while changing only the presentation format. The controller isolates communication and the details of the protocol used by the request (HTTP, console mode, and so on), while the model abstracts the data logic and remains independent of the view. Through small conventions, KumbiaPHP provides considerable power and flexibility.

## Practical example

To better understand how MVC works in a concrete task, consider adding a product to a shopping cart:

1. The Front Controller receives the user's action, such as clicking **Add to cart**. After running tasks such as routing and security checks, it determines that it must call the `add` action on the controller.
2. The `add` action accesses the model and updates the cart object in the user's session.
3. If the update succeeds, the action prepares the data returned to the view: confirmation that the product was added and the complete list of products in the cart. The view assembles the response and generates the shopping-cart page.
4. Finally, the response is transferred to the web server, which sends it to the user so they can read it and continue interacting with the application.

The following implementation illustrates this process. A real project may organize its logic and directories differently, but the fundamental MVC idea remains the same.

### MVC implementation example in KumbiaPHP

#### Controller: `app/controllers/cart_controller.php`

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

        // If the product is found, add it to the cart
        if ($product) {
            // Cart could be a model or a service handling cart operations
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

#### Model: `app/models/cart.php`

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
     */
    public static function getItems(): array
    {
        // Get the cart items from the session
        return Session::get('cart', self::SESSION_NAMESPACE) ?? [];
    }
}
```

#### View: `app/views/cart/show.phtml`

```php
<!-- This view displays the items currently in the cart. -->
<h1>My Shopping Cart</h1>

<?php if (!$cartItems): ?>
  <p>Your cart is empty.</p>
  <?php return 1; ?>
<?php endif; ?>

<ul>
    <?php foreach ($cartItems as $item): ?>
        <li>
            <?= $item['name'] ?> - $<?= number_format($item['price'], 2) ?>
        </li>
    <?php endforeach; ?>
</ul>
```

In this example, each layer has a defined role:

- The **controller** receives the request and decides which action to take (`add` or `show`).
- The **model** (the `Cart` class in this case) encapsulates the business logic for managing products in the cart.
- The **view** (`app/views/cart/show.phtml`) presents the information to the user.

The result is code that is more organized, easier to maintain, and easier to scale.
