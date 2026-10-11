# La consola

La consola de KumbiaPHP permite ejecutar tareas de la aplicación desde un terminal. KumbiaPHP incluye comandos para administrar la caché y para crear o eliminar modelos y controladores. También puedes añadir tus propias consolas.

## Inicio rápido

Si el directorio actual es el directorio `app` de la aplicación, ejecuta el despachador con una ruta relativa:

```shell
php ../../core/console/kumbia.php cache clean
```

Desde otro directorio, indica tanto la ubicación del despachador como la aplicación o el proyecto con `--path`:

```shell
php /var/www/mi_proyecto/core/console/kumbia.php cache clean --path=/var/www/mi_proyecto/default/app
php /var/www/mi_proyecto/core/console/kumbia.php cache clean --path=/var/www/mi_proyecto
```

`--path` admite la ruta al directorio de la aplicación o a la raíz del proyecto.

La forma general de una invocación es:

```text
php <ruta-al-despachador>/kumbia.php <consola> <comando> [argumentos] [--nombre=valor]
```

Ten en cuenta estas reglas:

- Cada opción con nombre ocupa **un solo token**, con la forma exacta `--nombre=valor`; no separes el nombre, el signo `=` y el valor.
- Las opciones con nombre deben aparecer después del comando. Los argumentos posicionales también se escriben después del comando.
- `--path` es una opción reservada: el despachador la consume para localizar la aplicación y no la entrega al método del comando.
- Si omites el comando, el despachador intenta ejecutar `main`. Las consolas incluidas (`cache`, `model` y `controller`) no implementan ese método, por lo que debes indicarles siempre un comando.

## Referencia de comandos incluidos

Los corchetes indican un argumento opcional y los signos `< >`, uno obligatorio.

| Comando | Argumentos | Valores predeterminados |
| --- | --- | --- |
| `cache clean [group] [--driver=value]` | `group` y `--driver` son opcionales. | Sin `group`, limpia toda la caché que corresponda al controlador. Sin `--driver`, usa `file`, salvo que código personalizado cambie esa configuración. |
| `cache remove <id> [group] [--driver=value]` | `id` es obligatorio; `group` y `--driver` son opcionales. | `group` es `default`. Sin `--driver`, usa `file`, salvo que código personalizado cambie esa configuración. |
| `model create <model>` | `model` es obligatorio. | No tiene argumentos opcionales. |
| `model delete <model>` | `model` es obligatorio. | No tiene argumentos opcionales. |
| `controller create <controller>` | `controller` es obligatorio. | No tiene argumentos opcionales. |
| `controller delete <controller>` | `controller` es obligatorio. | No tiene argumentos opcionales. |

