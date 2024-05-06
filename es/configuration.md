## Parámetros de Configuración

El archivo `default/app/config/config.php` es un componente central de configuración para cualquier aplicación KumbiaPHP.
A través de este archivo, puedes personalizar los ajustes clave de la aplicación, incluyendo su nombre, base de datos,
formato de fechas, depuración, y más.

En el archivo `config.php`, todas las opciones están organizadas bajo el índice 'application'. Esto permite que las
configuraciones de la aplicación sean fácilmente accesibles y modificables en un solo lugar. Además, es posible agregar
más índices para definir configuraciones adicionales o incluir archivos de configuración específicos. Esto proporciona
flexibilidad para gestionar distintos aspectos del proyecto y personalizar completamente la aplicación según las
necesidades del desarrollador.

```php
<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de configuracion de la aplicacion
 */
return [
    'application' => [        
        'name' => 'KUMBIAPHP PROJECT',
        'database' => 'development',
        'dbdate' => 'YYYY-MM-DD',
        'debug' => 'On',
        'log_exceptions' => 'On',
        //'cache_template' => 'On',
        'cache_driver' => 'file',
        'metadata_lifetime' => '+1 year',
        'namespace_auth' => 'default',
        //'routes' => '1',
    ],
];

```

Aquí te mostramos una explicación detallada de cada parámetro.

### Nombre de la Aplicación

El nombre de la aplicación, representado por el parámetro `name`, identifica el proyecto en el entorno KumbiaPHP. Aunque
no afecta la funcionalidad directamente, se utiliza para diferenciar y personalizar el proyecto.

### Base de Datos

El parámetro `database` determina cuál configuración de base de datos se debe utilizar para la aplicación. Este valor
debe coincidir con uno de los identificadores en el archivo `databases.php`, como "development" o "production". Esto
permite alternar entre distintos ambientes con facilidad.

### Formato de Fecha

El parámetro `dbdate` especifica el formato de fecha predeterminado para la aplicación, utilizando la notación estándar
`YYYY-MM-DD`. Esta configuración garantiza que todas las fechas en la aplicación sean consistentes.

### Depuración (Debug)

La opción `debug` activa o desactiva la visualización de errores en pantalla. En modo "On", los errores se muestran para
ayudar en el proceso de desarrollo. En producción, debe estar desactivado ("Off") para evitar la exposición de errores a
los usuarios finales.

### Registro de Excepciones

El parámetro `log_exceptions` determina si las excepciones capturadas se muestran en pantalla. Esto puede ser útil para
rastrear problemas durante el desarrollo, pero debe desactivarse en producción para evitar revelar información sensible.

### Caché de Plantillas

El parámetro `cache_template` puede habilitarse para almacenar las plantillas en caché, lo que mejora el rendimiento al
reducir la necesidad de recompilarlas.

### Controlador de Caché

La opción `cache_driver` permite seleccionar el mecanismo de almacenamiento en caché a usar. Entre las opciones
disponibles se encuentran:
- **file**: Archivos en el sistema de almacenamiento.
- **sqlite**: Una base de datos SQLite.
- **memsqlite**: Una base de datos SQLite en memoria.

### Tiempo de Vida de la Metadata

El parámetro `metadata_lifetime` define cuánto tiempo los metadatos almacenados en caché deben ser considerados válidos.
Se acepta cualquier formato compatible con la función `strtotime()`, como "+1 year".

### Espacio de Nombres para Autenticación

El `namespace_auth` permite definir un espacio de nombres predeterminado para el sistema de autenticación, lo que
facilita la gestión de múltiples espacios según el contexto de la aplicación.

### Rutas Personalizadas

El parámetro `routes` puede habilitarse para permitir rutas personalizadas a través del archivo `routes.php`. Esto
ofrece flexibilidad al reorganizar la estructura de URLs en la aplicación.

## Consideraciones Generales

Al configurar este archivo, es fundamental asegurarse de que los parámetros como `debug` y `log_exceptions` estén
deshabilitados en entornos de producción para mantener la seguridad. Además, elegir el mecanismo de caché y formato de fechas adecuado puede mejorar significativamente el rendimiento y la consistencia de la aplicación.