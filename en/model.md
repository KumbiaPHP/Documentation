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

## How to use models

The models represent the application logic, and are a fundamental part for the moment that develops an application, a good use of these provides us a great power when needed scale, maintain and reuse the code in an application.

A bad use of models is usually only leave the file with the class declaration and generate all the logic in the controller. Esta práctica trae como consecuencia que en primer lugar el controlador sea difícilmente entendible por alguien que intente agregar y/o modificar algo en esa funcionalidad, en segundo lugar lo poco que puedes rehusar el código en otros controladores. That leads to repeat code that does the same thing on another controller.

Based on this principle, the controllers should not contain any logic, only handle deal with the requests of the users and request such information from the models. With this we guarantee a good use of the [MVC](https://es.wikipedia.org/wiki/Modelo-vista-controlador).