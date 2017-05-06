# Scaffold

## Introduction

To begin, it is important to know, that the Scaffold was used until the stable release 0.5 Kumbiaphp and that leaving Kumbiaphp version 1.0 Spirit beta 1 will leave aside, to create a new one more customizable and maintainable.

Seeing the need and the facilities that the Scaffold provides applications support, Kumbiaphp development team returns to incorporate a new for your KumbiaPHP version beta 2, improving and simplifying the performance of the Scaffold for the Framework and that undoubtedly contributes to a breakthrough in any development application for users in using Kumbiaphp and advanced users, delivering to all a high range of possibilities.

## Concept

Scaffold is a meta-programming method to build software applications that support database. This is a new technique supported by some frameworks like MVC (model-view - controller), where the programmer must write a specification type as it should be used the implementation of databases. The compiler then use this to generate a code that I can use the application to read, create, update and delete entries (something known as CRUD or ABM) database, trying to put templates as a Scaffold scaffolding) on which to build an application more powerful.

Scaffolding is the evolution of generators codes of databases from more developed environments, such as CASE Generator for Oracle and other so many servers 4GL for services to customer. Scaffolding became popular thanks to the framework "Ruby on Rails", which has been adapted to other frameworks, including Django, Monorail, KumbiaPHP framework among others.

## Objective

Creating a CRUD 100% functional with just 2 lines of code in my controller.

KumbiaPHP takes as if by magic, the parameters listed in my table and weapon all the CRUD.

## Getting Started

To make our first Scaffold, will use the same model working on the [CRUD to KumbiaPHP Beta2](http://wiki.kumbiaphp.com/Beta2_CRUD_en_KumbiaPHP_Framework), and has different menus.

Model

Create the model, as always pointing to the ActiveRecord class.

[app]/models/menus.php:

```php
<? php class menu extends ActiveRecord{  

}

```

* * *

## Controller

Create the handler in this example, we will not set the AppController and if class to the ScaffoldController class.

[app]/controllers/menus_controller.php:

```php
<? php class MenusController extends ScaffoldController {public $model = 'menus';   }

```

* * *

Here complete our first steps. Don't need anything more. We will have magically a CRUD 100% functional.

## Advantages

  1. We can go loading our first records in the database
  2. You try to insert records
  3. Progressive advancement, since we can go replacing the Scaffold views for my own views.

## Disadvantage

  1. The Scaffold is not for making systems, if not to help the beginning of an application.

## Views for the scaffold

By default uses the views/_shared/scaffolds/kumbia /... One can create their own inside scaffolds views/_shared/scaffolds/foo /... and the controller in addition to the attribute $model added; public $scaffold = 'foo';

So use the views of scaffolds/foo /...

More important still, is that one can create your views as always. i.e. If you create the controller MiController and create the view in views/mi/editar.phtml (for example) use first the view, if not usa exists on scaffolds. You can one change the views to your liking wherever and progressively.