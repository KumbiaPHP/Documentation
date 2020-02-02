# Instalar KumbiaPHP

En esta sección, se explican los pasos a seguir, para poner a funcionar el
framework en nuestro ambiente de desarrollo.

## Requisitos

Como se mencionó arriba KumbiaPHP es muy fácil y en este sentido los
requerimientos para hacer funcionar el framework son mínimos, a continuación
se listan:

  * Interprete PHP versión 5.4 o superior.
  * Servidor Web con soporte de reescritura de URL (Apache, Nginx, Cherokee, Lighttpd, Internet Information Server (IIS)).
  * Manejador de base de datos soportado por KumbiaPHP.

Para instalar KumbiaPHP Framework, se debe descargar su archivo comprimido
desde la sección de descarga http://www.kumbiaphp.com/blog/manuales-y-descargas/ para
obtener la versión mas reciente del framework. Una vez descargado el archivo,
es esencial asegurarse que tiene la extensión .tgz para usuarios Linux y .zip
para usuarios de Windows, ya que de otro modo no se descomprimirá
correctamente.

A continuación se descomprime su contenido en el directorio raíz del servidor
web (DocumentRoot). Para asegurar cierta uniformidad en el documento, en este
capitulo se supone que se ha descomprimido el paquete del framework en el
directorio kumbiaphp/ . Teniendo una estructura como la siguiente:
```
-- KumbiaPHP-master  
    |-- core 
    |-- vendors 
    |-- default  
        |-- app  
        |-- public  
        |-- .htaccess  
        `-- index.php  
```

## Configurar Apache

KumbiaPHP Framework utiliza un módulo para la reescritura de URLs haciéndolas
mas comprensibles y fáciles de recordar en nuestras aplicaciones. Por esto, el
módulo debe ser configurado e instalado, en este sentido debe chequear que el
módulo esté habilitado, en las siguientes secciones se explica como hacerlo.

### Habilitando mod_rewrite de Apache en GNU/Linux (Debian, Ubuntu y derivados)

Nos aseguramos de activar el mod_rewrite  de esta manera y como usuario
administrador desde la consola.
```bash
  > a2enmod rewrite
  Enabling module rewrite.
  Run '/etc/init.d/apache2 restart' to activate new configuration!
```  
  
Lo anterior indica que se ha habilitado el mod_rewrite  de Apache, pero aun
falta indicarle a Apache que interprete los archivos .htaccess  que son los
encargados de hacer uso del rewrite y a su vez tienen las reglas de
reescritura de las URLs.

Como usuario administrador editamos el siguiente archivo.
``` bash
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
  
Para que los .htaccess tengan efectos, se ha de sustituir
*AllowOverride None*
por *AllowOverride All*, de esta manera Apache puede interpretar estos archivos.

Hecho esto, queda reiniciar el servicio de apache.

```bash
 >/etc/init.d/apache2 restart  
```

A continuación, se prueba todas las configuraciones realizadas mediante la
siguiente URL.

http://localhost/kumbiaphp/  

  
Si todo ha ido bien, debería ver una página de bienvenida, con lo que la instalación rápida se puede dar por
concluida.

![](../images/image12.png)

Figura 2.1: Instalación exitosa de KumbiaPHP

Esto es un entorno de pruebas el cual esta pensado para practicar con
KumbiaPHP en un servidor local, no para desarrollar aplicaciones complejas que
terminan siendo publicadas en la web.

## Configurar Nginx

Usando `$_SERVER['PATH_INFO']`:

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

Usando `$_GET['_url']`:

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


### ¿Por qué es importante el Mod-Rewrite?

ReWrite es un módulo de apache que permite reescribir las urls que han
utilizado nuestros usuarios. KumbiaPHP Framework encapsula esta complejidad
permitiendo usar URLs bonitas o limpias como las que vemos en blogs o en
muchos sitios donde no aparecen los ?, los & ni las extensiones del servidor
(.php, .asp, .aspx, etc).

Además de esto, con mod-rewrite KumbiaPHP puede proteger nuestras
aplicaciones ante la posibilidad de que los usuarios puedan ver los
directorios del proyecto y puedan acceder a archivos de clases, modelos,
lógica, etc., sin que sean autorizados.

Con mod-rewrite  el único directorio que pueden ver los usuarios es el
contenido del directorio público (public) del servidor web, el resto permanece
oculto y solo puede ser visualizado cuando ha realizado una petición en forma
correcta y también es correcto según nuestra lógica de aplicación. Cuando
escribes direcciones utilizando este tipo de URLs, estas ayudando también a
los motores de búsqueda a indexar mejor tu información.

## Modos de una Aplicación

KumbiaPHP ofrece dos modos de ejecución de una aplicación el cual es indicado 
en el archivo _public/index.php_, estos se describen a continuación:

### Desarrollo

Es el modo por defecto, en este caso el valor de la constante PRODUCTION 
es false: `const PRODUCTION = false;`. En éste la cache de KumbiaPHP está 
desactivada y cualquier cambio que se haga en los campos y tablas de la base 
de datos (adición o eliminación de campos, etc), vistas de la aplicación 
que se cacheen, surtirán efecto inmediatamente.

### Producción

Asignado en el archivo _public/index.php_ el valor true a la constante PRODUCTION: 
`const PRODUCTION = true;`, se entra en el modo de producción, en este la cache 
de kumbiaphp framework esta activada y se cachea información necesaria para 
agilizar la carga de la aplicación tal como la metadata de la base datos 
(información de tablas y campos), asimismo las vistas que el usuario desee cachear.

### ¡¡¡ ADVERTENCIA !!!
Cuando se efectua el cambio de `PRODUCTION = false;` a `PRODUCTION = true;`, 
es necesario eliminar el contenido del directorio de cache de la aplicación _/app/tmp/cache/*_ para que se renueve la metadata y no haya problemas al guardar o mostrar la información.
