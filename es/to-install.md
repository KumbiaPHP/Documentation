#Instalar KumbiaPHP

En esta seccion, se explican los pasos a seguir, para poner a funcionar el
framework en nuestro ambiente de desarrollo.

## Requisitos

Como se menciono arriba KumbiaPHP es muy facil  y en este sentido los
requerimientos para hacer funcionar el framework son minimos, a continuacion
se listan:

  * Interprete PHP (version 5.2.2 o superior).
  * Servidor Web con soporte de reescritura de URL (Apache, Cherokee, Lighttpd, Internet Information Server (IIS)).
  * Manejador de base de datos soportado por KumbiaPHP.

Para instalar KumbiaPHP Framework, se debe descargar su archivo comprimido
desde la seccion de descarga http://www.kumbiaphp.com/blog/manuales-y-descargas/ para
obtener la version mas reciente del framework. Una vez descargado el archivo,
es esencial asegurarse que tiene la extension .tgz para usuarios Linux y .zip
para usuarios de Windows, ya que de otro modo no se descomprimira
correctamente.

A continuacion se descomprime su contenido en el directorio raiz del servidor
web (DocumentRoot). Para asegurar cierta uniformidad en el documento, en este
capitulo se supone que se ha descomprimido el paquete del framework en el
directorio kumbiaphp/ . Teniendo una estructura como la siguiente:

`-- 1.0
    |-- core    
    |-- default
        |-- app
        |-- index.php
        |-- .htaccess
        `-- public  
  
## Configurar Servidor Web

KumbiaPHP Framework utiliza un modulo para la reescritura de URLs haciendolas
mas comprensibles y faciles de recordar en nuestras aplicaciones. Por esto, el
modulo debe ser configurado e instalado, en este sentido debe chequear que el
modulo este habilitado, en las siguientes secciones se explica como hacer.

### Habitando mod_rewrite de Apache en GNU/Linux (Debian, Ubuntu y Derivados)

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
por *AllowOverride All*, de esta manera Apache podra interpretar estos archivos.

Hecho esto, queda reiniciar el servicio de apache.

```bash
 >/etc/init.d/apache2 restart  
```

A continuacion, se prueba todas las configuraciones realizadas mediante la
siguiente URL.

http://localhost/kumbiaphp/  

  
Si todo ha ido bien, deberias ver una pagina de bienvenida como la que se
muestra en la figura 2.1, con lo que la instalacion rapida se puede dar por
concluida.

![](images/image12.png)

Figura 2.1: Instalacion Exitosa de KumbiaPHP

Esto es un entorno de pruebas el cual esta pensado para que practiques con
KumbiaPHP en un servidor local, no para desarrollar aplicaciones complejas que
terminan siendo publicadas en la web.

### ¿Por que es importante el Mod-Rewrite?

ReWrite es un modulo de apache que permite reescribir las urls que han
utilizado nuestros usuarios. KumbiaPHP Framework encapsula esta complejidad
permitiendonos usar URLs bonitas o limpias como las que vemos en blogs o en
muchos sitios donde no aparecen los ?, los & ni las extensiones del servidor
(.php, .asp, .aspx, etc).

Ademas de esto, con mod-rewrite  KumbiaPHP puede proteger nuestras
aplicaciones ante la posibilidad de que los usuarios puedan ver los
directorios del proyecto y puedan acceder a archivos de clases, modelos,
logica, etc., sin que sean autorizados.

Con mod-rewrite  el unico directorio que pueden ver los usuarios es el
contenido del directorio publico (public) del servidor web, el resto permanece
oculto y solo puede ser visualizado cuando ha realizado una peticion en forma
correcta y tambien es correcto segun nuestra logica de aplicacion. Cuando
escribes direcciones utilizando este tipo de URLs, estas ayudando tambien a
los motores de busqueda a indexar mejor tu informacion.

