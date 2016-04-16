# Install KumbiaPHP

This section explains the steps to follow, to run the framework in our development environment.

## Requirements

As mentioned above KumbiaPHP is very easy, and in this sense the requirements to operate the framework are minimal, are listed below:

- Interpret PHP (version 5.2.2 or higher).
- Web server with support for URL rewriting (Apache, Cherokee, Nginx, Lighttpd, Internet Information Server (IIS)).
- Database supported by KumbiaPHP.

To install KumbiaPHP Framework, you should download the archive from the download section http://www.kumbiaphp.com/blog/manuales-y-descargas/ for the framework most recent version. Once the file is downloaded, it is essential to make sure that it has the extension .tgz for users Linux and .zip for Windows users.

Then unzip its contents in the directory root of the webserver (DocumentRoot). To ensure some consistency in the document, this chapter assumes that the framework kumbiaphp is unzipped in the dir kumbiaphp/. Having a structure like the following:

    -- KumbiaPHP-master  
        |-- core  
        |-- default  
            |-- app  
            |-- public  
            |-- .htaccess  
            `-- index.php  
    

## Configure Web server

KumbiaPHP Framework uses a module to rewrite URLs, making them more understandable and easy to remember in our applications. This module must be configured and installed, in this sense must check that the module is enabled, the following sections explain how to do it.

### Enabling mod_rewrite of Apache on GNU/Linux (Debian, Ubuntu and derivatives)

Nos aseguramos de activar el mod_rewrite de esta manera y como usuario administrador desde la consola.

```bash
  > a2enmod rewrite
  Enabling module rewrite.
  Run '/etc/init.d/apache2 restart' to activate new configuration!
```

Lo anterior indica que se ha habilitado el mod_rewrite de Apache, pero aun falta indicarle a Apache que interprete los archivos .htaccess que son los encargados de hacer uso del rewrite y a su vez tienen las reglas de reescritura de las URLs.

Como usuario administrador editamos el siguiente archivo.

```bash
 > vi /etc/apache2/sites-enabled/000-default  
```

```apacheconf
<Directory "/to/document/root">  
    Options Indexes FollowSymLinks
    AllowOverride None
    Order allow,deny
    Allow from all
</Directory>  
```

Para que los .htaccess tengan efectos, se ha de sustituir *AllowOverride None* por *AllowOverride All*, de esta manera Apache puede interpretar estos archivos.

Hecho esto, queda reiniciar el servicio de apache.

```bash
 >/etc/init.d/apache2 restart  
```

A continuación, se prueba todas las configuraciones realizadas mediante la siguiente URL.

http://localhost/kumbiaphp/

Si todo ha ido bien, debería ver una página de bienvenida como la que se muestra en la figura 2.1, con lo que la instalación rápida se puede dar por concluida.

![](../images/image12.png)

Figura 2.1: Instalación exitosa de KumbiaPHP

Esto es un entorno de pruebas el cual esta pensado para practicar con KumbiaPHP en un servidor local, no para desarrollar aplicaciones complejas que terminan siendo publicadas en la web.

### Why is important Mod-Rewrite?

ReWrite es un módulo de apache que permite reescribir las urls que han utilizado nuestros usuarios. KumbiaPHP Framework encapsula esta complejidad permitiendo usar URLs bonitas o limpias como las que vemos en blogs o en muchos sitios donde no aparecen los ?, los & ni las extensiones del servidor (.php, .asp, .aspx, etc).

Además de esto, con mod-rewrite KumbiaPHP puede proteger nuestras aplicaciones ante la posibilidad de que los usuarios puedan ver los directorios del proyecto y puedan acceder a archivos de clases, modelos, lógica, etc., sin que sean autorizados.

Con mod-rewrite el único directorio que pueden ver los usuarios es el contenido del directorio público (public) del servidor web, el resto permanece oculto y solo puede ser visualizado cuando ha realizado una petición en forma correcta y también es correcto según nuestra lógica de aplicación. Cuando escribes direcciones utilizando este tipo de URLs, estas ayudando también a los motores de búsqueda a indexar mejor tu información.