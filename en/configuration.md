## Configuration: `config/config.php` File

The `default/app/config/config.php` file is a central configuration component for any KumbiaPHP application. Through
this file, you can customize key settings of the application, including its name, database, date format, debugging, and
more.

In the `config.php` file, all options are organized under the 'application' index. This allows application
configurations to be easily accessible and modifiable in one place. Additionally, it is possible to add more indexes to
define additional settings or include specific configuration files. This provides flexibility to manage different aspects of the project and fully customize the application according to the developer's needs.

```php
<?php
/**
 * KumbiaPHP Web Framework
 * Application configuration parameters
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

Here is a detailed explanation of each parameter.

### Application Name

The application name, represented by the `name` parameter, identifies the project in the KumbiaPHP environment. Although
it does not directly affect functionality, it is used to differentiate and personalize the project.

### Database

The `database` parameter determines which database configuration should be used for the application. This value must
match one of the identifiers in the `databases.php` file, such as "development" or "production". This allows easy
switching between different environments.

### Date Format

The `dbdate` parameter specifies the default date format for the application, using the standard notation `YYYY-MM-DD`.
This setting ensures that all dates in the application are consistent.

### Debugging

The `debug` option turns the display of errors on or off. In "On" mode, errors are shown to help in the development
process. In production, it should be turned off ("Off") to avoid exposing errors to end users.

### Exception Logging

The `log_exceptions` parameter determines whether captured exceptions are displayed on the screen. This can be useful
for tracking issues during development but should be turned off in production to avoid revealing sensitive information.

### Template Caching

The `cache_template` parameter can be enabled to cache templates, improving performance by reducing the need to
recompile them.

### Cache Driver

The `cache_driver` option allows selecting the caching mechanism to use. Available options include:
- **file**: Files on the storage system.
- **sqlite**: An SQLite database.
- **memsqlite**: An in-memory SQLite database.

### Metadata Lifetime

The `metadata_lifetime` parameter defines how long cached metadata should be considered valid. Any format compatible
with the `strtotime()` function, such as "+1 year," is accepted.

### Authentication Namespace

The `namespace_auth` allows defining a default namespace for the authentication system, facilitating the management of
multiple namespaces according to the application's context.

### Custom Routes

The `routes` parameter can be enabled to allow custom routes through the `routes.php` file. This offers flexibility in
reorganizing the URL structure in the application.

### General Considerations

When configuring this file, it is crucial to ensure that parameters such as `debug` and `log_exceptions` are disabled in
production environments to maintain security. Additionally, choosing the appropriate caching mechanism and date format
can significantly improve the application's performance and consistency.

## Configuration: `config/exception.php` File

The `config/exception.php` file in KumbiaPHP allows configuring the IP addresses from which exception details will be
displayed instead of a generic 404 error. This functionality is especially useful during the development phase, where
developers need to see error traces and specific details to debug effectively. This feature is available from version
1.2.0 onwards.

### File Location

The configuration file is located at `default/app/config/exception.php`.

### File Content

The file is in PHP array format and contains a single key `trustedIp`, which is an array of IP addresses. Below is the
default content of the file:

```php
<?php

return [
    // array of IPs to show the developer exception 
    // e.g.: ['12.12.12.12','23.23.23.23']
    'trustedIp' => []
];
```

### Trusted IPs Configuration

The `trustedIp` array should be configured with the IP addresses from which the full details of exceptions will be
displayed. This is useful when you want to allow certain developers or development teams to access this information from
specific locations.

**Example:**
```php
<?php

return [
    // array of IPs to show the developer exception 
    'trustedIp' => ['192.168.1.100', '203.0.113.5']
];
```
In this example, exception details will be shown only to users accessing from the IPs `192.168.1.100` and `203.0.113.5`.

### Default Behavior

By default, the `trustedIp` array is empty. This means that unless configured, exception details will only be shown in
the localhost environment. If left empty, only connections from `127.0.0.1` or `::1` (localhost in IPv6) will see the
full details of exceptions.

### Importance of Configuration

This configuration is crucial for maintaining security in production environments. Showing exception details to
unauthorized users can expose sensitive information and potential vulnerabilities. Therefore, it is recommended to keep
this list restricted to trusted IPs and use it with care.

### Additional Considerations
- **Security:** Ensure that only trusted IP addresses are added to avoid potential information leaks.
- **Production Environment:** In a production environment, it is advisable to disable the display of exception details
  for all users or strictly restrict it to internal IP addresses.
- **Maintenance:** Regularly review and update the IP list in `trustedIp` to reflect changes in the infrastructure or
  development team.

With this configuration, KumbiaPHP allows flexible and secure handling of exception debugging, adapting to the specific
needs of each development and production environment.