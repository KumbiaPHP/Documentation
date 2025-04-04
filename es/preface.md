# Prefacio

## Agradecimientos
Este manual está dedicado a quienes, con su tiempo y apoyo (sea mucho o poco), han contribuido a que este framework
mejore día a día. A toda la comunidad que rodea a KumbiaPHP, con sus preguntas, reportes de errores (bugs), aportes y
críticas, ¡muchas gracias!

## Acerca del Manual
El libro de KumbiaPHP busca mostrar cómo este framework puede ayudar en el trabajo diario de un desarrollador. Permite
descubrir las distintas facetas de KumbiaPHP y conocer por qué puede ser la herramienta que estaba esperando para
iniciar su proyecto. Se encuentra en constante desarrollo (diseño gráfico, revisión ortográfica y gramatical,
contenidos, etc.), al igual que el framework, por lo que se recomienda mantener siempre la última versión actualizada.

En esta edición del manual se han realizado grandes cambios respecto a la anterior. Gracias a la comunidad se
identificaron dudas recurrentes en el grupo, el foro y el chat. También se detectó el uso inadecuado del patrón MVC y la
falta de aprovechamiento de las facilidades de la Programación Orientada a Objetos (POO). Se ha procurado abordar estos
aspectos y mejorar la comprensión de uso, de modo que puedan crearse aplicaciones más mantenibles y de mayor calidad.

## Acerca de KumbiaPHP
KumbiaPHP es un producto latino para el mundo. La programación debería ser tan placentera como un baile, y KumbiaPHP
hace que programar sea tan ameno como bailar. Es un framework de libre uso bajo licencia New BSD, por lo que puedes
utilizarlo en tus proyectos respetando los términos de dicha licencia. Se sugiere siempre usar versiones estables y lo
más recientes posibles, ya que incluyen correcciones, nuevas funcionalidades y mejoras significativas.

## Sobre la comunidad
La comunidad de KumbiaPHP está compuesta mayoritariamente por hispano-latinos, lo que da origen a un framework
totalmente en español. Esta es su mayor diferencia respecto a otros frameworks anglosajones. Con el tiempo se han
incorporado nuevos sistemas de comunicación: una lista de correo, un foro, un canal de IRC y una Wiki. Todo ello hace
que la comunidad sea una parte fundamental para enriquecer y mejorar KumbiaPHP.
Puedes encontrar más información en el [Sitio web oficial de KumbiaPHP](https://www.kumbiaphp.com)

## ¿Por qué usar KumbiaPHP Framework?
Muchas personas se preguntan: ¿cómo funciona este framework?, ¿otro más?, ¿será fácil?, ¿qué tan potente es?, etc. A
continuación, algunas razones para utilizar KumbiaPHP:

- Es muy fácil de usar (Zero-Config). Empezar con KumbiaPHP es sencillísimo: basta con descomprimir y comenzar a
  trabajar. Esta filosofía se conoce como “Convención sobre Configuración”.
- Agiliza el trabajo. Crear una aplicación muy funcional con KumbiaPHP puede tomar solo minutos u horas, lo que permite
  complacer a los clientes sin sacrificar demasiado tiempo. Gracias a las múltiples herramientas que ofrece, se puede
  hacer más en menos tiempo.
- Separa la lógica de la presentación. Una de las mejores prácticas en el desarrollo web es separar la lógica de datos
  de la presentación. Con KumbiaPHP, implementar el patrón MVC (Modelo, Vista y Controlador) es sencillo, lo que
  facilita el mantenimiento y la escalabilidad de las aplicaciones.
- Reduce el uso de otros lenguajes. Gracias a los Helpers y a patrones como ActiveRecord, se minimiza la necesidad de
  escribir HTML y SQL (aunque sea en menor porcentaje). KumbiaPHP se encarga de esas tareas, logrando un código más
  claro, natural y menos propenso a errores.
- ¡Habla español! La documentación, los mensajes de error, los archivos de configuración, la comunidad y los
  desarrolladores hablan español, evitando la barrera del idioma presente en otros frameworks.
- Su curva de aprendizaje es muy corta, especialmente para quienes ya cuenten con experiencia en Programación Orientada
  a Objetos.
- Parece un juego. Sin notarlo, se aplican múltiples patrones de diseño, que facilitan el trabajo al abstraer, reducir
  código y hacer la aplicación más sencilla de entender. Trabajar con KumbiaPHP implica aplicar muchos patrones de
  manera casi natural.
- Es Software Libre. No hay que preocuparse por licencias adicionales, y KumbiaPHP promueve las comunidades de
  aprendizaje, donde el conocimiento es de todos y cada quien sabe cómo aprovecharlo mejor.
- Permite crear aplicaciones robustas. Las aplicaciones actuales requieren arquitecturas sólidas. KumbiaPHP ofrece una
  arquitectura sencilla de aprender e implementar, sin complicar con conceptos excesivos y sin sacrificar calidad.

## ¿Qué aporta KumbiaPHP?
KumbiaPHP es un esfuerzo por producir un framework que reduzca el tiempo de desarrollo de una aplicación web, sin
repercutir negativamente en los programadores, apoyándose en principios clave que siempre tenemos presentes:

- KISS («Mantenlo simple, estúpido» o Keep It Simple, Stupid).  
- DRY (Don’t Repeat Yourself, también conocido como “Una vez y solo una”).  
- Convención sobre configuración.  
- Velocidad.

Además, KumbiaPHP se fundamenta en las siguientes premisas:

- Fácil de aprender.  
- Fácil de instalar y configurar.  
- Compatible con muchas plataformas.  
- Listo para aplicaciones comerciales.  
- Sencillo en la mayoría de los casos, pero flexible para adaptarse a situaciones más complejas.  
- Soporte de numerosas características para aplicaciones web actuales.  
- Aplicación de prácticas y patrones de programación productivos y eficientes.  
- Producción de aplicaciones fáciles de mantener.  
- Basado en Software Libre.

El objetivo principal es lograr aplicaciones prácticas para el usuario final y no solo para el programador. La mayoría
de las tareas que consumen tiempo al desarrollador deberían automatizarse con KumbiaPHP, de modo que se pueda enfocar en
la lógica de negocio de su aplicación. No se debería reinventar la rueda cada vez que se inicia un nuevo proyecto de
software.

Para lograr estos objetivos, KumbiaPHP está escrito en PHP5 (plenamente compatible con PHP 8.0) y ha sido probado en
aplicaciones reales que abarcan diversas áreas con una amplia variedad de demandas y funcionalidades. Es compatible con
las bases de datos más utilizadas en la actualidad:

- MySQL  
- PostgreSQL  
- Oracle  
- SQLite  

El modelo de objetos de KumbiaPHP se aplica en las siguientes capas:

- [Lógica de la aplicación](model.md)  
- [Abstracción de la base de datos y mapeo Objeto-Relacional](active-record.md)  

Entre las características comunes de las aplicaciones web que KumbiaPHP automatiza se encuentran:

- Plantillas (TemplateView).  
- Validación y persistencia de formularios.  
- Administración de caché.  
- Scaffolding.  
- Front Controller.  
- Interacción AJAX.  
- Generación de formularios.  
- Seguridad.  
