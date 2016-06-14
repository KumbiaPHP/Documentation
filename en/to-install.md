# Install KumbiaPHP

This section explains the steps to follow, to run the framework in our development environment.

## Requirements

As mentioned above KumbiaPHP is very easy, and in this sense the requirements to operate the framework are minimal, are listed below:

- Interprete PHP versión 5.4 o superior.
- Servidor Web con soporte de reescritura de URL (Apache, Nginx, Cherokee, Lighttpd, Internet Information Server (IIS)).
- Database supported by KumbiaPHP.

To install KumbiaPHP Framework, you should download the archive from the download section http://www.kumbiaphp.com/blog/manuales-y-descargas/ for the framework most recent version. Once the file is downloaded, it is essential to make sure that it has the extension .tgz for users Linux and .zip for Windows users.

Then unzip its contents in the directory root of the webserver (DocumentRoot). To ensure some consistency in the document, this chapter assumes that the framework kumbiaphp is unzipped in the dir kumbiaphp/. Having a structure like the following:

    -- KumbiaPHP-master  
        |-- core 
        |-- vendors 
        |-- default  
            |-- app  
            |-- public  
            |-- .htaccess  
            `-- index.php  
    

## Configurar Apache

KumbiaPHP Framework uses a module to rewrite URLs, making them more understandable and easy to remember in our applications. This module must be configured and installed, in this sense must check that the module is enabled, the following sections explain how to do it.

### Enabling mod_rewrite of Apache on GNU/Linux (Debian, Ubuntu and derivatives)

We made sure to activate mod_rewrite in this way and as an administrator user from the console.

```bash
  > a2enmod rewrite
  Enabling module rewrite.
  Run '/etc/init.d/apache2 restart' to activate new configuration!
```

This indicates that is enabled Apache mod_rewrite, but there is still tell Apache to interpret the .htaccess files that are responsible for the rewrite use and in turn have the rules rewrite URLs.

As an administrator user edit the next file.

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

So that the .htaccess have effects, must replace *AllowOverride None* by *AllowOverride All* this way Apache can interpret these files.

That done, restart the apache service.

```bash
 >/etc/init.d/apache2 restart  
```

Next, test all settings made by the following URL.

http://localhost/kumbiaphp/

Si todo ha ido bien, debería ver una página de bienvenida, con lo que la instalación rápida se puede dar por concluida.

![](../images/image12.png)

Figure 2.1: Successful installation of KumbiaPHP

This is an environment test which is intended to practice with KumbiaPHP on a local server, not to develop complex applications that end up being published on the web.

## Configurar Nginx

Using `$_SERVER['PATH_INFO']` as source of URIs:

    server {
        listen      80;
        server_name localhost.dev;
        root        /var/www/kumbiaphp;
        index       index.php index.html index.htm;
    
        location / {
            try_files $uri $uri/ /index.php;
        }
    
        location ~ \.php {
            fastcgi_pass  unix:/run/php-fpm/php-fpm.sock;
            fastcgi_index /index.php;
    
            include fastcgi_params;
            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO       $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
    
        location ~ /\. {
            deny all;
        }
    }
    

Using `$_GET['_url']` as source of URIs:

    server {
        listen      80;
        server_name localhost.dev;
        root        /var/www/kumbiaphp;
        index       index.php index.html index.htm;
    
        location / {
            try_files $uri $uri/ /index.php?_url=$uri&$args;
        }
    
        location ~ \.php {
            fastcgi_pass  unix:/run/php-fpm/php-fpm.sock;
            fastcgi_index /index.php;
    
            include fastcgi_params;
            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO       $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
    
        location ~ /\. {
            deny all;
        }
    }
    

### Why is important Mod-Rewrite?

ReWrite es un módulo de apache que permite reescribir las urls que han utilizado nuestros usuarios. KumbiaPHP Framework encapsula esta complejidad permitiendo usar URLs bonitas o limpias como las que vemos en blogs o en muchos sitios donde no aparecen los ?, los & ni las extensiones del servidor (.php, .asp, .aspx, etc).

Además de esto, con mod-rewrite KumbiaPHP puede proteger nuestras aplicaciones ante la posibilidad de que los usuarios puedan ver los directorios del proyecto y puedan acceder a archivos de clases, modelos, lógica, etc., sin que sean autorizados.

Con mod-rewrite el único directorio que pueden ver los usuarios es el contenido del directorio público (public) del servidor web, el resto permanece oculto y solo puede ser visualizado cuando ha realizado una petición en forma correcta y también es correcto según nuestra lógica de aplicación. Cuando escribes direcciones utilizando este tipo de URLs, estas ayudando también a los motores de búsqueda a indexar mejor tu información.