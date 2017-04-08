# Modelos

En los Modelos reside la lógica de negocio (o de la aplicación). Equivocadamente, mucha gente cree que los modelos son solo para trabajar con las bases de datos.

Los modelos puedes ser de muchos tipos:

- Crear miniaturas de imágenes
- Consumir y usar webservices
- Crear pasarelas Scaffold de pago
- Usar LDAP
- Enviar mails o consultar servidores de correo
- Interactuar con el sistema de ficheros local o vía FTP, o cualquier otro protocolo
- etc etc

## Como usar los modelos

Los Modelos representan la lógica de la aplicación, y son parte fundamental para el momento que se desarrolla una aplicación, un buen uso de estos nos proporciona un gran poder al momento que se necesita escalar, mantener y reusar código en una aplicación.

Por lo general un mal uso de los modelos es sólo dejar el archivo con la declaración de la clase y generar toda la lógica en el controlador. Esta práctica trae como consecuencia que en primer lugar el controlador sea difícilmente entendible por alguien que intente agregar y/o modificar algo en esa funcionalidad, en segundo lugar lo poco que puedes rehusar el código en otros controladores. Eso conlleva a repetir código que hace lo mismo en otro controlador.

Partiendo de este principio, los controladores NO deberían contener ningún tipo de lógica, sólo se encargan de atender las peticiones del usuarios y solicitar dicha información a los modelos. Con esto garantizamos un buen uso del \[MVC\](http://www.google.com/url?q=http%3A%2F%2Fes.wikipedia.org%2Fwiki%2FM odelo_Vista_Controlador&sa=D&sntz=1&usg=AFQjCNFo6Rn8nbUjHG5f8Qqa__2nYwMDjg) .