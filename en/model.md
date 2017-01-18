# Models

Models lies the logic of business (or application). Mistakenly, many people believe that the models are only for working with databases.

Models can be of many types:

- Create thumbnails of images
- Consume and use webservices
- Create payment gateways
- Use LDAP
- Send mails or check mail servers
- Interact with the local file system or via FTP, or any other protocol
- etc etc

## Como usar los modelos

The models represent the application logic, and are a fundamental part for the moment that develops an application, a good use of these provides us a great power when needed scale, maintain and reuse the code in an application.

Por lo general un mal uso de los modelos es sólo dejar el archivo con la declaración de la clase y generar toda la lógica en el controlador. Esta práctica trae como consecuencia que en primer lugar el controlador sea difícilmente entendible por alguien que intente agregar y/o modificar algo en esa funcionalidad, en segundo lugar lo poco que puedes rehusar el código en otros controladores. Eso conlleva a repetir código que hace lo mismo en otro controlador.

Partiendo de este principio, los controladores NO deberían contener ningún tipo de lógica, sólo se encargan de atender las peticiones del usuarios y solicitar dicha información a los modelos. Con esto garantizamos un buen uso del \[MVC\](http://www.google.com/url?q=http%3A%2F%2Fes.wikipedia.org%2Fwiki%2FM odelo_Vista_Controlador&sa=D&sntz=1&usg=AFQjCNFo6Rn8nbUjHG5f8Qqa__2nYwMDjg) .