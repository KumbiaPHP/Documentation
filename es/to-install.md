# Instalar KumbiaPHP

En esta sección se explican los pasos necesarios para poner en funcionamiento el framework en tu entorno de desarrollo.

> ⚠️ **Advertencia**  
>
> Esta instalación es un entorno de pruebas, pensado para experimentar con KumbiaPHP en un servidor local. No está
> recomendada para el desarrollo de aplicaciones que vayan a ser publicadas en producción.

## Requisitos

Como se mencionó anteriormente, KumbiaPHP es muy fácil de usar y, en ese sentido, los requisitos para hacerlo funcionar
son mínimos, y solo es necesario un intérprete de [**PHP versión 8.0**](https://www.php.net/) o superior.

## Pasos para instalación

1. Descarga el archivo comprimido de KumbiaPHP desde la sección de descargas en
   [kumbiaphp.com](http://www.kumbiaphp.com/blog/manuales-y-descargas/) para obtener la versión más reciente del
   framework.

   Asegúrate de que el archivo tenga la extensión `.tgz` si usas Linux, o `.zip` si usas Windows, ya que de otro modo
   podría no descomprimirse correctamente.

2. Una vez descargado, descomprime su contenido en el directorio de tu preferencia. Para mantener la uniformidad en este
   manual, supondremos que el paquete ha sido descomprimido en un directorio llamado `kumbiaphp/`, con una estructura
   similar a la siguiente:

    ```
    kumbiaphp/
    ├── core/
    ├── vendor/
    └── default/
        ├── app/
        ├── public/
        │   ├── .htaccess
        │   └── index.php
        ├── .htaccess
        └── index.php
    ```

3. Abre una consola y navega hasta el directorio `default/app`:

    ```bash
    cd kumbiaphp/default/app
    ```

4. Ejecuta el servidor de desarrollo incluido:

    ```bash
    ./bin/phpserver
    ```

    Este comando inicia un servidor web local que utiliza el servidor embebido de PHP, facilitando así la ejecución
    inmediata de la aplicación sin necesidad de configuraciones adicionales.

5. Abre tu navegador web y accede a la siguiente dirección:

    ```
    http://0.0.0.0:8001/
    ```

    o

    ```
    http://127.0.0.1:8001/
    ```

    Si todo ha ido bien, deberías ver una página de bienvenida indicando que la instalación fue exitosa.

    ![Instalación exitosa](../images/successful-installation.jpg)

> ℹ️ **Información**  
>
> **Alternativa: Usar Apache o Nginx**, si lo prefieres, puedes utilizar un servidor web tradicional como Apache o Ngnix. Para ello,
> consulta la sección dedicada a la [Instalación de KumbiaPHP en Servidores Web (Apache y Nginx)](installing-kumbiaphp-apache-nginx.md), donde encontrarás
> instrucciones detalladas.

## Modos de una Aplicación

KumbiaPHP ofrece dos modos de ejecución para una aplicación, definidos en el archivo
[default/public/index.php](https://github.com/KumbiaPHP/KumbiaPHP/blob/master/default/public/index.php):

### Modo Desarrollo

Este es el modo por defecto. La constante `PRODUCTION` está definida como `false`:

```php
const PRODUCTION = false;
```

En este modo, la caché de KumbiaPHP está desactivada. Los cambios realizados en las tablas o campos de la base de datos,
así como en las vistas, se reflejan de inmediato.

### Modo Producción

Para activarlo, cambia la constante `PRODUCTION` a `true`:

```php
const PRODUCTION = true;
```

En este modo, KumbiaPHP activa su sistema de caché, almacenando información clave como la metadata de la base de datos
(nombres de tablas, campos, etc.) y las vistas que decidas cachear para mejorar el rendimiento.

> ⚠️ **Advertencia**
>
> Cuando cambies `PRODUCTION` de `false` a `true`, debes eliminar manualmente el contenido del directorio de caché en
  `default/app/temp/cache/` para asegurar que la metadata sea renovada correctamente. Si no lo haces, podrías
  experimentar errores al guardar o mostrar información.
