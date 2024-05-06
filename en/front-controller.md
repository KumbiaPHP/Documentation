# Front Controller

All web requests are handled by a single Front Controller, which is the unique entry point for the entire application.

When the front controller receives a request, it uses KumbiaPHP's routing system to associate the name of a controller
and action with the URL written by the client (user or another application).

Consider the following URL, which calls the `index.php` script (the front controller) and will be understood as a call
to an action.

http://localhost/kumbiaphp/mycontroller/myaction/

Because of URL rewriting, the `index.php` file is never explicitly called. Instead, only the controller, action, and
parameters are provided. Internally, the front controller is called according to the URL rewriting rules. See
[Why is important Mod-Rewrite?](to-install.md#why-is-important-mod-rewrite).

## Dissecting the Front Controller

The KumbiaPHP front controller is responsible for dispatching requests, which involves more than just identifying which
action to execute. In fact, it runs the common code for all actions, including:

1. Defines core application constants (`APP_PATH`, `CORE_PATH`, and `PUBLIC_PATH`).
2. Loads and initializes the core framework classes (bootstrap).
3. Loads configuration (Config).
4. Decodes the request URL to determine which action to execute and request parameters (Router).
5. If the action doesn't exist, it redirects to the 404 error action (Router).
6. Activates filters (e.g., if the request requires authentication) (Router).
7. Executes the filters, first pass (before) (Router).
8. Executes the action (Router).
9. Executes the filters, second pass (after) (Router).
10. Executes the view and displays the response (View).

In broad strokes, this is the front controller process. This is all you need to know about this indispensable component
in the MVC architecture within KumbiaPHP.

## Default Front Controller

The default front controller, called `index.php` and located in the project's `public/` directory, is a simple PHP
script.

The definition of constants corresponds to the first step described above. The front controller then includes the
application's `bootstrap.php`, which handles steps 2 to 5. Internally, KumbiaPHP's core, with its Router and View
components, handles all the subsequent steps.

All constants represent default values for the KumbiaPHP installation in a local environment.

## KumbiaPHP Constants

Each constant serves a specific purpose to provide greater flexibility when creating paths in the framework.

### APP_PATH

A constant that contains the absolute path to the application's `app` directory. For instance:

```php
echo APP_PATH;
// Output: /var/www/kumbiaphp/default/app/
``` 

This constant allows you to include files within the application's directory tree. For example, if you want to include a
file located in the `app/libs/test.php` directory, the way to do so would be:

```php
include_once APP_PATH . 'libs/test.php';
```

### CORE_PATH

A constant that contains the absolute path to the KumbiaPHP core directory. For instance:

```php
echo CORE_PATH;
// Output: /var/www/kumbiaphp/core/
```

To include files from this directory tree, follow the same procedure explained for the `APP_PATH` constant.

### PUBLIC_PATH

A constant that contains the URL path for the browser and points to the `public/` directory to link images, CSS,
JavaScript, and any other path required by the browser.

```php
// Generates a link to the 
// controller: controller and action: action
<a href="<?php echo PUBLIC_PATH ?>controller/action/" title="My Link">My Link</a>
  
// Links an image located in public/img/image.jpg
<img src="<?php echo PUBLIC_PATH ?>img/image.jpg" alt="An Image" />
  
// Links the CSS file in public/css/style.css
<link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_PATH ?>css/style.css"/>
```