# Model, View, Controller (MVC)

## What MVC is?

In 1979, Trygve Reenskaug developed an architecture for creating interactive applications. In his design there are three components: models, views and controllers. The MVC model allows the separation of the application layers in interface, model and logic control. Programming in layers, is a style of programming where the primary goal is the separation of presentation design from the business logic. A basic example of this is separation of the data layer from the presentation layer (user interfase).

The main advantage of this style is that development can be performed at various levels and in the event of any change only attacking the required level without having to review between mixed code. In addition, it allows to distribute the development of an application by levels so each work group is totally abstracted from the rest of levels. It is simply necessary to know the API (Application Interface) that exists between levels. The division into layers reduces complexity, facilitates the reuse and accelerates the process of assembling or disassembling any layer, or replace it by another (but with the same responsibility).

In a Web application, a request is performed using HTTP and is sent to the controller. The controller may interact in many ways with the model, then the controller calls its view which obtains the state of the model that is sent from the controller and displays it to the user.

## How KumbiaPHP apply the MVC?

KumbiaPHP Framework leverages the best patterns of oriented programming especially the Web pattern MVC (model, view, controller). The following describes the general operation of this paradigm in KumbiaPHP.

The objective of this pattern is to make and maintain the separation between the logic of our application, data and presentation. This separation has some important advantages, as to be able to identify more easily in that layer is this causing a problem just know its nature. We can create various presentations without repeatedly typing the same application logic. Each part works independent and any changes centralize the effect over the others, so we can be sure that a change in one component does not affect the tasks in any part of the application.

## Additional information

The basis of KumbiaPHP is the MVC and OOP, a traditional design pattern that works in three layers:

- **Models:** They represent the information on which the application operates, its business logic.
- **Views:** They displayed the model using Web pages and interacts with users (in principle). A view can be represented by any format output, we refer to xml, pdf, json, svg, png, etc. A simple view of a controller action has a phtml extension. all of this are seen.
- **Controllers:** Respond to user actions (that is triggered in the views) and invoke changes in the views or models as needed.

In KumbiaPHP controllers are separate parts, called front controller and a set of actions. Each action knows how to react to a particular type of request.

The views are separated into templates, views and partials.

The model provides a layer of abstraction from the database, in addition it gives functionality added to session and relational integrity validation data. This model helps to separate work in logic of business (models) and the presentation (view).

For example, if you have an application that runs both on desktop computers and mobile devices then you could create two different views sharing the same actions on the controller and the logic of the model. The driver helps to hide the details of the protocol used in the request (HTTP, console mode, etc.) for the model and the view.

Finally, the model abstracts the data logic, which makes independent views models. The implementation of this model is very light through small conventions can achieve much power and functionality.

## Case study (example of change)

To better understand, here is an example of how an MVC architecture works to add to cart. First, the user interacts with the interface by selecting a product and pressing a button, this probably validates a form and sends a request to the server.

  1. The Front Controller receives notification of a user action, and after running some tasks (routing, security, etc.), understands that it must run the action add on controller.
  2. Action add access to the model and updates the object of the cart in the user session.
  3. If the modification is stored correctly, the action prepares the content that will be returned in the response - confirmation of the addition and a complete list of products that are currently in your shopping cart. View joins the response of action in the body of the application to produce the shopping cart page.
  4. It is finally transferred to the Web server that sends it to the user, who can read it and interact with it again.