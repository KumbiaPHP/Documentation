## Configuración: Archivo `config/config.php`

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

### Consideraciones Generales

Al configurar este archivo, es fundamental asegurarse de que los parámetros como `debug` y `log_exceptions` estén
deshabilitados en entornos de producción para mantener la seguridad. Además, elegir el mecanismo de caché y formato de
fechas adecuado puede mejorar significativamente el rendimiento y la consistencia de la aplicación.

## Configuración: Archivo `config/exception.php` (v 1.2)

El archivo `config/exception.php` en KumbiaPHP permite configurar las direcciones IP desde las cuales se mostrarán los
detalles de las excepciones en lugar de un error 404 genérico. Esta funcionalidad es especialmente útil durante la fase
de desarrollo, donde los desarrolladores necesitan ver la traza de errores y detalles específicos para depurar de manera
efectiva.

### Ubicación del Archivo
El archivo de configuración se encuentra en la ruta `default/app/config/exception.php`.

### Contenido del Archivo
El archivo tiene un formato de arreglo PHP y contiene una única clave `trustedIp`, que es un array de direcciones IP. A
continuación se muestra el contenido por defecto del archivo:

```php
<?php

return [
    // array de IPs para mostrar la excepción de desarrollador 
    // ej: ['12.12.12.12','23.23.23.23']
    'trustedIp' => []
];
```

### Configuración de IPs Confiables
El array `trustedIp` debe ser configurado con las direcciones IP desde las cuales se permitirá mostrar los detalles
completos de las excepciones. Esto es útil cuando se quiere permitir que ciertos desarrolladores o equipos de desarrollo
accedan a esta información desde ubicaciones específicas. Esta característica está disponible desde la versión 1.2.0 en
adelante.

**Ejemplo:**
```php
<?php

return [
    // array de IPs para mostrar la excepción de desarrollador 
    'trustedIp' => ['192.168.1.100', '203.0.113.5']
];
```
En este ejemplo, los detalles de las excepciones se mostrarán únicamente a los usuarios que accedan desde las IPs
`192.168.1.100` y `203.0.113.5`.

### Comportamiento por Defecto
Por defecto, el arreglo `trustedIp` está vacío. Esto significa que, a menos que se configure, los detalles de las
excepciones solo se mostrarán en el ambiente localhost. Si se deja vacío, solo las conexiones desde `127.0.0.1` o `::1`
(localhost en IPv6) podrán ver los detalles completos de las excepciones.

### Importancia de la Configuración
Esta configuración es crucial para mantener la seguridad en entornos de producción. Mostrar detalles de excepciones a
usuarios no autorizados puede exponer información sensible y vulnerabilidades potenciales. Por lo tanto, se recomienda mantener esta lista restringida solo a IPs de confianza y utilizarla con cuidado.

### Consideraciones Adicionales
- **Seguridad:** Asegúrate de que solo se añadan direcciones IP confiables para evitar posibles filtraciones de
  información sensible.
- **Entorno de Producción:** En un entorno de producción, es recomendable desactivar la visualización de detalles de
  excepciones para todos los usuarios o restringirla estrictamente a direcciones IP internas.
- **Mantenimiento:** Revisa y actualiza periódicamente la lista de IPs en `trustedIp` para reflejar cambios en la
  infraestructura o equipo de desarrollo.

Con esta configuración, KumbiaPHP permite un manejo flexible y seguro de la depuración de excepciones, adaptándose a las
necesidades específicas de cada entorno de desarrollo y producción.
