# Install KumbiaPHP

This section explains the steps to follow, to run the framework in our development environment.

## Requirements

As mentioned above KumbiaPHP is very easy, and in this sense the requirements to operate the framework are minimal, are listed below:

- PHP version 5.4 or higher.
- Web server with support for URL rewriting (Apache, Cherokee, Nginx, Lighttpd, Internet Information Server (IIS)).
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
    

## Configure Apache

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

If all has gone well, you should see a welcome page, so the quick installation can be finished.

![](../images/image12.png)

Figure 2.1: Successful installation of KumbiaPHP

This is an environment test which is intended to practice with KumbiaPHP on a local server, not to develop complex applications that end up being published on the web.

## Configure Nginx

Using `$_SERVER['PATH_INFO']`:

```nginx
server {
    listen      80;
    server_name localhost.dev;
    root        /var/www/kumbiaphp;
    index       index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php;
    }

    location ~ \.php {
        #fastcgi_pass  unix:/run/php-fpm/php-fpm.sock;
        fastcgi_pass  127.0.0.1:9000;
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
```

Using `$_GET['_url']`:

```nginx
server {
    listen      80;
    server_name localhost.dev;
    root        /var/www/kumbiaphp;
    index       index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?_url=$uri&$args;
    }

    location ~ \.php {
        #fastcgi_pass  unix:/run/php-fpm/php-fpm.sock;
        fastcgi_pass  127.0.0.1:9000;
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
```

### Why is important Mod-Rewrite?

ReWrite is an apache module that allows you to rewrite urls that our users have used. KumbiaPHP Framework encapsulates this complexity by allowing to use beautiful URLs or clean like that you see in blogs or in places where they do not appear the?, the & or server extensions (.php, .asp, .aspx, etc).

In addition, with mod-rewrite KumbiaPHP can protect our applications to the possibility that users can see the project directories and can access class files, models, logic, etc., unless they are authorized.

With mod-rewrite the only directory that users can see is public directory (public) of the web server content, the rest remains hidden and only can be viewed when you have made a request to properly and is also correct according to our application logic. When you write addresses using this type of URLs, are also helping the search engines to better index your information.

## Modos de una Aplicación

KumbiaPHP ofrece dos modos de ejecución de una aplicación el cual es indicado en el archivo [default/public/index.php](https://github.com/KumbiaPHP/KumbiaPHP/blob/master/default/public/index.php), se describen a continuación:

### Desarrollo

Es el modo por defecto, en este caso el valor de la constante PRODUCTION es false: `const PRODUCTION = false;`. En éste la cache de KumbiaPHP está desactivada y cualquier cambio que se haga en los campos y tablas de la base de datos (adición o eliminación de campos, etc), vistas de la aplicación que se cacheen, surtirán efecto inmediatamente.

### Producción

Se activa asignando en el archivo [default/public/index.php](https://github.com/KumbiaPHP/KumbiaPHP/blob/master/default/public/index.php) el valor true a la constante PRODUCTION, así: `const PRODUCTION = true;`, en este la cache de KumbiaPHP esta activada y se cachea información necesaria para agilizar la carga de la aplicación tal como la metadata de la base datos (información de tablas y campos), asimismo las vistas que el usuario desee cachear.

### ¡¡¡ ADVERTENCIA !!!

Cuando se efectua el cambio de `PRODUCTION = false;` a `PRODUCTION = true;`, es necesario eliminar el contenido del directorio de cache de la aplicación [default/app/temp/cache/*](https://github.com/KumbiaPHP/KumbiaPHP/tree/master/default/app/temp/cache) para que se renueve la metadata y no haya problemas al guardar o mostrar la información.

no se deben confundir con la conexión a la base de datos que se va usar ,