> **Nota sobre operaciones destructivas:** `model delete` y `controller delete` no solicitan confirmación cuando el argumento corresponde a un directorio. El tratamiento de rutas y el borrado recursivo de estos comandos están en revisión en el proyecto: la validación de rutas ya está en la rama `dev`, pendiente de pasar a `master` ([KumbiaPHP#431](https://github.com/KumbiaPHP/KumbiaPHP/issues/431)), y el borrado recursivo incompleto sigue abierto ([KumbiaPHP#430](https://github.com/KumbiaPHP/KumbiaPHP/issues/430)). Mientras esos cambios no lleguen a `master`, verifica siempre el argumento antes de ejecutar estos comandos.

### Caché

#### `cache clean [group] [--driver=value]`

Limpia un grupo o, cuando se omite `group`, toda la caché administrada por el controlador seleccionado.

```shell
# Limpia toda la caché con el controlador predeterminado.
php ../../core/console/kumbia.php cache clean

# Limpia el grupo paginas con el controlador indicado.
php ../../core/console/kumbia.php cache clean paginas --driver=file
```

> **Nota sobre APC:** al usar el controlador APC, `group` se ignora y se limpia por completo la caché APC de usuario.

#### `cache remove <id> [group] [--driver=value]`

Elimina de la caché el elemento identificado por `id`. Si no indicas `group`, se usa `default`.

```shell
# Elimina vista1 del grupo predeterminado.
php ../../core/console/kumbia.php cache remove vista1

# Elimina vista1 del grupo mis_vistas.
php ../../core/console/kumbia.php cache remove vista1 mis_vistas --driver=file
```

`file` es el controlador predeterminado de la consola, a menos que código personalizado lo cambie. KumbiaPHP o la aplicación pueden proporcionar otros controladores; por ello, esta guía no pretende enumerarlos de forma definitiva.

### Modelos

#### `model create <model>`

Crea un modelo a partir de la plantilla `core/console/generators/model.php`.

```shell
php ../../core/console/kumbia.php model create venta_vehiculo
```

Puedes usar `/` para generar un modelo dentro de subdirectorios. Por ejemplo:

```shell
php ../../core/console/kumbia.php model create administracion/usuario
```

crea `app/models/administracion/usuario.php` (donde `app` representa el directorio de la aplicación seleccionada).

Si el archivo ya existe, la consola solicita permiso para sobrescribirlo. Las respuestas admitidas son exactamente `s` y `n`, en minúsculas.

#### `model delete <model>`

Elimina el modelo indicado; también admite rutas anidadas separadas con `/`.

```shell
php ../../core/console/kumbia.php model delete administracion/usuario
```

> **Aviso:** si el argumento corresponde a un directorio, la consola elimina su contenido de forma recursiva. Verifica el argumento antes de ejecutar el comando.

### Controladores

#### `controller create <controller>`

Crea un controlador a partir de la plantilla `core/console/generators/controller.php` y prepara su directorio de vistas.

```shell
php ../../core/console/kumbia.php controller create venta_vehiculo
```

Las rutas anidadas se separan con `/`:

```shell
php ../../core/console/kumbia.php controller create administracion/usuarios
```

El ejemplo crea `app/controllers/administracion/usuarios_controller.php` y el directorio de vistas `app/views/administracion/usuarios/`.

Si el archivo ya existe, la consola solicita permiso para sobrescribirlo. Las únicas respuestas válidas son `s` y `n`, en minúsculas.

#### `controller delete <controller>`

Elimina el controlador indicado; también admite rutas anidadas separadas con `/`.

```shell
php ../../core/console/kumbia.php controller delete administracion/usuarios
```

> **Aviso:** si el argumento corresponde a un directorio, la consola lo elimina sin solicitar confirmación; después puede ofrecer eliminar también el directorio de vistas. Verifica la ruta y lee la pregunta antes de responder.

## Desarrollar consolas propias

### Ubicación y carga

Guarda una consola de la aplicación en `app/extensions/console`. El nombre del archivo debe terminar en `_console.php` y el nombre de la clase, en `Console`. Por ejemplo, `report_console.php` define `ReportConsole`.

Al resolver una consola, KumbiaPHP busca primero la implementación de la aplicación y después la del núcleo. Por tanto, una consola de `app/extensions/console` con el mismo nombre tiene precedencia sobre la incluida en `core/console`.

### Despacho de comandos y argumentos

Cada comando corresponde a un método público de la clase. El despachador:

1. carga la clase de la consola;
2. ejecuta automáticamente el método reservado `initialize()`, si existe;
3. invoca el método cuyo nombre coincide con el comando.

`initialize()` está reservado para la inicialización automática, no para usarlo como comando. Si no se indica un comando, se intenta invocar `main()`.

El primer argumento de cada método de comando es un array con las opciones con nombre. Después se reciben, en orden, los argumentos posicionales. La opción reservada `--path` no aparece en ese array porque el despachador ya la consumió.

```php
<?php

class ReportConsole
{
    public function initialize()
    {
        // Preparación común para todos los comandos.
    }

    public function export($params, $report)
    {
        $format = isset($params['format']) ? $params['format'] : 'csv';
        echo "Exportando $report como $format", PHP_EOL;
    }
}
```

El comando anterior se puede ejecutar así:

```shell
php ../../core/console/kumbia.php report export ventas --format=csv
```

La consola recibe `array('format' => 'csv')` en `$params` y `ventas` en `$report`.

### Clases y constantes disponibles

En el entorno de consola se cargan automáticamente las clases auxiliares `Load`, `Config` y `Util`. También están definidas las constantes `APP_PATH`, `CORE_PATH` y `PRODUCTION`.

Este fragmento, basado en la consola de caché, muestra su uso y contiene la terminación correcta de la llamada a `Cache::driver()`:

```php
<?php

Load::lib('cache');

class CacheConsole
{
    public function clean($params, $group = false)
    {
        if (isset($params['driver'])) {
            $cache = Cache::driver($params['driver']);
        } else {
            $cache = Cache::driver();
        }

        if ($cache->clean($group)) {
            echo $group
                ? "-> Se ha limpiado el grupo $group"
                : '-> Se ha limpiado la caché';
            echo PHP_EOL;
            return;
        }

        throw new KumbiaException('No se ha logrado eliminar el contenido');
    }
}
```

### `Console::input()`

```php
Console::input($message, $values = null);
```

`$message` es el texto que se muestra al solicitar la entrada. Si `$values` es `null`, el método acepta y devuelve la entrada leída. Si proporcionas un array en `$values`, solo devuelve cuando la entrada coincide con uno de esos valores; ante cualquier otro valor vuelve a solicitarla. Los valores se aceptan exactamente como aparecen en el array: no se convierten variantes como `S` en `s`.

```php
$respuesta = Console::input('¿Desea continuar?', array('s', 'n'));
```

En este ejemplo solo se admiten `s` y `n`, en minúsculas.
