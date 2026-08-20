# Parent classes

## AppController

## View

...

# KumbiaPHP Libraries

KumbiaPHP includes ready-to-use classes, but you can also create your own classes and reuse them in your projects. You can use external KumbiaPHP classes as explained in the next chapter.

## Cache

A cache is a set of duplicate data from another source. The original data is costly to access, usually in terms of time, compared with the copy stored in the cache.

KumbiaPHP implements its data cache using the factory and singleton design patterns. To use the cache, the application needs write permission for the `cache` directory (only when using the `sqlite` and `file` handlers).

Each cache is controlled by a cache handler. The KumbiaPHP cache system currently provides the following handlers:

* APC: uses Alternative PHP Cache.
* file: stores cache files in the `cache` directory and is compatible with all operating systems.
* nixfile: stores cache files in the `cache` directory and is compatible only with *nix operating systems (Linux, FreeBSD, and others). This cache is faster than `file`.
* sqlite: uses a SQLite database located in the `cache` directory.

To obtain a cache handler, use the `driver` method provided by the `Cache` class.

### driver($driver = null)

This method obtains a specific cache handler (`APC`, `file`, `nixfile`, `sqlite`, or `memsqlite`). If no handler is specified, it obtains the default handler configured in `config.ini`.

```php
<?php
// Default cache handler
$data = Cache::driver()->get('data');

// Memcache handler
$data_memcache = Cache::driver('memcache')->get('data');

// APC cache handler
$data_apc = Cache::driver('APC')->get('data');
```

### get($id, $group = 'default')

Retrieves a value stored in the cache. You must specify `$id`, the ID corresponding to the cached value. The `default` group is used when no group is specified.

### save($value, $lifetime = null, $id = false, $group = 'default')

