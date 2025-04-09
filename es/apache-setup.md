## Instalación de KumbiaPHP en Apache para GNU/Linux (Debian, Ubuntu y derivados)

Esta sección proporciona instrucciones paso a paso para instalar y configurar KumbiaPHP en Apache para distribuciones
Linux como Ubuntu y Debian. Al finalizar, tendrás una configuración básica lista para desarrollar tu aplicación en
KumbiaPHP.

> ⚠️ **Advertencia**  
>
> Esta instalación es un entorno de pruebas, pensado para experimentar con KumbiaPHP en un servidor local. No está
> recomendada para el desarrollo de aplicaciones que vayan a ser publicadas en producción.

### 1. Requisitos Previos

- **Servidor Apache HTTP** instalado y en ejecución.  
- **PHP 8.0** (o posterior) instalado. Asegúrate de incluir extensiones como `php-mbstring`, `php-xml`, `php-json`, etc.  
- Conocimientos básicos de comandos de terminal (por ejemplo, `sudo`, mover archivos, etc.).

### 2. Descargar y Descomprimir KumbiaPHP

1. **Descarga** el archivo `.tar.gz` más reciente desde la web de KumbiaPHP. Por ejemplo, desde `/var/www`:
   ```bash
   cd /var/www
   wget https://github.com/KumbiaPHP/KumbiaPHP/archive/v1.2.1.tar.gz
   ```
2. **Descomprime** el contenido del archivo:
   ```bash
   tar -xzvf v1.2.1.tar.gz
   ```
3. (Opcional) **Renombra** la carpeta resultante si lo deseas:
   ```bash
   mv KumbiaPHP-1.2.1 kumbiaphp
   ``` 

### 3. Configurar VirtualHost en Apache

Crea un nuevo archivo de configuración en `/etc/apache2/sites-available/`, por ejemplo `kumbiafw.conf`:

```apache
<VirtualHost *:80>
    ServerName kumbia.fw
    DocumentRoot /var/www/kumbiaphp/default/public

    <Directory /var/www/kumbiaphp/default/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/kumbiafw-error.log
    CustomLog ${APACHE_LOG_DIR}/kumbiafw-access.log combined
</VirtualHost>
```

- Cambia `kumbia.fw` por el dominio o hostname local que desees.
- Ajusta la ruta de `DocumentRoot` a la ubicación donde descomprimiste KumbiaPHP.

Activa el nuevo sitio y el módulo `rewrite`:

```bash
sudo a2ensite kumbiafw.conf
sudo a2enmod rewrite
sudo systemctl reload apache2
```

### 4. Configurar Permisos

Asegúrate de que el usuario del servidor web (normalmente `www-data` en Ubuntu/Debian) tenga los permisos adecuados:

```bash
sudo chown -R www-data:www-data /var/www/kumbiaphp
sudo find /var/www/kumbiaphp -type d -exec chmod 755 {} \;
sudo find /var/www/kumbiaphp -type f -exec chmod 644 {} \;
```

- Las carpetas tienen permisos `755`.
- Los archivos tienen permisos `644`.


### 5. Probar la Instalación

1. **Configura tu archivo hosts** para apuntar `kumbia.fw` a `127.0.0.1` si es un entorno local. Edita `/etc/hosts` y
añade:
   ```
   127.0.0.1   kumbia.fw
   ```
2. **Visita** `http://kumbia.fw` en tu navegador. Si todo está correcto, verás la página de bienvenida de KumbiaPHP.

![Instalación exitosa](../images/welcome-page.jpg)

### 6. Ejemplo de Controlador y Vista para Verificación

A continuación, se muestra un simple controlador para verificar la configuración de tu aplicación. Colócalo en
`app/controllers/test_controller.php`:

```php
<?php
/**
 * TestController is an example to demonstrate a basic setup in KumbiaPHP.
 */
class TestController extends AppController
{
    /**
     * Default action
     *
     * This action simply shows a welcome message.
     *
     * @return void
     */
    public function index()
    {
        $this->date = date('Y-m-d H:i:s');
    }
}
```

Y la vista correspondiente en `app/views/test/index.phtml`:

```php
<h1>Welcome to KumbiaPHP!</h1>
Today's date and time is: <?= $date ?>
```

Ahora, dirígete a `http://kumbia.fw/test` en tu navegador. Deberías ver el mensaje de bienvenida, lo que indica que tu
configuración funciona correctamente.

![Mensaje de bienvenida](../images/test-welcome-message.jpg)

> ℹ️ **Información**  
>
> Estas instrucciones pueden variar ligeramente según la versión de Ubuntu o Debian que utilices. Tómalas como guía y,
> si necesitas más ayuda o instrucciones específicas, por favor contacta con el soporte de KumbiaPHP.

## ¿Por qué es importante `mod_rewrite`?

`mod_rewrite` es un módulo de Apache que permite reescribir las URLs que utilizan los usuarios. KumbiaPHP encapsula esta
funcionalidad, permitiéndote usar URLs limpias y legibles, como las que vemos en blogs o aplicaciones modernas (sin
signos como `?`, `&`, ni extensiones como `.php`, `.asp`, `.aspx`, etc.).

Además, con `mod_rewrite`, KumbiaPHP mejora la seguridad de la aplicación al restringir el acceso directo a directorios
y archivos internos. Solo el contenido del directorio `public/` será accesible por los usuarios. Esto garantiza que la
lógica de negocio y las clases del sistema permanezcan protegidas.

También mejora la indexación en motores de búsqueda, lo que es beneficioso para la visibilidad de tus aplicaciones.
