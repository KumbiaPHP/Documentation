#Prefacio

##Agradecimietos
Este manual es para agradecer a los que con su tiempo y apoyo, en gran o en poca medida, han ayudado a que este framework sea cada día mejor. A toda la comunidad que rodea a KumbiaPHP, con sus preguntas, notificaciones de errores (Bug’s), aportes, críticas, etc., a todos ellos ¡Gracias!.

##Acerca del Manual
El libro de KumbiaPHP intenta comunicar, todo lo que este framework puede ayudar en su trabajo diario como desarrollador. Le permite descubrir todos los aspectos de KumbiaPHP y aprender por qué KumbiaPHP puede ser la herramienta que estaba esperando para empezar a desarrollar su proyecto. Este libro se encuentra en etapa de continuo desarrollo, diseño gráfico, revisión ortográfica y gramática, contenidos, etc. Lo mismo sucede con el framework, por lo cual se aconseja siempre disponer de la última versión para su referencia.

Esta versión del manual ha cambiado mucho de la anterior. Gracias a la comunidad se han reflejado cuestiones que se repetían en grupo, foro e IRC. También se detectó el mal uso del MVC, ya que no se aprovechaban las facilidades del POO. Se ha mejorado esos puntos recurrentes de consulta, así como también el entendimiento de uso, para que logren aplicaciones robustas y altamente mantenibles.

##Acerca de Kumbia
KumbiaPHP es un producto latino para el mundo. Programar debe ser tan bueno como bailar y KumbiaPHP es un baile, un baile para programar. KumbiaPHP es un framework de libre uso bajo licencia new BSD. Por lo tanto, puedes usar KumbiaPHP para tus proyectos siempre y cuando tengas en cuenta la licencia. Te aconsejamos que siempre uses versiones estables y lo más recientes posibles, ya que se incluyen correcciones, nuevas funcionalidades y otros elementos interesantes.

##Sobre la comunidad
La comunidad de KumbiaPHP está formada en su gran mayoría por gente hispano-latina, de la cual nace un framework completamente en español. Y donde radica su mayor diferencia respecto a otros frameworks que son, de forma nativa, anglosajones. Por otra parte se ha intentado, con el tiempo, aportar nuevos sistemas de comunicación, así que se cuenta con una lista de correo, el foro, canal de IRC y una WiKi. Esperamos que todo esto haga que la comunidad sea una parte importante y vital para enriquecer y mejorar KumbiaPHP.
Puedes encontrar más información en [[www.kumbiaphp.com]]

##¿Porque usar KumbiaPHP Framework?
Mucha gente pregunta ¿cómo es este framework?, ¿otro más?, ¿será fácil? ¿qué tan potente es? etc. Pues aquí algunas razones para utilizar KumbiaPHP:

Es muy fácil de usar (Zero-Config). Empezar con KumbiaPHP es demasiado fácil, es sólo descomprimir y empezar a trabajar. Esta filosofía también es conocida como Convención sobre Configuración.
Agiliza el Trabajo, crear una aplicación funcional con KumbiaPHP es cuestión de horas o minutos, así que podemos darle gusto a nuestros clientes sin que afecte nuestro tiempo. Gracias a las múltiples herramientas que proporciona el framework para agilizar el trabajo podemos hacer más en menos tiempo.
Separar la Lógica de la Presentación, una de las mejores prácticas de desarrollo orientado a la Web es separar la lógica de los datos y la presentación, con KumbiaPHP es sencillo aplicar el patrón MVC (Modelo, Vista, Controlador) y hacer nuestras aplicaciones más fáciles de mantener y de escalar.
Reducción del uso de otros Lenguajes, gracias a los Helpers y a otros patrones como ActiveRecord se evita el uso de lenguajes HTML y SQL (en menor porcentaje). KumbiaPHP hace esto por nosotros, con esto logramos código más claro, natural y con menos errores.
¡Habla Español! La documentación, mensajes de error, archivos de configuración, comunidad, desarrolladores ¡hablan español!, con esto no tenemos que entender a medias, como con otros frameworks que nos toca quedarnos cruzados de brazos porque no podemos pedir ayuda.
La Curva de Aprendizaje de KumbiaPHP es muy corta, y si a usted tiene experiencia de Programación Orientada a Objetos, dicha curva será aún menor.
Parece un juego, sin darnos cuenta aplicamos los patrones de diseño; los patrones de diseño son herramientas que facilitan el trabajo realizando abstracción, reduciendo código o haciendo más fácil de entender la aplicación. Cuando trabajas con KumbiaPHP aplicas muchos patrones y al final te das cuenta que eran más fáciles de usar de lo que se piensa.
Software Libre. No tienes que preocuparte por licenciar nada, KumbiaPHP promueve las comunidades de aprendizaje: el conocimiento es de todos y cada uno sabe como aprovecharlo mejor.
Aplicaciones Robustas, ¿no sabía que tenía una?. Las aplicaciones de hoy día requieren arquitecturas robustas. KumbiaPHP proporciona una arquitectura fácil de aprender y de implementar, sin complicarnos con conceptos y sin sacrificar calidad.

##¿Qué aporta KumbiaPHP?
KumbiaPHP es un esfuerzo por producir un framework que ayude a reducir el tiempo de desarrollo de una aplicación web sin generar efectos sobre los programadores, basándonos en principios claves, que siempre recordamos.

- KISS «Mantenlo simple, estúpido» (Keep It Simple, Stupid).
- DRY No te repitas, en inglés Don’t Repeat Yourself, también conocido como Una vez y sólo una.
- Convención sobre configuración.
- Velocidad.

Además KumbiaPHP está fundamentado en las siguientes premisas:
- Fácil de aprender.
- Fácil de instalar y configurar.
- Compatible con muchas plataformas.
- Listo para aplicaciones comerciales.
- Simple en la mayor parte de casos, pero flexible para adaptarse a casos más complejos.
- Soportar muchas características de aplicaciones Web actuales.
- Soportar las prácticas y patrones de programación más productivos y eficientes.
- Producir aplicaciones fáciles de mantener.
- Basado en Software Libre.

Lo principal es producir aplicaciones que sean prácticas para el usuario final y no sólo para el programador. La mayor parte de tareas que le quiten tiempo al desarrollador deberían ser automatizadas por KumbiaPHP, para que pueda enfocarse en la lógica de negocio de su aplicación. No deberíamos reinventar la rueda cada vez que se afronte un nuevo proyecto de software.

Para satisfacer estos objetivos KumbiaPHP está escrito en PHP5. Además ha sido probado en aplicaciones reales que trabajan en diversas áreas con variedad de demanda y funcionalidad. Es compatible con las bases de datos disponibles actuales más usadas:

- MySQL.
- PostgreSQL.
- Oracle.
- SQLite.

El modelo de objetos de KumbiaPHP es utilizado en las siguientes capas:

- Abstracción de la base de datos.
- Mapeo Objeto-Relacional.
- Modelo MVC (Modelo, Vista, Controlador).

Características comunes de aplicaciones Web que son automatizadas por KumbiaPHP:

- Plantillas (TemplateView).
- Validación y Persistencia de Formularios.
- Administración de Caché.
- Scaffolding.
- Front Controller.
- Interacción AJAX.
- Generación de Formularios.
- Seguridad.