Stores a value in the cache. The lifetime must use the format accepted by the PHP [`strtotime`](https://www.php.net/manual/en/function.strtotime.php) function.

When parameters are omitted, `save` behaves as follows:

* If `$lifetime` is not specified, the value is cached indefinitely.
* If `$id` and `$group` are not specified, the values used by the most recent `get` call are used.

```php
<?php

$data = Cache::driver()->get('saludo');
if (!$data) {
    Cache::driver()->save('Hello', '+1 day');
}
echo $data;
```

### start($lifetime, $id, $group = 'default')

Displays a cached output buffer or, if none exists, starts buffering output until `end` is called. It is frequently used to cache a view fragment.

```php
<?php if (Cache::driver()->start('+1 day', 'saludo')): ?>
    Hello <?php echo $usuario; ?>
    <?php Cache::driver()->end(); ?>
<?php endif; ?>
```

### end($save = true)

Ends output buffering and indicates whether the buffer should be kept in the cache.

* * *

## Logger

The `Logger` class for handling [logs](https://en.wikipedia.org/wiki/Log_%28computing%29) was rewritten as a static class, so it is no longer necessary to create a `Logger` instance. It provides several methods for handling different types of log messages.

```php
<?php
Logger::error('Error message');
```

* * *

The previous statement outputs the following:

```text
[Thu, 05 Feb 09 15:19:39-0500][ERROR] Error message
```

By default, log files are named `logDDMMYYY.txt`. You can change this name by passing an additional parameter to the method.

```php
<?php
Logger::error('Error message', 'mi_log');
```

* * *

Because the second parameter is provided, the file is named `mi_log.txt`.

### Logger::warning($msg)

### Logger::error($msg)

### Logger::debug($msg)

### Logger::alert($msg)

### Logger::critical($msg)

### Logger::notice($msg)

### Logger::info($msg)

### Logger::emergence($msg)

### Logger::custom($type = 'CUSTOM', $msg)

* * *

## Flash

Flash is a useful Kumbia helper that outputs error, warning, informational, and success messages in a standard format.

### Flash::error($text)

Sends an error message to the user. By default, the text is red with a pink background. These styles can be changed in the `error` class in `public/css/style.css`.

```php
Flash::error("An error occurred");
```

* * *

### Flash::valid($text)

Sends a success message to the user. By default, the text is green with a pastel-green background. These styles can be changed in the `valid` class in `public/css/style.css`.

```php
Flash::valid("The process completed successfully");
```

* * *

### Flash::info($text)

Sends an informational message to the user. By default, the text is blue with a pastel-blue background. These styles can be changed in the `info` class in `public/css/style.css`.

```php
Flash::info("There are no search results");
```

* * *

### Flash::warning($text)

Sends a warning message to the user. By default, the text is blue with a pastel-blue background. These styles can be changed in the `warning` class in `public/css/style.css`.

```php
Flash::warning("Warning: You are not logged in to the system");
```

* * *

### Flash::show($name, $text)

...

* * *

## Session

The `Session` class facilitates session management.

### Session::set($index, $value, $namespace = 'default')

Creates or sets the value for an index in the current session.

```php
<?php
Session::set('usuario', 'Administrator');
```

* * *

### Session::get($index, $namespace = 'default')

Gets the value for an index in the current session.

```php
<?php
Session::get('usuario'); // returns 'Administrator'
```

* * *

### Session::delete($index, $namespace = 'default')

Deletes the value for an index in the current session.

```php
<?php
Session::delete('usuario');
```

* * *

### Session::has($index, $namespace = 'default')

Checks whether an index is defined in the current session.

```php
<?php
Session::has('id_usuario'); // returns false
```

* * *

**Note:** `$namespace` is an independent space that can contain session variables and prevent collisions between variable names.

## Load

The `Load` class loads libraries in KumbiaPHP.

### Load::coreLib($lib)

Loads a KumbiaPHP core library.

```php
<?php

// Load the cache library

Load::coreLib('cache');
```

### Load::lib($lib)

Loads an application library. Application libraries are located in the `app/libs` directory.

```php
<?php

// Load the app/libs/split.php file

Load::lib('split');
```
If the library does not exist, `Load::lib` tries to load a core library with the specified name.

```php
<?php

/* Load "app/libs/auth2.php" if it exists; otherwise, load
 * the auth2 core library. */

Load::lib('auth2');
```
To group libraries, place them in a subdirectory and prefix the path with the directory name when loading them.

```php
<?php

// Load the app/libs/controllers/auth_controller.php file

Load::lib('controllers/auth_controller.php');
```
### Load::model($model)

Loads and instantiates the specified model, returning the model instance.

```php
<?php

// Load and instantiate the usuario.php model

$usuario = Load::model('usuario');
```
To group models, place them in a subdirectory and prefix the path with the directory name when loading them.

```php
<?php

// Load and instantiate the partes_vehiculo/motor.php model

$motor = Load::model('partes_vehiculo/motor.php');
```
## Auth2

This class handles user authentication through adapters for specialized authentication types.

### Requesting an adapter

To request an adapter, use the static `factory` method and pass the type of adapter to use. If no adapter type is specified, the default adapter is used.

Example:

```php
<?php

$auth = Auth2::factory('model');
```
The following adapter is implemented:

* Model: uses an ActiveRecord model as its data source. Pass `model` as the argument to `factory`.

### Default adapter

The default adapter is `model`, but you can change it with the static `setDefault` method.

$adapter (string): adapter name

setDefault($adapter)

Example:

```php
Auth2::setDefault('model');
```
### How authentication works

The `identify` method checks whether an authenticated session already exists. Otherwise, it reads the username and password from `$_POST` and verifies them against the data source. By default, the password is encrypted using `md5`.

To perform authentication, `$_POST['mode']` must exist and have the value `auth`.

The authentication form must have the following basic structure:

```php
<?php echo Form::open() ?>

    <input name="mode" type="hidden" value="auth">
    
    <label for="login">User:</label>
    
    <?php echo Form::text('login') ?>
    
    <label for="password">Password:</label>
    
    <?php echo Form::pass('password') ?>
    

<?php echo Form::close() ?>
```

* * *

By default, Auth2 uses the `login` field for the username and the `password` field for the password.

To start a user session and perform authentication, call the `identify` method. Depending on the adapter type, you may also need to specify configuration parameters.

### Model adapter

This adapter provides authentication based on a model that inherits from `ActiveRecord`, verifying authentication data against the database.

#### setModel()

Sets the ActiveRecord model used as the data source. By default, the data source model is `users`.

$model (string): model name in lowercase.

setModel($model)

Example:

$auth->setModel('usuario');

* * *

#### identify()

Performs authentication. Identification succeeds if an active user session already exists or the user data are correct.

Returns `true` or `false`.

identify()

Example:

$valid = $auth->identify();

* * *

#### logout()

Ends the user session.

logout()

Example:

$auth->logout();

* * *

#### setFields()

Sets the model fields that are loaded into the session using `Session::set`. By default, it loads the `id` field.

$fields (array): array of fields.

setFields($fields)

Example:

$auth->setFields(array('id', 'usuario'));

* * *

#### setSessionNamespace()

Sets a namespace for fields loaded into the session.

$namespace (string): session namespace.

setSessionNamespace($namespace)

Example:

$auth->setSessionNamespace('auth');

* * *

#### isValid()

Checks whether an authenticated user session exists.

Returns `true` or `false`.

isValid()

Example:

$valid = $auth->isValid();

* * *

#### getError()

Gets the error message.

Returns a string.

getError()

Example:

if (!$auth->identify()) Flash::error($auth->getError());

* * *

#### setAlgos()

Sets the user's password-encryption method.

$algos (string): encryption method; the name must match a PHP hash function.

setAlgos($algos)

Example:

$auth->setAlgos('md5');

* * *

#### setKey()

Sets the key used to identify an authenticated session. This key receives the Boolean value `true` when the authenticated session is valid and is assigned through `Session::set`.

$key (string): session key.

setKey($key)

Example:

$auth->setKey('usuario_logged');

* * *

#### setCheckSession()

Indicates whether a session may be started from a different browser on the same IP address.

$check (boolean): indicator.

setCheckSession($check)

Example:

$auth->setCheckSession(true);

* * *

#### setPass()

Sets the name of the password field. This field must correspond to the database field and the form field. The default is `password`.

$field (string): name of the field received through POST.

setPass($field)

Example:

$auth->setPass('clave');

* * *

#### setLogin()

Sets the name of the username field. This field must correspond to the database field and the form field. The default is `login`.

$field (string): name of the field received through POST.

setLogin($field)

Example:

$auth->setLogin('usuario');

* * *

#### Get the fields loaded in the session

The fields are obtained through the `Session::get` method.

$id = Session::get('id');

* * *

If you specified a session namespace, you must provide it when calling the method.

$id = Session::get('id', 'mi_namespace');

* * *

#### Example

The view is `app/views/acceso/login.phtml`:

```php
<?php echo Form::open() ?>

    <input name="mode" type="hidden" value="auth">

    <label for="login">User:</label>

    <?php echo Form::text('login') ?>

    <label for="password">Password:</label>

    <?php echo Form::pass('password') ?>

<?php echo Form::close() ?>
```

The controller is `app/controllers/auth_controller.php`:

```php
<?php

class AuthController extends AppController
{
    public function login()
    {
        // Redirect to the client module after login.
        if (Load::model('usuario')->login()) {
            Router::toAction('usuario/panel');
        }
    }

    public function logout()
    {
        // End the session.
        Load::model('usuario')->logout();
        Router::toAction('login');
    }
}
```

To validate that the user is authenticated, add the following code to any controller action or to the `before_filter` method:

```php
if (!Load::model('usuario')->logged()) {
    Router::toAction('auth/login');
    return false;
}
```

The model is `app/models/usuario.php`:

```php
<?php

// Load the auth2 library.
Load::lib('auth2');

class Usuario extends ActiveRecord
{
    /**
     * Start the user session.
     */
    public function login()
    {
        // Get the adapter.
        $auth = Auth2::factory('model');

        // Set the model used for the query.
        $auth->setModel('usuario');

        if ($auth->identify()) {
            return true;
        }

        Flash::error($auth->getError());
        return false;
    }

    /**
     * End the user session.
     */
    public function logout()
    {
        Auth2::factory('model')->logout();
    }

    /**
     * Check whether this user is authenticated.
     *
     * @return boolean
     */
    public function logged()
    {
        return Auth2::factory('model')->isValid();
    }
}
```
